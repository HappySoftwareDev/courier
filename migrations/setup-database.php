<?php
/**
 * Database Setup Backend
 * Processes migration requests
 */

header('Content-Type: application/json; charset=utf-8');

require_once dirname(__DIR__) . '/config/database.php';

$action = $_GET['action'] ?? 'test';
$response = [
    'success' => false,
    'error' => '',
    'details' => []
];

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    if (!$conn) {
        throw new Exception("No database connection");
    }
    
    if ($action === 'test') {
        // Test connection
        $result = $conn->query("SELECT DATABASE() as db_name, USER() as user_info, VERSION() as version");
        if ($result) {
            $row = $result->fetch_assoc();
            $response['success'] = true;
            $response['database'] = $row['db_name'];
            $response['user'] = $row['user_info'];
            $response['version'] = $row['version'];
            $response['host'] = 'localhost';
        } else {
            throw new Exception("Failed to get database info: " . $conn->error);
        }
    } 
    elseif ($action === 'migrate') {
        // Run all migrations
        $migrations = [];
        $errors = [];
        
        // Disable foreign key checks temporarily
        $conn->query("SET FOREIGN_KEY_CHECKS=0");
        
        // Migration 1: Bookings table
        try {
            $sql = "
            CREATE TABLE IF NOT EXISTS bookings (
                booking_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                order_id VARCHAR(50) UNIQUE NOT NULL,
                user_id INT UNSIGNED DEFAULT NULL,
                service_type VARCHAR(50) NOT NULL,
                booking_data JSON NOT NULL,
                base_price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
                modifiers JSON DEFAULT NULL,
                coupon_code VARCHAR(50) DEFAULT NULL,
                coupon_discount DECIMAL(10, 2) DEFAULT 0.00,
                total_price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
                status VARCHAR(20) NOT NULL DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                created_ip VARCHAR(45),
                notes TEXT,
                INDEX idx_order_id (order_id),
                INDEX idx_service_type (service_type),
                INDEX idx_status (status),
                INDEX idx_user_id (user_id),
                INDEX idx_created_at (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            if ($conn->query($sql)) {
                $migrations[] = 'Bookings table created';
            } else {
                throw new Exception("Bookings table: " . $conn->error);
            }
        } catch (Exception $e) {
            $errors[] = "Bookings table error: " . $e->getMessage();
        }
        
        // Migration 2: Booking history table
        try {
            $sql = "
            CREATE TABLE IF NOT EXISTS booking_history (
                history_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                booking_id INT UNSIGNED NOT NULL,
                old_status VARCHAR(20),
                new_status VARCHAR(20) NOT NULL,
                changed_by INT UNSIGNED,
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_booking_id (booking_id),
                CONSTRAINT fk_booking_history_booking FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            if ($conn->query($sql)) {
                $migrations[] = 'Booking history table created';
            } else {
                throw new Exception("Booking history table: " . $conn->error);
            }
        } catch (Exception $e) {
            $errors[] = "Booking history table error: " . $e->getMessage();
        }
        
        // Migration 3: Booking items table
        try {
            $sql = "
            CREATE TABLE IF NOT EXISTS booking_items (
                item_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                booking_id INT UNSIGNED NOT NULL,
                item_type VARCHAR(100),
                description TEXT,
                quantity INT DEFAULT 1,
                weight DECIMAL(8, 2),
                dimensions VARCHAR(100),
                special_handling BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_booking_id (booking_id),
                CONSTRAINT fk_booking_items_booking FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            if ($conn->query($sql)) {
                $migrations[] = 'Booking items table created';
            } else {
                throw new Exception("Booking items table: " . $conn->error);
            }
        } catch (Exception $e) {
            $errors[] = "Booking items table error: " . $e->getMessage();
        }
        
        // Migration 4: Driver assignments table
        try {
            $sql = "
            CREATE TABLE IF NOT EXISTS driver_assignments (
                assignment_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                booking_id INT UNSIGNED NOT NULL,
                driver_id INT UNSIGNED,
                assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                completed_at TIMESTAMP NULL,
                INDEX idx_booking_id (booking_id),
                INDEX idx_driver_id (driver_id),
                CONSTRAINT fk_driver_assignments_booking FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            if ($conn->query($sql)) {
                $migrations[] = 'Driver assignments table created';
            } else {
                throw new Exception("Driver assignments table: " . $conn->error);
            }
        } catch (Exception $e) {
            $errors[] = "Driver assignments table error: " . $e->getMessage();
        }
        
        // Migration 5: Config table
        try {
            $sql = "
            CREATE TABLE IF NOT EXISTS config (
                config_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                config_key VARCHAR(255) UNIQUE NOT NULL,
                config_value LONGTEXT NOT NULL,
                config_type VARCHAR(50) DEFAULT 'string',
                description TEXT,
                section VARCHAR(100) DEFAULT 'general',
                is_locked BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_section (section),
                INDEX idx_created (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            if ($conn->query($sql)) {
                $migrations[] = 'Config table created';
                
                // Insert default configs
                $defaults = [
                    ['app_name', 'Courier App', 'string', 'Application name', 'general'],
                    ['currency', 'ZMW', 'string', 'Currency code', 'general'],
                    ['currency_symbol', 'K', 'string', 'Currency symbol', 'general'],
                    ['timezone', 'UTC', 'string', 'Default timezone', 'general'],
                ];
                
                foreach ($defaults as $config) {
                    $key = $conn->real_escape_string($config[0]);
                    $value = $conn->real_escape_string($config[1]);
                    $type = $config[2];
                    $desc = $conn->real_escape_string($config[3]);
                    $section = $config[4];
                    
                    $checkSql = "SELECT config_id FROM config WHERE config_key = '$key'";
                    $check = $conn->query($checkSql);
                    
                    if ($check && $check->num_rows === 0) {
                        $conn->query("INSERT INTO config (config_key, config_value, config_type, description, section) VALUES ('$key', '$value', '$type', '$desc', '$section')");
                    }
                }
            } else {
                throw new Exception("Config table: " . $conn->error);
            }
        } catch (Exception $e) {
            $errors[] = "Config table error: " . $e->getMessage();
        }
        
        // Migration 6: Email templates table
        try {
            $sql = "
            CREATE TABLE IF NOT EXISTS email_templates (
                template_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                template_name VARCHAR(100) UNIQUE NOT NULL,
                subject VARCHAR(255),
                html_body LONGTEXT,
                text_body LONGTEXT,
                variables JSON,
                is_active BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_name (template_name)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            if ($conn->query($sql)) {
                $migrations[] = 'Email templates table created';
            } else {
                throw new Exception("Email templates table: " . $conn->error);
            }
        } catch (Exception $e) {
            $errors[] = "Email templates table error: " . $e->getMessage();
        }
        
        // Migration 7: Users table
        try {
            $sql = "
            CREATE TABLE IF NOT EXISTS users (
                user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) UNIQUE,
                email VARCHAR(100) UNIQUE NOT NULL,
                password_hash VARCHAR(255),
                phone VARCHAR(20),
                user_type ENUM('customer', 'driver', 'admin') DEFAULT 'customer',
                status VARCHAR(50) DEFAULT 'active',
                profile_data JSON,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                last_login TIMESTAMP NULL,
                INDEX idx_email (email),
                INDEX idx_user_type (user_type),
                INDEX idx_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            if ($conn->query($sql)) {
                $migrations[] = 'Users table created';
            } else {
                throw new Exception("Users table: " . $conn->error);
            }
        } catch (Exception $e) {
            $errors[] = "Users table error: " . $e->getMessage();
        }
        
        // Migration 8: Pricing table
        try {
            $sql = "
            CREATE TABLE IF NOT EXISTS pricing (
                pricing_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                service_type VARCHAR(50) NOT NULL,
                origin_city VARCHAR(100),
                destination_city VARCHAR(100),
                base_price DECIMAL(10, 2),
                per_kg_price DECIMAL(10, 2),
                per_km_price DECIMAL(10, 2),
                is_active BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_service (service_type),
                INDEX idx_route (origin_city, destination_city)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            if ($conn->query($sql)) {
                $migrations[] = 'Pricing table created';
            } else {
                throw new Exception("Pricing table: " . $conn->error);
            }
        } catch (Exception $e) {
            $errors[] = "Pricing table error: " . $e->getMessage();
        }
        
        // Re-enable foreign key checks
        $conn->query("SET FOREIGN_KEY_CHECKS=1");
        
        $response['success'] = count($errors) === 0;
        $response['details']['migrations'] = $migrations;
        $response['details']['errors'] = $errors;
        
        if (count($errors) > 0) {
            $response['error'] = "Some migrations completed with warnings. Check details.";
        }
    }
    
} catch (Exception $e) {
    $response['success'] = false;
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>