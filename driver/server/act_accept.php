<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

require_once 'db.php';

if (isset($_POST['status'])) {

    $username = trim($_POST['status']);
    $status = "new";
    $bid_price = trim($_POST['bid_price']);
    $number_of_trucks =  1;
    $date_available = trim($_POST['date_available']);
    $shot_desc = trim($_POST['shot_desc']);
    $order_id = trim($_POST['order_id']);

    try {

        $stmt = $DB_con->prepare("SELECT * FROM bookings WHERE status=:status AND order_number='$order_id'");
        $stmt->execute(array(":status" => $status));
        $count = $stmt->rowCount();

        if ($count == 1) {
            $stmt = $DB_con->prepare("UPDATE `bookings` SET status=:username, num_truck_available=:number_of_trucks, bid_price=:bid_price WHERE order_number=:order_id");
            $stmt->bindparam(":username", $username);
            $stmt->bindparam(":number_of_trucks", $number_of_trucks);
            $stmt->bindparam(":bid_price", $bid_price);
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
