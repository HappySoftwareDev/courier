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

    if (count($results) > 0) {
        foreach ($results as $row_type) {
            $ID = $row_type['order_id'];
            $order_number = $row_type['order_number'];
            $Date = $row_type['Date'];
            $email_fro = $row_type['email'];
            $address = $row_type['pick_up_address'];
            $drop_address = $row_type['drop_address'];
            $name = $row_type['Name'];
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
            $goods = $row_type['goods'];
            $distance = $row_type['distance'];

            $details = "<tr>
                <td>$ID</td>
				<td>$name</td>
				<td>$address</td>
				<td>$drop_address</td>
				<td><a class='btn btn-info' href='' title='Bootstrap 3 themes generator'><span class='fa fa-file-o'></span> Info</a></td>
                </tr>";
            $cost = 80 / 100 * $Total_price;
            $cost1 = number_format((float)$cost, 2, '.', '');

            $MC = "<ul class='list-group'>
                   <li class='list-group-item'><h3>From</h3></li>
			       <li class='list-group-item'><b>Name:</b> $name<br></li>

				   <li class='list-group-item'><h3>Deliver To</h3></li>
				   <li class='list-group-item'><b>Name:</b> $Drop_name<br></li>
                   <li class='list-group-item'><b>Phone:</b> $drop_phone<br/></li>

				  <li class='list-group-item'> <h3>Pick Up Address</h3></li>
                   <li class='list-group-item'><b>Address:</b> $address <br/></li>
                   <li class='list-group-item'><b>Pick Up Date:</b> $pick_up_date <br/></li>
                   <li class='list-group-item'><b>Pick Up Time:</b> $time <br/><br/></li>

				   <li class='list-group-item'><h3>Delivery Address</h3></li>
                   <li class='list-group-item'><b>Address:</b> $drop_address <br/></li>
                   <li class='list-group-item'><b>Delivery Date:</b> $drop_date <br/></li>
                   <li class='list-group-item'><b>Delivery Time:</b> $drop_time <br/><br/></li>

                   <li class='list-group-item'><b>Distance:</b> $distance <br/><br/></li>

				   <li class='list-group-item'><h3>Package Details</h3></li>
				  <li class='list-group-item'> <b>Weight:</b> $weight_of_package tonnes<br></li>
                   <li class='list-group-item'><b>Goods:</b> $goods<br/></li>
                   <li class='list-group-item'><b>Transport:</b> $type_of_transport <br/></li>
                   <li class='list-group-item'><b>Proposed Cost:</b> $$cost1 <br/><br/></li>
                  <li class='list-group-item'> <b>Note:</b> $note <br/>

				   </ul>
				   ";

            $ClientD = "    $address<br>
                                Phone: $phone<br/>
                                Email: $email_fro";
        }
    }
}



$date = date("Y-m-d");
$time = date("H:m");
$datetime = $date . "T" . $time;


echo "
    	  $MC

    	  <li class='list-group-item'><center><div class='btn-group'>
		  <button class='btn btn-success btn-lg' type='submit' id='acc_btn'
		  data-status_up_date='$datetime'
		  data-phone='$phone'
		  data-clientEmail='$email_fro'
		  data-order_id='$order_number'
		  data-bid_price='$cost1'
		  >
		  <span class='icon_check_alt2'></span> accept
		  </button>
		  <a class='btn btn-danger btn-lg' href='new_orders.html' ><span class='icon_close_alt2'></span> decline</a></div>
		  </center>
		  </li>

	  ";


