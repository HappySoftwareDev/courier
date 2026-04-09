<?php

// ============================================================================
// GUARD: Prevent redeclaration of functions  
// Check FIRST - this must execute before any output
// ============================================================================

if (defined('FUNCTION_PHP_LOADED') || function_exists('getClients')) {
    // Functions already loaded - return immediately
    return;
}

// Mark as loaded
define('FUNCTION_PHP_LOADED', true);

/**
 * Legacy Functions Library - MIGRATED TO NEW SYSTEM
 * 
 * All functions now use the new PDO database system.
 * Centralized bootstrap ensures consistent database access.
 */

// Note: Bootstrap is loaded before this file by config/bootstrap.php
// Do NOT require bootstrap here to avoid circular dependency
// The $DB variable is made available globally by bootstrap.php

// Note: All functions below have been updated to use $DB (PDO) instead of $Connect (MySQLi)
// The old $Connect variable is no longer available - all code must use the new system

function getClients()
{
    global $DB;

    $get = "SELECT * FROM `clients`";
    $stmt = $DB->prepare($get);
    $stmt->execute();
    $results = $stmt->fetchAll(); // MySQLi wrapper - no fetch mode needed

    foreach ($results as $row_type) {
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
    global $DB;

    $get = "SELECT * FROM `users`";
    $stmt = $DB->prepare($get);
    $stmt->execute();
    $results = $stmt->fetchAll(); // MySQLi wrapper - no fetch mode needed

    foreach ($results as $row_type) {
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
    global $DB;

    $get = "SELECT * FROM `driver`";
    $stmt = $DB->prepare($get);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row_type) {
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
    global $DB;

    $get = "SELECT * FROM `driver`";
    $stmt = $DB->prepare($get);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row_type) {
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
    if (isset($_SESSION['user_email'])) {
        $user = $_SESSION['user_email'];
        global $DB;

        $get = "SELECT * FROM `driver` where username = ?";
        $stmt = $DB->prepare($get);
        $stmt->execute([$user]);
        $drivers = $stmt->fetchAll();

        foreach ($drivers as $row_type) {
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
    $user = $_SESSION['user_email'] ?? null;
    if (!$user) return;
    
    global $DB;

    $get = "SELECT * FROM `driver` where username = ? LIMIT 1";
    $stmt = $DB->prepare($get);
    $stmt->execute([$user]);
    $results = $stmt->fetchAll();

    foreach ($results as $row_type) {
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
    $user = $_SESSION['user_email'] ?? null;
    if (!$user) return;
    
    global $DB;

    $get = "SELECT * FROM `driver` where username = ? LIMIT 1";
    $stmt = $DB->prepare($get);
    $stmt->execute([$user]);
    $results = $stmt->fetchAll();

    foreach ($results as $row_type) {
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
    global $DB;

    $get = "SELECT * FROM `bookings`";
    $stmt = $DB->prepare($get);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row_type) {
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
    global $DB;

    $get = "SELECT * FROM `bookings`";
    $stmt = $DB->prepare($get);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row_type) {
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
    global $DB;

    $user = $_SESSION['user_email'];

    $get_driver = "SELECT * FROM driver WHERE username = ?";
    $stmt = $DB->prepare($get_driver);
    $stmt->execute([$user]);
    $drivers = $stmt->fetchAll();

    foreach ($drivers as $row_type) {
        $ID = $row_type['driverID'];
        $company_name = $row_type['company_name'];
        $online = $row_type['online'];
        $mode_of_transport = $row_type['mode_of_transport'];
        $username = $row_type['username'];

        $get = "SELECT * FROM `users` WHERE Name = ?";
        $stmt = $DB->prepare($get);
        $stmt->execute([$company_name]);
        $users = $stmt->fetchAll();

        foreach ($users as $row_type) {
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

    $user = $_SESSION['user_email'];
    global $DB;

    $get_driver = "SELECT * FROM driver WHERE username = ?";
    $stmt = $DB->prepare($get_driver);
    $stmt->execute([$user]);
    $drivers = $stmt->fetchAll();

    foreach ($drivers as $row_type) {
        $ID = $row_type['driverID'];
        $company_name = $row_type['company_name'];
        $online = $row_type['online'];
        $mode_of_transport = $row_type['mode_of_transport'];
        $type_of_service = $row_type['type_of_service'];
        $username = $row_type['username'];


        $get = "SELECT * FROM bookings WHERE status = 'new' AND vehicle_type = ? ORDER BY Date DESC LIMIT 8";
        $stmt = $DB->prepare($get);
        $stmt->execute([$type_of_service]);
        $bookings = $stmt->fetchAll();

        foreach ($bookings as $row_type) {
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

            $get_commission = "SELECT * FROM `prizelist`";
            $stmt = $DB->prepare($get_commission);
            $stmt->execute();
            $commissions = $stmt->fetchAll();

            foreach ($commissions as $row_type) {

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

    $user = $_SESSION['user_email'];
    global $DB;

    $get_driver = "SELECT * FROM driver WHERE username = ?";
    $stmt = $DB->prepare($get_driver);
    $stmt->execute([$user]);
    $drivers = $stmt->fetchAll();

    foreach ($drivers as $row_type) {
        $ID = $row_type['driverID'];
        $company_name = $row_type['company_name'];
        $online = $row_type['online'];
        $mode_of_transport = $row_type['mode_of_transport'];
        $type_of_service = $row_type['type_of_service'];
        $username = $row_type['username'];

        $get = "SELECT * FROM `users` WHERE Name = ?";
        $stmt = $DB->prepare($get);
        $stmt->execute([$company_name]);
        $users = $stmt->fetchAll();

        foreach ($users as $row_type) {
            $ID = $row_type['ID'];
            $Name = $row_type['Name'];
            $Email = $row_type['email'];
            $date = $row_type['date'];
            $days = $row_type['days'];

            $expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . "+ $days day"));

            if (date("Y-m-d") < $expire) {

                $get = "SELECT * FROM bookings WHERE status = 'new' AND vehicle_type = ? AND company_name = ? ORDER BY Date DESC LIMIT 8";
                $stmt = $DB->prepare($get);
                $stmt->execute([$type_of_service, $company_name]);
                $bookings = $stmt->fetchAll();

                foreach ($bookings as $row_type) {
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


                    $get_commission = "SELECT * FROM `prizelist`";
                    $stmt = $DB->prepare($get_commission);
                    $stmt->execute();
                    $commissions = $stmt->fetchAll();

                    foreach ($commissions as $row_type) {

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

    $user = $_SESSION['user_email'];
    global $DB;

    $get_driver = "SELECT * FROM driver WHERE username = ?";
    $stmt = $DB->prepare($get_driver);
    $stmt->execute([$user]);
    $drivers = $stmt->fetchAll();

    foreach ($drivers as $row_type) {
        $ID = $row_type['driverID'];
        $company_name = $row_type['company_name'];
        $online = $row_type['online'];
        $mode_of_transport = $row_type['mode_of_transport'];
        $type_of_service = $row_type['type_of_service'];
        $username = $row_type['username'];

        $get = "SELECT * FROM `users` WHERE Name = ?";
        $stmt = $DB->prepare($get);
        $stmt->execute([$company_name]);
        $users = $stmt->fetchAll();

        foreach ($users as $row_type) {
            $ID = $row_type['ID'];
            $Name = $row_type['Name'];
            $Email = $row_type['email'];
            $date = $row_type['date'];
            $days = $row_type['days'];

            $expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . "+ $days day"));

            if (date("Y-m-d") < $expire) {

                $get = "SELECT * FROM bookings WHERE status = 'new' AND delivery_type = ? AND company_name = ? ORDER BY Date DESC LIMIT 8";
                $stmt = $DB->prepare($get);
                $stmt->execute([$type_of_service, $company_name]);
                $bookings = $stmt->fetchAll();

                foreach ($bookings as $row_type) {
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
    $user = $_SESSION['user_email'];
    global $DB;
    $service = "";
    $cost = "";
    $get = "SELECT * FROM `bookings` where username = ? AND status = 'accepted' ORDER BY Date DESC LIMIT 8";
    $stmt = $DB->prepare($get);
    $stmt->execute([$user]);
    $bookings = $stmt->fetchAll();

    foreach ($bookings as $row_type) {
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

        $get_commission = "SELECT * FROM `prizelist`";
        $stmt = $DB->prepare($get_commission);
        $stmt->execute();
        $commissions = $stmt->fetchAll();

        foreach ($commissions as $row_type) {

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
    $user = $_SESSION['user_email'];
    global $DB;
    $service = "";
    $get = "SELECT * FROM `bookings` where username = ? AND status = 'accepted' ORDER BY Date DESC LIMIT 8";
    $stmt = $DB->prepare($get);
    $stmt->execute([$user]);
    $bookings = $stmt->fetchAll();

    foreach ($bookings as $row_type) {
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

        $get_commission = "SELECT * FROM `prizelist`";
        $stmt = $DB->prepare($get_commission);
        $stmt->execute();
        $commissions = $stmt->fetchAll();

        foreach ($commissions as $row_type) {

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
    $user = $_SESSION['user_email'];
    global $DB;
    $service = "";
    $get = "SELECT * FROM `bookings` where username = ? AND status = 'on the way' ORDER BY Date DESC LIMIT 8";
    $stmt = $DB->prepare($get);
    $stmt->execute([$user]);
    $bookings = $stmt->fetchAll();

    foreach ($bookings as $row_type) {
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

        $get_commission = "SELECT * FROM `prizelist`";
        $stmt = $DB->prepare($get_commission);
        $stmt->execute();
        $commissions = $stmt->fetchAll();

        foreach ($commissions as $row_type) {

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
    $user = $_SESSION['user_email'];
    global $DB;
    $service = "";
    $cost = "";
    $get = "SELECT * FROM `bookings` where username = ? AND status = 'deliverd'";
    $stmt = $DB->prepare($get);
    $stmt->execute([$user]);
    $bookings = $stmt->fetchAll();

    foreach ($bookings as $row_type) {
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

        $get_commission = "SELECT * FROM `prizelist`";
        $stmt = $DB->prepare($get_commission);
        $stmt->execute();
        $commissions = $stmt->fetchAll();

        foreach ($commissions as $row_type) {

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
    $user = $_SESSION['user_email'];
    global $DB;
    $service = "";
    $get = "SELECT * FROM `bookings` where username = ?";
    $stmt = $DB->prepare($get);
    $stmt->execute([$user]);
    $bookings = $stmt->fetchAll();

    foreach ($bookings as $row_type) {
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

        $get_commission = "SELECT * FROM `prizelist`";
        $stmt = $DB->prepare($get_commission);
        $stmt->execute();
        $commissions = $stmt->fetchAll();

        foreach ($commissions as $row_type) {

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
        global $DB;
        $service = "";
        $get = "SELECT * FROM `bookings` WHERE order_id = ?";
        $stmt = $DB->prepare($get);
        $stmt->execute([$MrE]);
        $bookings = $stmt->fetchAll();

        foreach ($bookings as $row_type) {
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

            $get_commission = "SELECT * FROM `prizelist`";
            $stmt = $DB->prepare($get_commission);
            $stmt->execute();
            $commissions = $stmt->fetchAll();

            foreach ($commissions as $row_type) {

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
    global $DB;

    $get = "SELECT * FROM `blog` ORDER BY Post_date DESC";
    $stmt = $DB->prepare($get);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row_type) {
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


function getCountTotalSales()
{
    global $DB;
    
    try {
        $get = "SELECT COUNT(*) as total, SUM(Total_price) as sum FROM `bookings` WHERE status = 'completed'";
        $stmt = $DB->prepare($get);
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result && isset($result['total'])) {
            echo htmlspecialchars($result['sum'] ?? 0);
        } else {
            echo "0";
        }
    } catch (Exception $e) {
        echo "0";
    }
}

function getCountTotalBookings()
{
    global $DB;
    
    try {
        $get = "SELECT COUNT(*) as total FROM `bookings`";
        $stmt = $DB->prepare($get);
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result && isset($result['total'])) {
            return intval($result['total']);
        }
        return 0;
    } catch (Exception $e) {
        return 0;
    }
}

// Count all sellers/business partners
if (!function_exists('getCountAllSellers')) {
    function getCountAllSellers() {
        global $DB;
        try {
            $query = "SELECT COUNT(*) as count FROM `businesspartners`";
            $stmt = $DB->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch();
            
            if ($result && isset($result['count'])) {
                return intval($result['count']);
            }
            return 0;
        } catch (Exception $e) {
            error_log('getCountAllSellers error: ' . $e->getMessage());
            return 0;
        }
    }
}

// Count all drivers
if (!function_exists('getCountAllDrivers')) {
    function getCountAllDrivers() {
        global $DB;
        try {
            $query = "SELECT COUNT(*) as count FROM `users` WHERE user_role = 'driver'";
            $stmt = $DB->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch();
            
            if ($result && isset($result['count'])) {
                return intval($result['count']);
            }
            return 0;
        } catch (Exception $e) {
            error_log('getCountAllDrivers error: ' . $e->getMessage());
            return 0;
        }
    }
}

// Count all orders
if (!function_exists('getCountAllOrders')) {
    function getCountAllOrders() {
        global $DB;
        try {
            $query = "SELECT COUNT(*) as count FROM `bookings`";
            $stmt = $DB->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch();
            
            if ($result && isset($result['count'])) {
                return intval($result['count']);
            }
            return 0;
        } catch (Exception $e) {
            error_log('getCountAllOrders error: ' . $e->getMessage());
            return 0;
        }
    }
}

// Count new orders (not assigned to driver)
if (!function_exists('getCountNewOrders')) {
    function getCountNewOrders() {
        global $DB;
        try {
            $query = "SELECT COUNT(*) as count FROM `bookings` WHERE assign_driver IS NULL OR assign_driver = ''";
            $stmt = $DB->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch();
            
            if ($result && isset($result['count'])) {
                return intval($result['count']);
            }
            return 0;
        } catch (Exception $e) {
            error_log('getCountNewOrders error: ' . $e->getMessage());
            return 0;
        }
    }
}

// Count cancelled orders
if (!function_exists('getCountCancelledOrders')) {
    function getCountCancelledOrders() {
        global $DB;
        try {
            $query = "SELECT COUNT(*) as count FROM `bookings` WHERE status = 'cancelled'";
            $stmt = $DB->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch();
            
            if ($result && isset($result['count'])) {
                return intval($result['count']);
            }
            return 0;
        } catch (Exception $e) {
            error_log('getCountCancelledOrders error: ' . $e->getMessage());
            return 0;
        }
    }
}
{
    global $DB;

    $get = "SELECT * FROM `Video_blog` ORDER BY post_date DESC limit 4";
    $stmt = $DB->prepare($get);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row_type) {
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
    global $DB;

    $get = "SELECT * FROM `Video_blog` ORDER BY post_date DESC";
    $stmt = $DB->prepare($get);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row_type) {
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
    global $DB;

    $get = "SELECT * FROM `blog` ORDER BY Post_date DESC LIMIT 3";
    $stmt = $DB->prepare($get);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row_type) {
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
        global $DB;

        $get = "SELECT * FROM `blog` where ID = ?";
        $stmt = $DB->prepare($get);
        $stmt->execute([$MrE]);
        $results = $stmt->fetchAll();

        foreach ($results as $row_type) {
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
        global $DB;

        $get = "SELECT * FROM `blog_comments` where Blog_id = ?";
        $stmt = $DB->prepare($get);
        $stmt->execute([$MrE1]);
        $results = $stmt->fetchAll();

        foreach ($results as $row_type) {
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
        global $DB;

        $get = "SELECT * FROM `blog_comments` where Blog_id = ?";
        $stmt = $DB->prepare($get);
        $stmt->execute([$vidCom]);
        $results = $stmt->fetchAll();

        foreach ($results as $row_type) {
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
    $user = $_SESSION['user_email'];
    global $DB;

    $get = "SELECT chat_drivers.*, driver.* FROM chat_drivers, driver where chat_drivers.IDFrom = driver.driverID AND driver.username = ?";
    $stmt = $DB->prepare($get);
    $stmt->execute([$user]);
    $results = $stmt->fetchAll();

    foreach ($results as $row_type) {
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
    $user = $_SESSION['user_email'];
    global $DB;

    $get = "SELECT replychat_drivers.*, driver.* FROM replychat_drivers, driver where replychat_drivers.IDFrom = driver.driverID AND driver.username = ?";
    $stmt = $DB->prepare($get);
    $stmt->execute([$user]);
    $results = $stmt->fetchAll();

    foreach ($results as $row_type) {
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
    global $DB;
    $userid = $_POST['userid'];
    $coupon = $_POST['coupon'];
    $today = date('Y-m-d');

    $get = "SELECT * FROM user_coupons WHERE user_id = ? AND expiry_date >= ? AND user_coupons.used < user_coupons.limit_used AND coupon = ?";
    $stmt = $DB->prepare($get);
    $stmt->execute([$userid, $today, $coupon]);
    $results = $stmt->fetchAll();
    $result = !empty($results) ? $results[0] : null;
    
    if (empty($result)) {

        $getuc = "SELECT * FROM common_coupon WHERE expiry_date >= ? AND common_coupon.used < common_coupon.limit_used AND coupon = ?";
        $stmt = $DB->prepare($getuc);
        $stmt->execute([$today, $coupon]);
        $results = $stmt->fetchAll();
        $result1 = !empty($results) ? $results[0] : null;
        return $result1;
    } else {
        return $result;
    }
}

// =========================== Bookings to Client  Portal =====================================

function getClientBookingHistory()
 {
    $user = isset($_SESSION['CC_Username']) ? $_SESSION['CC_Username'] : '';
    global $DB;

    if (empty($user)) {
        return; // No user logged in
    }

    // Try to find booking using available columns
    $get = "SELECT * FROM `bookings` WHERE email = ? LIMIT 1000";
    try {
        $stmt = $DB->prepare($get);
        $stmt->execute([$user]);
        $results = $stmt->fetchAll();
    } catch (Exception $e) {
        // Fallback: Try just one column
        $get = "SELECT * FROM `bookings` LIMIT 1000";
        $stmt = $DB->prepare($get);
        $stmt->execute();
        $results = $stmt->fetchAll();
    }

    foreach ($results as $row_type) {
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


