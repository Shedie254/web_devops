<?php
session_start();
include 'includes/db.php';
include 'templates/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch products from the database
$stmt = $conn->prepare("SELECT id, name, description, price, image FROM products");
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container">
    <h1>Welcome to the Dashboard</h1>
    
    <nav>
        <a href="index.php">Home</a>
        <a href="account.php">Account</a>
        <a href="cart.php">Cart</a>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <a href="add_product.php">Add Product</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </nav>
    
    <div class="products">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product">
                <a href="add_to_cart.php?id=<?php echo $row['id']; ?>">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                </a>
                <h2><?php echo $row['name']; ?></h2>
                <p><?php echo $row['description']; ?></p>
                <p>ksh<?php echo number_format($row['price'], 2); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php
$stmt->close();
$conn->close();
include 'templates/footer.php';
?>

<style>
.container {
    padding: 20px;
}

nav {
    margin-bottom: 20px;
}

nav a {
    margin-right: 15px;
    text-decoration: none;
    color: #007bff;
}

nav a:hover {
    text-decoration: underline;
}

.products {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.product {
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    width: 200px;
    text-align: center;
}

.product img {
    max-width: 100%;
    height: auto;
    cursor: pointer;
}

.product h2 {
    font-size: 1.2em;
    margin: 10px 0;
}

.product p {
    margin: 5px 0;
}
</style>
