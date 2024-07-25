<?php
session_start();
include 'includes/db.php';
include 'templates/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<div class="container">
    <h1>Your Account</h1>
    
    <table>
        <tr>
            <th>Field</th>
            <th>Value</th>
            <th>Action</th>
        </tr>
        <tr>
            <td>Username</td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><a href="edit_account.php?field=username">Edit</a></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><a href="edit_account.php?field=email">Edit</a></td>
        </tr>
        <tr>
            <td>Password</td>
            <td>********</td>
            <td><a href="change_password.php">Change Password</a></td>
        </tr>
    </table>
</div>

<?php include 'templates/footer.php'; ?>

<style>
.container {
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table, th, td {
    border: 1px solid #ddd;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

td a {
    color: #007bff;
    text-decoration: none;
}

td a:hover {
    text-decoration: underline;
}
</style>
