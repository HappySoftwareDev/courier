<?php
/**
 * Validation Helper
 * Handles all input validation
 */

class ValidationHelper {
    /**
     * Validate email
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate phone
     */
    public static function validatePhone($phone) {
        // Remove spaces and special chars for validation
        $cleaned = preg_replace('/[^\d\+]/', '', $phone);
        return strlen($cleaned) >= 7 && strlen($cleaned) <= 15;
    }

    /**
     * Validate URL
     */
    public static function validateUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Sanitize string
     */
    public static function sanitizeString($string) {
        return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize array recursively
     */
    public static function sanitizeArray($array) {
        $sanitized = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = self::sanitizeArray($value);
            } else {
                $sanitized[$key] = self::sanitizeString($value);
            }
        }
        return $sanitized;
    }

    /**
     * Validate booking data
     */
    public static function validateBookingData($data) {
        $errors = [];

        if (empty($data['name']) || strlen($data['name']) < 2) {
            $errors[] = 'Please enter a valid name';
        }

        if (!self::validateEmail($data['email'])) {
            $errors[] = 'Please enter a valid email address';
        }

        if (!self::validatePhone($data['phone'])) {
            $errors[] = 'Please enter a valid phone number';
        }

        if (empty($data['pickup_address'])) {
            $errors[] = 'Pickup address is required';
        }

        if (empty($data['drop_address'])) {
            $errors[] = 'Delivery address is required';
        }

        if (empty($data['weight']) || !is_numeric($data['weight']) || $data['weight'] <= 0) {
            $errors[] = 'Please enter a valid weight';
        }

        if (empty($data['quantity']) || !is_numeric($data['quantity']) || $data['quantity'] <= 0) {
            $errors[] = 'Please enter a valid quantity';
        }

        if (empty($data['total_price']) || !is_numeric($data['total_price']) || $data['total_price'] <= 0) {
            $errors[] = 'Invalid price';
        }

        return count($errors) === 0 ? true : $errors;
    }

    /**
     * Validate password strength
     */
    public static function validatePassword($password) {
        $errors = [];

        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters';
        }

        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain lowercase letters';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain uppercase letters';
        }

        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain numbers';
        }

        if (!preg_match('/[\W_]/', $password)) {
            $errors[] = 'Password must contain special characters';
        }

        return count($errors) === 0 ? true : $errors;
    }

    /**
     * Validate coordinates (latitude, longitude)
     */
    public static function validateCoordinates($lat, $lng) {
        return is_numeric($lat) && is_numeric($lng) && 
               $lat >= -90 && $lat <= 90 && 
               $lng >= -180 && $lng <= 180;
    }
}

?>


