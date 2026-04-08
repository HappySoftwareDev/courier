<?php
/**
 * Input Validation & Sanitization Middleware
 * 
 * Provides centralized input validation and sanitization methods.
 */

class InputValidator {
    /**
     * Validate email address
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Validate URL
     */
    public static function validateUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    /**
     * Validate IP address
     */
    public static function validateIP($ip) {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    /**
     * Validate phone number
     */
    public static function validatePhone($phone) {
        // Remove common separators
        $phone = preg_replace('/[\s\-\+\(\)]/', '', $phone);
        
        // Should have 7-15 digits (international standard)
        return preg_match('/^\d{7,15}$/', $phone);
    }

    /**
     * Validate integer
     */
    public static function validateInteger($value) {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    /**
     * Validate float
     */
    public static function validateFloat($value) {
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }

    /**
     * Validate date format (YYYY-MM-DD)
     */
    public static function validateDate($date, $format = 'Y-m-d') {
        $parsed = DateTime::createFromFormat($format, $date);
        return $parsed && $parsed->format($format) === $date;
    }

    /**
     * Validate date range
     */
    public static function validateDateRange($startDate, $endDate, $format = 'Y-m-d') {
        $start = DateTime::createFromFormat($format, $startDate);
        $end = DateTime::createFromFormat($format, $endDate);

        if (!$start || !$end) {
            return false;
        }

        return $start <= $end;
    }

    /**
     * Sanitize string input
     */
    public static function sanitizeString($string) {
        return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize email
     */
    public static function sanitizeEmail($email) {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitize URL
     */
    public static function sanitizeUrl($url) {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * Sanitize integer
     */
    public static function sanitizeInteger($value) {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Sanitize float
     */
    public static function sanitizeFloat($value) {
        return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    /**
     * Validate booking data
     */
    public static function validateBookingData($data) {
        $errors = [];

        // Name validation
        if (empty($data['name']) || strlen($data['name']) < 2) {
            $errors['name'] = 'Name must be at least 2 characters';
        }

        // Email validation
        if (empty($data['email']) || !self::validateEmail($data['email'])) {
            $errors['email'] = 'Invalid email address';
        }

        // Phone validation
        if (empty($data['phone']) || !self::validatePhone($data['phone'])) {
            $errors['phone'] = 'Invalid phone number (7-15 digits required)';
        }

        // Pickup address validation
        if (empty($data['pickup_address']) || strlen($data['pickup_address']) < 5) {
            $errors['pickup_address'] = 'Pickup address must be at least 5 characters';
        }

        // Drop address validation
        if (empty($data['drop_address']) || strlen($data['drop_address']) < 5) {
            $errors['drop_address'] = 'Drop-off address must be at least 5 characters';
        }

        // Service type validation
        if (empty($data['service_type']) || !array_key_exists($data['service_type'], SERVICE_TYPES)) {
            $errors['service_type'] = 'Invalid service type';
        }

        // Weight validation
        if (isset($data['weight'])) {
            if (!self::validateFloat($data['weight']) || floatval($data['weight']) <= 0) {
                $errors['weight'] = 'Weight must be a positive number';
            }
        }

        // Date validation
        if (!empty($data['pickup_date'])) {
            if (!self::validateDate($data['pickup_date'])) {
                $errors['pickup_date'] = 'Invalid pickup date format (YYYY-MM-DD)';
            }
        }

        // Time validation
        if (!empty($data['pickup_time'])) {
            if (!preg_match('/^\d{2}:\d{2}$/', $data['pickup_time'])) {
                $errors['pickup_time'] = 'Invalid time format (HH:MM)';
            }
        }

        return empty($errors) ? true : $errors;
    }

    /**
     * Validate password strength
     */
    public static function validatePassword($password) {
        $errors = [];

        if (strlen($password) < PASSWORD_MIN_LENGTH) {
            $errors[] = 'Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter';
        }

        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter';
        }

        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number';
        }

        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = 'Password must contain at least one special character';
        }

        return empty($errors) ? true : $errors;
    }

    /**
     * Escape SQL string (use prepared statements instead when possible)
     */
    public static function escapeSQLString($string) {
        // This is a fallback - prepared statements should be used instead
        return addslashes(trim($string));
    }

    /**
     * Get safe array values
     */
    public static function getSafeArrayValues($array, $keys) {
        $safe = [];
        foreach ($keys as $key) {
            $safe[$key] = isset($array[$key]) ? self::sanitizeString($array[$key]) : '';
        }
        return $safe;
    }
}


