<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Check if the cart table exists, create it if not
    $create_table_query = "CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT DEFAULT 1,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (product_id) REFERENCES products(id)
    )";
    $conn->query($create_table_query);

    // Check if the product is already in the cart
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update the quantity if the product is already in the cart
        $stmt->bind_result($quantity);
        $stmt->fetch();
        $stmt->close();

        $new_quantity = $quantity + 1;
        $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $update_stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // Insert the product into the cart if it's not already there
        $insert_stmt = $conn->prepare("INSERT INTO cart (user_id, product_id) VALUES (?, ?)");
        $insert_stmt->bind_param("ii", $user_id, $product_id);
        $insert_stmt->execute();
        $insert_stmt->close();
    }

    header("Location: cart.php");
    exit();
} else {
    echo "No product ID specified.";
}

$conn->close();
?>
