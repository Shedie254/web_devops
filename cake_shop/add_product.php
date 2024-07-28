<?php
session_start();
include 'includes/db.php';
include 'templates/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!-- Add Product Form -->
<div class="container">
    <h1>Add Product</h1>
    <form action="add_product_process.php" method="POST" enctype="multipart/form-data">
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
