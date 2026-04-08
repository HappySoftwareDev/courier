<?php
// Start the session before any other output
if (!isset($_SESSION)) {
    session_start();
}

// Enable error reporting for debugging (This should be done early in the script)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include('../admin/pages/site_settings.php');

require_once '../config/bootstrap.php';
require_once '../function.php'; 


$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup)
{
    // For security, start by assuming the visitor is NOT authorized.
    $isValid = False;

    // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
    // Therefore, we know that a user is NOT logged in if that Session variable is blank.
    if (!empty($UserName)) {
        // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
        // Parse the strings into arrays.
        $arrUsers = Explode(",", $strUsers);
        $arrGroups = Explode(",", $strGroups);
        if (in_array($UserName, $arrUsers)) {
            $isValid = true;
        }
        // Or, you may restrict access to only certain users based on their username.
        if (in_array($UserGroup, $arrGroups)) {
            $isValid = true;
        }
        if (($strUsers == "") && true) {
            $isValid = true;
        }
    }
    return $isValid;
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
    $MM_qsChar = "?";
    $MM_referrer = $_SERVER['PHP_SELF'];
    if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
        $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
    $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
    header("Location: " . $MM_restrictGoTo);
    exit; // Make sure to call exit after header to prevent further code execution
}
?>


<?php require("../function.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title>Driver - <?php echo $site_name ?></title>
    
    <!-- =======================================================
        Theme Name: NiceAdmin
        Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        Author: BootstrapMade
        Author URL: https://bootstrapmade.com
    ======================================================= -->
    <!--[if lt IE 9]><script src="../assets/flashcanvas.js"></script><![endif]-->
    <style>
        #myBtn {
            display: block;
            position: fixed;
            bottom: 5px;
            left: 10px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 4px;
        }
    </style>

</head>

<body>
    <!-- container section start -->
    <section id="container" class="">


        <?php include 'side-menu.php'; ?>

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <!--overview start-->


                <?php
                if (isset($_POST['onway'])) {
                    $to1 = "bamhara1@gmail.com";
                    $to2 = $_POST['email'];

                    $from = $_POST['driveremail'];
                    $message = "Driver is on the way";
                    $headers = "From: $from\n";
                    mail($to1, '', $message, $headers);
                    mail($to2, '', $message, $headers);
                }

                ?>

                <?php

                $user = $_SESSION['MM_Username'];
                global $DB;

                $get = "SELECT * FROM `bookings` where  username = '$user' AND status = 'on the way' LIMIT 1 ";
                $stmt = $DB->prepare( $get);

                foreach ($results as $1) {
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

                    $get_commission = "SELECT * FROM `prizelist` ";

                    $stmt = $DB->prepare( $get_commission);

                    foreach ($results as $1) {

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


                ?>





                <!-- project team & activity start -->

                <?php $date = date("Y-m-d");
                $time = date("H:m");
                $datetime = $date . "T" . $time;

                $user = $_SESSION['MM_Username'];

                $get = "SELECT * FROM `driver` where username = '$user' LIMIT 1 ";

                $stmt = $DB->prepare( $get);

                foreach ($results as $1) {
                    $driverID = $row_type['driverID'];
                    $username = $row_type['username'];
                    $email = $row_type['email'];
                    $drivername = $row_type['name'];
                }
                ?>





                <div class="row">

                </div>
                <!--/.row-->


                <div class="row">

                </div>

                <div class="panel-group m-bot20" id="accordion">
                    <?php echo $MC; ?>


                    <form action="http://maps.google.com/maps" method="get" target="_blank">
                        <input type="hidden" name="saddr" Value="<?php echo $address; ?>" />
                        <input type="hidden" name="daddr" value="<?php echo $drop_address; ?>" />

                        <button class='btn btn-primary btn-lg btn-block' type="submit"><span class='fa fa-map-marker'></span> Directions</button>
                    </form>
                    <div class="btn-group btn-group-justified">
                        <a class="btn btn-primary" href="tel:<?php echo $phone; ?>" target="_blank">CALL</a>
                        <a class="btn btn-success" href="whatsapp://send?abid=<?php echo $phone; ?>&text=HeyThere!">WhatsApp</a>
                        <a class="btn btn-info" href="sms:<?php echo $phone; ?>?body=Hello!" target="_blank">SMS</a>
                    </div>
                    <br />

                    <a href="signature.php?orderD=<?php echo $ID; ?>"><button class='btn btn-success btn-lg btn-block' name="onWay" type="button"><span class='icon_check_alt2'></span> Complete Order</button></a>
                    <form method="POST" action="cancel.php" name="cancelForm">
                        <input type="hidden" class="form-control" name="status" value="new">
                        <input type="hidden" class="form-control" name="username" value="<?php echo $user; ?>">
                        <input type="hidden" class="form-control" name="status_up_date" value="<?php echo $datetime; ?>">
                        <input type="hidden" class="form-control" name="order_id" value="<?php echo $order_number; ?>">
                        <button class='btn btn-danger btn-lg btn-block' name="cancel" type="submit"><span class='icon_close_alt2'></span> Cancel Order</button>
                        <input type="hidden" name="MM_update" value="cancelForm">
                    </form>
                    <div class='btn-group'>

                        <div class="row">

                        </div>
                    </div><br><br>


                    <!-- project team & activity end -->

            </section>
            <div class="text-right">

            </div>
        </section>
        <!--main content end-->
        
        <!-- Whatsapp button -->
        <a href="https://api.whatsapp.com/send?phone=<?php echo $bus_phone; ?>&text=Hi, I'd like to book a delivery." id="myBtn">
            <img src="../images/wats2.png" width="50px">
        </a>

    </section>
    <!-- container section start -->
    <!-- Whatsapp script -->
    <script>
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("myBtn").style.display = "block";
            } else {
                document.getElementById("myBtn").style.display = "block";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    <?php include 'footer_scripts.php'; ?>

</body>

</html>


