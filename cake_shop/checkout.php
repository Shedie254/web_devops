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
    <h1>Checkout</h1>
    <p>Here you would integrate a checkout process.</p>
    <!-- Add checkout form or payment gateway integration here -->
</div>

<?php include 'templates/footer.php'; ?>
