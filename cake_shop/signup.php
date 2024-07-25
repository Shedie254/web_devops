<?php
session_start();
include 'includes/db.php';
include 'templates/header.php';
?>

<div class="container">
    <form class="standard-form" action="signup_process.php" method="POST" onsubmit="return validateSignupForm()">
        <h1>Signup</h1>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Signup</button>
    </form>
</div>

<script>
function validateSignupForm() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    if (!name || !email || !password) {
        alert("Please fill out all fields.");
        return false;
    }
    return true;
}
</script>

<?php include 'templates/footer.php'; ?>
