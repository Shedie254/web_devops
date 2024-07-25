<?php
session_start();
include 'includes/db.php';
include 'templates/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$stmt = $conn->prepare("SELECT c.id, p.id as product_id, p.name, p.description, p.price, p.image, c.quantity 
                         FROM cart c 
                         JOIN products p ON c.product_id = p.id 
                         WHERE c.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container">
    <h1>Your Cart</h1>
    
    <div class="products">
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php 
            // Construct image path
            $image_path = 'uploads/' . $row['image'];
            ?>
            <div class="product">
                <?php if (file_exists($image_path) && !empty($row['image'])): ?>
                    <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <?php else: ?>
                    <img src="uploads/default.png" alt="No image available">
                <?php endif; ?>
                <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <p>$<?php echo number_format($row['price'], 2); ?></p>
                <p>Quantity: <?php echo $row['quantity']; ?></p>
                <form action="update_cart.php" method="POST" class="update-form">
                    <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1" required>
                    <button type="submit">Update Quantity</button>
                </form>
                <a href="remove_from_cart.php?id=<?php echo $row['id']; ?>" class="remove-link">Remove Item</a>
            </div>
        <?php endwhile; ?>
    </div>

    <a href="checkout.php" class="checkout-link">Proceed to Checkout</a>
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
}

.product h2 {
    font-size: 1.2em;
    margin: 10px 0;
}

.product p {
    margin: 5px 0;
}

.update-form {
    margin: 10px 0;
}

.remove-link {
    color: red;
    text-decoration: none;
}

.remove-link:hover {
    text-decoration: underline;
}

.checkout-link {
    display: block;
    margin-top: 20px;
    text-align: center;
    background-color: #007bff;
    color: white;
    padding: 10px;
    border-radius: 5px;
    text-decoration: none;
}

.checkout-link:hover {
    background-color: #0056b3;
}
</style>
