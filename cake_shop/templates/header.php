<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Shop</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="account.php">Account</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="add_product.php">Add Product</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Signup</a></li>
            <?php endif; ?>
            <li class="search-container">
                <form action="search.php" method="GET" class="search-form">
                    <input type="text" name="query" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>
            </li>
        </ul>
    </nav>
</header>
</body>
</html>
