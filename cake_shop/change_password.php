<?php
session_start();
include 'includes/db.php';
include 'templates/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch current password hash
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify old password
    if (password_verify($old_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            // Update password
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $new_password_hash, $user_id);

            if ($update_stmt->execute()) {
                $success = "Password successfully updated.";
            } else {
                $error = "Error updating password: " . $conn->error;
            }

            $update_stmt->close();
        } else {
            $error = "New passwords do not match.";
        }
    } else {
        $error = "Old password is incorrect.";
    }

    $stmt->close();
    $conn->close();
}
?>

<div class="container">
    <h1>Change Password</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form action="change_password.php" method="POST">
        <label for="old_password">Old Password</label>
        <input type="password" name="old_password" id="old_password" required>

        <label for="new_password">New Password</label>
        <input type="password" name="new_password" id="new_password" required>

        <label for="confirm_password">Confirm New Password</label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <button type="submit">Change Password</button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>

<style>
.container {
    padding: 20px;
}

.error {
    color: red;
    margin-bottom: 10px;
}

.success {
    color: green;
    margin-bottom: 10px;
}

form {
    max-width: 500px;
    margin: 0 auto;
}

form label {
    display: block;
    margin-bottom: 8px;
}

form input {
    width: 100%;
    padding: 8px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form button {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

form button:hover {
    background-color: #0056b3;
}
</style>
