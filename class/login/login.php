<?php
session_start();
include 'db.php';
include 'FormHandler.php'; // Include the FormHandler class

$errors = [];
$formHandler = new FormHandler();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate user input
    $username = $formHandler->validateInput($_POST['username']);
    $password = $formHandler->validateInput($_POST['password']);

    // Validate the username
    $nameError = $formHandler->validateName($username);
    if (!empty($nameError)) {
        $errors["username"] = $nameError;
    }

    if (empty($errors)) {
        // Process form data
        $timestamp = $formHandler->getCurrentDateTime();
       
        // Example: Display success message
        echo "Form submitted successfully at $timestamp";
        // Prepare and execute the SQL statement
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists and verify the password
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header("Location: welcome.php");
                exit();
            } else {
                $errors["login"] = "Invalid username or password";
            }
        } else {
            $errors["login"] = "Invalid username or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eedfdf;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: rgb(122, 119, 119);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .container input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .container button:hover {
            background-color: #45a049;
        }
        .signup-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" required>
            <?php if(isset($errors["username"])) : ?>
                <p style="color: red"><?= $errors['username']?></p>
            <?php endif ?>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <?php if(isset($errors["login"])) : ?>
                <p style="color: red"><?= $errors['login']?></p>
            <?php endif ?>
            <button type="submit">Login</button>
            <p class="signup-link">
                Don't have an account?<br>
                <a href="signup.php">Sign Up</a>
            </p>
        </form>
    </div>
</body>
</html>