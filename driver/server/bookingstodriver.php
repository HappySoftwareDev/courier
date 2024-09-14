<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

$Connect = @mysqli_connect("localhost", "iobagcmg_merchant_admin", "}{kTftfu1449", "iobagcmg_merchant_db");


$get = "SELECT * FROM bookings WHERE status ='new'";

$run = mysqli_query($Connect, $get);

if (mysqli_num_rows($run) > 0) {
    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['order_id'];
        $Date = $row_type['Date'];
        $name = $row_type['Name'];
        $Total_price = $row_type['Total_price'];
        $service = $row_type['vehicle_type'];


        $cost = "";
        $url = "";

        if ($service == "Parcel Delivery") {
            $url = "order_datails.html?orderD=$ID";
            $cost = 70 / 100 * $Total_price;
        } else if ($service == "Freight Delivery") {
            $url = "freight_order_details.html?orderD=$ID";
            $cost = 80 / 100 * $Total_price;
        } else if ($service == "Test") {
            $url = "freight_order_details.html?orderD=$ID";
            $cost = 70 / 100 * $Total_price;
        }

        $cost1 = number_format((float)$cost, 2, '.', '');



        echo "
		   <ul class='list-group'>
                 <li class='list-group-item' ><a  style=' color:#ff8c00;' href='$url'> Order From $name <button class='btn btn-info btn-sm pull-right'>new</button></a> <br> $$cost1 </li>

				</ul>
			";
    }
}
