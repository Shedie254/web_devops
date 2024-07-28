<?php
include 'includes/db.php';

$username = 'admin';
$password = 'IyamAdmin1';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$role = 'admin';

$stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $hashed_password, $role);

if ($stmt->execute()) {
    echo "Admin account created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
