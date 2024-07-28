<?php
session_start();
include 'includes/db.php';
include 'templates/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        
    </header>
    <div class="container">
        <form class="standard-form" action="add_product_process.php" method="POST" enctype="multipart/form-data">
            <h1>Add Product</h1>
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" required>

            <label for="description">Product Description</label>
            <textarea name="description" id="description" required></textarea>

            <label for="price">Price</label>
            <input type="number" name="price" id="price" step="0.01" required>

            <label for="image">Product Image</label>
            <input type="file" name="image" id="image" required>

            <button type="submit">Add Product</button>
        </form>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
