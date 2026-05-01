<?php
require_once 'config/bootstrap.php';

echo "<h2>Database Login Debug</h2>";

global $DB;

try {
    // Check users table structure
    echo "<h3>Users Table Fields:</h3>";
    $result = $DB->query("DESCRIBE users");
    while ($field = $result->fetch(PDO::FETCH_ASSOC)) {
        echo $field['Field'] . " (" . $field['Type'] . ")<br>";
    }
    
    // Check users table data
    echo "<h3>Users in Database:</h3>";
    $users = $DB->query("SELECT ID, email, username, Password FROM users LIMIT 10");
    $userList = $users->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($userList);
    echo "</pre>";
    
    // Check driver table structure
    echo "<h3>Driver Table Fields:</h3>";
    $result = $DB->query("DESCRIBE driver");
    while ($field = $result->fetch(PDO::FETCH_ASSOC)) {
        echo $field['Field'] . " (" . $field['Type'] . ")<br>";
    }
    
    // Check driver table data
    echo "<h3>Drivers in Database:</h3>";
    $drivers = $DB->query("SELECT * FROM driver LIMIT 5");
    $driverList = $drivers->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($driverList);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
