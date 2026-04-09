<?php
/**
 * Homepage Test - Loads index.php and shows result
 */

header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Suppress session warnings
ini_set('session.save_path', '/tmp');

echo "<!DOCTYPE html>
<html>
<head>
    <title>Homepage Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .info { background: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { background: #ffebee; padding: 15px; border-radius: 5px; margin: 10px 0; color: #c62828; }
        .success { background: #e8f5e9; padding: 15px; border-radius: 5px; margin: 10px 0; color: #2e7d32; }
    </style>
</head>
<body>
    <h1>🏠 Homepage Loading Test</h1>";

try {
    echo "<div class='info'>Starting to load index.php...</div>";
    
    // Capture output
    ob_start();
    
    // Change to the directory
    chdir(dirname(__FILE__));
    
    // Load index.php
    include 'index.php';
    
    $output = ob_get_clean();
    
    if (!empty($output)) {
        echo "<div class='success'>✅ Homepage loaded successfully!</div>";
        echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 10px 0; max-height: 600px; overflow-y: auto;'>";
        echo $output;
        echo "</div>";
    } else {
        echo "<div class='error'>❌ Homepage loaded but produced no output</div>";
    }
    
} catch (Exception $e) {
    echo "<div class='error'>";
    echo "<strong>❌ Error Loading Homepage</strong><br>";
    echo htmlspecialchars($e->getMessage()) . "<br>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}

echo "
</body>
</html>";
?>
