<?php
include 'db.php';

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Edit User</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <h2>Edit User</h2>
            <form action="update_user.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                Name: <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br>
                Email: <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br>
                <input type="submit" value="Update User">
            </form>
        </body>
        </html>
        <?php
}
else {
    echo "User not found";
}
$conn->close();
?>