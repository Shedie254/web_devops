<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Users List</h2>
    <a href='add_form.php' class = "link">Add New User</a>
    <?php
    include 'db.php';

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>
                        <a href='edit_user.php?id=" . $row['id'] . "'>Edit</a> | 
                        <a href='delete_user.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No users found";
    }

    $conn->close();
    ?>
</body>
</html>
