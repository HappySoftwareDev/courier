<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

$Connect = @mysqli_connect("localhost","iobagcmg_merchant_admin","}{kTftfu1449", "iobagcmg_merchant_db");


	 if (isset($_GET['order_id'])){

	 $MrE = $_GET['order_id'];

	 $get = "SELECT * FROM `bookings` WHERE  order_number='$MrE' ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
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
		$url="";

		if($service=="Parcel Delivery"){
		   $cost = 70 / 100 * $Total_price;

		}
		else if($service=="Freight Delivery"){
		   $cost = 80 / 100 * $Total_price;
		}
			else if($service=="Test"){
		   $cost = 70 / 100 * $Total_price;
		}
		$cost1 = number_format((float)$cost, 2, '.', '');

		$ClientD = "    $address<br>
                                Phone: $phone<br/>
                                Email: $email_fro";

         $date= date("Y-m-d");
         $time=date("H:m");
         $datetime=$date."T".$time;




		 }
		 }

		 echo "

	<button class='btn btn-success button' type='submit' id='complete_btn'
		  data-status_up_date='$datetime'
		  data-phone='$phone'
		  data-clientEmail='$email_fro'
		  data-order_id='$order_number'
		  data-bid_price='$cost1'
		  data-delivery_type='$service'
		  data-clientName='$name'
		  data-drop_name='$Drop_name'
		  data-drop_phone='$drop_phone'
		  data-bid_price='$cost1'
		  >
		  <span class='icon_check_alt2'></span> Complete Delivery
		  </button>

	  ";
