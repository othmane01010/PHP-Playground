<?php
trait Validator {
    
    // Validate name: non-empty and follows a specific text pattern
    public function validateName($name) {
        $name = trim($name);
        if(empty($name)) {
            return false;
        }
        $pattern = "/^[a-zA-Z]+(\s[a-zA-Z]+){0,2}$/"; 
        return preg_match($pattern, $name);
    }

    // Check if the email format is valid
    public function validateEmail($email) {
        $email = trim($email);
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    // Check if password is at least 6 characters long
    public function validatePassword($password) {
        if (empty($password) || mb_strlen($password) < 6) {
            return false;
        }
        return true;
    }

    // Clean input data from tags and special characters
    public function sanitize($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    // Validate phone number (Optimized for Moroccan format)
    public function validatePhone($phone) {
      $phone = preg_replace('/[\s\-\.]/', '', $phone);
      if(empty($phone)){
            return false;
       }
      $pattern = "/^(?:(?:\+|00)212|0)[5-7][0-9]{8}$/";
      return preg_match($pattern, $phone);
    }
}
?>