<?php
session_start();
include 'includes/db.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check for empty fields
    if (empty($username)) {
        $errors["username"] = "Username is required";
    }

    if (empty($password)) {
        $errors["password"] = "Password is required";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
        } else {
            $errors["login"] = "Invalid username or password";
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
            padding-top: 70px; /* To account for fixed header */
        }
        .header {
            width: 100%;
            background-color: #333;
            padding: 20px;
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
        }
        .search-form input[type="text"] {
            padding: 0.5rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .search-form button {
            padding: 0.5rem;
            background-color: #45a049;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-form button:hover {
            background-color: #3d8a41;
        }
        .container {
            background-color: #7a7777;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin-top: 50px; /* To avoid overlap with the fixed header */
        }
        .container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: white;
        }
        .container label {
            color: white;
            display: block;
            margin: 10px 0 5px;
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
            color: white;
        }
        .signup-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .signup-link a:hover {
            text-decoration: underline;
        }
        .errors {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="index.php">Home</a>
        <form class="search-form" action="search.php" method="GET">
            <input type="text" name="query" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
    </header>

    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" required>
            <?php if(isset($errors["username"])) : ?>
                <p class="errors"><?= $errors['username'] ?></p>
            <?php endif ?>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <?php if(isset($errors["login"])) : ?>
                <p class="errors"><?= $errors['login'] ?></p>
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
