<?php
session_start();
include 'includes/db.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate username
    if (empty($username)) {
        $errors["username"] = "Username is required";
    }

    // Validate email
    if (empty($email)) {
        $errors["email"] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format";
    }

    // Validate password
    if (empty($password)) {
        $errors["password"] = "Password is required";
    } elseif (strlen($password) < 6 || !preg_match('/[A-Z]/i', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
        $errors["password"] = "Password must be at least 6 characters long and include at least one letter, one number, and one special character";
    }

    // Validate confirm password
    if (empty($confirm_password)) {
        $errors["confirm_password"] = "Please confirm your password";
    } elseif ($password !== $confirm_password) {
        $errors["confirm_password"] = "Passwords do not match";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
        } else {
            $errors["signup"] = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
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
            flex-direction: column;
            padding-top: 70px; /* To account for fixed header */
        }
        .header {
            width: 100%;
            background-color: #333;
            padding: 20px; /* Increased padding */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            font-size: 1.2em; /* Increased font size */
        }
        .header a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
        .search-form {
            display: flex;
            align-items: center;
            margin-left: auto;
            margin-right: 30px;
        }
        .search-form input[type="text"] {
            padding: 5px;
            border: none;
            border-radius: 3px;
        }
        .search-form button {
            padding: 5px;
            background-color: #45a049;
            border: none;
            color: white;
            border-radius: 3px;
            cursor: pointer;
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
        .errors {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php">Home</a>
        <form class="search-form" action="search.php" method="GET">
            <input type="text" name="query" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" required>
            <?php if(isset($errors["username"])) : ?>
                <p class="errors"><?= $errors['username'] ?></p>
            <?php endif ?>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>
            <?php if(isset($errors["email"])) : ?>
                <p class="errors"><?= $errors['email'] ?></p>
            <?php endif ?>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <?php if(isset($errors["password"])) : ?>
                <p class="errors"><?= $errors['password'] ?></p>
            <?php endif ?>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <?php if(isset($errors["confirm_password"])) : ?>
                <p class="errors"><?= $errors['confirm_password'] ?></p>
            <?php endif ?>
            <?php if(isset($errors["signup"])) : ?>
                <p class="errors"><?= $errors['signup'] ?></p>
            <?php endif ?>
            <button type="submit">Sign Up</button>
            <p class="signup-link">
                Already have an account?<br>
                <a href="login.php">Login</a>
            </p>
        </form>
    </div>
</body>
</html>
