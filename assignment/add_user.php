<?php
include 'db.php';
include 'FormHandler.php';

$name = $_POST['name'];
$email = $_POST['email'];

$formHandler = new FormHandler();
$emailError = $formHandler->validateEmail($email);

if ($emailError) {
    // Redirect back to the form with the error message
    header("Location: add_form.php?error=" . urlencode($emailError));
    exit(); // Ensure the script stops after the redirect
} else {
    $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email);

    if ($stmt->execute()) {
        echo "New user added successfully";
        header("Location: view_users.php");
        exit(); // Ensure the script stops after the redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
