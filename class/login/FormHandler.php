<?php
class FormHandler {
    // Validate and sanitize input data
    public function validateInput($data) {
        $data = trim($data); // Remove leading/trailing whitespace
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data;
    }

    // Validate name input
    public function validateName($name) {
        if (empty($name)) {
            return "Name is required";
        } else {
            // Check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                return "Only letters and white space allowed";
            }
        }
        return ""; // Return empty string if validation passes
    }
        // Get current date and time
        public function getCurrentDateTime() {
            return date('Y-m-d H:i:s');
        }
    
}
?>
