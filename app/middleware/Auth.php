<?php
/**
 * Authentication Middleware
 * 
 * Handles user authentication, session management, and authorization checks.
 */

class AuthMiddleware {
    private $db;
    private $sessionTimeout = 3600;
    private $maxLoginAttempts = 5;
    private $lockoutTime = 900;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Initialize session with security settings
     */
    public function initSession() {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', 1);
            ini_set('session.cookie_samesite', 'Strict');
            session_start();
        }

        // Regenerate session ID for security
        if (!isset($_SESSION['created'])) {
            $_SESSION['created'] = time();
        } elseif (time() - $_SESSION['created'] > 300) {
            session_regenerate_id(true);
            $_SESSION['created'] = time();
        }

        // Check session timeout
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $this->sessionTimeout)) {
            session_destroy();
            header('Location: /book/signin.php?session=expired');
            exit;
        }

        $_SESSION['last_activity'] = time();
    }

    /**
     * Check if user is authenticated
     */
    public static function isAuthenticated() {
        return isset($_SESSION['Userid']) && !empty($_SESSION['Userid']);
    }

    /**
     * Require login - redirect if not authenticated
     */
    public static function requireLogin($redirectTo = null) {
        if (!self::isAuthenticated()) {
            $redirect = $redirectTo ?? $_SERVER['REQUEST_URI'];
            header('Location: /book/signin.php?redirect=' . urlencode($redirect));
            exit;
        }
    }

    /**
     * Require specific role
     */
    public static function requireRole($role) {
        self::requireLogin();
        
        if ($_SESSION['userRole'] !== $role) {
            http_response_code(403);
            die('Access denied. Required role: ' . htmlspecialchars($role));
        }
    }

    /**
     * Require multiple roles
     */
    public static function requireRoles($roles = []) {
        self::requireLogin();
        
        if (!in_array($_SESSION['userRole'], $roles)) {
            http_response_code(403);
            die('Access denied. Required roles: ' . htmlspecialchars(implode(', ', $roles)));
        }
    }

    /**
     * Login user
     */
    public function login($email, $password) {
        try {
            // Check if account is locked
            if ($this->isAccountLocked($email)) {
                throw new Exception('Account is temporarily locked. Please try again later.');
            }

            // Get user from database
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email AND status = 'active'");
            $stmt->execute([':email' => $email]);

            if ($stmt->rowCount() === 0) {
                $this->recordFailedLogin($email);
                throw new Exception('Invalid email or password');
            }

            $user = $stmt->fetch();

            // Verify password
            if (!password_verify($password, $user['password'])) {
                $this->recordFailedLogin($email);
                throw new Exception('Invalid email or password');
            }

            // Clear failed login attempts
            $this->clearFailedLogins($email);

            // Set session
            $_SESSION['Userid'] = $user['id'];
            $_SESSION['userEmail'] = $user['email'];
            $_SESSION['userName'] = $user['name'];
            $_SESSION['userRole'] = $user['role'];
            $_SESSION['lastLogin'] = date('Y-m-d H:i:s');

            return [
                'success' => true,
                'user_id' => $user['id'],
                'message' => 'Login successful'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Logout user
     */
    public static function logout() {
        $_SESSION = [];
        session_destroy();
        return true;
    }

    /**
     * Hash password
     */
    public static function hashPassword($password) {
        if (strlen($password) < PASSWORD_MIN_LENGTH) {
            throw new Exception('Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters');
        }
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Verify password
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    /**
     * Record failed login attempt
     */
    private function recordFailedLogin($email) {
        $stmt = $this->db->prepare(
            "INSERT INTO failed_logins (email, attempt_time) VALUES (:email, NOW())"
        );
        $stmt->execute([':email' => $email]);
    }

    /**
     * Clear failed login attempts
     */
    private function clearFailedLogins($email) {
        $stmt = $this->db->prepare("DELETE FROM failed_logins WHERE email = :email");
        $stmt->execute([':email' => $email]);
    }

    /**
     * Check if account is locked
     */
    private function isAccountLocked($email) {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) as attempts FROM failed_logins 
             WHERE email = :email AND attempt_time > DATE_SUB(NOW(), INTERVAL 15 MINUTE)"
        );
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch();

        return $result['attempts'] >= $this->maxLoginAttempts;
    }

    /**
     * Get current user
     */
    public static function getCurrentUser() {
        if (!self::isAuthenticated()) {
            return null;
        }

        return [
            'id' => $_SESSION['Userid'],
            'email' => $_SESSION['userEmail'],
            'name' => $_SESSION['userName'],
            'role' => $_SESSION['userRole']
        ];
    }

    /**
     * Generate CSRF token
     */
    public static function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verify CSRF token
     */
    public static function verifyCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}


