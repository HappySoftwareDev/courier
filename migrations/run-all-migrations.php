<?php
/**
 * Master Migration Runner
 * 
 * Runs all migrations in sequence:
 * 1. CompatibilityMigrator - Expands password columns, creates config/email_templates tables
 * 2. migrate-passwords - Converts passwords to bcrypt
 * 
 * Usage:
 * Visit: http://app.wgroos.com/migrations/run-all-migrations.php
 * 
 * @package Wgroos\Logistics
 */

// Only allow web access (no CLI for safety)
if (php_sapi_name() === 'cli') {
    die("This script must be run via web browser, not CLI.\n");
}

// Start session and check authentication
session_start();
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

// Allow with ?token=admin_override if stored token is present (for first run)
$allowRun = false;
$message = '';

if ($isAdmin) {
    $allowRun = true;
} elseif (isset($_GET['token']) && $_GET['token'] === 'admin_override') {
    // Emergency override (remove after use)
    $allowRun = true;
    $message = "⚠️ WARNING: Using emergency override token. Remove this access after migration.\n\n";
} else {
    http_response_code(403);
    die("<h2>Access Denied</h2><p>Admin authentication required.</p><p>If this is your first migration, visit with: ?token=admin_override</p>");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Migration Runner</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 20px; border-radius: 5px; max-width: 900px; }
        .step { margin: 20px 0; padding: 15px; border-left: 4px solid #ddd; }
        .running { border-left-color: #ff9800; background: #fff3e0; }
        .success { border-left-color: #4caf50; background: #e8f5e9; }
        .error { border-left-color: #f44336; background: #ffebee; }
        .output { background: #263238; color: #aed581; padding: 10px; border-radius: 3px; overflow-x: auto; max-height: 300px; }
        h1 { color: #333; }
        .status { font-weight: bold; }
        .spinner { display: inline-block; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
<div class="container">
    <h1>🚀 Database Migration Runner</h1>
    <p>This script will run all required migrations to make the original SQL compatible with the modernized system.</p>
    
    <?php if ($message) echo "<div class='step error'>" . nl2br($message) . "</div>"; ?>
    
    <?php
    // Database configuration
    require_once dirname(__DIR__) . '/config/database-config.php';
    
    try {
        // Get config from database.php which uses PDO
        $configPath = dirname(__DIR__) . '/config/database.php';
        if (file_exists($configPath)) {
            require_once $configPath;
            // Database class should be loaded; use it
        } else {
            throw new Exception("Database configuration not found");
        }
        
    } catch (Exception $e) {
        echo "<div class='step error'>";
        echo "<p class='status'>❌ Database Connection Failed</p>";
        echo "<div class='output'>" . htmlspecialchars($e->getMessage()) . "</div>";
        echo "</div>";
        exit;
    }
    
    // Verify we have a database connection
    if (!class_exists('Database')) {
        echo "<div class='step error'>";
        echo "<p class='status'>❌ Database class not initialized</p>";
        echo "<div class='output'>Unable to load Database connection class</div>";
        echo "</div>";
        exit;
    }
    
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    
    // Step 1: Run CompatibilityMigrator
    echo "<div class='step running'>";
    echo "<p class='status'>⏳ Step 1: Running CompatibilityMigrator...</p>";
    
    try {
        // Include the migrator
        require_once dirname(__FILE__) . '/CompatibilityMigrator.php';
        
        // Create instance
        $migrator = new CompatibilityMigrator($pdo);
        
        // Run migrations
        echo "<div class='output'>";
        
        // 1.1 Expand password columns
        echo "→ Expanding password columns...\n";
        $migrator->expandPasswordColumns();
        echo "✓ Password columns expanded (varchar 40 → 255)\n\n";
        
        // 1.2 Create config table
        echo "→ Creating config table...\n";
        $migrator->createConfigTable();
        echo "✓ Config table created\n\n";
        
        // 1.3 Populate config
        echo "→ Populating configuration...\n";
        $migrator->populateConfigTable();
        echo "✓ 20+ config entries populated\n\n";
        
        // 1.4 Create email templates table
        echo "→ Creating email_templates table...\n";
        $migrator->createEmailTemplatesTable();
        echo "✓ Email templates table created\n\n";
        
        // 1.5 Seed email templates
        echo "→ Seeding default email templates...\n";
        $migrator->seedEmailTemplates();
        echo "✓ Default email templates seeded\n\n";
        
        // 1.6 Create password migration tracking
        echo "→ Creating password migration tracking...\n";
        $migrator->createPasswordMigrationTable();
        echo "✓ Migration tracking table created\n\n";
        
        echo "</div>";
        echo "<p class='status'>✅ Step 1 Complete</p>";
        
    } catch (Exception $e) {
        echo "<div class='output'>❌ ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
        echo "</div>";
        exit;
    }
    echo "</div>";
    
    // Step 2: Migrate passwords to bcrypt
    echo "<div class='step running'>";
    echo "<p class='status'>⏳ Step 2: Running Password Migration...</p>";
    
    try {
        require_once dirname(__FILE__) . '/migrate-passwords.php';
        
        $passwordMigrator = new PasswordMigrator($pdo);
        
        echo "<div class='output'>";
        
        echo "→ Migrating admin passwords...\n";
        $adminCount = $passwordMigrator->migrateAdminPasswords();
        echo "✓ Migrated {$adminCount} admin password(s)\n\n";
        
        echo "→ Migrating driver passwords...\n";
        $driverCount = $passwordMigrator->migrateDriverPasswords();
        echo "✓ Migrated {$driverCount} driver password(s)\n\n";
        
        echo "→ Migrating user passwords...\n";
        $userCount = $passwordMigrator->migrateUserPasswords();
        echo "✓ Migrated {$userCount} user password(s)\n\n";
        
        echo "→ Migrating affiliate passwords...\n";
        $affiliateCount = $passwordMigrator->migrateAffiliatePasswords();
        echo "✓ Migrated {$affiliateCount} affiliate password(s)\n\n";
        
        echo "→ Migrating client passwords...\n";
        $clientCount = $passwordMigrator->migrateClientPasswords();
        echo "✓ Migrated {$clientCount} client password(s)\n\n";
        
        $totalMigrated = $adminCount + $driverCount + $userCount + $affiliateCount + $clientCount;
        echo "═════════════════════════════════════════\n";
        echo "TOTAL PASSWORDS MIGRATED: {$totalMigrated}\n";
        echo "═════════════════════════════════════════\n";
        
        echo "</div>";
        echo "<p class='status'>✅ Step 2 Complete</p>";
        
    } catch (Exception $e) {
        echo "<div class='output'>❌ ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
        echo "</div>";
        exit;
    }
    echo "</div>";
    
    // Final success message
    echo "<div class='step success'>";
    echo "<h2>✅ All Migrations Complete!</h2>";
    echo "<p>Your database is now fully compatible with the modernized system.</p>";
    echo "<p><strong>Next Steps:</strong></p>";
    echo "<ol>";
    echo "<li>Test login with existing credentials (fallback auth works)</li>";
    echo "<li>Create a test booking to verify functionality</li>";
    echo "<li>Check application logs for any issues</li>";
    echo "<li>Monitor system performance</li>";
    echo "</ol>";
    echo "</div>";
    
    ?>
    
</div>
</body>
</html>
