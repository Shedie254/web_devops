<?php
session_start();
include 'includes/db.php';
include 'templates/header.php';

$query = $_GET['query'];
$sql = "SELECT * FROM products WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$search_query = "%" . $query . "%";
$stmt->bind_param("s", $search_query);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<h1>Search Results for "<?php echo htmlspecialchars($query); ?>"</h1>
<div class="products">
    <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
        <div class="product">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            <h2><?php echo $product['name']; ?></h2>
            <p><?php echo $product['description']; ?></p>
            <p>$<?php echo $product['price']; ?></p>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>

<?php include 'templates/footer.php'; ?>
