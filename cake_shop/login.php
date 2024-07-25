<?php
session_start();
include 'includes/db.php';
include 'templates/header.php';
?>

<div class="container">
    <form class="standard-form" action="login_process.php" method="POST" onsubmit="return validateLoginForm()">
        <h1>Login</h1>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</div>

<script>
function validateLoginForm() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    if (!email || !password) {
        alert("Please fill out all fields.");
        return false;
    }
    return true;
}
</script>

<?php include 'templates/footer.php'; ?>
