<?php
include 'db.php';

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "User deleted successfully";
    header("location:view_users.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
