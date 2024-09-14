<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

$Connect = @mysqli_connect("localhost", "iobagcmg_merchant_admin", "}{kTftfu1449", "iobagcmg_merchant_db");


if (isset($_GET['driva'])) {

    $MrE = $_GET['driva'];

    $get = "SELECT * FROM `bookings` WHERE  username='$MrE' AND status='on the way' ";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
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

        $ClientD = "    $address<br>
                                Phone: $phone<br/>
                                Email: $email_fro";

        $date = date("Y-m-d");
        $time = date("H:m");
        $datetime = $date . "T" . $time;
    }
}

echo "
    	 <ul class='list-group'>
                <li class='list-group-item'>
				<h5>From: <b> $name </b></h5>

				$address
				<br/>

				<h5>To: <b> $Drop_name </b> </h5>
				$drop_address
				<br/>


				Cost: $$cost1  </li>

				</ul>
			<form action='http://maps.google.com/maps' method='get' target='_blank'>
            <input type='hidden' name='saddr' Value='' />
            <input type='hidden' name='daddr' value='$drop_address' />

    		<button class='btn btn-primary btn-lg btn-block' type='submit' ><span class='fa fa-map-marker'></span> Directions</button>
    		</form>
    	  <div class='btn-group btn-group-justified'>
              <a class='btn btn-primary' href='tel:$phone' target='_blank'>CALL</a>
              <a class='btn btn-success' href='whatsapp://send?abid=$phone&text=HeyThere!'>WhatsApp</a>
              <a class='btn btn-info' href='sms:$phone?body=Hello!' target='_blank'>SMS</a>
          </div><br/>
          <a href='signature.html?orderD=$order_number'><button class='btn btn-success btn-lg btn-block' name='onWay' type='button' ><span class='icon_check_alt2'></span> Complete Order</button></a>

    	 <button class='btn btn-danger btn-lg btn-block' id='cancel_btn'
	 	  data-status_up_date='$datetime'
		  data-order_id='$order_number'
		  ><span class='icon_close_alt2'></span> Cancel Order</button>
	  ";
