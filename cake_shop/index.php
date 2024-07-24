<?php
include 'includes/db.php';
include 'includes/functions.php';
include 'templates/header.php';

$products = getProducts($conn);
?>
<h1>Our Cakes</h1>
<div class="products">
    <?php foreach ($products as $product): ?>
    <div class="product">
        <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        <h2><?php echo $product['name']; ?></h2>
        <p><?php echo $product['description']; ?></p>
        <p>$<?php echo $product['price']; ?></p>
    </div>
    <?php endforeach; ?>
</div>
<?php include 'templates/footer.php'; ?>
