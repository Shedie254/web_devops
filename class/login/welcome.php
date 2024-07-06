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
 <style>
    body{
        background-image:url('/web_devops/images/background4.jpeg');
        background-repeat: no-repeat;
    background-size: cover; /* Ensures the image covers the entire background */
    background-position: center; /* Centers the background image */
    background-attachment: fixed; /* Makes the background image fixed relative to the viewport */
    }
 </style>
    
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <br>
    <p >
    <button class = "mybuton">
    <a href="logout.php">Logout</a>
    </button>
    </p>
</body>
</html>
