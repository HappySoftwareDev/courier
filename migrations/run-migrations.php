<?php
/**
 * Database Migration Runner
 * 
 * This script runs all pending database migrations to set up the required tables.
 * Run this from the command line or via a web request to initialize the database.
 * 
 * Usage:
 * - CLI: php migrations/run-migrations.php
 * - Web: Visit /migrations/run-migrations.php in your browser (requires admin auth)
 * 
 * @package Wgroos\Logistics
 */

// Security check - only allow CLI or admin
$isCliMode = php_sapi_name() === 'cli';
if (!$isCliMode) {
    // For web access, check if user is authenticated admin
    session_start();
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        http_response_code(403);
        die('Access denied. Admin authentication required.');
    }
}

// Get database connection
$configPath = dirname(__DIR__) . '/Connections/db.php';
if (!file_exists($configPath)) {
    die("Error: Database configuration file not found at {$configPath}\n");
}

require_once $configPath;

// Create PDO connection if not exists
if (!isset($DB)) {
    try {
        $DB = new PDO(
            "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4",
            $DB_USER,
            $DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage() . "\n");
    }
}

// Migration files to run
$migrations = [
    '001_create_config_table.sql',
    '002_create_email_templates_table.sql',
];

// Track migrations in database
$migrationsTableExists = false;
try {
    $result = $DB->query("SHOW TABLES LIKE 'migrations'");
    $migrationsTableExists = $result && $result->rowCount() > 0;
} catch (Exception $e) {
    // Table doesn't exist yet
}

// Create migrations tracking table if needed
if (!$migrationsTableExists) {
    try {
        $DB->exec("
            CREATE TABLE `migrations` (
                `migration_id` INT AUTO_INCREMENT PRIMARY KEY,
                `migration_name` VARCHAR(255) UNIQUE NOT NULL,
                `executed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        outputMessage("✓ Created migrations tracking table");
    } catch (Exception $e) {
        outputMessage("✗ Error creating migrations table: " . $e->getMessage(), true);
        exit(1);
    }
}

// Run migrations
$completedCount = 0;
$skippedCount = 0;
$errorCount = 0;

outputMessage("\n" . str_repeat("=", 60));
outputMessage("DATABASE MIGRATION RUNNER");
outputMessage(str_repeat("=", 60) . "\n");

foreach ($migrations as $migrationFile) {
    $migrationPath = dirname(__FILE__) . '/' . $migrationFile;
    
    if (!file_exists($migrationPath)) {
        outputMessage("✗ Migration file not found: {$migrationFile}", true);
        $errorCount++;
        continue;
    }
    
    // Check if already executed
    try {
        $checkStmt = $DB->prepare("SELECT * FROM migrations WHERE migration_name = ?");
        $checkStmt->execute([$migrationFile]);
        $alreadyRun = $checkStmt->rowCount() > 0;
    } catch (Exception $e) {
        $alreadyRun = false;
    }
    
    if ($alreadyRun) {
        outputMessage("⊘ SKIPPED: {$migrationFile} (already executed)");
        $skippedCount++;
        continue;
    }
    
    // Read and execute migration
    try {
        $sql = file_get_contents($migrationPath);
        
        // Split SQL into individual statements and execute each
        $statements = array_filter(
            array_map('trim', explode(';', $sql)),
            function($stmt) {
                return !empty($stmt) && substr(trim($stmt), 0, 2) !== '--';
            }
        );
        
        foreach ($statements as $statement) {
            if (!empty(trim($statement))) {
                $DB->exec($statement . ';');
            }
        }
        
        // Record migration as executed
        $recordStmt = $DB->prepare("INSERT INTO migrations (migration_name) VALUES (?)");
        $recordStmt->execute([$migrationFile]);
        
        outputMessage("✓ COMPLETED: {$migrationFile}");
        $completedCount++;
        
    } catch (Exception $e) {
        outputMessage("✗ ERROR in {$migrationFile}:", true);
        outputMessage("  " . $e->getMessage(), true);
        $errorCount++;
    }
}

// Summary
outputMessage("\n" . str_repeat("-", 60));
outputMessage("MIGRATION SUMMARY");
outputMessage(str_repeat("-", 60));
outputMessage("Completed: {$completedCount}");
outputMessage("Skipped:   {$skippedCount}");
outputMessage("Errors:    {$errorCount}");
outputMessage(str_repeat("=", 60) . "\n");

if ($errorCount === 0) {
    outputMessage("✓ All migrations completed successfully!", false);
    exit(0);
} else {
    outputMessage("✗ Some migrations failed. Please review errors above.", true);
    exit(1);
}

/**
 * Output message with proper formatting
 */
function outputMessage($message, $isError = false) {
    $prefix = $isError ? "[ERROR] " : "";
    if (php_sapi_name() === 'cli') {
        echo $prefix . $message . "\n";
    } else {
        echo "<div style='color: " . ($isError ? 'red' : 'black') . "; font-family: monospace;'>";
        echo htmlspecialchars($prefix . $message);
        echo "<br/></div>";
    }
}
?>


