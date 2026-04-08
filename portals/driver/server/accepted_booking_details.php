<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

require_once '../../config/bootstrap.php';
require_once '../../function.php';


if (isset($_GET['orderD'])) {

    $MrE = $_GET['orderD'];

    $get = "SELECT * FROM `bookings` WHERE order_id = ?";
    $stmt = $DB->prepare($get);
    $stmt->execute([$MrE]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row_type) {
        $ID = $row_type['order_id'];
        $order_number = $row_type['order_number'];
        $Date = $row_type['Date'];
        $email_fro = $row_type['email'];
        $address = $row_type['pick_up_address'];
        $drop_address = $row_type['drop_address'];
        $name = $row_type['Name'];
        $client_name = $row_type['Name'];
        $phone = $row_type['phone'];
        $pick_up_date = $row_type['pick_up_date'];
        $drop_date = $row_type['drop_date'];
        $Drop_name = $row_type['Drop_name'];
        $Total_price = $row_type['Total_price'];
        $drop_phone = $row_type['drop_phone'];
        $weight_of_package = $row_type['weight'];
        $package_quantity = $row_type['quantity'];
        $insurance = $row_type['insurance'];
        $value_of_package = $row_type['value'];
        $type_of_transport = $row_type['type_of_transport'];
        $note = $row_type['drivers_note'];
        $time = $row_type['pick_up_time'];
        $drop_time = $row_type['drop_time'];
        $status = $row_type['status'];
        $service = $row_type['vehicle_type'];

        $cost = "";
        $url = "";

        if ($service == "Parcel Delivery") {
            $cost = 70 / 100 * $Total_price;
        } else if ($service == "Freight Delivery") {
            $cost = 80 / 100 * $Total_price;
        } else if ($service == "Test") {
            $cost = 70 / 100 * $Total_price;
        }
        $cost1 = number_format((float)$cost, 2, '.', '');

        $details = "<tr>
                <td>$ID</td>
				<td>$name</td>
				<td>$address</td>
				<td>$drop_address</td>
				<td><a class='btn btn-info' href='' title='Bootstrap 3 themes generator'><span class='fa fa-file-o'></span> Info</a></td>
            </tr>";

        $MC = "<ul class='list-group'>
                <li class='list-group-item'>
				<h5>From: <b> $name </b></h5>

				$address
				<br/>

				<h5>To: <b> $Drop_name </b> </h5>
				$drop_address
				<br/>


				Cost: $$cost1  </li>

				</ul>
				   ";

        $ClientD = "    $address<br>
                                Phone: $phone<br/>
                                Email: $email_fro";
    }
}




$date = date("Y-m-d");
$time = date("H:m");
$datetime = $date . "T" . $time;


echo "
    	  $MC

    	 <li class='list-group-item'>
		  <button class='btn btn-success btn-lg btn-block' type='submit' id='atPick_btn'
		  data-status_up_date='$datetime'
		  data-phone='$phone'
		  data-clientEmail='$email_fro'
		  data-order_id='$order_number'
		  data-client_name='$name'
		  >
		  <span class='icon_check_alt2'></span> At Pickup
		  </button>
		  </li>
		  <li class='list-group-item'>
		  <button class='btn btn-danger btn-lg btn-block' id='cancel_btn'
	 	  data-status_up_date='$datetime'
		  data-order_id='$order_number'
		  ><span class='icon_close_alt2'></span> Cancel Order</button>
		  </li>

	  ";


