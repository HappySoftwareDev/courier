<?php

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}
// Enable error reporting for debugging (This should be done early in the script)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
//$response = array();

require_once '../config/bootstrap.php';
require_once('../function.php');

// Driver auth - this file handles login
 


$loginFormAction = $_SERVER['PHP_SELF'];


if ($_POST) {
    $username = trim($_POST['uname']);
    $password = trim($_POST['password']);
    try {
        global $DB;
        
        // Check driver table - try both possible field names for password
        $stmt = $DB->prepare("SELECT * FROM `driver` WHERE username = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        
        if ($row) {
            // Try different password field names
            $storedPassword = $row['password'] ?? $row['Password'] ?? $row['password_hash'] ?? null;
            
            if ($storedPassword && ($storedPassword === $password || password_verify($password, $storedPassword))) {
                $_SESSION['MM_Username'] = $username;
                $_SESSION['MM_UserGroup'] = $username;
                $_SESSION['driver_id'] = $row['id'] ?? $row['ID'] ?? '';
                
                // Ensure session is written before responding
                session_write_close();
                echo "ok";
                exit;
            } else {
                echo "Invalid password";
            }
        } else {
            echo "Username not found";
        }
    } catch (Exception $e) {
        error_log('Driver login error: ' . $e->getMessage());
        echo "Login error: " . $e->getMessage();
    }
  
?>

