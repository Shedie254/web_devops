<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Add User</h2>
    <a href="view_users.php" class="link">View Users</a>
    <form action="add_user.php" method="POST">
        Name: <input type="text" name="name" required><br>
        Email: <input type="email" name="email" required><br>
        <?php
        if (isset($_GET['error'])) {
            echo '<p style="color:red;">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>
        <input type="submit" value="Add User">
    </form>
</body>
</html>
