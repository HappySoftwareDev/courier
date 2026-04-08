<?php
/**
 * Setup & Verification Script
 * Run this to initialize and verify the new system
 */

define('APP_PATH', dirname(__FILE__));
define('SHOW_DEBUG', true);

class SetupVerifier {
    private $errors = [];
    private $warnings = [];
    private $success = [];
    
    public function run() {
        echo "=== Merchant Couriers - System Verification ===\n\n";
        
        $this->checkPhpVersion();
        $this->checkExtensions();
        $this->checkFilesExist();
        $this->checkDatabaseConnection();
        $this->checkTables();
        $this->checkDirectoryPermissions();
        
        $this->outputResults();
    }
    
    private function checkPhpVersion() {
        echo "[1/6] Checking PHP Version...\n";
        $version = phpversion();
        if (version_compare($version, '7.4', '>=')) {
            $this->success[] = "PHP $version - OK";
        } else {
            $this->errors[] = "PHP $version - Requires 7.4 or higher";
        }
    }
    
    private function checkExtensions() {
        echo "[2/6] Checking Extensions...\n";
        $required = ['pdo', 'pdo_mysql', 'mysqli', 'json', 'curl', 'filter'];
        
        foreach ($required as $ext) {
            if (extension_loaded($ext)) {
                $this->success[] = "Extension '$ext' - Loaded";
            } else {
                $this->errors[] = "Extension '$ext' - NOT loaded (required)";
            }
        }
    }
    
    private function checkFilesExist() {
        echo "[3/6] Checking New Files Exist...\n";
        
        $files = [
            'config/bootstrap.php',
            'config/database.php',
            'config/ConfigManager.php',
            'app/classes/BookingProcessor.php',
            'app/classes/AuthManager.php',
            'app/classes/PricingEngine.php',
            'app/helpers/ValidationHelper.php',
            'app/helpers/EmailHelper.php',
            'book/submit.php',
            'admin/pages/site_management_new.php',
            'database/migrations/001_create_site_settings.sql'
        ];
        
        foreach ($files as $file) {
            $path = APP_PATH . '/' . $file;
            if (file_exists($path)) {
                $size = round(filesize($path) / 1024, 2);
                $this->success[] = "File exists: $file ($size KB)";
            } else {
                $this->warnings[] = "File missing: $file";
            }
        }
    }
    
    private function checkDatabaseConnection() {
        echo "[4/6] Checking Database Connection...\n";
        
        try {
            $dbHost = 'localhost';
            $dbUser = 'wgroosco_wp598app';
            $dbPass = ''; // Will need to be provided
            $dbName = 'wgroosco_app.wgroos';
            
            $pdo = new PDO(
                "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
                $dbUser,
                $dbPass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            
            $this->success[] = "Database connected - $dbName";
        } catch (Exception $e) {
            $this->errors[] = "Database connection failed: " . $e->getMessage();
        }
    }
    
    private function checkTables() {
        echo "[5/6] Checking Database Tables...\n";
        
        try {
            $dbHost = 'localhost';
            $dbUser = 'wgroosco_wp598app';
            $dbPass = '';
            $dbName = 'wgroosco_app.wgroos';
            
            $pdo = new PDO(
                "mysql:host=$dbHost;dbname=$dbName",
                $dbUser,
                $dbPass
            );
            
            $tables = ['site_settings', 'users', 'bookings', 'driver'];
            
            foreach ($tables as $table) {
                $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
                if ($stmt) {
                    $count = $stmt->fetchColumn();
                    $this->success[] = "Table '$table' exists ($count rows)";
                } else {
                    $this->warnings[] = "Table '$table' - Query failed";
                }
            }
            
            // Check if site_settings is populated
            $stmt = $pdo->query("SELECT COUNT(*) FROM site_settings");
            $settingsCount = $stmt->fetchColumn();
            
            if ($settingsCount > 0) {
                $this->success[] = "Site settings populated ($settingsCount settings)";
            } else {
                $this->warnings[] = "Site settings table is empty - run migration";
            }
            
        } catch (Exception $e) {
            // Skip if connection failed
        }
    }
    
    private function checkDirectoryPermissions() {
        echo "[6/6] Checking Directory Permissions...\n";
        
        $dirs = [
            'app',
            'config',
            'templates',
            'database',
            'logs'
        ];
        
        foreach ($dirs as $dir) {
            $path = APP_PATH . '/' . $dir;
            
            if (!is_dir($path)) {
                @mkdir($path, 0755, true);
            }
            
            if (is_writable($path)) {
                $this->success[] = "Directory writable: $dir";
            } else {
                $this->warnings[] = "Directory not writable: $dir";
            }
        }
    }
    
    private function outputResults() {
        echo "\n\n=== RESULTS ===\n\n";
        
        if (!empty($this->errors)) {
            echo "❌ ERRORS (" . count($this->errors) . "):\n";
            foreach ($this->errors as $error) {
                echo "  - $error\n";
            }
            echo "\n";
        }
        
        if (!empty($this->warnings)) {
            echo "⚠️ WARNINGS (" . count($this->warnings) . "):\n";
            foreach ($this->warnings as $warning) {
                echo "  - $warning\n";
            }
            echo "\n";
        }
        
        echo "✅ SUCCESS (" . count($this->success) . "):\n";
        foreach ($this->success as $item) {
            echo "  - $item\n";
        }
        
        echo "\n\n";
        
        if (empty($this->errors)) {
            echo "✅ All critical checks passed!\n";
            echo "Next step: Run database migration\n";
            echo "Command: mysql -u wgroosco_wp598app -p wgroosco_app.wgroos < database/migrations/001_create_site_settings.sql\n";
        } else {
            echo "❌ Fix errors above before proceeding\n";
        }
    }
}

// Run verification
$verifier = new SetupVerifier();
$verifier->run();
?>

