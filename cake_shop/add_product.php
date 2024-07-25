<?php
session_start();
include 'includes/db.php';
include 'templates/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<div class="container">
    <form class="standard-form" action="add_product_process.php" method="POST" enctype="multipart/form-data" onsubmit="return validateProductForm()">
        <h1>Add Product</h1>
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>
        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" required>
        <button type="submit">Add Product</button>
    </form>
</div>

<script>
function validateProductForm() {
    const name = document.getElementById('name').value;
    const description = document.getElementById('description').value;
    const price = document.getElementById('price').value;
    const image = document.getElementById('image').value;

    if (!name || !description || !price || !image) {
        alert("Please fill out all fields.");
        return false;
    }
    return true;
}
</script>

<?php include 'templates/footer.php'; ?>
