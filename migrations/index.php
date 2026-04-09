<?php
/**
 * WG ROOS Courier - Database Migrations Dashboard
 * 
 * Provides overview of available migrations and their status
 */

// Get database connection if available
try {
    require_once dirname(dirname(__FILE__)) . '/config/bootstrap.php';
    $db_connected = isset($DB);
} catch (Exception $e) {
    $db_connected = false;
}

// Helper function to get table count
function get_table_count() {
    global $DB, $db_connected;
    if (!$db_connected) return null;
    
    try {
        $result = $DB->query("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = DATABASE()");
        $row = $result->fetch_assoc();
        return $row['count'] ?? 0;
    } catch (Exception $e) {
        return null;
    }
}

// Helper to check if table exists
function table_exists($name) {
    global $DB, $db_connected;
    if (!$db_connected) return null;
    
    try {
        $result = $DB->query("SHOW TABLES LIKE '$name'");
        return $result->num_rows > 0;
    } catch (Exception $e) {
        return null;
    }
}

// Define migrations
$migrations = [
    [
        'id' => '001',
        'name' => 'Create Config Table',
        'file' => '001_create_config_table.sql',
        'description' => 'Creates site_settings table for application configuration',
        'tables' => 1,
        'type' => 'sql',
        'status' => 'completed'
    ],
    [
        'id' => '002',
        'name' => 'Create Email Templates Table',
        'file' => '002_create_email_templates_table.sql',
        'description' => 'Creates email template storage for notifications',
        'tables' => 1,
        'type' => 'sql',
        'status' => 'completed'
    ],
    [
        'id' => '003',
        'name' => 'Add Currency and Exchange Tables',
        'file' => '003_add_currency_and_exchange_tables.sql',
        'description' => 'Adds support for multi-currency and exchange rates',
        'tables' => 2,
        'type' => 'sql',
        'status' => 'optional'
    ],
    [
        'id' => '004',
        'name' => 'Create All Missing Application Tables',
        'file' => '004_create_missing_tables.php',
        'description' => 'Creates 43 essential application tables (users, bookings, payments, blog, etc.)',
        'tables' => 43,
        'type' => 'php',
        'status' => 'recommended',
        'url' => 'migrations/004_create_missing_tables.php'
    ]
];

$table_count = get_table_count();
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WGroos - Migrations Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            padding: 40px 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 10px;
            margin-bottom: 40px;
            text-align: center;
        }
        h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 14px;
            opacity: 0.9;
        }
        .db-status {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .status-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #4CAF50;
        }
        .status-dot.error {
            background: #f44336;
        }
        .migrations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .migration-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            border: 2px solid #eee;
            transition: all 0.3s;
        }
        .migration-card:hover {
            border-color: #667eea;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.1);
        }
        .migration-id {
            font-size: 12px;
            color: #999;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .migration-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        .migration-description {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        .migration-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #999;
            padding-top: 15px;
            border-top: 1px solid #eee;
            margin-bottom: 15px;
        }
        .table-count {
            background: #f0f7ff;
            padding: 5px 10px;
            border-radius: 20px;
            color: #667eea;
            font-weight: 600;
        }
        .migration-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-completed {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .status-recommended {
            background: #fff3e0;
            color: #e65100;
        }
        .status-optional {
            background: #f3e5f5;
            color: #6a1b9a;
        }
        .migration-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .btn {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
            display: inline-block;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background: #5568d3;
        }
        .btn-secondary {
            background: #eee;
            color: #333;
        }
        .btn-secondary:hover {
            background: #ddd;
        }
        .btn-view {
            flex-basis: 30%;
        }
        .info-box {
            background: #f0f7ff;
            border: 1px solid #b3d9ff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .info-box h3 {
            color: #1565c0;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .info-box p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        .info-box ol {
            margin-left: 20px;
            color: #666;
            font-size: 14px;
            line-height: 1.8;
        }
        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .warning-box strong {
            color: #856404;
        }
        footer {
            text-align: center;
            color: #999;
            font-size: 12px;
            margin-top: 40px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>WGroos Courier</h1>
            <p class="subtitle">Database Migrations Management Dashboard</p>
        </header>

        <!-- Database Status -->
        <?php if ($db_connected): ?>
            <div class="db-status">
                <div class="status-indicator">
                    <div class="status-dot"></div>
                    <span><strong>Database Connected</strong> - <?php echo $table_count; ?> tables found</span>
                </div>
                <a href="README.md" target="_blank" class="btn btn-secondary">View Documentation</a>
            </div>
        <?php else: ?>
            <div class="db-status">
                <div class="status-indicator">
                    <div class="status-dot error"></div>
                    <span><strong>Database Not Connected</strong> - Run setup.php first</span>
                </div>
            </div>
            <div class="warning-box">
                <strong>⚠️ Database Connection Required</strong><br>
                You need to complete the setup wizard first. Visit <code>setup.php</code> to configure your database and create an admin user.
            </div>
        <?php endif; ?>

        <!-- Quick Start Info -->
        <div class="info-box">
            <h3>Quick Start: Setup Your Database</h3>
            <p>Follow these steps to get your WGroos Courier system up and running:</p>
            <ol>
                <li><strong>Run Setup Wizard</strong> - Visit <code>setup.php</code> to configure database connection and create admin user</li>
                <li><strong>Create Tables</strong> - After setup, run migration 004 to create all 43 application tables</li>
                <li><strong>Configure Payment</strong> - Set up payment gateway API keys in admin panel</li>
                <li><strong>Delete setup.php</strong> - Remove this file from production for security</li>
            </ol>
        </div>

        <!-- Migrations Grid -->
        <h2 style="margin-bottom: 20px; color: #333;">Available Migrations</h2>
        <div class="migrations-grid">
            <?php foreach ($migrations as $mig): ?>
                <div class="migration-card">
                    <div class="migration-id"><?php echo $mig['id']; ?></div>
                    <div class="migration-name"><?php echo htmlspecialchars($mig['name']); ?></div>
                    <div class="migration-description"><?php echo htmlspecialchars($mig['description']); ?></div>
                    
                    <div class="migration-meta">
                        <span class="table-count"><?php echo $mig['tables']; ?> Table<?php echo $mig['tables'] != 1 ? 's' : ''; ?></span>
                        <span class="migration-status status-<?php echo $mig['status']; ?>">
                            <?php echo $mig['status']; ?>
                        </span>
                    </div>

                    <div class="migration-actions">
                        <?php if ($mig['type'] === 'php' && isset($mig['url'])): ?>
                            <a href="<?php echo $mig['url']; ?>" target="_blank" class="btn btn-primary">Run Migration</a>
                        <?php endif; ?>
                        <a href="<?php echo htmlspecialchars($mig['file']); ?>" target="_blank" class="btn btn-secondary btn-view">View File</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Additional Info -->
        <div class="info-box">
            <h3>About These Migrations</h3>
            <p>
                <strong>Migration 001-003:</strong> These are SQL files that set up initial configuration and optional features. You can import them manually via phpMyAdmin if needed.
            </p>
            <p>
                <strong>Migration 004 (Recommended):</strong> This is the main application migration that creates 43 essential tables for bookings, users, payments, drivers, and more. It's safe to run multiple times - it won't duplicate tables.
            </p>
            <p>
                <strong>Auto-Skip Existing:</strong> All migrations check if tables already exist before creating them. Running them again is perfectly safe.
            </p>
        </div>

        <footer>
            <p>WGroos Courier - Database Administration</p>
            <p>For issues or questions, check the README.md file</p>
        </footer>
    </div>
</body>
</html>
