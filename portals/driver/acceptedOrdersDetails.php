<?php
require_once '../../config/bootstrap.php';
require_once '../../function.php';
require_once 'signin-security.php';

error_reporting(0);

// Get site name
$site_name = defined('SITE_NAME') ? SITE_NAME : 'WG ROOS Courier';
?>

<?php

require_once '../../config/bootstrap.php';

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
                $driverName = $_POST['username'];
                $clientName = $_POST['clientName'];
                $from = "orders@" . $web_url;
                $sub = "Driver At Pickup";
                $drop_name = $_POST['drop_name'];
                $subject = "Driver AT PICKUP";

                $htmlContent = '
            <html>
            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <title>' . $site_name . '</title>
            </head>
            <body>
            <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                <h1 style="color:#FF8C00">' . $site_name . '</h1>
                <h3>Driver At Pickup</h3>
        		<p>
        	    Hey ' . $clientName . '. Delivery driver  is AT PICKUP for your delivery to ' . $drop_name . '. You will receive a notification when your goods are on the way to drop off.
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
                // $sms_msg = "Hey $clientName. Delivery driver $driverName is AT PICKUP location. An email/sms notification will be sent when your delivery is on the way.";
                // $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

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
                $msg = "Hey $clientName. Delivery driver $driverName is AT PICKUP location.";
                $page = "afterPick.php";
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
    <title>Order Details | <?php echo $site_name ?></title>
</head>
<body>
    <div class="page-wrapper">
        <!-- Header -->
        <?php include 'header.php'; ?>
        
        <div class="page-body">
            <!-- Sidebar -->
            <?php include 'side-menu.php'; ?>
            
            <!-- Main Content -->
            <div class="page-content">
                <div class="container-xl">
                    <!-- Page header -->
                    <div class="page-header d-print-none">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="page-title">Order Details</h2>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="page-body">
                    <div class="container-xl">

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

                if (isset($_GET['orderD'])) {

                    $MrE = $_GET['orderD'];

                    $get = "SELECT * FROM `bookings` where order_id= '$MrE' ";

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
                                $d_username = $row_type['username'];
                                $email = $row_type['email'];
                                $drivername = $row_type['name'];
                            }
                            ?>

                            <div class="panel-body">
                                <?php echo $MC; ?>

                                <form method="POST" action="acceptedOrdersDetails.php" name="atPickForm">
                                    <input type="hidden" class="form-control" name="status" value="at pickup">
                                    <input type="hidden" class="form-control" name="status_up_date" value="<?php echo $datetime; ?>">
                                    <input type="hidden" class="form-control" name="email" value="<?php echo $email; ?>">
                                    <input type="hidden" class="form-control" name="username" value="<?php echo $d_username; ?>">
                                    <input type="hidden" class="form-control" name="phone" value="<?php echo $phone; ?>">
                                    <input type="hidden" class="form-control" name="clientEmail" value="<?php echo $email_fro; ?>">
                                    <input type="hidden" class="form-control" name="clientName" value="<?php echo $client_name; ?>">
                                    <input type="hidden" class="form-control" name="drop_name" value="<?php echo $Drop_name; ?>">
                                    <input type="hidden" class="form-control" name="order_id" value="<?php echo $order_number; ?>">
                                    <li class='list-group-item'>
                                        <button class='btn btn-success btn-lg btn-block' name="atPick" type="submit"><span class='fa fa-car'></span> At Pickup</button>
                                        <input type="hidden" name="MM_update" value="atPickForm">
                                </form>
                                </li>

                                <form method="POST" action="cancel.php" name="cancelForm">
                                    <input type="hidden" class="form-control" name="status" value="new">
                                    <input type="hidden" class="form-control" name="status_up_date" value="<?php echo $datetime; ?>">
                                    <input type="hidden" class="form-control" name="order_id" value="<?php echo $order_number; ?>">
                                    <li class='list-group-item'>
                                        <button class='btn btn-danger btn-lg btn-block' name="cancel" type="submit"><span class='icon_close_alt2'></span> Cancel Order</button>
                                        <input type="hidden" name="cancel" value="cancelForm">
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
    </section>
    <!-- container section start -->

   <?php include 'footer_scripts.php'; ?>

</body>

</html>


