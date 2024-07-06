<?php
class FormHandler {
    
    // Validate email input
    public function validateEmail($email) {
        if (empty($email)) {
            return "Email is required";
        } else {
            // Check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "Invalid email format";
            }
        }
        return ""; // Return empty string if validation passes
    }
}
?>