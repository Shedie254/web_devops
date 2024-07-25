<?php
session_start();
include 'includes/db.php';
include 'templates/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$field = $_GET['field'];
$allowed_fields = ['username', 'email'];

if (!in_array($field, $allowed_fields)) {
    die('Invalid field');
}

// Fetch current value
$stmt = $conn->prepare("SELECT $field FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_value = $_POST['new_value'];
    
    // Validate input
    if (empty($new_value)) {
        $error = "The $field cannot be empty.";
    } elseif ($field == 'email' && !filter_var($new_value, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        // Update user data
        $update_stmt = $conn->prepare("UPDATE users SET $field = ? WHERE id = ?");
        $update_stmt->bind_param("si", $new_value, $user_id);
        
        if ($update_stmt->execute()) {
            header("Location: account.php");
            exit();
        } else {
            $error = "Error updating record: " . $conn->error;
        }

        $update_stmt->close();
    }
}

$stmt->close();
$conn->close();
?>

<div class="container">
    <h1>Edit <?php echo htmlspecialchars($field); ?></h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form action="edit_account.php?field=<?php echo htmlspecialchars($field); ?>" method="POST">
        <label for="new_value"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $field))); ?></label>
        <input type="text" name="new_value" id="new_value" value="<?php echo htmlspecialchars($user[$field]); ?>" required>
        <button type="submit">Save</button>
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
