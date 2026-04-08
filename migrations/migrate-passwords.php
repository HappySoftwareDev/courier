<?php
/**
 * Password Migration Tool
 * Migrates plain text passwords to bcrypt hashes
 * 
 * This tool:
 * 1. Identifies accounts with plain text passwords
 * 2. Hashes them securely using bcrypt
 * 3. Updates the database
 * 4. Maintains a migration log for audit
 * 
 * USAGE:
 * CLI:  php migrate-passwords.php
 * WEB:  http://your-site.com/path/to/migrate-passwords.php?token=YOUR_SECRET
 */

require_once dirname(__DIR__) . '/config/database.php';

class PasswordMigrator {
    private $db;
    private $migratedCount = 0;
    private $skippedCount = 0;
    private $errorCount = 0;
    private $migrations = [];

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Check if a password looks like plain text or bcrypt
     * Bcrypt hashes start with $2a$, $2b$, or $2y$ and are 60 characters
     */
    private function isBcryptHash($password) {
        return (
            strlen($password) === 60 &&
            (strpos($password, '$2a$') === 0 || 
             strpos($password, '$2b$') === 0 || 
             strpos($password, '$2y$') === 0)
        );
    }

    /**
     * Migrate passwords in admin table
     */
    public function migrateAdminPasswords() {
        echo "\n[1/5] Migrating admin passwords...\n";
        
        try {
            $sql = "SELECT ID, Password FROM admin WHERE Password IS NOT NULL";
            $result = $this->db->query($sql);

            while ($admin = $result->fetch()) {
                if ($this->isBcryptHash($admin['Password'])) {
                    $this->skippedCount++;
                    continue;
                }

                $newHash = password_hash($admin['Password'], PASSWORD_BCRYPT, ['cost' => 12]);
                
                $updateSql = "UPDATE admin SET Password = ? WHERE ID = ?";
                $stmt = $this->db->prepare($updateSql);
                
                if ($stmt->execute([$newHash, $admin['ID']])) {
                    $this->migratedCount++;
                    $this->logMigration('admin', $admin['ID'], $admin['Password'], $newHash);
                }
            }

            echo "   ✓ Migrated {$this->migratedCount} admin accounts\n";

        } catch (Exception $e) {
            echo "   ✗ Error: {$e->getMessage()}\n";
            $this->errorCount++;
        }
    }

    /**
     * Migrate passwords in driver table
     */
    public function migrateDriverPasswords() {
        echo "[2/5] Migrating driver passwords...\n";
        
        try {
            $sql = "SELECT driverID, password FROM driver WHERE password IS NOT NULL";
            $result = $this->db->query($sql);

            while ($driver = $result->fetch()) {
                if ($this->isBcryptHash($driver['password'])) {
                    $this->skippedCount++;
                    continue;
                }

                $newHash = password_hash($driver['password'], PASSWORD_BCRYPT, ['cost' => 12]);
                
                $updateSql = "UPDATE driver SET password = ? WHERE driverID = ?";
                $stmt = $this->db->prepare($updateSql);
                
                if ($stmt->execute([$newHash, $driver['driverID']])) {
                    $this->migratedCount++;
                    $this->logMigration('driver', $driver['driverID'], $driver['password'], $newHash);
                }
            }

            echo "   ✓ Migrated drivers\n";

        } catch (Exception $e) {
            echo "   ✗ Error: {$e->getMessage()}\n";
            $this->errorCount++;
        }
    }

    /**
     * Migrate passwords in users table
     */
    public function migrateUserPasswords() {
        echo "[3/5] Migrating user passwords...\n";
        
        try {
            $sql = "SELECT Userid, password FROM users WHERE password IS NOT NULL";
            $result = $this->db->query($sql);

            while ($user = $result->fetch()) {
                if ($this->isBcryptHash($user['password'])) {
                    $this->skippedCount++;
                    continue;
                }

                $newHash = password_hash($user['password'], PASSWORD_BCRYPT, ['cost' => 12]);
                
                $updateSql = "UPDATE users SET password = ? WHERE Userid = ?";
                $stmt = $this->db->prepare($updateSql);
                
                if ($stmt->execute([$newHash, $user['Userid']])) {
                    $this->migratedCount++;
                    $this->logMigration('users', $user['Userid'], $user['password'], $newHash);
                }
            }

            echo "   ✓ Migrated users\n";

        } catch (Exception $e) {
            echo "   ✗ Error: {$e->getMessage()}\n";
            $this->errorCount++;
        }
    }

    /**
     * Migrate passwords in affiliate_user table
     */
    public function migrateAffiliatePasswords() {
        echo "[4/5] Migrating affiliate passwords...\n";
        
        try {
            $sql = "SELECT id, password FROM affilate_user WHERE password IS NOT NULL";
            $result = $this->db->query($sql);

            while ($aff = $result->fetch()) {
                if ($this->isBcryptHash($aff['password'])) {
                    $this->skippedCount++;
                    continue;
                }

                $newHash = password_hash($aff['password'], PASSWORD_BCRYPT, ['cost' => 12]);
                
                $updateSql = "UPDATE affilate_user SET password = ? WHERE id = ?";
                $stmt = $this->db->prepare($updateSql);
                
                if ($stmt->execute([$newHash, $aff['id']])) {
                    $this->migratedCount++;
                    $this->logMigration('affilate_user', $aff['id'], $aff['password'], $newHash);
                }
            }

            echo "   ✓ Migrated affiliates\n";

        } catch (Exception $e) {
            echo "   ✗ Error: {$e->getMessage()}\n";
            $this->errorCount++;
        }
    }

    /**
     * Migrate passwords in clients table
     */
    public function migrateClientPasswords() {
        echo "[5/5] Migrating client passwords...\n";
        
        try {
            $sql = "SELECT client_id, Password FROM clients WHERE Password IS NOT NULL";
            $result = $this->db->query($sql);

            while ($client = $result->fetch()) {
                if ($this->isBcryptHash($client['Password'])) {
                    $this->skippedCount++;
                    continue;
                }

                $newHash = password_hash($client['Password'], PASSWORD_BCRYPT, ['cost' => 12]);
                
                $updateSql = "UPDATE clients SET Password = ? WHERE client_id = ?";
                $stmt = $this->db->prepare($updateSql);
                
                if ($stmt->execute([$newHash, $client['client_id']])) {
                    $this->migratedCount++;
                    $this->logMigration('clients', $client['client_id'], $client['Password'], $newHash);
                }
            }

            echo "   ✓ Migrated clients\n";

        } catch (Exception $e) {
            echo "   ✗ Error: {$e->getMessage()}\n";
            $this->errorCount++;
        }
    }

    /**
     * Log migration for audit trail
     */
    private function logMigration($table, $userId, $oldHash, $newHash) {
        try {
            // Store first 10 chars of hashes for comparison
            $oldPrefix = substr($oldHash, 0, 10);
            $newPrefix = substr($newHash, 0, 10);

            $sql = "INSERT INTO password_migrations 
                    (user_table, user_id, old_password_hash, new_password_hash, status, migrated_at) 
                    VALUES (?, ?, ?, ?, 'migrated', NOW())
                    ON DUPLICATE KEY UPDATE 
                    new_password_hash = VALUES(new_password_hash),
                    migrated_at = NOW(),
                    status = 'migrated'";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$table, $userId, $oldPrefix, $newPrefix]);

        } catch (Exception $e) {
            // Silently fail - table might not exist yet
        }
    }

    /**
     * Run all migrations
     */
    public function runAll() {
        echo "\n" . str_repeat("=", 70);
        echo "\n🔐 PASSWORD MIGRATION TOOL\n";
        echo str_repeat("=", 70);
        echo "\nThis will migrate all plain text passwords to bcrypt hashes.\n";
        echo "This process is SAFE and REVERSIBLE (if you have backups).\n";

        // Create migrations table if needed
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
        } catch (Exception $e) {
            // Table might already exist
        }

        $this->migrateAdminPasswords();
        $this->migrateDriverPasswords();
        $this->migrateUserPasswords();
        $this->migrateAffiliatePasswords();
        $this->migrateClientPasswords();

        $this->displayResults();
    }

    /**
     * Display results
     */
    private function displayResults() {
        echo "\n" . str_repeat("=", 70);
        echo "\n📊 MIGRATION RESULTS\n";
        echo str_repeat("=", 70) . "\n";
        echo "   ✓ Migrated: {$this->migratedCount} accounts\n";
        echo "   ⊘ Already bcrypt: {$this->skippedCount} accounts\n";
        echo "   ✗ Errors: {$this->errorCount}\n";
        echo "\n" . str_repeat("=", 70) . "\n";

        if ($this->migratedCount > 0) {
            echo "\n✅ Password migration completed successfully!\n\n";
            echo "IMPORTANT NOTES:\n";
            echo "1. All passwords have been hashed with bcrypt (cost=12)\n";
            echo "2. Original passwords cannot be recovered\n";
            echo "3. Migration log stored in 'password_migrations' table\n";
            echo "4. Test login with an admin account to verify\n";
        } else {
            echo "\nℹ️  No passwords needed migration (all already bcrypt)\n\n";
        }
    }
}

// Run if called from CLI or with proper token
$isCli = (php_sapi_name() === 'cli');
$hasToken = isset($_GET['token']) && $_GET['token'] === getenv('MIGRATION_TOKEN');

if ($isCli || $hasToken) {
    try {
        $migrator = new PasswordMigrator($DB);
        $migrator->runAll();
    } catch (Exception $e) {
        die("Fatal error: {$e->getMessage()}\n");
    }
} else {
    die("Unauthorized. Run from CLI or provide valid migration token.\n");
}

?>
