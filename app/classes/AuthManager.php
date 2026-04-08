<?php
/**
 * Authentication Manager
 * Handles login, logout, password management, and security
 */

class AuthManager {
    private $db;
    private $sessionTimeout = 3600; // 1 hour

    public function __construct($db, $sessionTimeout = 3600) {
        $this->db = $db;
        $this->sessionTimeout = $sessionTimeout;
    }

    /**
     * Hash password using bcrypt
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Verify password
     */
    public static function verifyPassword($inputPassword, $hashPassword) {
        return password_verify($inputPassword, $hashPassword);
    }

    /**
     * Customer login
     */
    public function loginCustomer($email, $password) {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM users WHERE email = :email LIMIT 1"
            );
            $stmt->execute([':email' => $email]);

            if ($stmt->rowCount() === 0) {
                return ['success' => false, 'error' => 'Invalid email or password'];
            }

            $user = $stmt->fetch();

            // For now, handle both plain text and hashed passwords
            // TODO: Migrate all passwords to bcrypt
            if (!self::verifyPassword($password, $user['password']) && $user['password'] !== $password) {
                return ['success' => false, 'error' => 'Invalid email or password'];
            }

            // Set session
            $_SESSION['Userid'] = $user['Userid'];
            $_SESSION['CC_Username'] = $email;
            $_SESSION['CC_UserGroup'] = 'customer';
            $_SESSION['user_role'] = 'customer';
            $_SESSION['login_time'] = time();

            return ['success' => true, 'user' => $user];

        } catch (Exception $e) {
            error_log("Login Error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Login failed'];
        }
    }

    /**
     * Driver login
     */
    public function loginDriver($username, $password) {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM driver WHERE username = :username LIMIT 1"
            );
            $stmt->execute([':username' => $username]);

            if ($stmt->rowCount() === 0) {
                return ['success' => false, 'error' => 'Invalid username or password'];
            }

            $driver = $stmt->fetch();

            // Check password
            if (!self::verifyPassword($password, $driver['password']) && $driver['password'] !== $password) {
                return ['success' => false, 'error' => 'Invalid username or password'];
            }

            // Check if driver is active
            if ($driver['status'] !== 'active') {
                return ['success' => false, 'error' => 'Driver account is inactive'];
            }

            // Set session
            $_SESSION['MM_Username'] = $username;
            $_SESSION['MM_UserGroup'] = 'driver';
            $_SESSION['driver_id'] = $driver['driverID'];
            $_SESSION['user_role'] = 'driver';
            $_SESSION['login_time'] = time();

            return ['success' => true, 'driver' => $driver];

        } catch (Exception $e) {
            error_log("Driver Login Error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Login failed'];
        }
    }

    /**
     * Admin login
     */
    public function loginAdmin($email, $password) {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM admin_users WHERE email = :email LIMIT 1"
            );
            $stmt->execute([':email' => $email]);

            if ($stmt->rowCount() === 0) {
                return ['success' => false, 'error' => 'Invalid credentials'];
            }

            $admin = $stmt->fetch();

            if (!self::verifyPassword($password, $admin['password']) && $admin['password'] !== $password) {
                return ['success' => false, 'error' => 'Invalid credentials'];
            }

            // Check if admin is active
            if ($admin['status'] !== 'active') {
                return ['success' => false, 'error' => 'Admin account is inactive'];
            }

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $email;
            $_SESSION['admin_role'] = $admin['role'];
            $_SESSION['user_role'] = 'admin';
            $_SESSION['login_time'] = time();

            return ['success' => true, 'admin' => $admin];

        } catch (Exception $e) {
            error_log("Admin Login Error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Login failed'];
        }
    }

    /**
     * Logout
     */
    public function logout() {
        session_destroy();
        return true;
    }

    /**
     * Check if user is authenticated
     */
    public static function isAuthenticated() {
        return isset($_SESSION['Userid']) || isset($_SESSION['MM_Username']) || isset($_SESSION['admin_id']);
    }

    /**
     * Get current user role
     */
    public static function getUserRole() {
        return $_SESSION['user_role'] ?? 'guest';
    }

    /**
     * Require authentication
     */
    public static function requireAuth($redirectUrl = null) {
        if (!self::isAuthenticated()) {
            $redirect = $redirectUrl ?? '/book/signin.php?redirect=' . urlencode($_SERVER['REQUEST_URI']);
            header("Location: $redirect");
            exit;
        }
    }

    /**
     * Require specific role
     */
    public static function requireRole($role, $redirectUrl = null) {
        self::requireAuth();
        
        if (self::getUserRole() !== $role) {
            header('HTTP/1.0 403 Forbidden');
            die('Access denied');
        }
    }

    /**
     * Check session timeout
     */
    public static function checkSessionTimeout($timeout = 3600) {
        if (isset($_SESSION['login_time']) && time() - $_SESSION['login_time'] > $timeout) {
            session_destroy();
            return false;
        }
        return true;
    }

    /**
     * Change password
     */
    public function changePassword($userId, $oldPassword, $newPassword, $userType = 'customer') {
        try {
            // Determine table and field name
            $table = ($userType === 'driver') ? 'driver' : 'users';
            $idField = ($userType === 'driver') ? 'driverID' : 'Userid';

            // Get current user
            $stmt = $this->db->prepare("SELECT password FROM $table WHERE $idField = :id");
            $stmt->execute([':id' => $userId]);

            $user = $stmt->fetch();
            if (!$user) {
                return ['success' => false, 'error' => 'User not found'];
            }

            // Verify old password
            if (!self::verifyPassword($oldPassword, $user['password']) && $user['password'] !== $oldPassword) {
                return ['success' => false, 'error' => 'Current password is incorrect'];
            }

            // Validate new password
            if (strlen($newPassword) < 6) {
                return ['success' => false, 'error' => 'Password must be at least 6 characters'];
            }

            // Update password
            $hashedPassword = self::hashPassword($newPassword);
            $updateStmt = $this->db->prepare("UPDATE $table SET password = :pass WHERE $idField = :id");
            $updateStmt->execute([':pass' => $hashedPassword, ':id' => $userId]);

            return ['success' => true, 'message' => 'Password changed successfully'];

        } catch (Exception $e) {
            error_log("Password Change Error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Error changing password'];
        }
    }

    /**
     * Reset password (admin or via email)
     */
    public function resetPassword($email, $userType = 'customer') {
        try {
            $table = ($userType === 'driver') ? 'driver' : 'users';
            $emailField = ($userType === 'driver') ? 'email' : 'email'; // Adjust if driver table has different field

            // Check if user exists
            $stmt = $this->db->prepare("SELECT * FROM $table WHERE email = :email");
            $stmt->execute([':email' => $email]);

            if ($stmt->rowCount() === 0) {
                return ['success' => false, 'error' => 'User not found'];
            }

            // Generate reset token
            $resetToken = bin2hex(random_bytes(32));
            $resetTokenHash = hash('sha256', $resetToken);
            $resetTokenExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Store reset token (you'll need to add columns to users/driver table)
            // For now, just return the token
            return [
                'success' => true,
                'token' => $resetToken,
                'message' => 'Password reset link generated'
            ];

        } catch (Exception $e) {
            error_log("Reset Password Error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Error resetting password'];
        }
    }
}

?>


