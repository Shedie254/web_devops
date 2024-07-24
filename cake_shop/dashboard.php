<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';
include 'templates/header.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<h1>Welcome, <?php echo $user['username']; ?>!</h1>
<p>This is your dashboard. Here you can manage your account and orders.</p>

<!-- You can add more features to the dashboard like viewing orders, updating account details, etc. -->

<?php include 'templates/footer.php'; ?>
