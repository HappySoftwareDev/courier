<?php
$Connect = @mysqli_connect("localhost","merchant_admin","}{kTftfu1449", "merchant_db");

	 $count = 0;

	 $get = "SELECT * FROM bookings WHERE status ='new' ";


	 $run = mysqli_query($Connect,$get);

	 $count = mysqli_num_rows($run);

		echo $count;
