<?php
class FormHandler {
    
    // Validate input data
    public function validateInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    // Validate name input
    public function validateName($name) {
        if (empty($name)) {
            return "Name is required";
        } else {
            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                return "Only letters and white space allowed";
            }
        }
        return "";
    }
    
    // Validate email input
    public function validateEmail($email) {
        if (empty($email)) {
            return "Email is required";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "Invalid email format";
            }
        }
        return "";
    }
    
    // Get data from URL
    public function getDataFromURL($param) {
        return isset($_GET[$param]) ? $_GET[$param] : '';
    }
    
    // Get data from email
    public function getDataFromEmail($param) {
        return isset($_POST[$param]) ? $_POST[$param] : '';
    }
    
    // Get current date and time
    public function getCurrentDateTime() {
        return date('Y-m-d H:i:s');
    }
}

// Example usage:
$formHandler = new FormHandler();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $formHandler->validateInput($_POST['name']);
    $email = $formHandler->validateInput($_POST['email']);
    
    // Validate inputs
    $nameError = $formHandler->validateName($name);
    $emailError = $formHandler->validateEmail($email);
    
    if (empty($nameError) && empty($emailError)) {
        // Process form data
        $timestamp = $formHandler->getCurrentDateTime();
        
        // Example: Display success message
        echo "Form submitted successfully at $timestamp";
    } else {
        // Example: Display validation errors
        echo "Validation errors:<br>";
        echo $nameError . "<br>";
        echo $emailError . "<br>";
    }
}
?>

<!-- Sample HTML form -->

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Name: <input type="text" name="name"><br>
    Email: <input type="text" name="email"><br>
    <input type="submit">
</form>
