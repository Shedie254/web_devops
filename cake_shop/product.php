<?php
session_start();
include 'includes/db.php';
include 'templates/header.php';

$product_id = $_GET['id'];

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
?>

<h1><?php echo htmlspecialchars($product['name']); ?></h1>
<img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
<p><?php echo htmlspecialchars($product['description']); ?></p>
<p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>

<form action="add_to_cart.php" method="POST">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    <button type="submit">Add to Cart</button>
</form>

<?php include 'templates/footer.php'; ?>
