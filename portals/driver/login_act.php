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
        // Use prepared statement with password as parameter (NOT hardcoded in SQL)
        $stmt = $DB->prepare("SELECT * FROM `driver` WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        $MM_UserGroup = "";
        //check if password is correct
        if ($count == 1) {
            $_SESSION['MM_Username'] = $username;
            $_SESSION['MM_UserGroup'] = $username;

            // $go = "new_orders.php";
            // //set session
            // header("Location: " . $go);
            echo "ok";
        } else {
            echo "Invalid password";
        }
    } // end of try block

    catch (PDOException $e) {
        echo $e->getMessage();
    }
  } //end post
  
?>

