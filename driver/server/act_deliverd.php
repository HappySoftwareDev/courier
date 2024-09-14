<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

require_once 'db.php';
$Connect = @mysqli_connect("localhost", "merchant_admin", "}{kTftfu1449", "merchant_db");

if ($_POST) {

    $username = trim($_POST['username']);
    $status = trim($_POST['status']);
    $order_id = trim($_POST['order_id']);
    $status_update = trim($_POST['status_up_date']);
    $drop_name = trim($_POST['recipeint_name']);

    $Image1 = $_FILES['signature']['name'];
    $tmp_name_array1 = $_FILES['signature']['tmp_name'];
    move_uploaded_file($tmp_name_array1, "sign_img/" . date('d-m-Y-H-i-s') . '-' . $Image1);
    $img1 =  date('d-m-Y-H-i-s') . '-' . $Image1;

    try {

        $stmt = $DB_con->prepare("SELECT * FROM bookings WHERE order_number=:order_id");
        $stmt->execute(array(":order_id" => $order_id));
        $count = $stmt->rowCount();

        if ($count == 1) {
            $upd = "UPDATE `bookings` SET `status`='$status',`status_update_date`='$status_update',`ReciepientName`='$drop_name',`username`='$username' WHERE `order_number`='$order_id'";

            $run = mysqli_query($Connect, $upd);
            //check if query executes
            if ($upd) {

                echo 2;
            } else {

                echo "Query could not execute";
            }
        } //end of integrity check

        else {
            echo 1; // user email is taken
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
