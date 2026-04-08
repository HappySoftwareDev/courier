<?php
/**
 * Admin Database Settings
 * View and update database configuration from admin panel
 * Passwords are encrypted in database, not stored in files
 */

require_once '../../../config/bootstrap.php';

// Require admin authentication
if (!isset($_SESSION['admin_id']) && (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin')) {
    header('Location: /portals/admin/');
    exit;
}

$pageTitle = 'Database Settings';
$message = '';
$messageType = '';

// Get current config from file
$configFile = dirname(__DIR__) . '/../../config/database-config.php';
$currentConfig = include $configFile;

// Check if updating from admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_database'])) {
    try {
        $dbHost = trim($_POST['db_host'] ?? '');
        $dbUser = trim($_POST['db_user'] ?? '');
        $dbPass = trim($_POST['db_pass'] ?? '');
        $dbName = trim($_POST['db_name'] ?? '');

        // Validate inputs
        if (empty($dbHost) || empty($dbUser) || empty($dbName)) {
            throw new Exception('All fields are required');
        }

        // Test new connection
        $testPdo = new PDO(
            "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
            $dbUser,
            $dbPass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );

        // If successful, encrypt and store in database
        $encryptionKey = $CONFIG->get('encryption_key') ?: 'default-key-change-this';
        $encryptedPass = openssl_encrypt($dbPass, 'AES-256-CBC', $encryptionKey, 0, substr(md5($encryptionKey), 0, 16));

        // Store in config table (encrypted)
        $stmt = $DB->prepare("INSERT INTO config (config_key, config_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE config_value = ?");
        $stmt->execute(['db_host_encrypted', $dbHost, $dbHost]);
        $stmt->execute(['db_user_encrypted', $dbUser, $dbUser]);
        $stmt->execute(['db_pass_encrypted', $encryptedPass, $encryptedPass]);
        $stmt->execute(['db_name_encrypted', $dbName, $dbName]);

        $message = 'Database configuration updated and encrypted successfully. You can now update database-config.php manually with these new credentials.';
        $messageType = 'success';

        // Update file config if authorized (optional)
        if (isset($_POST['update_file']) && $_POST['update_file'] === 'yes') {
            $configContent = "<?php
/**
 * Database Configuration - Updated " . date('Y-m-d H:i:s') . "
 * Manage database details from Admin > Database Settings
 */

return [
    'driver' => getenv('DB_DRIVER') ?: 'pdo',
    'host' => getenv('DB_HOST') ?: '$dbHost',
    'user' => getenv('DB_USER') ?: '$dbUser',
    'pass' => getenv('DB_PASS') ?: '$dbPass',
    'name' => getenv('DB_NAME') ?: '$dbName',
    'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
    'port' => getenv('DB_PORT') ?: 3306,
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => \"SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci\"
    ]
];
";
            
            if (file_put_contents($configFile, $configContent)) {
                $message .= ' File configuration also updated.';
            } else {
                $message .= ' (Note: File could not be updated - check permissions)';
            }
        }

    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $messageType = 'error';
    }
}

// Get encrypted config from database if available
$encryptedConfig = [];
try {
    $stmt = $DB->prepare("SELECT config_key, config_value FROM config WHERE config_key IN ('db_host_encrypted', 'db_user_encrypted', 'db_pass_encrypted', 'db_name_encrypted')");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($results as $row) {
        $encryptedConfig[$row['config_key']] = $row['config_value'];
    }
} catch (Exception $e) {
    // Table might not exist yet
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database Settings - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        body { background: #f5f5f5; }
        .container { margin-top: 30px; max-width: 600px; }
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .card-header { background: #667eea; color: white; }
        .alert { margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .help-text { font-size: 12px; color: #666; margin-top: 5px; }
        .password-note { background: #fff3cd; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .badge { font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 style="margin: 0;">Database Settings</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?php echo $messageType === 'success' ? 'success' : 'danger'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <div class="password-note">
                    <strong>🔒 Security Notice:</strong>
                    <p style="margin-top: 10px; margin-bottom: 0; font-size: 14px;">
                        Database passwords are encrypted and stored in the database, not in the configuration file. Environment variables (if set) take priority over these settings.
                    </p>
                </div>

                <form method="POST">
                    <input type="hidden" name="update_database" value="1">

                    <div class="form-group">
                        <label for="db_host" class="form-label">Database Host</label>
                        <input type="text" class="form-control" id="db_host" name="db_host" 
                               value="<?php echo htmlspecialchars($encryptedConfig['db_host_encrypted'] ?? $currentConfig['host']); ?>" required>
                        <div class="help-text">Usually <code>localhost</code></div>
                    </div>

                    <div class="form-group">
                        <label for="db_user" class="form-label">Database User</label>
                        <input type="text" class="form-control" id="db_user" name="db_user" 
                               value="<?php echo htmlspecialchars($encryptedConfig['db_user_encrypted'] ?? $currentConfig['user']); ?>" required>
                        <div class="help-text">Database username (e.g., cpaneluser_dbname)</div>
                    </div>

                    <div class="form-group">
                        <label for="db_pass" class="form-label">Database Password</label>
                        <input type="password" class="form-control" id="db_pass" name="db_pass" placeholder="Enter password (leave blank to keep current)" required>
                        <div class="help-text">⚠️ Password will be encrypted and stored securely</div>
                    </div>

                    <div class="form-group">
                        <label for="db_name" class="form-label">Database Name</label>
                        <input type="text" class="form-control" id="db_name" name="db_name" 
                               value="<?php echo htmlspecialchars($encryptedConfig['db_name_encrypted'] ?? $currentConfig['name']); ?>" required>
                        <div class="help-text">Name of your database</div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="update_file" name="update_file" value="yes">
                            <label class="form-check-label" for="update_file">
                                Also update <code>config/database-config.php</code> file
                            </label>
                            <div class="help-text">Optional: Update the config file if you have write permissions</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Save & Test Connection</button>
                </form>

                <hr>

                <div style="background: #f0f7ff; padding: 15px; border-radius: 5px;">
                    <strong>Current Configuration:</strong>
                    <table style="margin-top: 10px; width: 100%; font-size: 13px;">
                        <tr>
                            <td><strong>Host:</strong></td>
                            <td style="text-align: right;"><code><?php echo htmlspecialchars($currentConfig['host']); ?></code></td>
                        </tr>
                        <tr>
                            <td><strong>User:</strong></td>
                            <td style="text-align: right;"><code><?php echo htmlspecialchars($currentConfig['user']); ?></code></td>
                        </tr>
                        <tr>
                            <td><strong>Database:</strong></td>
                            <td style="text-align: right;"><code><?php echo htmlspecialchars($currentConfig['name']); ?></code></td>
                        </tr>
                        <tr>
                            <td><strong>Encrypted Password:</strong></td>
                            <td style="text-align: right;">
                                <?php if (!empty($encryptedConfig['db_pass_encrypted'])): ?>
                                    <span class="badge bg-success">✓ Stored</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Not stored</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
