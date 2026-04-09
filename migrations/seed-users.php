<?php
/**
 * Initial User Setup & API Key Generation
 * 
 * This script creates initial users for all portals and generates API credentials.
 * Run this AFTER running the SQL migrations: 004_create_initial_users.sql
 * 
 * Usage: php seed-users.php (from project root or migrations directory)
 */

// Determine the correct path to bootstrap.php
$configPath = null;
$possiblePaths = [
    __DIR__ . '/../config/bootstrap.php',      // If run from migrations dir
    __DIR__ . '/config/bootstrap.php',         // If run from project root
    dirname(__DIR__) . '/config/bootstrap.php', // Parent dir approach
];

foreach ($possiblePaths as $path) {
    if (file_exists($path)) {
        $configPath = $path;
        break;
    }
}

if (!$configPath) {
    die("Error: Could not find config/bootstrap.php. Please ensure you have a valid config/bootstrap.php file in your project.\n");
}

require_once $configPath;

// Load database configuration
$dbConfig = null;
$dbConfigPaths = [
    dirname(dirname(__FILE__)) . '/config/database-config.php',
    dirname(__FILE__) . '/../config/database-config.php',
];

foreach ($dbConfigPaths as $path) {
    if (file_exists($path)) {
        $dbConfig = require $path;
        break;
    }
}

// Extract database credentials from config or constants
$dbHost = defined('DB_HOST') ? DB_HOST : ($dbConfig['host'] ?? 'localhost');
$dbUser = defined('DB_USER') ? DB_USER : ($dbConfig['user'] ?? '');
$dbPass = defined('DB_PASSWORD') ? DB_PASSWORD : ($dbConfig['pass'] ?? '');
$dbName = defined('DB_NAME') ? DB_NAME : ($dbConfig['name'] ?? '');

class UserSeeder {
    private $db;
    private $conn;
    private $dbHost;
    private $dbUser;
    private $dbPass;
    private $dbName;
    
    public function __construct($host, $user, $pass, $name) {
        $this->dbHost = $host;
        $this->dbUser = $user;
        $this->dbPass = $pass;
        $this->dbName = $name;
        
        try {
            // Get database connection
            $this->conn = new mysqli(
                $this->dbHost,
                $this->dbUser,
                $this->dbPass,
                $this->dbName
            );
            
            if ($this->conn->connect_error) {
                throw new Exception("Database connection failed: " . $this->conn->connect_error);
            }
            
            echo "[✓] Database connection established\n";
        } catch (Exception $e) {
            die("[✗] Error: " . $e->getMessage() . "\n");
        }
    }
    
    /**
     * Generate a secure API key
     * Format: pklive_[32-character hex string]
     */
    public static function generateApiKey() {
        $randomBytes = bin2hex(random_bytes(16));
        return 'pklive_' . $randomBytes;
    }
    
    /**
     * Hash password using bcrypt (matching AuthManager)
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    
    /**
     * Create Admin User
     */
    public function createAdminUser($email, $password, $name = 'System Admin', $phone = '+000000000000') {
        echo "\n[→] Creating Admin User...\n";
        
        // Check if admin already exists
        $stmt = $this->conn->prepare("SELECT ID FROM admin WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "[!] Admin with email '{$email}' already exists\n";
            return true;
        }
        
        // Insert admin user (store plain password as existing system uses it)
        $stmt = $this->conn->prepare(
            "INSERT INTO admin (Name, Email, phone, Password) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $name, $email, $phone, $password);
        
        if ($stmt->execute()) {
            echo "[✓] Admin user created: {$email}\n";
            return true;
        } else {
            echo "[✗] Failed to create admin: " . $stmt->error . "\n";
            return false;
        }
    }
    
    /**
     * Create Customer/Booking User
     */
    public function createCustomerUser($email, $password, $name = 'Test Customer') {
        echo "\n[→] Creating Customer User...\n";
        
        // Check if customer already exists
        $stmt = $this->conn->prepare("SELECT Userid FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "[!] Customer with email '{$email}' already exists\n";
            return true;
        }
        
        // Insert customer into users table (not clients)
        $stmt = $this->conn->prepare(
            "INSERT INTO users (Name, email, password, days) VALUES (?, ?, ?, ?)"
        );
        $days = 14;
        $stmt->bind_param("sssi", $name, $email, $password, $days);
        
        if ($stmt->execute()) {
            echo "[✓] Customer user created: {$email}\n";
            return true;
        } else {
            echo "[✗] Failed to create customer: " . $stmt->error . "\n";
            return false;
        }
    }
    
    /**
     * Create Driver User
     */
    public function createDriverUser(
        $username, 
        $password, 
        $email, 
        $name = 'Test Driver',
        $phone = '+000000000000',
        $driverNumber = 10001
    ) {
        echo "\n[→] Creating Driver User...\n";
        
        // Check if driver already exists
        $stmt = $this->conn->prepare("SELECT driverID FROM driver WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "[!] Driver with username '{$username}' already exists\n";
            return true;
        }
        
        // Insert driver
        $stmt = $this->conn->prepare(
            "INSERT INTO driver (
                driver_number, name, email, username, password, phone, 
                company_name, address, city, vehicleMake, model, year, 
                engineCapacity, RegNo, occupation, mode_of_transport, 
                type_of_service, profileImage, online, info
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        
        $company = 'Test Company';
        $address = 'Test Address';
        $city = 'Test City';
        $make = 'Test';
        $model = 'Test';
        $year = '2020';
        $capacity = '2000cc';
        $regNo = 'TEST001';
        $occupation = 'Driver';
        $transport = 'Car';
        $service = 'Parcel Delivery';
        $profileImage = 'profilePic';
        $online = 'offline';
        $info = '....';
        
        $stmt->bind_param(
            "isssssssssssssssss",
            $driverNumber, $name, $email, $username, $password, $phone,
            $company, $address, $city, $make, $model, $year,
            $capacity, $regNo, $occupation, $transport, $service, $profileImage, $online, $info
        );
        
        if ($stmt->execute()) {
            echo "[✓] Driver user created: {$username} ({$email})\n";
            return true;
        } else {
            echo "[✗] Failed to create driver: " . $stmt->error . "\n";
            return false;
        }
    }
    
    /**
     * Create API User with Auto-Generated Key
     */
    public function createApiUser(
        $businessName,
        $businessEmail,
        $password,
        $businessPhone = '+000000000000',
        $contactPerson = 'System'
    ) {
        echo "\n[→] Creating API User...\n";
        
        // Generate API key
        $apiKey = self::generateApiKey();
        
        // Check if API user already exists
        $stmt = $this->conn->prepare("SELECT id FROM api_users WHERE business_email = ?");
        $stmt->bind_param("s", $businessEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "[!] API user with email '{$businessEmail}' already exists, regenerating key...\n";
            // Update API key for existing user
            $stmt = $this->conn->prepare("UPDATE api_users SET api_key = ? WHERE business_email = ?");
            $stmt->bind_param("ss", $apiKey, $businessEmail);
            $stmt->execute();
        } else {
            // Create new API user
            $stmt = $this->conn->prepare(
                "INSERT INTO api_users (
                    business_name, business_email, business_phone, password, 
                    api_key, contact_person, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            
            $status = 'active';
            $stmt->bind_param("sssssss", $businessName, $businessEmail, $businessPhone, $password, $apiKey, $contactPerson, $status);
            
            if (!$stmt->execute()) {
                echo "[✗] Failed to create API user: " . $stmt->error . "\n";
                return false;
            }
        }
        
        echo "[✓] API Key Generated: {$apiKey}\n";
        echo "    Business: {$businessName}\n";
        echo "    Email: {$businessEmail}\n";
        
        return $apiKey;
    }
    
    /**
     * Create API User Business Link
     */
    public function createApiUserBusiness($apiUserId, $businessName, $businessEmail, $apiKey) {
        echo "\n[→] Linking API User to Business...\n";
        
        // Check if already linked
        $stmt = $this->conn->prepare("SELECT id FROM api_users_business WHERE api_user_id = ?");
        $stmt->bind_param("i", $apiUserId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "[!] API user already linked to a business\n";
            return false;
        }
        
        $stmt = $this->conn->prepare(
            "INSERT INTO api_users_business (
                api_user_id, business_name, business_email, password, 
                api_key, status
            ) VALUES (?, ?, ?, ?, ?, ?)"
        );
        
        $password = '12345#$';
        $status = 'active';
        $stmt->bind_param("isssss", $apiUserId, $businessName, $businessEmail, $password, $apiKey, $status);
        
        if ($stmt->execute()) {
            echo "[✓] API User Business link created\n";
            return true;
        } else {
            echo "[✗] Failed to link business: " . $stmt->error . "\n";
            return false;
        }
    }
    
    /**
     * Display Summary
     */
    public function displaySummary() {
        echo "\n";
        echo "===========================================\n";
        echo "   INITIAL USER SETUP COMPLETED\n";
        echo "===========================================\n";
        echo "\n✓ DEFAULT TEST CREDENTIALS:\n";
        echo "\n  Admin Portal:\n";
        echo "    Email: admin@app.wgroos.com\n";
        echo "    Password: 12345#$\n";
        echo "\n  Booking/Customer Portal:\n";
        echo "    Email: customer@app.wgroos.com\n";
        echo "    Password: 12345#$\n";
        echo "\n  Driver Portal:\n";
        echo "    Username: testdriver\n";
        echo "    Password: 12345#$\n";
        echo "\n  API Access:\n";
        echo "    Email: api@app.wgroos.com\n";
        echo "    Password: 12345#$\n";
        echo "    Check database api_users table for API keys\n";
        echo "\n⚠  IMPORTANT - FOR PRODUCTION:\n";
        echo "    1. Change all default passwords immediately\n";
        echo "    2. Update email addresses to real values\n";
        echo "    3. Secure API keys properly\n";
        echo "    4. Delete test users when not needed\n";
        echo "\n===========================================\n\n";
    }
    
    public function close() {
        $this->conn->close();
    }
}

// ============================================================
// MAIN EXECUTION
// ============================================================
if (php_sapi_name() !== 'cli') {
    die("This script can only be run from the command line.\n");
}

echo "\n";
echo "╔════════════════════════════════════════╗\n";
echo "║   WG ROOS - Initial User Setup        ║\n";
echo "║   Seed Script v1.0                    ║\n";
echo "╚════════════════════════════════════════╝\n";

// Validate database credentials
if (empty($dbHost) || empty($dbUser) || empty($dbName)) {
    die("\n[✗] Error: Database credentials not found. Please ensure config/database-config.php exists.\n");
}

$seeder = new UserSeeder($dbHost, $dbUser, $dbPass, $dbName);

try {
    // Create test users for each portal
    $seeder->createAdminUser('admin@app.wgroos.com', '12345#$', 'System Admin', '+000000000000');
    $seeder->createCustomerUser('customer@app.wgroos.com', '12345#$', 'Test Customer');
    $seeder->createDriverUser('testdriver', '12345#$', 'driver@app.wgroos.com', 'Test Driver', '+000000000000', 10001);
    
    // Create API user with generated key
    $apiKey = $seeder->createApiUser(
        'Internal API User',
        'api@app.wgroos.com',
        '12345#$',
        '+000000000000',
        'System Administrator'
    );
    
    // Link API user to business
    $seeder->createApiUserBusiness(1, 'Internal API Business', 'api@app.wgroos.com', $apiKey);
    
    // Display summary
    $seeder->displaySummary();
    
} catch (Exception $e) {
    echo "[✗] Error: " . $e->getMessage() . "\n";
} finally {
    $seeder->close();
}
?>
