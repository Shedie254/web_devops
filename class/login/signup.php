<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db.php';
include 'FormHandler.php'; 

$formHandler = new FormHandler();
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate user input
    $username = $formHandler->validateInput($_POST['username']);
    $password = $formHandler->validateInput($_POST['password']);

    // Validate the username
    $nameError = $formHandler->validateName($username);
    if (!empty($nameError)) {
        $errors["username"] = $nameError;
    }

    // Additional validation for password (e.g., length, complexity)
    if (strlen($password) < 6) {
        $errors["password"] = "Password must be at least 5 characters long.";
    }

    if (empty($errors)) {
        // Process form data
        $timestamp = $formHandler->getCurrentDateTime();
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $passwordHash);

        if ($stmt->execute()) {
            echo "<script>window.location.href = 'welcome.php';</script>";
            exit();
        } else {
            $errors["database"] = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
        .errors {
            color: red;
            margin-bottom: 10px;
            
        }
        .login_link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $key => $error): ?>
                    <p><?php// echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="signup.php" method="POST">
            <input type="text" name="username" placeholder="Username"  required>
            <?php if (isset($errors['username'])): ?>
                <p class="errors"><?php echo htmlspecialchars($errors['username']); ?></p>
            <?php endif; ?>
            <input type="password" name="password" placeholder="Password" required>
            <?php if (isset($errors['password'])): ?>
                <p class="errors"><?php echo htmlspecialchars($errors['password']); ?></p>
            <?php endif; ?>
            <button type="submit">Submit</button>
            <p class="login_link">
                Already Have An Account?
                <a href = "login.php">login</a>
        </form>
    </div>
</body>
</html>
