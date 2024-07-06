<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <br>
    <p >
    <button class = "mybuton">
    <a href="logout.php">Logout</a>
    </button>
    </p>
</body>
</html>
