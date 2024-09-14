<?php
$hostname_Connect = "localhost";
$database_Connect = "kundaita_mc_db";
$username_Connect = "kundaita_mc_user";
$password_Connect = "#;H}MXNXx(kB";

// FOR DEV ENV
// $hostname_Connect = "localhost";
// $database_Connect = "kundaita_mc_db";
// $username_Connect = "root";
// $password_Connect = "";

$Connect = @mysqli_connect($hostname_Connect, $username_Connect, $password_Connect, $database_Connect);
// $Connect = @mysqli_connect("localhost","root","", "kundaita_mc_db");

function getClients()
{
    global $Connect;

    $get = "SELECT * FROM `clients`";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['client_id'];
        $Name = $row_type['Name'];
        $Email = $row_type['Email'];
        $Pass = $row_type['Password'];

        echo "<tr>
                <td> $ID</td>
                <td>$Name</td>
                <td>$Email</td>
                <td>$Pass</td>
				<td><a href='delete.php?delete=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";
    }
}

function getUsers()
{
    global $Connect;

    $get = "SELECT * FROM `users`";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['client_id'];
        $Name = $row_type['Name'];
        $Email = $row_type['EmailAddress'];

        echo "<tr>
                <td> $ID</td>
                <td>$Name</td>
                <td>$Email</td>
                <td></td>
				<td><a href='delete.php?delete=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";
    }
}

function getDrivers()
{
    global $Connect;

    $get = "SELECT * FROM `driver`";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['driverID'];
        $Name = $row_type['name'];
        $phone = $row_type['phone'];
        $address = $row_type['address'];
        $vehicleMake = $row_type['vehicleMake'];
        $model = $row_type['model'];
        $year = $row_type['year'];
        $engineCapacity = $row_type['engineCapacity'];
        $dob = $row_type['DOB'];
        $occupation = $row_type['occupation'];
        $documents = $row_type['documents'];

        echo "<tr>
                <td> $ID</td>
                <td><b style='color:#FF8C00'>$Name</b><br/>$phone<br/><b style='color:#FF8C00'>$address</b></td>
                <td>Online</td>
                <td>Active</td>
				<td>On Wage</td>
				<td><button type='button' class='btn btn-danger'>Revoke</button></td>
				<td><a href='delete.php?deleteDriver=$ID'><i class='fa-fw'>details...</i></a></td>
            </tr>";
    }
}

function getDriversOnMaps()
{
    global $Connect;

    $get = "SELECT * FROM `driver`";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['driverID'];
        $Name = $row_type['name'];
        $phone = $row_type['phone'];
        $address = $row_type['address'];
        $vehicleMake = $row_type['vehicleMake'];
        $model = $row_type['model'];
        $year = $row_type['year'];
        $engineCapacity = $row_type['engineCapacity'];
        $dob = $row_type['DOB'];
        $occupation = $row_type['occupation'];
        $documents = $row_type['documents'];

        echo "<div class='list-group'>
	  <button id='driver_id' class='list-group-item' style='color: #FF8C00'><i class='fa fa-car fa-fw'></i>$Name</button>
	  </div>
	  ";
    }
}


function getDriversOnApp()
{
    if (isset($_SESSION['MM_Username'])) {
        $user = $_SESSION['MM_Username'];
        global $Connect;

        $get = "SELECT * FROM `driver` where username = '$user'  ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['driverID'];
            $Name = $row_type['name'];
            $phone = $row_type['phone'];
            $address = $row_type['address'];
            $vehicleMake = $row_type['vehicleMake'];
            $model = $row_type['model'];
            $year = $row_type['year'];
            $engineCapacity = $row_type['engineCapacity'];
            $dob = $row_type['DOB'];
            $occupation = $row_type['occupation'];
            $documents = $row_type['documents'];

            echo " <div class='bio-row'>
                                              <p><span> Name </span>: $Name </p>
                                              </div>
                                              <div class='bio-row'>
                                                  <p><span>Last Name </span>: $address</p>
                                              </div>
                                              <div class='bio-row'>
                                                  <p><span>Birthday</span>: $dob</p>
                                              </div>
                                              <div class='bio-row'>
                                                  <p><span>Country </span>: Zimbabwe</p>
                                              </div>
                                              <div class='bio-row'>
                                                  <p><span>Occupation </span>: $occupation</p>
                                              </div>
                                              <div class='bio-row'>
                                                  <p><span>Mobile </span>: $phone</p>
                                              </div>

	  ";
        }
    }
}

function getDriversNameOnApp()
{
    $user = $_SESSION['MM_Username'];
    global $Connect;

    $get = "SELECT * FROM `driver` where username = '$user' LIMIT 1 ";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['driverID'];
        $Name = $row_type['name'];
        $phone = $row_type['phone'];
        $address = $row_type['address'];
        $vehicleMake = $row_type['vehicleMake'];
        $model = $row_type['model'];
        $year = $row_type['year'];
        $engineCapacity = $row_type['engineCapacity'];
        $dob = $row_type['DOB'];
        $occupation = $row_type['occupation'];

        echo "  $Name


	  ";
    }
}

function getTaxiDriversLiveJob()
{
    $user = $_SESSION['MM_Username'];
    global $Connect;

    $get = "SELECT * FROM `driver` where username = '$user' LIMIT 1 ";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $type_of_service = $row_type['type_of_service'];

        $link = "afterPick.php";

        if ($type_of_service == "Taxi") {
            $link = "taxi.afterPick.php";
        }

        echo "
          $link
        ";
    }
}

function getBookings()
{
    global $Connect;

    $get = "SELECT * FROM `bookings`";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['order_id'];
        $email_from = $row_type['email'];
        $address = $row_type['pick_up_address'];
        $drop_address = $row_type['drop_address'];
        $name = $row_type['Name'];;
        $date = $row_type['pick_up_date'];
        $drop_date = $row_type['drop_date'];
        $weight_of_package = $row_type['weight'];
        $package_quantity = $row_type['quantity'];
        $insurance = $row_type['insurance'];
        $value_of_package = $row_type['value'];
        $note = $row_type['drivers_note'];
        $time = $row_type['pick_up_time'];

        echo "<tr>
                <td>$ID</td>
                <td>$date</td>
                <td>$time</td>
                <td>$name</td>
				<td>$email_from</td>
				<td><a href='delete.php?deleteOrder=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";
    }
}

function getBookingInv()
{
    global $Connect;

    $get = "SELECT * FROM `bookings`";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['order_id'];
        $email_from = $row_type['email'];
        $address = $row_type['pick_up_address'];
        $drop_address = $row_type['drop_address'];
        $name = $row_type['Name'];;
        $date = $row_type['pick_up_date'];
        $drop_date = $row_type['drop_date'];
        $weight_of_package = $row_type['weight'];
        $package_quantity = $row_type['quantity'];
        $insurance = $row_type['insurance'];
        $value_of_package = $row_type['value'];
        $note = $row_type['drivers_note'];
        $time = $row_type['pick_up_time'];

        echo "<tr>
                <td>$ID</td>
                <td>$date</td>
                <td>$time</td>
                <td>$name</td>
				<td>$email_from</td>
				<td><a href='delete.php?deleteOrder=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";
    }
}

function getExDateToDriver()
{
    global $Connect;

    $user = $_SESSION['MM_Username'];

    $get_driver = "SELECT * FROM driver WHERE username='$user' ";

    $run_driver = mysqli_query($Connect, $get_driver);

    while ($row_type = mysqli_fetch_array($run_driver)) {
        $ID = $row_type['driverID'];
        $company_name = $row_type['company_name'];
        $online = $row_type['online'];
        $mode_of_transport = $row_type['mode_of_transport'];
        $username = $row_type['username'];

        $get = "SELECT * FROM `users` WHERE Name='$company_name'";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['ID'];
            $Name = $row_type['Name'];
            $Email = $row_type['email'];
            $date = $row_type['date'];
            $days = $row_type['days'];

            $expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . "+ $days day"));

            if (date("Y-m-d") < $expire) {
                $show = "";
            } else {
                $show = "<div style='color:red'><h2>Your account has expired please recharge!<h2></div>";
            }
            echo "$show";
        }
    }
}


function getBookingsToDriver()
{

    $user = $_SESSION['MM_Username'];
    global $Connect;

    $get_driver = "SELECT * FROM driver WHERE username='$user' ";

    $run_driver = mysqli_query($Connect, $get_driver);

    while ($row_type = mysqli_fetch_array($run_driver)) {
        $ID = $row_type['driverID'];
        $company_name = $row_type['company_name'];
        $online = $row_type['online'];
        $mode_of_transport = $row_type['mode_of_transport'];
        $type_of_service = $row_type['type_of_service'];
        $username = $row_type['username'];


        $get = "SELECT * FROM bookings WHERE status ='new' AND vehicle_type='$type_of_service' ORDER BY Date DESC LIMIT 8 ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['order_id'];
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
            $service = $row_type['vehicle_type'];


            $cost = "";
            $url = "";

            $get_commission = "SELECT * FROM `prizelist` ";

            $run_commission = mysqli_query($Connect, $get_commission);

            while ($row_type = mysqli_fetch_array($run_commission)) {

                $parcel_driver_commission = $row_type['parcel_driver_commission'];
                $freight_driver_commission = $row_type['freight_driver_commission'];
                $furniture_driver_commission = $row_type['furniture_driver_commission'];
            }

            if ($service == "Parcel Delivery") {
                $url = "order_datails.php?orderD=$ID";
                $cost = $parcel_driver_commission / 100 * $Total_price;
            } else if ($service == "Freight Delivery") {
                $url = "freight_order_details.php?orderD=$ID";
                $cost = $freight_driver_commission / 100 * $Total_price;
            } else if ($service == "Test") {
                $url = "freight_order_details.php?orderD=$ID";
                $cost = $freight_driver_commission / 100 * $Total_price;
            }

            $cost1 = number_format((float)$cost, 2, '.', '');

            if ($online == "offline") {
                echo "
		  <ul class='list-group'>
                 <li class='list-group-item' ><a  style=' color:#ff8c00;' href='#'> Order From $name <button class='btn btn-info btn-sm pull-right'>new</button></a> <br> $$cost1 </li>

				</ul>
		 ";
            } else {

                echo "
	       <tr>
		   <ul class='list-group'>
                 <li class='list-group-item' ><a  style=' color:#ff8c00;' href='$url'> Order From $name <button class='btn btn-info btn-sm pull-right'>new</button></a> <br> $$cost1 </li>

				</ul>
            </tr>
			";
            }
        }
    }
}


function getBookingsToTruckDrivers()
{

    $user = $_SESSION['MM_Username'];
    global $Connect;

    $get_driver = "SELECT * FROM driver WHERE username='$user' ";

    $run_driver = mysqli_query($Connect, $get_driver);

    while ($row_type = mysqli_fetch_array($run_driver)) {
        $ID = $row_type['driverID'];
        $company_name = $row_type['company_name'];
        $online = $row_type['online'];
        $mode_of_transport = $row_type['mode_of_transport'];
        $type_of_service = $row_type['type_of_service'];
        $username = $row_type['username'];

        $get = "SELECT * FROM `users` WHERE Name='$company_name'";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['ID'];
            $Name = $row_type['Name'];
            $Email = $row_type['email'];
            $date = $row_type['date'];
            $days = $row_type['days'];

            $expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . "+ $days day"));

            if (date("Y-m-d") < $expire) {

                $get = "SELECT * FROM bookings WHERE status ='new' AND vehicle_type='$type_of_service' AND company_name='$company_name' ORDER BY Date DESC LIMIT 8 ";

                $run = mysqli_query($Connect, $get);

                while ($row_type = mysqli_fetch_array($run)) {
                    $ID = $row_type['order_id'];
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
                    $service = $row_type['vehicle_type'];
                    $drop_time = $row_type['drop_time'];


                    $get_commission = "SELECT * FROM `prizelist` ";

                    $run_commission = mysqli_query($Connect, $get_commission);

                    while ($row_type = mysqli_fetch_array($run_commission)) {

                        $parcel_driver_commission = $row_type['parcel_driver_commission'];
                        $freight_driver_commission = $row_type['freight_driver_commission'];
                        $furniture_driver_commission = $row_type['furniture_driver_commission'];
                    }

                    if ($service == "Parcel Delivery") {
                        $url = "order_datails.php?orderD=$ID";
                        $cost = $parcel_driver_commission / 100 * $Total_price;
                    } else if ($service == "Freight Delivery") {
                        $url = "freight_order_details.php?orderD=$ID";
                        $cost = $freight_driver_commission / 100 * $Total_price;
                    } else if ($service == "Test") {
                        $url = "freight_order_details.php?orderD=$ID";
                        $cost = $freight_driver_commission / 100 * $Total_price;
                    }
                    $cost1 = number_format((float)$cost, 2, '.', '');


                    if ($online == "offline") {
                        echo "
		  <ul class='list-group'>
                 <li class='list-group-item' ><a  style=' color:#ff8c00;' href='#'> Order From $name <button class='btn btn-info btn-sm pull-right'>new</button></a> <br> $$cost1 </li>

				</ul>
		 ";
                    } else {

                        echo "
	       <tr>
		   <ul class='list-group'>
                 <li class='list-group-item' ><a  style=' color:#ff8c00;' href='freight_order_details.php?orderD=$ID'> Order From $name <button class='btn btn-info btn-sm pull-right'>new</button></a> <br> $$cost1 </li>

				</ul>
            </tr>
			";
                    }
                }
            } else {
                echo "<div style='color:red'><h2>Your account has expired please recharge!<h2></div>";
            }
        }
    }
}

function getBookingsToTaxiDrivers()
{

    $user = $_SESSION['MM_Username'];
    global $Connect;

    $get_driver = "SELECT * FROM driver WHERE username='$user' ";

    $run_driver = mysqli_query($Connect, $get_driver);

    while ($row_type = mysqli_fetch_array($run_driver)) {
        $ID = $row_type['driverID'];
        $company_name = $row_type['company_name'];
        $online = $row_type['online'];
        $mode_of_transport = $row_type['mode_of_transport'];
        $type_of_service = $row_type['type_of_service'];
        $username = $row_type['username'];

        $get = "SELECT * FROM `users` WHERE Name='$company_name'";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['ID'];
            $Name = $row_type['Name'];
            $Email = $row_type['email'];
            $date = $row_type['date'];
            $days = $row_type['days'];

            $expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . "+ $days day"));

            if (date("Y-m-d") < $expire) {

                $get = "SELECT * FROM bookings WHERE status ='new' AND delivery_type='$type_of_service' AND company_name='$company_name' ORDER BY Date DESC LIMIT 8 ";

                $run = mysqli_query($Connect, $get);

                while ($row_type = mysqli_fetch_array($run)) {
                    $ID = $row_type['order_id'];
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
                    $service = $row_type['vehicle_type'];


                    $cost = 80 / 100 * $Total_price;
                    $cost1 = number_format((float)$cost, 2, '.', '');

                    if ($online == "offline") {
                        echo "
		  <ul class='list-group'>
                 <li class='list-group-item' ><a  style=' color:#ff8c00;' href='#'> Order From $name <button class='btn btn-info btn-sm pull-right'>new</button></a> <br> $$cost1 </li>

				</ul>
		 ";
                    } else {

                        echo "
	       <tr>
		   <ul class='list-group'>
                 <li class='list-group-item' ><a  style=' color:#ff8c00;' href='taxi.order_details.php?orderD=$ID'> Order From $name <button class='btn btn-info btn-sm pull-right'>new</button></a> <br> $$cost1 </li>

				</ul>
            </tr>
			";
                    }
                }
            } else {
                echo "<div style='color:red'><h2>Your account has expired please recharge!<h2></div>";
            }
        }
    }
}


function getAcceptedBookingsToDriver()
{
    $user = $_SESSION['MM_Username'];
    global $Connect;
    $service = "";
    $cost = "";
    $get = "SELECT * FROM `bookings` where username ='$user' && status ='accepted' ORDER BY Date DESC LIMIT 8";
    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['order_id'];
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
        $delivery_type = $row_type['delivery_type'];
        $time = $row_type['pick_up_time'];
        $drop_time = $row_type['drop_time'];
        $service = $row_type['vehicle_type'];

        $get_commission = "SELECT * FROM `prizelist` ";

        $run_commission = mysqli_query($Connect, $get_commission);

        while ($row_type = mysqli_fetch_array($run_commission)) {

            $parcel_driver_commission = $row_type['parcel_driver_commission'];
            $freight_driver_commission = $row_type['freight_driver_commission'];
            $furniture_driver_commission = $row_type['furniture_driver_commission'];
        }

        if ($service == "Parcel Delivery") {
            $url = "order_datails.php?orderD=$ID";
            $cost = $parcel_driver_commission / 100 * $Total_price;
        } else if ($service == "Freight Delivery") {
            $url = "freight_order_details.php?orderD=$ID";
            $cost = $freight_driver_commission / 100 * $Total_price;
        } else if ($service == "Test") {
            $url = "freight_order_details.php?orderD=$ID";
            $cost = $freight_driver_commission / 100 * $Total_price;
        }
        $cost1 = number_format((float)$cost, 2, '.', '');

        $url = "acceptedOrdersDetails.php?orderD=$ID";

        if ($delivery_type == "Taxi") {
            $url = "taxi.acceptedOrdersDetails.php?orderD=$ID";
        }

        echo "
	       <tr>
		   <ul class='list-group'>
               <li class='list-group-item' ><a  style=' color:#ff8c00;' href='$url'> Order From $name $ID <button class='btn btn-warning btn-sm pull-right'>accepted</button></a> </li>

				</ul>
            </tr>
			";
    }
}

function getAcceptedBookingsToDriver2()
{
    $user = $_SESSION['MM_Username'];
    global $Connect;
    $service = "";
    $get = "SELECT * FROM `bookings` where username = '$user' && status ='accepted' ORDER BY Date DESC LIMIT 8";
    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['order_id'];
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
        $service = $row_type['vehicle_type'];

        $get_commission = "SELECT * FROM `prizelist` ";

        $run_commission = mysqli_query($Connect, $get_commission);

        while ($row_type = mysqli_fetch_array($run_commission)) {

            $parcel_driver_commission = $row_type['parcel_driver_commission'];
            $freight_driver_commission = $row_type['freight_driver_commission'];
            $furniture_driver_commission = $row_type['furniture_driver_commission'];
        }

        if ($service == "Parcel Delivery") {
            $url = "order_datails.php?orderD=$ID";
            $cost = $parcel_driver_commission / 100 * $Total_price;
        } else if ($service == "Freight Delivery") {
            $url = "freight_order_details.php?orderD=$ID";
            $cost = $freight_driver_commission / 100 * $Total_price;
        } else if ($service == "Test") {
            $url = "freight_order_details.php?orderD=$ID";
            $cost = $freight_driver_commission / 100 * $Total_price;
        }
        $cost1 = number_format((float)$cost, 2, '.', '');
        echo "
	       <tr>
		   <ul class='list-group'>
               <li class='list-group-item' ><a  style=' color:#ff8c00;' href='taxi.acceptedOrdersDetails.php?orderD=$ID'> Order From $name <button class='btn btn-warning btn-sm pull-right'>accepted</button></a> $$cost1 </li>

				</ul>
            </tr>
			";
    }
}

function getAfterPickBookingsToDriver()
{
    $user = $_SESSION['MM_Username'];
    global $Connect;
    $service = "";
    $get = "SELECT * FROM `bookings` where  username = '$user' AND status = 'on the way' ORDER BY Date DESC LIMIT 8";
    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['order_id'];
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
        $service = $row_type['vehicle_type'];

        $get_commission = "SELECT * FROM `prizelist` ";

        $run_commission = mysqli_query($Connect, $get_commission);

        while ($row_type = mysqli_fetch_array($run_commission)) {

            $parcel_driver_commission = $row_type['parcel_driver_commission'];
            $freight_driver_commission = $row_type['freight_driver_commission'];
            $furniture_driver_commission = $row_type['furniture_driver_commission'];
        }

        if ($service == "Parcel Delivery") {
            $url = "order_datails.php?orderD=$ID";
            $cost = $parcel_driver_commission / 100 * $Total_price;
        } else if ($service == "Freight Delivery") {
            $url = "freight_order_details.php?orderD=$ID";
            $cost = $freight_driver_commission / 100 * $Total_price;
        } else if ($service == "Test") {
            $url = "freight_order_details.php?orderD=$ID";
            $cost = $freight_driver_commission / 100 * $Total_price;
        }
        $cost1 = number_format((float)$cost, 2, '.', '');
        echo "
	       <tr>
		   <ul class='list-group'>
                <li class='list-group-item'><a class='list-group-item' href='afterPick.php?orderD=$ID'> On Order From $name<i class='fa fa-shopping-cart'></i> </a> Cost: $$cost1  </li>

				</ul>
            </tr>
			";
    }
}


function getCompletedBookingsToDriver()
{
    $user = $_SESSION['MM_Username'];
    global $Connect;
    $service = "";
    $cost = "";
    $get = "SELECT * FROM `bookings` where  username = '$user' AND status = 'deliverd' ";
    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['order_id'];
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
        $service = $row_type['vehicle_type'];

        $get_commission = "SELECT * FROM `prizelist` ";

        $run_commission = mysqli_query($Connect, $get_commission);

        while ($row_type = mysqli_fetch_array($run_commission)) {

            $parcel_driver_commission = $row_type['parcel_driver_commission'];
            $freight_driver_commission = $row_type['freight_driver_commission'];
            $furniture_driver_commission = $row_type['furniture_driver_commission'];
        }

        if ($service == "Parcel Delivery") {
            $url = "order_datails.php?orderD=$ID";
            $cost = $parcel_driver_commission / 100 * $Total_price;
        } else if ($service == "Freight Delivery") {
            $url = "freight_order_details.php?orderD=$ID";
            $cost = $freight_driver_commission / 100 * $Total_price;
        } else if ($service == "Test") {
            $url = "freight_order_details.php?orderD=$ID";
            $cost = $freight_driver_commission / 100 * $Total_price;
        }
        $cost1 = number_format((float)$cost, 2, '.', '');
        echo "
	       <tr>
		   <ul class='list-group'>

				<li class='list-group-item' ><a  style=' color:#ff8c00;' href='#?orderD=$ID'> Order From $name <button class='btn btn-success btn-sm pull-right'>completed</button></a> $$cost1 </li>

				</ul>
            </tr>
			";
    }
}

function getAllarchivedBookingsToDriver()
{
    $user = $_SESSION['MM_Username'];
    global $Connect;
    $service = "";
    $get = "SELECT * FROM `bookings` where  username = '$user'";
    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['order_id'];
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
        $service = $row_type['vehicle_type'];

        $get_commission = "SELECT * FROM `prizelist` ";

        $run_commission = mysqli_query($Connect, $get_commission);

        while ($row_type = mysqli_fetch_array($run_commission)) {

            $parcel_driver_commission = $row_type['parcel_driver_commission'];
            $freight_driver_commission = $row_type['freight_driver_commission'];
            $furniture_driver_commission = $row_type['furniture_driver_commission'];
        }

        if ($service == "Parcel Delivery") {
            $url = "order_datails.php?orderD=$ID";
            $cost = $parcel_driver_commission / 100 * $Total_price;
        } else if ($service == "Freight Delivery") {
            $url = "freight_order_details.php?orderD=$ID";
            $cost = $freight_driver_commission / 100 * $Total_price;
        } else if ($service == "Test") {
            $url = "freight_order_details.php?orderD=$ID";
            $cost = $freight_driver_commission / 100 * $Total_price;
        }
        $cost1 = number_format((float)$cost, 2, '.', '');
        echo "
	       <tr>
		   <ul class='list-group'>
                <li class='list-group-item'><a style=' color:#ff8c00;' href='#?orderD=$ID'> Order From $name<i class='fa fa-shopping-cart'></i> </a> Cost: $$cost1 </li>

				</ul>
            </tr>
			";
    }
}

function getLiveOrderBookingsToDriver()
{
    if (isset($_GET['orderD'])) {

        $MrE = $_GET['orderD'];
        global $Connect;
        $service = "";
        $get = "SELECT * FROM `bookings` order_id = '$MrE' ";
        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['order_id'];
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
            $service = $row_type['vehicle_type'];

            $get_commission = "SELECT * FROM `prizelist` ";

            $run_commission = mysqli_query($Connect, $get_commission);

            while ($row_type = mysqli_fetch_array($run_commission)) {

                $parcel_driver_commission = $row_type['parcel_driver_commission'];
                $freight_driver_commission = $row_type['freight_driver_commission'];
                $furniture_driver_commission = $row_type['furniture_driver_commission'];
            }

            if ($service == "Parcel Delivery") {
                $url = "order_datails.php?orderD=$ID";
                $cost = $parcel_driver_commission / 100 * $Total_price;
            } else if ($service == "Freight Delivery") {
                $url = "freight_order_details.php?orderD=$ID";
                $cost = $freight_driver_commission / 100 * $Total_price;
            } else if ($service == "Test") {
                $url = "freight_order_details.php?orderD=$ID";
                $cost = $freight_driver_commission / 100 * $Total_price;
            }
            $cost1 = number_format((float)$cost, 2, '.', '');

            echo "
	       <tr>
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
            </tr>
			";
        }
    }
}


function getBlog()
{
    global $Connect;

    $get = "SELECT * FROM `blog` ORDER BY Post_date DESC";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $name = $row_type['Name'];
        $Date = $row_type['date'];
        $heading = $row_type['heading'];
        $category = $row_type['category'];
        $msg = $row_type['message'];
        $image = $row_type['image'];

        if (strlen($msg) > 500) {
            $trimstring = substr($msg, 0, 500);
        } else {
            $trimstring = $msg;
        }

        echo "<div class='blog-item well'>
                        <a href='#'><h2> $heading </h2></a>
                        <div class='blog-meta clearfix'>
                            <p class='pull-left'>
                              <i class='icon-user'></i> by <a href='#'>$name</a> | <i class='icon-folder-close'></i> Category <a href='#'> $category</a> | <i class='icon-calendar'></i> $Date
                          </p>
                          <p class='pull-right'><i class='icon-comment pull'></i> <a href='blog-item.html#comments'>3 Comments</a></p>
                      </div>
                      <p><img src='admin/pages/blog_images/$image' style='width:100%;' alt='' /></p>
                      <p> $trimstring... </p>

					  <a class='btn btn-link' href='blog-item.php?blogID=$ID'>Read More <i class='icon-angle-right'></i><i class='icon-angle-right'></i></a>
                  </div>
				  ";
    }
}


function getBlogVids()
{
    global $Connect;

    $get = "SELECT * FROM `Video_blog` ORDER BY post_date DESC limit 4";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $Post_date = $row_type['post_date'];
        $name = $row_type['Title'];
        $Date = $row_type['Date'];
        $desc = $row_type['Description'];
        $image = $row_type['image'];
        $video = $row_type['Video'];

        echo "<div class='span6'>
         <div class='video'>
		 <a href='blog_video.php?watch=$ID'> <img src='admin/pages/blog_videos/cover_image/$image' width='300px'> $name</a> <a href='blog_video.php?watch=$ID' class='play1'>Play Video</a>

		 </div>
                </div>

				  ";
    }
}

function getBlogAllVids()
{
    global $Connect;

    $get = "SELECT * FROM `Video_blog` ORDER BY post_date DESC";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $Post_date = $row_type['post_date'];
        $name = $row_type['Title'];
        $Date = $row_type['Date'];
        $desc = $row_type['Description'];
        $image = $row_type['image'];
        $video = $row_type['Video'];

        echo "<div class='span6'>
         <div class='video'>
		 <a href='blog_video.php?watch=$ID'> <img src='admin/pages/blog_videos/cover_image/$image' width='300px'> $name</a> <a href='blog_video.php?watch=$ID' class='play1'>Play Video</a>

		 </div>
                </div>

				  ";
    }
}


function getBlogPop()
{
    global $Connect;

    $get = "SELECT * FROM `blog` ORDER BY Post_date DESC LIMIT 3";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $Post_date = $row_type['Post_date'];
        $name = $row_type['Name'];
        $Date = $row_type['date'];
        $heading = $row_type['heading'];
        $category = $row_type['category'];
        $msg = $row_type['message'];
        $image = $row_type['image'];

        echo " <div class='widget-blog-item media'>
                    <div class='pull-left'>
                        <div class='date' style=' background-color:#153b50;'>
                            <span class='month'>$Date</span>
                        </div>
                    </div>
                    <div class='media-body'>
                        <a href='blog-item.php?blogID=$ID'><h5>$heading</h5></a>
                    </div>
                </div>
				  ";
    }
}

function getBlog_item()
{
    if (isset($_GET['blogID'])) {

        $MrE = $_GET['blogID'];
        global $Connect;

        $get = "SELECT * FROM `blog` where ID = '$MrE' ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['ID'];
            $name = $row_type['Name'];
            $Date = $row_type['date'];
            $heading = $row_type['heading'];
            $category = $row_type['category'];
            $msg = $row_type['message'];
            $image = $row_type['image'];

            echo "<div class='blog-item well'>
                        <a href='#'><h2> $heading </h2></a>
                        <div class='blog-meta clearfix'>
                            <p class='pull-left'>
                              <i class='icon-user'></i> by <a href='#'>$name</a> | <i class='icon-folder-close'></i> Category <a href='#'> $category</a> | <i class='icon-calendar'></i> $Date
                          </p>
                          <p class='pull-right'><i class='icon-comment pull'></i> <a href='blog-item.html#comments'>3 Comments</a></p>
                      </div>
                      <p><img src='admin/pages/blog_images/$image' width='100%' alt='' /></p>
                      <p> $msg </p>

					  <a class='btn btn-link' href='blog-item.php?blogID=$ID'>Read More <i class='icon-angle-right'></i></a>
                  </div>
				  ";
        }
    }
}

function getBlog_comments()
{
    if (isset($_GET['blogID'])) {

        $MrE1 = $_GET['blogID'];
        global $Connect;

        $get = "SELECT * FROM `blog_comments` where Blog_id = '$MrE1' ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID1 = $row_type['ID'];
            $name1 = $row_type['Name'];
            $Date1 = $row_type['Date'];
            $Email = $row_type['Email'];
            $Blog_id = $row_type['Blog_id'];
            $msg1 = $row_type['message'];

            echo "<div class='comment media'>
                                <div class='pull-left'>
                                    <img class='avatar' src='images/sample/cAvatar2.jpg' alt='' />
                                </div>

                                <div class='media-body'>
                                    <strong>Posted by <a href='#'> $name1</a></strong><br>
                                    <small> $Date1 </small><br>
                                    <p>$msg1</p>
								</div>
                            </div>
							";
        }
    }
}


function getBlogVideo_comments()
{
    if (isset($_GET['watch'])) {

        $MrE1 = $_GET['watch'];

        $vidCom = "video" . $MrE1;
        global $Connect;

        $get = "SELECT * FROM `blog_comments` where Blog_id = '$vidCom' ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID1 = $row_type['ID'];
            $name1 = $row_type['Name'];
            $Date1 = $row_type['Date'];
            $Email = $row_type['Email'];
            $Blog_id = $row_type['Blog_id'];
            $msg1 = $row_type['message'];

            echo "<div class='comment media'>
                                <div class='pull-left'>
                                    <img class='avatar' src='images/sample/cAvatar2.jpg' alt='' />
                                </div>

                                <div class='media-body'>
                                    <strong>Posted by <a href='#'> $name1</a></strong><br>
                                    <small> $Date1 </small><br>
                                    <p>$msg1</p>
								</div>
                            </div>
							";
        }
    }
}

function getChatsFroDr()
{
    $user = $_SESSION['MM_Username'];
    global $Connect;

    $get = "SELECT chat_drivers.*, driver.* FROM chat_drivers, driver where chat_drivers.IDFrom = driver.driverID AND driver.username = '$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $Date = $row_type['Date'];
        $Name = $row_type['name'];
        $msg = $row_type['message'];

        echo " <li class='by-me'>
                        <div class='avatar pull-left'>
                          <img src='img/user.png' alt=''/>
                        </div>

                        <div class='chat-content'>
                          <div class='chat-meta'>$Name <span class='pull-right'>$Date</span></div>
                          $msg
                          <div class='clearfix'></div>
                        </div>
                      </li>
				";
    }
}


function getReplyChatsFroDr()
{
    $user = $_SESSION['MM_Username'];
    global $Connect;

    $get = "SELECT replychat_drivers.*, driver.* FROM replychat_drivers, driver where replychat_drivers.IDFrom = driver.driverID AND driver.username = '$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $Date = $row_type['Date'];
        $Name = $row_type['name'];
        $msg = $row_type['message'];

        echo " <li class='by-other'>
                        <div class='avatar pull-right'>
                          <img src='img/user2.png' alt=''/>
                        </div>

                        <div class='chat-content'>
                          <div class='chat-meta'>$Date<span class='pull-right'>$Name</span></div>
                          $msg
                          <div class='clearfix'></div>
                        </div>
                      </li>
				";
    }
}
function checkCoupon()
{
    global $Connect;
    $userid = $_POST['userid'];
    $coupon = $_POST['coupon'];
    $today = date('Y-m-d');

    $get = "SELECT * FROM user_coupons WHERE user_id = '$userid' AND expiry_date >= '$today' AND user_coupons.used < user_coupons.limit_used AND coupon = '$coupon'";

    $run = mysqli_query($Connect, $get);
    $result = mysqli_fetch_array($run);
    if (empty($result)) {

        $getuc = "SELECT * FROM common_coupon WHERE  expiry_date >= '$today' AND common_coupon.used < common_coupon.limit_used AND coupon = '$coupon'";

        $run1 = mysqli_query($Connect, $getuc);
        $result1 = mysqli_fetch_array($run1);
        return $result1;
    } else {
        return $result;
    }
}

// =========================== Bookings to Client  Portal =====================================

function getClientBookingHistory()
 {
    $user = $_SESSION['MM_Username'];
    global $Connect;

    $get = "SELECT * FROM `bookings` WHERE email ='$user' ";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['order_id'];
        $order_number = $row_type['order_number'];
        $date_booked = $row_type['Date'];
        $email_from = $row_type['email'];
        $address = $row_type['pick_up_address'];
        $drop_address = $row_type['drop_address'];
        $name = $row_type['Name'];;
        $date = $row_type['pick_up_date'];
        $drop_date = $row_type['drop_date'];
        $weight_of_package = $row_type['weight'];
        $package_quantity = $row_type['quantity'];
        $insurance = $row_type['insurance'];
        $value_of_package = $row_type['value'];
        $note = $row_type['drivers_note'];
        $time = $row_type['pick_up_time'];
        $invoice = $row_type['invoice'];

        echo "<tr>
                <td class='min-width'>$order_number</td>
                <td  class='min-width'>$date_booked</td>
                <td  class='min-width'>
                    <b>From:</b> $address 
                        </br>
                    <b>To:</b> $drop_address
                    </td>
                <td  class='min-width'><a href='invoice.php?orderD=$order_number' class='status-btn active-btn'>invoice</a></td>
				<td  class='min-width'>
				<div class='action'>
                      <a class='status-btn danger-btn icon'>cancel</a>
                    </div>
				</td>
            </tr>";
    }
}
