<?php
/**
 * Centralized Configuration Manager
 * All hardcoded settings moved to database and managed via admin panel
 * 
 * Supports two database schemas:
 * 1. Legacy: site_settings table with setting_key/setting_value columns
 * 2. New: config table with config_key/config_value columns
 */

class ConfigManager {
    private $db;
    private $settings = [];
    private $loaded = false;
    private $useNewSchema = false;

    public function __construct($db) {
        $this->db = $db;
        $this->detectSchema();
        $this->load();
    }

    /**
     * Detect which database schema is in use
     */
    private function detectSchema() {
        try {
            // Check for new config table
            $result = $this->db->query("SHOW TABLES LIKE 'config'");
            if ($result && $result->rowCount() > 0) {
                $this->useNewSchema = true;
                return;
            }
            
            // Fall back to legacy site_settings table
            $result = $this->db->query("SHOW TABLES LIKE 'site_settings'");
            if ($result && $result->rowCount() > 0) {
                $this->useNewSchema = false;
                return;
            }
        } catch (Exception $e) {
            error_log("Schema Detection Error: " . $e->getMessage());
        }
    }

    /**
     * Load all settings from database (public method)
     */
    public function load() {
        if ($this->useNewSchema) {
            $this->loadSettingsNewSchema();
        } else {
            $this->loadSettingsLegacy();
        }
    }

    /**
     * Load all settings from new config table
     */
    private function loadSettingsNewSchema() {
        try {
            $stmt = $this->db->prepare("SELECT config_key, config_value, config_type FROM config");
            $stmt->execute();
            
            $results = $stmt->fetchAll();
            foreach ($results as $row) {
                $key = $row['config_key'];
                $value = $row['config_value'];
                $type = $row['config_type'] ?? 'string';
                
                // Parse value based on type
                $value = $this->parseValue($value, $type);
                
                $this->settings[$key] = $value;
            }
            
            $this->loaded = true;
        } catch (Exception $e) {
            error_log("Settings Load Error (New Schema): " . $e->getMessage());
        }
    }

    /**
     * Load all settings from legacy site_settings table
     */
    private function loadSettingsLegacy() {
        try {
            $stmt = $this->db->prepare("SELECT setting_key, setting_value FROM site_settings");
            $stmt->execute();
            
            $results = $stmt->fetchAll();
            foreach ($results as $row) {
                $key = $row['setting_key'];
                $value = $row['setting_value'];
                
                // Parse JSON values
                if (strpos($value, '{') === 0 || strpos($value, '[') === 0) {
                    $value = json_decode($value, true);
                }
                
                // Parse boolean strings
                if ($value === 'true') $value = true;
                if ($value === 'false') $value = false;
                
                $this->settings[$key] = $value;
            }
            
            $this->loaded = true;
        } catch (Exception $e) {
            error_log("Settings Load Error (Legacy): " . $e->getMessage());
        }
    }

    /**
     * Parse configuration value based on type
     */
    private function parseValue($value, $type) {
        switch (strtolower($type)) {
            case 'boolean':
            case 'bool':
                return in_array($value, ['true', '1', 'yes', true], true);
            
            case 'number':
            case 'integer':
            case 'int':
                return (int) $value;
            
            case 'float':
            case 'decimal':
                return (float) $value;
            
            case 'json':
            case 'array':
                if (is_string($value)) {
                    return json_decode($value, true);
                }
                return $value;
            
            case 'string':
            default:
                return (string) $value;
        }
    }

    /**
     * Get a setting value with optional default
     */
    public function get($key, $default = null) {
        return $this->settings[$key] ?? $default;
    }

    /**
     * Get all settings as array
     */
    public function getAll() {
        return $this->settings;
    }

    /**
     * Get all settings (alias for getAll)
     */
    public function all() {
        return $this->settings;
    }

    /**
     * Set a setting temporarily (not saved to DB)
     */
    public function set($key, $value) {
        $this->settings[$key] = $value;
    }

    /**
     * Save setting to database
     */
    public function save($key, $value, $type = 'string', $section = 'general') {
        try {
            if ($this->useNewSchema) {
                return $this->saveLegacy($key, $value, $type, $section);
            } else {
                return $this->saveNewSchema($key, $value, $type, $section);
            }
        } catch (Exception $e) {
            error_log("Settings Save Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Save to new config table
     */
    private function saveNewSchema($key, $value, $type = 'string', $section = 'general') {
        try {
            // Convert complex types to string for storage
            if (is_array($value) || is_object($value)) {
                $storedValue = json_encode($value);
                $type = 'json';
            } elseif (is_bool($value)) {
                $storedValue = $value ? 'true' : 'false';
                $type = 'boolean';
            } else {
                $storedValue = (string) $value;
            }
            
            // Check if setting exists
            $checkStmt = $this->db->prepare("SELECT config_id FROM config WHERE config_key = ?");
            $checkStmt->execute([$key]);
            
            if ($checkStmt->rowCount() > 0) {
                // Update existing
                $stmt = $this->db->prepare(
                    "UPDATE config SET config_value = ?, config_type = ?, section = ?, updated_at = NOW() WHERE config_key = ?"
                );
                $stmt->execute([$storedValue, $type, $section, $key]);
            } else {
                // Insert new
                $stmt = $this->db->prepare(
                    "INSERT INTO config (config_key, config_value, config_type, section) VALUES (?, ?, ?, ?)"
                );
                $stmt->execute([$key, $storedValue, $type, $section]);
            }
            
            // Update in-memory cache
            $this->settings[$key] = $value;
            return true;
        } catch (Exception $e) {
            error_log("Save New Schema Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Save to legacy site_settings table
     */
    private function saveLegacy($key, $value, $type = 'string', $section = 'general') {
        try {
            // Convert arrays/objects to JSON
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value);
            }
            
            // Convert booleans to string
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }
            
            // Check if setting exists
            $checkStmt = $this->db->prepare("SELECT id FROM site_settings WHERE setting_key = ?");
            $checkStmt->execute([$key]);
            
            if ($checkStmt->rowCount() > 0) {
                // Update existing
                $stmt = $this->db->prepare("UPDATE site_settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?");
                $stmt->execute([$value, $key]);
            } else {
                // Insert new
                $stmt = $this->db->prepare("INSERT INTO site_settings (setting_key, setting_value, created_at) VALUES (?, ?, NOW())");
                $stmt->execute([$key, $value]);
            }
            
            // Update in-memory cache
            $this->settings[$key] = $value;
            return true;
        } catch (Exception $e) {
            error_log("Save Legacy Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get website settings
     */
    public function getWebsite() {
        return [
            'name' => $this->get('app_name', $this->get('site_name', 'Wgroos Logistics')),
            'url' => $this->get('app_url', $this->get('site_url', 'https://app.wgroos.com')),
            'logo' => $this->get('logo_path', ''),
            'favicon' => $this->get('favicon_path', 'favicon.ico'),
        ];
    }

    /**
     * Get business/contact settings
     */
    public function getBusiness() {
        return [
            'address' => $this->get('company_address', $this->get('business_address', '')),
            'phone' => $this->get('support_phone', $this->get('business_phone', '')),
            'email' => $this->get('support_email', $this->get('business_email', '')),
            'registration_number' => $this->get('business_reg_number', ''),
        ];
    }

    /**
     * Get payment gateway settings
     */
    public function getPayment() {
        return [
            'stripe_enabled' => $this->get('stripe_integration_enabled', false),
            'stripe_public_key' => $this->get('stripe_public_key', ''),
            'stripe_secret_key' => $this->get('stripe_secret_key', ''),
            'paynow_enabled' => $this->get('paynow_integration_enabled', false),
            'paynow_merchant_code' => $this->get('paynow_merchant_code', ''),
            'paynow_merchant_key' => $this->get('paynow_merchant_key', ''),
            'allow_cash_payment' => $this->get('allow_cash_payment', true),
            'require_payment_upfront' => $this->get('require_payment_upfront', false),
        ];
    }

    /**
     * Get Firebase settings
     */
    public function getFirebase() {
        return [
            'api_key' => $this->get('firebase_api_key', ''),
            'auth_domain' => $this->get('firebase_auth_domain', ''),
            'database_url' => $this->get('firebase_database_url', ''),
            'project_id' => $this->get('firebase_project_id', ''),
            'storage_bucket' => $this->get('firebase_storage_bucket', ''),
            'messaging_sender_id' => $this->get('firebase_messaging_sender_id', ''),
            'app_id' => $this->get('firebase_app_id', ''),
            'push_key' => $this->get('firebase_push_key', ''),
        ];
    }

    /**
     * Get SMS settings
     */
    public function getSMS() {
        return [
            'provider' => $this->get('sms_provider', 'africastalking'),
            'api_key' => $this->get('sms_api_key', ''),
            'api_url' => $this->get('sms_api_url', ''),
            'enabled' => $this->get('send_sms_notifications', true),
        ];
    }

    /**
     * Get Email settings
     */
    public function getEmail() {
        return [
            'from_email' => $this->get('email_from_address', $this->get('email_from', 'noreply@wgroos.com')),
            'from_name' => $this->get('email_from_name', 'Wgroos Logistics'),
            'smtp_host' => $this->get('smtp_host', ''),
            'smtp_port' => (int) $this->get('smtp_port', 587),
            'smtp_encryption' => $this->get('smtp_encryption', 'tls'),
            'smtp_user' => $this->get('smtp_username', ''),
            'smtp_pass' => $this->get('smtp_password', ''),
            'send_welcome_email' => $this->get('send_welcome_email', true),
            'send_booking_confirmation' => $this->get('send_booking_confirmation', true),
            'send_driver_assignment' => $this->get('send_driver_assignment', true),
            'send_completion_email' => $this->get('send_completion_email', true),
        ];
    }

    /**
     * Get security settings
     */
    public function getSecurity() {
        return [
            'recaptcha_enabled' => $this->get('recaptcha_enabled', false),
            'recaptcha_site_key' => $this->get('recaptcha_site_key', ''),
            'recaptcha_secret_key' => $this->get('recaptcha_secret_key', ''),
            'force_https' => $this->get('force_https', true),
            'session_timeout' => (int) $this->get('session_timeout_minutes', 60) * 60,
            'password_min_length' => (int) $this->get('password_min_length', 8),
            'max_login_attempts' => (int) $this->get('max_login_attempts', 5),
            'lockout_duration' => (int) $this->get('lockout_duration_minutes', 30) * 60,
        ];
    }

    /**
     * Get pricing settings
     */
    public function getPricing() {
        return [
            'currency' => $this->get('currency', 'MWK'),
            'currency_symbol' => $this->get('currency_symbol', 'K'),
            'parcel_base_price' => (float) $this->get('base_price_parcel', 500),
            'freight_base_price' => (float) $this->get('base_price_freight', 2000),
            'furniture_base_price' => (float) $this->get('base_price_furniture', 3000),
            'taxi_base_price' => (float) $this->get('base_price_taxi', 300),
            'towtruck_base_price' => (float) $this->get('base_price_towtruck', 1500),
            'price_per_km' => (float) $this->get('price_per_km', 50),
            'insurance_percentage' => (float) $this->get('insurance_percentage', 10),
            'platform_fee_percentage' => (float) $this->get('platform_fee_percentage', 15),
            'emergency_surcharge' => (float) $this->get('emergency_surcharge', 25),
        ];
    }

    /**
     * Get commission settings
     */
    public function getCommission() {
        return [
            'parcel_commission' => (float) $this->get('parcel_commission_percentage', 15),
            'freight_commission' => (float) $this->get('freight_commission_percentage', 20),
            'furniture_commission' => (float) $this->get('furniture_commission_percentage', 25),
            'taxi_commission' => (float) $this->get('taxi_commission_percentage', 15),
            'towtruck_commission' => (float) $this->get('towtruck_commission_percentage', 20),
        ];
    }

    /**
     * Get feature flags/toggles
     */
    public function getFeatures() {
        return [
            'guest_booking' => $this->get('guest_booking_enabled', false),
            'instant_booking' => $this->get('instant_booking_enabled', true),
            'scheduled_booking' => $this->get('scheduled_booking_enabled', true),
            'email_verification' => $this->get('email_verification_required', false),
            'phone_verification' => $this->get('phone_verification_required', true),
            'auto_assign_driver' => $this->get('auto_assign_driver', true),
            'two_factor_auth' => $this->get('two_factor_auth_enabled', false),
            'driver_rating' => $this->get('driver_rating_enabled', true),
            'customer_rating' => $this->get('customer_rating_enabled', true),
            'referral_program' => $this->get('referral_program_enabled', false),
            'affiliate_program' => $this->get('affiliate_program_enabled', true),
        ];
    }

    /**
     * Check if the system is using new or legacy schema
     */
    public function isUsingNewSchema() {
        return $this->useNewSchema;
    }

    /**
     * Get load status
     */
    public function isLoaded() {
        return $this->loaded;
    }
}


