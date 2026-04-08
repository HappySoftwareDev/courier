<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

require_once '../../config/bootstrap.php';
require_once '../../function.php';

if (isset($_POST['status'])) {

    $username = trim($_POST['username']);
    $status = trim($_POST['status']);
    $order_id = trim($_POST['order_id']);

    try {

        $stmt = $DB_con->prepare("SELECT * FROM bookings WHERE order_number='$order_id' AND username=:username");
        $stmt->execute(array(":username" => $username));
        $count = $stmt->rowCount();

        if ($count == 1) {
            $stmt = $DB_con->prepare("UPDATE `bookings` SET status=:status WHERE order_number=:order_id");
            $stmt->bindparam(":status", $status);
            $stmt->bindparam(":order_id", $order_id);


            //check if query executes
            if ($stmt->execute()) {

                echo 2;
            } else {

                echo "Query could not execute";
            }
        } //end of integrity check

        else {
            echo "1"; // user email is taken
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


