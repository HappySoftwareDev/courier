<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

//header('Content-type: application/json');
session_start();
//$response = array();

require_once '../../config/bootstrap.php';
require_once '../../function.php';

if ($_POST) {

    $username = trim($_POST['uname']);
    $password = trim($_POST['password']);


    try {

        $stmt = $DB_con->prepare("SELECT * FROM `driver` WHERE username=:username");
        $stmt->execute(array(":username" => $username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();

        //check if password is correct
        if ($row['password'] == $password) {

            echo "Program Created";
            $_SESSION['id'] = $row['id'];
            $_SESSION['MM_Username'] = $row['username'];
            //set session

        } else {

            echo "Invalid password";
        }
    } // end of try block

    catch (PDOException $e) {
        echo $e->getMessage();
    }
} //end post
else {

    echo "Nothing has been posted"; // user email is taken
}


 //echo json_encode($response);


