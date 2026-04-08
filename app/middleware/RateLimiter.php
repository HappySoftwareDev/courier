<?php
/**
 * Rate Limiting Middleware
 * 
 * Prevents abuse by limiting requests per user/IP address.
 */

class RateLimiter {
    private $db;
    private $cache = [];
    private $limits = [];

    public function __construct($db) {
        $this->db = $db;
        $this->setupDefaultLimits();
    }

    /**
     * Setup default rate limits
     */
    private function setupDefaultLimits() {
        $this->limits = [
            'login' => ['limit' => 5, 'window' => 900],        // 5 attempts per 15 minutes
            'api' => ['limit' => 100, 'window' => 3600],       // 100 requests per hour
            'booking' => ['limit' => 10, 'window' => 3600],    // 10 bookings per hour
            'password_reset' => ['limit' => 3, 'window' => 3600],  // 3 attempts per hour
            'signup' => ['limit' => 3, 'window' => 3600]       // 3 signups per hour
        ];
    }

    /**
     * Check rate limit for user
     */
    public function checkLimit($userId, $action = 'api', $customLimit = null) {
        $limit = $customLimit ?? ($this->limits[$action]['limit'] ?? 100);
        $window = $customLimit ? 3600 : ($this->limits[$action]['window'] ?? 3600);

        $key = "rate_limit:{$action}:{$userId}";
        $count = $this->getRequestCount($key);

        if ($count >= $limit) {
            return [
                'allowed' => false,
                'remaining' => 0,
                'reset_in' => $this->getResetTime($key)
            ];
        }

        $this->incrementRequestCount($key, $window);

        return [
            'allowed' => true,
            'remaining' => $limit - $count - 1,
            'window' => $window
        ];
    }

    /**
     * Check rate limit for IP address
     */
    public function checkIPLimit($action = 'api', $customLimit = null, $customIP = null) {
        $ip = $customIP ?? $this->getClientIP();
        $limit = $customLimit ?? ($this->limits[$action]['limit'] ?? 100);
        $window = $customLimit ? 3600 : ($this->limits[$action]['window'] ?? 3600);

        $key = "rate_limit:ip:{$action}:{$ip}";
        $count = $this->getRequestCount($key);

        if ($count >= $limit) {
            return [
                'allowed' => false,
                'remaining' => 0,
                'reset_in' => $this->getResetTime($key)
            ];
        }

        $this->incrementRequestCount($key, $window);

        return [
            'allowed' => true,
            'remaining' => $limit - $count - 1,
            'window' => $window
        ];
    }

    /**
     * Get request count from cache/database
     */
    private function getRequestCount($key) {
        if (isset($this->cache[$key])) {
            return $this->cache[$key]['count'];
        }

        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as count FROM rate_limits 
                WHERE `key` = :key AND timestamp > DATE_SUB(NOW(), INTERVAL 1 HOUR)
            ");
            $stmt->execute([':key' => $key]);
            $result = $stmt->fetch();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Increment request count
     */
    private function incrementRequestCount($key, $window) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO rate_limits (`key`, timestamp) VALUES (:key, NOW())"
            );
            $stmt->execute([':key' => $key]);

            // Cache locally
            if (!isset($this->cache[$key])) {
                $this->cache[$key] = ['count' => 0, 'window' => $window];
            }
            $this->cache[$key]['count']++;
        } catch (Exception $e) {
            // Fail silently
        }
    }

    /**
     * Get reset time in seconds
     */
    private function getResetTime($key) {
        try {
            $stmt = $this->db->prepare(
                "SELECT UNIX_TIMESTAMP(MAX(timestamp)) as last_request FROM rate_limits WHERE `key` = :key"
            );
            $stmt->execute([':key' => $key]);
            $result = $stmt->fetch();

            if ($result['last_request']) {
                $resetTime = $result['last_request'] + ($this->limits['api']['window'] ?? 3600);
                return max(0, $resetTime - time());
            }
        } catch (Exception $e) {
            // Fail silently
        }

        return 0;
    }

    /**
     * Reset limits for user
     */
    public function resetUserLimits($userId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM rate_limits WHERE `key` LIKE :pattern");
            $stmt->execute([':pattern' => "rate_limit:%:{$userId}%"]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Reset limits for IP
     */
    public function resetIPLimits($ip) {
        try {
            $stmt = $this->db->prepare("DELETE FROM rate_limits WHERE `key` LIKE :pattern");
            $stmt->execute([':pattern' => "rate_limit:ip:%:{$ip}%"]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get client IP address
     */
    private function getClientIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        }

        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }

    /**
     * Cleanup old rate limit records
     */
    public function cleanup() {
        try {
            $this->db->exec("DELETE FROM rate_limits WHERE timestamp < DATE_SUB(NOW(), INTERVAL 24 HOUR)");
        } catch (Exception $e) {
            // Cleanup failed silently
        }
    }
}


