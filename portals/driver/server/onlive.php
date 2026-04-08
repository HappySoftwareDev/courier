<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

require_once '../../config/bootstrap.php';
require_once '../../function.php';

if (isset($_GET['driva'])) {

    $MrE = $_GET['driva'];

    try {

        $stmt = $DB_con->prepare("SELECT * FROM `bookings` WHERE  username=:username AND status = 'on the way'");
        $stmt->execute(array(":username" => $MrE));
        $count = $stmt->rowCount();

        if ($count == 1) {

            echo 2;
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


