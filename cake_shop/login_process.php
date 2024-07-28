<?php
session_start();
include 'includes/db.php';

$username = trim($_POST['username']);
$password = $_POST['password'];

$errors = [];

$stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $user['role'];
    header("Location: dashboard.php");
} else {
    $errors[] = "Invalid username or password.";
    $_SESSION['login_errors'] = $errors;
    header("Location: login.php");
}

$stmt->close();
$conn->close();
?>
