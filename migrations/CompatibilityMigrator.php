<?php
/**
 * SQL Compatibility Migration Runner
 * Makes the original wgroosco_app_wgroos.sql compatible with the new modernized system
 * 
 * Run this script ONCE to:
 * 1. Expand password columns to support bcrypt
 * 2. Create new tables (config, email_templates)
 * 3. Populate default configurations
 * 4. Seed email templates
 */

require_once 'config/database.php';

class CompatibilityMigrator {
    private $db;
    private $errors = [];
    private $warnings = [];
    private $successes = [];

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Step 1: Expand password columns
     */
    public function expandPasswordColumns() {
        echo "\n[STEP 1] Expanding password columns to support bcrypt...\n";
        
        $columns = [
            ['table' => 'admin', 'column' => 'Password'],
            ['table' => 'driver', 'column' => 'password'],
            ['table' => 'users', 'column' => 'password'],
            ['table' => 'affilate_user', 'column' => 'password'],
            ['table' => 'clients', 'column' => 'Password'],
        ];

        foreach ($columns as $col) {
            try {
                // Check current column size
                $checkSql = "SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS 
                             WHERE TABLE_NAME = '{$col['table']}' AND COLUMN_NAME = '{$col['column']}'";
                
                $result = $this->db->query($checkSql);
                $current = $result->fetch()['CHARACTER_MAXIMUM_LENGTH'] ?? 0;

                if ($current < 255) {
                    $sql = "ALTER TABLE `{$col['table']}` MODIFY COLUMN `{$col['column']}` VARCHAR(255) NOT NULL";
                    $this->db->query($sql);
                    $this->successes[] = "✓ {$col['table']}.{$col['column']} expanded to VARCHAR(255)";
                } else {
                    $this->successes[] = "✓ {$col['table']}.{$col['column']} already VARCHAR(255)";
                }
            } catch (Exception $e) {
                $this->warnings[] = "⚠ Could not modify {$col['table']}.{$col['column']}: {$e->getMessage()}";
            }
        }
    }

    /**
     * Step 2: Create config table
     */
    public function createConfigTable() {
        echo "\n[STEP 2] Creating config table...\n";
        
        try {
            // Check if table exists
            $checkSql = "SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'config'";
            $result = $this->db->query($checkSql);

            if ($result->rowCount() > 0) {
                $this->warnings[] = "⚠ config table already exists, skipping creation";
                return;
            }

            $sql = "CREATE TABLE IF NOT EXISTS `config` (
              `config_id` INT AUTO_INCREMENT PRIMARY KEY,
              `config_key` VARCHAR(255) UNIQUE NOT NULL COMMENT 'Configuration key (e.g., app_name, base_price)',
              `config_value` LONGTEXT NOT NULL COMMENT 'Configuration value (stored as JSON if needed)',
              `config_type` VARCHAR(50) DEFAULT 'string' COMMENT 'Data type: string, number, boolean, json',
              `description` TEXT COMMENT 'Human-readable description of this config',
              `section` VARCHAR(100) DEFAULT 'general' COMMENT 'Configuration section: general, pricing, email, payment, features',
              `is_locked` BOOLEAN DEFAULT FALSE COMMENT 'If true, cannot be modified via admin UI',
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              INDEX idx_section (section),
              INDEX idx_created (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

            $this->db->query($sql);
            $this->successes[] = "✓ config table created successfully";

        } catch (Exception $e) {
            $this->errors[] = "✗ Failed to create config table: {$e->getMessage()}";
        }
    }

    /**
     * Step 3: Populate config table with defaults
     */
    public function populateConfigTable() {
        echo "\n[STEP 3] Populating config table with defaults...\n";
        
        try {
            $defaults = [
                // General Settings
                ['app_name', 'Wgroos Logistics', 'string', 'Application name', 'general'],
                ['app_url', 'https://app.wgroos.com', 'string', 'Main application URL', 'general'],
                ['support_email', 'support@wgroos.com', 'string', 'Support email', 'general'],
                ['support_phone', '+265999999999', 'string', 'Support phone', 'general'],
                ['timezone', 'Africa/Blantyre', 'string', 'Timezone', 'general'],
                ['company_address', 'Lilongwe, Malawi', 'string', 'Company address', 'general'],
                ['currency', 'MWK', 'string', 'Currency code', 'general'],
                ['currency_symbol', 'K', 'string', 'Currency symbol', 'general'],
                
                // Pricing Settings
                ['base_price_parcel', '500', 'number', 'Base parcel price', 'pricing'],
                ['base_price_freight', '2000', 'number', 'Base freight price', 'pricing'],
                ['base_price_furniture', '3000', 'number', 'Base furniture price', 'pricing'],
                ['base_price_taxi', '300', 'number', 'Base taxi price per km', 'pricing'],
                ['base_price_towtruck', '1500', 'number', 'Base towtruck price', 'pricing'],
                ['price_per_km', '50', 'number', 'Price per km', 'pricing'],
                ['insurance_percentage', '10', 'number', 'Insurance percentage', 'pricing'],
                ['platform_fee_percentage', '15', 'number', 'Platform fee percentage', 'pricing'],
                
                // Email Settings
                ['email_from_address', 'noreply@wgroos.com', 'string', 'From email', 'email'],
                ['email_from_name', 'Wgroos Logistics', 'string', 'From name', 'email'],
                ['smtp_enabled', 'true', 'boolean', 'Enable SMTP', 'email'],
                
                // Firebase Settings
                ['firebase_enabled', 'false', 'boolean', 'Enable Firebase', 'features'],
                ['firebase_api_key', '', 'string', 'Firebase API key', 'features'],
            ];

            $insertedCount = 0;
            foreach ($defaults as $config) {
                try {
                    $sql = "INSERT INTO config (config_key, config_value, config_type, description, section) 
                            VALUES (?, ?, ?, ?, ?) 
                            ON DUPLICATE KEY UPDATE config_value = VALUES(config_value)";
                    
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute($config);
                    $insertedCount++;
                } catch (Exception $e) {
                    // Skip if duplicate key error
                    if (strpos($e->getMessage(), 'Duplicate') === false) {
                        throw $e;
                    }
                }
            }

            $this->successes[] = "✓ Config table populated with {$insertedCount} entries";

        } catch (Exception $e) {
            $this->errors[] = "✗ Failed to populate config: {$e->getMessage()}";
        }
    }

    /**
     * Step 4: Create email templates table
     */
    public function createEmailTemplatesTable() {
        echo "\n[STEP 4] Creating email_templates table...\n";
        
        try {
            // Check if table exists
            $checkSql = "SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'email_templates'";
            $result = $this->db->query($checkSql);

            if ($result->rowCount() > 0) {
                $this->warnings[] = "⚠ email_templates table already exists, skipping creation";
                return;
            }

            $sql = "CREATE TABLE IF NOT EXISTS `email_templates` (
              `template_id` INT AUTO_INCREMENT PRIMARY KEY,
              `template_key` VARCHAR(255) UNIQUE NOT NULL COMMENT 'Unique key for template',
              `template_name` VARCHAR(255) NOT NULL COMMENT 'Human-readable name',
              `subject` VARCHAR(500) NOT NULL COMMENT 'Email subject',
              `body` LONGTEXT NOT NULL COMMENT 'Email body HTML',
              `plain_text` LONGTEXT COMMENT 'Email plain text version',
              `description` TEXT COMMENT 'When this template is used',
              `is_active` BOOLEAN DEFAULT TRUE,
              `placeholders` JSON COMMENT 'Available placeholders',
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              INDEX idx_template_key (template_key),
              INDEX idx_is_active (is_active)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

            $this->db->query($sql);
            $this->successes[] = "✓ email_templates table created successfully";

        } catch (Exception $e) {
            $this->errors[] = "✗ Failed to create email_templates table: {$e->getMessage()}";
        }
    }

    /**
     * Step 5: Seed email templates
     */
    public function seedEmailTemplates() {
        echo "\n[STEP 5] Seeding email templates...\n";
        
        try {
            $templates = [
                [
                    'booking_confirmation',
                    'Booking Confirmation',
                    'Your {{app_name}} Booking #{{order_id}} Confirmed',
                    'Sent when customer completes booking'
                ],
                [
                    'booking_assigned',
                    'Driver Assigned',
                    'Driver {{driver_name}} Assigned to Your Order',
                    'Sent when driver is assigned'
                ],
                [
                    'booking_completed',
                    'Delivery Complete',
                    'Your {{app_name}} Order #{{order_id}} Completed',
                    'Sent when delivery is complete'
                ],
                [
                    'password_reset',
                    'Password Reset',
                    'Reset Your {{app_name}} Password',
                    'Sent for password reset'
                ],
            ];

            $insertedCount = 0;
            foreach ($templates as $template) {
                try {
                    $sql = "INSERT INTO email_templates (template_key, template_name, subject, description, body, plain_text) 
                            VALUES (?, ?, ?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE template_name = VALUES(template_name)";
                    
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        $template[0],
                        $template[1],
                        $template[2],
                        $template[3],
                        '<p>{{message}}</p>',  // Default body
                        '{{message}}'           // Default plain text
                    ]);
                    $insertedCount++;
                } catch (Exception $e) {
                    if (strpos($e->getMessage(), 'Duplicate') === false) {
                        throw $e;
                    }
                }
            }

            $this->successes[] = "✓ Email templates seeded with {$insertedCount} templates";

        } catch (Exception $e) {
            $this->errors[] = "✗ Failed to seed email templates: {$e->getMessage()}";
        }
    }

    /**
     * Step 6: Create password migration tracking table
     */
    public function createPasswordMigrationTable() {
        echo "\n[STEP 6] Creating password migration tracking table...\n";
        
        try {
            $sql = "CREATE TABLE IF NOT EXISTS `password_migrations` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `user_table` VARCHAR(50) NOT NULL,
              `user_id` INT NOT NULL,
              `old_password_hash` VARCHAR(40),
              `new_password_hash` VARCHAR(255),
              `migrated_at` TIMESTAMP,
              `status` ENUM('pending', 'migrated', 'skipped') DEFAULT 'pending',
              UNIQUE KEY `migration_track` (user_table, user_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

            $this->db->query($sql);
            $this->successes[] = "✓ password_migrations table created";

        } catch (Exception $e) {
            $this->warnings[] = "⚠ Could not create password_migrations table: {$e->getMessage()}";
        }
    }

    /**
     * Run all migrations
     */
    public function runAll() {
        echo "\n" . str_repeat("=", 70);
        echo "\n🔄 RUNNING SQL COMPATIBILITY MIGRATIONS\n";
        echo str_repeat("=", 70);

        $this->expandPasswordColumns();
        $this->createConfigTable();
        $this->populateConfigTable();
        $this->createEmailTemplatesTable();
        $this->seedEmailTemplates();
        $this->createExchangeRatesTable();
        $this->populateExchangeRatesConfig();
        $this->createPasswordMigrationTable();

        $this->displayResults();
    }

    /**
     * Step 6: Create exchange rates table for caching
     */
    public function createExchangeRatesTable() {
        echo "\n[STEP 6] Creating exchange rates cache table...\n";
        
        try {
            $checkSql = "SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'exchange_rates'";
            $result = $this->db->query($checkSql);

            if ($result->rowCount() > 0) {
                $this->warnings[] = "⚠ exchange_rates table already exists";
                return;
            }

            $sql = "CREATE TABLE IF NOT EXISTS `exchange_rates` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `from_currency` VARCHAR(3) NOT NULL,
              `to_currency` VARCHAR(3) NOT NULL,
              `rate` DECIMAL(15,8) NOT NULL,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              UNIQUE KEY `currency_pair` (`from_currency`, `to_currency`),
              KEY `created_at` (`created_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

            $this->db->query($sql);
            $this->successes[] = "✓ exchange_rates table created successfully";

        } catch (Exception $e) {
            $this->errors[] = "✗ Failed to create exchange_rates table: {$e->getMessage()}";
        }
    }

    /**
     * Step 7: Populate currency and country configuration
     */
    public function populateExchangeRatesConfig() {
        echo "\n[STEP 7] Adding currency and country configuration...\n";
        
        try {
            $configs = [
                ['base_currency', 'USD', 'string', 'Base currency for pricing (USD, GBP, ZAR, etc.)', 'general'],
                ['base_country', 'US', 'string', 'Country of operation (affects timezone and currency defaults)', 'general'],
                ['allow_currency_selection', 'true', 'boolean', 'Allow customers to select payment currency', 'general'],
                ['currency_list', '["USD", "EUR", "GBP", "ZAR", "ZWL", "NGN", "KES", "GHS"]', 'json', 'List of supported currencies for bookings', 'general'],
                ['exchange_rate_cache_duration', '3600', 'number', 'How long to cache exchange rates in seconds', 'general'],
            ];

            foreach ($configs as $config) {
                try {
                    $sql = "INSERT INTO config (config_key, config_value, config_type, description, section) 
                            VALUES (?, ?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE config_value = VALUES(config_value)";
                    
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute($config);
                    $this->successes[] = "✓ Added config: {$config[0]}";
                    
                } catch (Exception $e) {
                    $this->warnings[] = "⚠ Could not add config {$config[0]}: {$e->getMessage()}";
                }
            }

        } catch (Exception $e) {
            $this->errors[] = "✗ Failed to populate currency config: {$e->getMessage()}";
        }
    }

    /**
     * Display migration results
     */
    private function displayResults() {
        echo "\n" . str_repeat("=", 70);
        echo "\n📊 MIGRATION RESULTS\n";
        echo str_repeat("=", 70);

        if (!empty($this->successes)) {
            echo "\n✅ SUCCESSES (" . count($this->successes) . "):\n";
            foreach ($this->successes as $msg) {
                echo "   $msg\n";
            }
        }

        if (!empty($this->warnings)) {
            echo "\n⚠️  WARNINGS (" . count($this->warnings) . "):\n";
            foreach ($this->warnings as $msg) {
                echo "   $msg\n";
            }
        }

        if (!empty($this->errors)) {
            echo "\n❌ ERRORS (" . count($this->errors) . "):\n";
            foreach ($this->errors as $msg) {
                echo "   $msg\n";
            }
        }

        echo "\n" . str_repeat("=", 70);
        echo "\n✅ MIGRATIONS COMPLETED\n";
        echo str_repeat("=", 70) . "\n";

        // Return status
        return empty($this->errors) ? true : false;
    }
}

// Run if called directly
if (php_sapi_name() === 'cli' || (isset($_GET['run']) && $_GET['run'] === 'migrations')) {
    try {
        $migrator = new CompatibilityMigrator($DB);
        $migrator->runAll();
    } catch (Exception $e) {
        die("Fatal error: " . $e->getMessage());
    }
}

?>
