<?php
// Start the session before any other output
if (!isset($_SESSION)) {
    session_start();
}

// Enable error reporting for debugging (This should be done early in the script)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include ('../admin/pages/site_settings.php');


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


<?php

require_once '../config/bootstrap.php';
require_once '../function.php';


if (isset($_POST["MM_update"])) {
    // Check if POST data exists and trim if present, else set default value
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    $order_id = isset($_POST['order_id']) ? trim($_POST['order_id']) : '';


    try {

        $stmt = $DB_con->prepare("SELECT * FROM driver WHERE username=:username");
        $stmt->execute(array(":username" => $username));
        $count = $stmt->rowCount();

        if ($count == 1) {
            $stmt = $DB_con->prepare("UPDATE `bookings` SET status=:status, username=:username WHERE order_number=:order_id");
            $stmt->bindparam(":status", $status);
            $stmt->bindparam(":username", $username);
            $stmt->bindparam(":order_id", $order_id);


            //check if query executes
            if ($stmt->execute()) {
                $to = $_POST['clientEmail'];
                $driverName = $_POST['driverName'];
                $clientName = $_POST['clientName'];
                $from = "orders@" . $web_url;
                $drop_name = $_POST['drop_name'];
                $subject = "Delivery ON THE WAY";

                $htmlContent = '
    <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>' . $site_name . '</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">' . $site_name . '</h1>
        <h3>Delivery Is On The Way</h3>
		<p>
	    Hey ' . $clientName . '. Delivery driver  is ON THE WAY to dropoff your goods for ' . $drop_name . '.
		</p>
		<p>Thank you for using ' . $site_name . '.</p>
		<footer>
		<div style="background-color:#CCC; padding:10px;">

		<p>For inquiries, visit <a href="http://' . $web_url . '">' . $web_url . '</a>. Call/WhatsApp <b>' . $bus_phone . '</b>.</p>
        <p>PLEASE DO NOT REPLY TO THIS EMAIL.</p>
        <h4 style="color:#FF8C00">' . $site_name . '</h4>
		<p></p>
		</div>
		</footer>
		</div>
    </body>
    </html>';

                // Set content-type header for sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // Additional headers
                $headers .= 'From: ' . $site_name . ' <orders@' . $web_url . '>' . "\r\n";

                // Send email
                if (mail($to, $subject, $htmlContent, $headers)) :
                    $successMsg = 'Email has sent successfully.';
                else :
                    $errorMsg = 'Email sending fail.';
                endif;


                // $sms_phone = $_POST['phone'];
                // $uname = "Business";
                // $pwd = "Merchant2017";
                // $id = "b5c57830717b41b6c8b038912a55e641";
                // $sms_msg = "Hey $clientName. Delivery driver $driverName is ON THE WAY to dropoff your goods.";
                // $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

                // $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
                // curl_setopt($ch, CURLOPT_POST, true);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // $result = curl_exec($ch);
                // curl_close($ch);

                // $sms_phone2 = $_POST['drop_phone'];
                // $uname = "Business";
                // $pwd = "Merchant2017";
                // $id2 = "b5c57830717b41b6c8b038912a55e641";
                // $sms_msg2 = "Hello $rec_name. Delivery driver $driverName is ON THE WAY to dropoff goods to you sent by $clientName. Please be ready to collect it.";
                // $data = "&u=" . $uname . "&h=" . $id2 . "&op=pv&to=" . $sms_phone2 . "&msg=" . urlencode($sms_msg2);

                // $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
                // curl_setopt($ch, CURLOPT_POST, true);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // $result = curl_exec($ch);
                // curl_close($ch);
                
                // Get the user token using PDO
                $get_user = "SELECT * FROM `users` WHERE email = :email_to"; // Use a parameterized query
                $stmt = $Connect->prepare($get_user); // Prepare the statement
                $stmt->bindParam(':email_to', $to, PDO::PARAM_STR); // Bind the email parameter to avoid SQL injection
                $stmt->execute(); // Execute the query
                
                // Fetch the result and get the push_token
                $row_type = $stmt->fetch(PDO::FETCH_ASSOC); 
                if ($row_type) {
                    $push_token = $row_type['push_token'];
                }
                
                $title = $site_name;
                $msg = "Hello $rec_name. Delivery driver $driverName is ON THE WAY to drop off goods.";
                $page = "onLiveJob.php";
                echo "<script>window.open('../../web_push/send_notification.php?title=$title&message=$msg&token=$push_token&page=$page','_self')</script>";

            } else {

                echo "Query could not execute";
            }
        } //end of integrity check

        else {
            echo "1"; // user email is taken
        }
    } // end of try block

    catch (PDOException $e) {
        echo $e->getMessage();
    }
} //end post
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
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
                            <li><i class="fa fa-laptop"></i>Live Order</li>
                        </ol>
                    </div>
                </div>

                <div class="row">

                </div>
                <!--/.row-->


                <div class="row">

                </div>


                <!-- Today status end -->



                <div class="row">


                </div>



                <!-- statics end -->
                <?php

                $user = $_SESSION['MM_Username'];
                global $DB;

                $get = "SELECT * FROM `bookings` where  username = '$user' AND status = 'at pickup' LIMIT 1 ";

                $stmt = $DB->prepare( $get);
                $MC = "";
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

                    $MC = " <ul class='list-group'>
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
                <div class="row">
                    <div class="col-lg-9 col-md-12">
                        <div class="panel panel-default">

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

                            <div class="panel-body">
                                <?php echo $MC; ?>

                                <form method="POST" action="afterPick.php" name="onWayForm">
                                    <input type="hidden" class="form-control" name="status" value="on the way">
                                    <input type="hidden" class="form-control" name="status_up_date" value="<?php echo $datetime; ?>">
                                    <input type="hidden" class="form-control" name="email" value="<?php echo $email; ?>">
                                    <input type="hidden" class="form-control" name="username" value="<?php echo $username; ?>">
                                    <input type="hidden" class="form-control" name="phone" value="<?php echo $phone; ?>">
                                    <input type="hidden" class="form-control" name="drop_phone" value="<?php echo $drop_phone; ?>">
                                    <input type="hidden" class="form-control" name="Drop_name" value="<?php echo $Drop_name; ?>">
                                    <input type="hidden" class="form-control" name="clientEmail" value="<?php echo $email_fro; ?>">
                                    <input type="hidden" class="form-control" name="clientName" value="<?php echo $client_name; ?>">
                                    <input type="hidden" class="form-control" name="drop_name" value="<?php echo $Drop_name; ?>">
                                    <input type="hidden" class="form-control" name="order_id" value="<?php echo $order_number; ?>">
                                    <li class='list-group-item'>
                                        <button class='btn btn-warning btn-lg btn-block' name="onWay" type="submit"><span class='icon_check_alt2'></span> On the Way</button>
                                        <input type="hidden" name="MM_update" value="onWayForm">
                                </form>
                                </li>

                                <form method="POST" action="acceptedOrdersDetails.php" name="acceptForm">
                                    <input type="hidden" class="form-control" name="status" value="deliverd">
                                    <input type="hidden" class="form-control" name="status_up_date" value="<?php echo $datetime; ?>">
                                    <input type="hidden" class="form-control" name="email" value="<?php echo $email; ?>">
                                    <input type="hidden" class="form-control" name="name" value="<?php echo $drivername; ?>">
                                    <input type="hidden" class="form-control" name="clientEmail" value="<?php echo $email_fro; ?>">
                                    <input type="hidden" class="form-control" name="order_id" value="<?php echo $ID; ?>">
                                </form>
                                <li class='list-group-item'>
                                    <form action="http://maps.google.com/maps" method="get" target="_blank">
                                        <input type="hidden" name="saddr" Value="<?php echo $address; ?>" />
                                        <input type="hidden" name="daddr" value="<?php echo $drop_address; ?>" />

                                        <button class='btn btn-primary btn-lg btn-block' type="submit"><span class='fa fa-map-marker'></span> Directions</button>
                                    </form>
                                </li>

                            </div>

                        </div>

                    </div>
                    <!--/col-->
                </div>


                </div><br><br>


                <!-- project team & activity end -->

            </section>
            <div class="text-right">

            </div>
        </section>
        <!--main content end-->
        <!-- Whatsapp button -->
        <a href="https://api.whatsapp.com/send?phone=+263779495409&text=Hi, I'd like to book a delivery." id="myBtn"><img src="../images/wats2.png" width="50px"></a>
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


