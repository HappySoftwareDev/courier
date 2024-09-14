<?php
require_once('../db.php');
$loginFormAction = $_SERVER['PHP_SELF'];
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}
//$response = array();

if ($_POST) {
    $username = trim($_POST['uname']);
    $password = trim($_POST['password']);
    try {
        $stmt = $Connect->prepare("SELECT * FROM `driver` WHERE username=:username and password='$password'");
        $stmt->execute(array(":username" => $username));
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