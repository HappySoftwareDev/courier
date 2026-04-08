<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

require_once '../../config/bootstrap.php';
require_once('../../function.php');

if (isset($_GET["driva"])) {
    $user = $_GET['driva'];

    $get = "SELECT * FROM bookings WHERE status =?";
    $stmt = $DB->prepare($get);
    $stmt->execute([$user]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row_type) {
        $ID = $row_type['order_id'];
        $Date = $row_type['Date'];
        $name = $row_type['Name'];
        $Total_price = $row_type['Total_price'];
        $service = $row_type['vehicle_type'];


        $cost = "";
        $url = "";

        if ($service == "Parcel Delivery") {
            $url = "acceptedOrdersDetails.html?orderD=$ID";
            $cost = 70 / 100 * $Total_price;
        } else if ($service == "Freight Delivery") {
            $url = "acceptedOrdersDetails.html?orderD=$ID";
            $cost = 80 / 100 * $Total_price;
        } else if ($service == "Test") {
            $url = "acceptedOrdersDetails.html?orderD=$ID";
            $cost = 70 / 100 * $Total_price;
        }

        $cost1 = number_format((float)$cost, 2, '.', '');



        echo "
		   <ul class='list-group'>
               <li class='list-group-item' ><a  style=' color:#ff8c00;' href='$url'> Order From $name <button class='btn btn-warning btn-sm pull-right'>accepted</button></a> <br/> $ $cost1 </li>

				</ul>
			";
    }
}


