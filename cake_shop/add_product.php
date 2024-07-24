<?php
include 'includes/db.php';
include 'includes/functions.php';
include 'templates/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        addProduct($conn, $name, $description, $price, $image);
        echo "Product added successfully!";
    } else {
        echo "Failed to upload image.";
    }
}
?>

<h1>Add New Product</h1>
<form action="add_product.php" method="POST" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" name="name" required><br>
    <label for="description">Description:</label>
    <textarea name="description" required></textarea><br>
    <label for="price">Price:</label>
    <input type="text" name="price" required><br>
    <label for="image">Image:</label>
    <input type="file" name="image" required><br>
    <button type="submit">Add Product</button>
</form>

<?php include 'templates/footer.php'; ?>
