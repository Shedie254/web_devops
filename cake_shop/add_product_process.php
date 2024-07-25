<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    // Validate inputs
    if (empty($name) || empty($description) || empty($price) || empty($image)) {
        echo "All fields are required.";
        exit();
    }

    // Handle image upload
    $target_dir = "uploads/";
    // Check if the uploads directory exists, if not create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        exit();
    }

    // Check file size (5MB max)
    if ($image["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        exit();
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
        exit();
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        exit();
    }

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        echo "Sorry, there was an error uploading your file.";
        exit();
    }

    // Insert product into the database
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $description, $price, $target_file);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
