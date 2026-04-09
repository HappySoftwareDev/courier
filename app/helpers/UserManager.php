<?php
/**
 * User Management Helper Functions
 * 
 * Use these functions to create additional users after initial setup
 * Can be called from admin panels or CLI scripts
 */

require_once __DIR__ . '/../config/bootstrap.php';

class UserManager {
    private $db;
    
    public function __construct($mysqli) {
        $this->db = $mysqli;
    }
    
    /**
     * Add Admin User
     * 
     * Usage:
     * $manager = new UserManager($db);
     * $manager->addAdminUser('neoadmin@example.com', 'SecurePass123!', 'Neo Admin', '+1234567890');
     */
    public function addAdminUser($email, $password, $name, $phone = '') {
        try {
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'error' => 'Invalid email address'];
            }
            
            // Check if exists
            $stmt = $this->db->prepare("SELECT ID FROM admin WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                return ['success' => false, 'error' => 'Admin with this email already exists'];
            }
            
            // Insert
            $stmt = $this->db->prepare(
                "INSERT INTO admin (Name, Email, phone, Password) VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("ssss", $name, $email, $phone, $password);
            
            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Admin user created successfully',
                    'id' => $this->db->insert_id
                ];
            } else {
                return ['success' => false, 'error' => $stmt->error];
            }
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Add Customer User
     * 
     * Usage:
     * $manager->addCustomerUser('john@example.com', 'CustPass123!', 'John Doe');
     */
    public function addCustomerUser($email, $password, $name) {
        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'error' => 'Invalid email address'];
            }
            
            $stmt = $this->db->prepare("SELECT client_id FROM clients WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                return ['success' => false, 'error' => 'Customer with this email already exists'];
            }
            
            $stmt = $this->db->prepare(
                "INSERT INTO clients (Name, Email, Password) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $name, $email, $password);
            
            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Customer user created successfully',
                    'id' => $this->db->insert_id
                ];
            } else {
                return ['success' => false, 'error' => $stmt->error];
            }
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Add Driver User
     * 
     * Usage:
     * $manager->addDriverUser(
     *     'jane_driver',
     *     'DriverPass123!',
     *     'jane.driver@example.com',
     *     'Jane Driver',
     *     '+1234567890'
     * );
     */
    public function addDriverUser($username, $password, $email, $name, $phone, $driverNumber = null) {
        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'error' => 'Invalid email address'];
            }
            
            // Check if username exists
            $stmt = $this->db->prepare("SELECT driverID FROM driver WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                return ['success' => false, 'error' => 'Driver with this username already exists'];
            }
            
            // Generate driver number if not provided
            if ($driverNumber === null) {
                $driverNumber = rand(10000, 99999);
            }
            
            // Prepare default values
            $company = 'Merchant Couriers';
            $address = 'To be updated';
            $city = 'To be updated';
            $vehicleMake = 'To be updated';
            $model = 'To be updated';
            $year = date('Y');
            $capacity = '0cc';
            $regNo = 'TBD';
            $occupation = 'Driver';
            $transport = 'Car';
            $service = 'Parcel Delivery';
            $profileImage = 'profilePic';
            $online = 'offline';
            $info = '....';
            
            $stmt = $this->db->prepare(
                "INSERT INTO driver (
                    driver_number, name, email, username, password, phone,
                    company_name, address, city, vehicleMake, model, year,
                    engineCapacity, RegNo, occupation, mode_of_transport,
                    type_of_service, profileImage, online, info
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            
            $stmt->bind_param(
                "isssssssssssssssss",
                $driverNumber, $name, $email, $username, $password, $phone,
                $company, $address, $city, $vehicleMake, $model, $year,
                $capacity, $regNo, $occupation, $transport, $service, $profileImage, $online, $info
            );
            
            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Driver user created successfully',
                    'id' => $this->db->insert_id,
                    'driver_number' => $driverNumber
                ];
            } else {
                return ['success' => false, 'error' => $stmt->error];
            }
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Add API User
     * 
     * Usage:
     * $apiKey = UserManager::generateApiKey();
     * $manager->addApiUser(
     *     'New Business Co',
     *     'api.business@example.com',
     *     'APIPass123!',
     *     $apiKey,
     *     '+1234567890',
     *     'Contact Person'
     * );
     */
    public function addApiUser($businessName, $businessEmail, $password, $apiKey, $businessPhone = '', $contactPerson = '') {
        try {
            if (!filter_var($businessEmail, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'error' => 'Invalid email address'];
            }
            
            // Check if exists
            $stmt = $this->db->prepare("SELECT id FROM api_users WHERE business_email = ?");
            $stmt->bind_param("s", $businessEmail);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                return ['success' => false, 'error' => 'API user with this email already exists'];
            }
            
            $status = 'active';
            $stmt = $this->db->prepare(
                "INSERT INTO api_users (
                    business_name, business_email, business_phone, password,
                    api_key, contact_person, status, join_date
                ) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
            );
            
            $stmt->bind_param(
                "sssssss",
                $businessName, $businessEmail, $businessPhone, $password,
                $apiKey, $contactPerson, $status
            );
            
            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'API user created successfully',
                    'id' => $this->db->insert_id,
                    'api_key' => $apiKey
                ];
            } else {
                return ['success' => false, 'error' => $stmt->error];
            }
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Regenerate API Key
     * 
     * Usage:
     * $manager->regenerateApiKey($apiUserId);
     */
    public function regenerateApiKey($apiUserId) {
        try {
            $newKey = self::generateApiKey();
            
            $stmt = $this->db->prepare("UPDATE api_users SET api_key = ? WHERE id = ?");
            $stmt->bind_param("si", $newKey, $apiUserId);
            
            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'API key regenerated',
                    'api_key' => $newKey
                ];
            } else {
                return ['success' => false, 'error' => $stmt->error];
            }
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Update User Password
     * 
     * Usage:
     * $manager->updatePassword('admin', 'admin@example.com', 'NewPassword123!');
     */
    public function updatePassword($userType, $identifier, $newPassword) {
        try {
            $userType = strtolower($userType);
            
            if ($userType === 'admin') {
                $stmt = $this->db->prepare("UPDATE admin SET Password = ? WHERE Email = ?");
            } elseif ($userType === 'customer') {
                $stmt = $this->db->prepare("UPDATE clients SET Password = ? WHERE Email = ?");
            } elseif ($userType === 'driver') {
                $stmt = $this->db->prepare("UPDATE driver SET password = ? WHERE username = ?");
            } elseif ($userType === 'api') {
                $stmt = $this->db->prepare("UPDATE api_users SET password = ? WHERE business_email = ?");
            } else {
                return ['success' => false, 'error' => 'Invalid user type'];
            }
            
            $stmt->bind_param("ss", $newPassword, $identifier);
            
            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => ucfirst($userType) . ' password updated successfully'
                ];
            } else {
                return ['success' => false, 'error' => $stmt->error];
            }
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Delete User
     * 
     * Usage:
     * $manager->deleteUser('driver', 'username_to_delete');
     */
    public function deleteUser($userType, $identifier) {
        try {
            $userType = strtolower($userType);
            
            if ($userType === 'admin') {
                $stmt = $this->db->prepare("DELETE FROM admin WHERE Email = ?");
            } elseif ($userType === 'customer') {
                $stmt = $this->db->prepare("DELETE FROM clients WHERE Email = ?");
            } elseif ($userType === 'driver') {
                $stmt = $this->db->prepare("DELETE FROM driver WHERE username = ?");
            } elseif ($userType === 'api') {
                $stmt = $this->db->prepare("DELETE FROM api_users WHERE business_email = ?");
            } else {
                return ['success' => false, 'error' => 'Invalid user type'];
            }
            
            $stmt->bind_param("s", $identifier);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'User deleted successfully'];
            } else {
                return ['success' => false, 'error' => $stmt->error];
            }
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Generate Secure API Key
     * 
     * Static method - Usage:
     * $apiKey = UserManager::generateApiKey();
     */
    public static function generateApiKey() {
        return 'pklive_' . bin2hex(random_bytes(16));
    }
}

/**
 * EXAMPLE USAGE BELOW
 */

/*
// Example 1: Create a new admin
$manager = new UserManager($db);
$result = $manager->addAdminUser(
    'admin.john@example.com',
    'SecurePassword123!',
    'John Admin',
    '+1234567890'
);
print_r($result);

// Example 2: Create a new driver
$result = $manager->addDriverUser(
    'driver_sophia',
    'DriverPass456!',
    'sophia@example.com',
    'Sophia Driver',
    '+9876543210'
);
print_r($result);

// Example 3: Create API user with auto-generated key
$apiKey = UserManager::generateApiKey();
$result = $manager->addApiUser(
    'Tech Startup Inc',
    'api@techstartup.com',
    'TechAPIPass789!',
    $apiKey,
    '+5555555555',
    'Tom Tech'
);
print_r($result);

// Example 4: Regenerate API key
$result = $manager->regenerateApiKey(1); // API user ID 1
print_r($result);

// Example 5: Update password
$result = $manager->updatePassword('driver', 'driver_sophia', 'NewDriverPass123!');
print_r($result);

// Example 6: Delete user
$result = $manager->deleteUser('customer', 'customer@example.com');
print_r($result);
*/

?>
