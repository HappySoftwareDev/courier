<?php
if (!isset($_SESSION)) session_start();
require("function.php");
error_reporting(0);
?>
<?php

$get = "SELECT * FROM `bookings` ORDER BY Date DESC Limit 1";

$run = mysqli_query($Connect, $get);

while ($row_type = mysqli_fetch_array($run)) {
    $ID = $row_type['order_id'];
    $order_number = $row_type['order_number'];
    $Date = $row_type['Date'];
}
if (!empty($_POST['coupon'])) {
    $coupon = $_POST['coupon'];
    $uid = $_SESSION['Userid'];
    $today = date('Y-m-d');

    $getc = "SELECT * FROM user_coupons WHERE user_id = '$uid' AND expiry_date >= '$today' AND user_coupons.used < user_coupons.limit_used AND coupon = '$coupon'";

    $runc = mysqli_query($Connect, $getc);
    $row_c = mysqli_fetch_array($runc);
    if (empty($row_c)) {

        $getuc = "SELECT * FROM common_coupon WHERE expiry_date >= '$today' AND common_coupon.used < common_coupon.limit_used AND coupon = '$coupon' ";
        $runuc = mysqli_query($Connect, $getuc);
        $row_uc = mysqli_fetch_array($runuc);
        $ccid = $row_uc['id'];
        $used = $row_uc['used'];
        $used = $used + 1;

        $updatecc = "UPDATE common_coupon SET used = '$used' WHERE id = '$ccid'";

        $ccquery = mysqli_query($Connect, $updatecc);
    } else {

        $ucid = $row_c['user_coupon_id'];
        $used = $row_c['used'];
        $used = $used + 1;

        $updateuc = "UPDATE user_coupons SET used = '$used' WHERE user_coupon_id = '$ucid'";

        $ucquery = mysqli_query($Connect, $updateuc);
    }
}
?>
<?php
$smsData = json_decode(file_get_contents("admin/pages/keys.json"));
$smsID = !empty($smsData->smsId) ? $smsData->smsId : "";
$smsUsername = !empty($smsData->smsUsername) ? $smsData->smsUsername : "";
$smsPwd = !empty($smsData->smsPwd) ? $smsData->smsPwd : "";
$twiliosmsID = !empty($aData->twiliosmsID) ? $aData->twiliosmsID : "";
$twiliosmsUsername = !empty($aData->twiliosmsUsername) ? $aData->twiliosmsUsername : "";
$twilioPhoneNumber = !empty($aData->twilioPhoneNumber) ? $aData->twilioPhoneNumber : "";
?>
<!DOCTYPE html>
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Services | Merchant Couriers</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/sl-slide.css">

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>

<body>

    <!--Header-->
    <header class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a id="logo" class="pull-left" href="index.php"></a>
                <div class="nav-collapse collapse pull-right">
                    <ul class="nav">

                        <li class="active"><a href="index.php">Home</a></li>



                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Book Delivery <i class="icon-angle-down"></i></a>
                            <ul class="dropdown-menu">


                                <li><a href="book/parcel_delivery.php">Parcel Delivery</a></li>
                                <li><a href="book/freight.booking.php">Send Freight</a></li>
                                <li><a href="book/furniture_go.php">Move Furniture</a></li>
                                <li><a href="freight.reg.php">New Customer? Register.</a></li>
                                <li class="divider"></li>
                                <li><a href="privacy.php">Privacy Policy</a></li>
                                <li><a href="terms.php">Terms of Use</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign-UP <i class="icon-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="driver_registration.php">Driver Sign-Up</a></li>
                                <li><a href="freight.reg.php">Customer Sign-Up</a></li>
                                <li class="divider"></li>
                                <li><a href="privacy.php">Privacy Policy</a></li>
                                <li><a href="terms.php">Terms of Use</a></li>
                            </ul>
                        </li>
                        <li class="login"><a href="driver/index.php"><i class="icon-taxi">Driver Login</i></a></li>
                        <li><a href="invite-email.php"><i class="icon-share"></i> Share</a></li>


                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </header>
    <!-- /header -->

    <section class="title">
        <div class="container">
            <div class="row-fluid">
                <div class="span6">
                    <h1>Booking</h1>
                </div>
                <div class="span6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                        <li class="active">Booking</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- / .title -->


    <section Style="background-color:#193b50" id="services">
        <div class="container">


            <?php

            // echo "<pre>" . print_r($_SESSION['payment'], true) . "</pre>";
            // $adata = json_decode($_SESSION['payment']);
            // echo "<pre>" . print_r($adata, true) . "</pre>";
            // exit;
            // unset($_SESSION['POST']);
            if ($_POST) {
                $aPost = $_POST;
            } else {
                $aPost = unserialize($_SESSION['POST']);
                if (isset($aPost['paymentOpt'])) {
                    unset($aPost['paymentOpt']);
                }
                //   echo "<pre>" . print_r($aPost, true) . "</pre>";
            }
            // echo "<pre>" . print_r($aPost, true) . "</pre>";
            if (isset($aPost['MM_insert'])) {
                if (isset($aPost['paymentOpt']) && $aPost['paymentOpt'] != "cash") {
                    // if (!isset($_SESSION)) session_start();
                    $_SESSION['POST'] = serialize($aPost); #Copy _POST to _SESSION
                    // $aPost = unserialize($_SESSION['POST']); #Copy it back.
                    // var_dump($aPost);
            ?>
                    <h1>Thank you for Choosing Us. <br />
                        your stuff will be on its way upon successful payment!</h1> <br />
                    <h2>Please proceed with payment option below</h2><br /><br />

                    <?php
                    switch ($aPost['paymentOpt']) {
                        case "USD":
                    ?>
                            <h5>Pay Online-Visa or Mastercard USD</h5>
                            <img src="stripe.png" style="width: 235px;"><br /><br />
                            <div id="token_response-fail"></div>
                            <div id="token_response-ok">
                                <a href="#">
                                    <button class="btn btn-primary btn-block" style="width: 150px;" onclick="pay(<?php echo $aPost['Total_price']; ?>)">Pay $<?php echo $aPost['Total_price']; ?></button>
                                </a>
                            </div><br />
                        <?php
                            break;
                        case "RTGS":
                        ?>
                            <h5>Pay Online-Local Zimswitch, Ecocash, Onemoney, Telecash. LOCAL CURRENCY</h5>
                            <img src="rtgs.png" style="width: 235px;"><br /><br />
                            <a href="paynow.php?orderD=<?= $aPost['order_number']; ?>&amount=<?= $aPost['Total_price']; ?>&ref=parcel">
                                <button class="btn btn-primary btn-block" style="width: 150px;">PAY</button>
                            </a><br />
                        <?php
                            break;
                        case "cash":
                        ?>
                            <h5>Pay Cash at Pickup</h5><br />
                            <a href="invoice.php?orderD=<?= $aPost['order_number']; ?>" target="_blank">
                                <button class="btn btn-primary btn-block" style="width: 150px;">Pay Cash</button>
                            </a><br />
                        <?php
                            break;
                        case "paypal":


                            $aData = json_decode(file_get_contents("keys.json"));
                            $paypalid = !empty($aData->paypalid) ? $aData->paypalid : "";
                        ?>
                            <h5>Pay Cash at Pickup</h5><br />
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="display: contents;">
                                <!-- Identify your business so that you can collect the payments. -->
                                <input type="hidden" name="business" value="<?php echo $paypalid; ?>">

                                <!-- Specify a Buy Now button. -->
                                <input type="hidden" name="cmd" value="_xclick">

                                <!-- Specify details about the item that buyers will purchase. -->
                                <input type="hidden" name="item_name" value="sale">
                                <!-- <input type="hidden" name="item_number" value="<?php echo $row['id']; ?>"> -->
                                <input type="hidden" name="amount" value="<?php echo $aPost['Total_price']; ?>">
                                <input type="hidden" name="currency_code" value="USD">

                                <!-- Specify URLs -->
                                <input type="hidden" name="return" value="invoice.php?orderD=<?= $aPost['order_number']; ?>">
                                <input type="hidden" name="cancel_return" value="invoice.php?orderD=<?= $aPost['order_number']; ?>">

                                <!-- Display the payment button. -->
                                <button type="submit" name="submit" class="btn btn-success " border="0" style="margin-left:20px"><i class="fa fa-credit-card"></i> Pay Via Paypal</button>
                            </form>
                            <!--<a href="invoice.php?orderD=<?= $aPost['order_number']; ?>" target="_blank">-->
                            <!--    <button class="btn btn-primary btn-block" style="width: 150px;" >Pay Cash</button>-->
                            <!--</a><br/>-->
                    <?php
                            break;
                    }
                } else {

                    $affiliate_no = $aPost['affiliate_no'];
                    $get = "SELECT * FROM `affilate_user` WHERE affialte_no='$affiliate_no'";

                    $run = mysqli_query($Connect, $get);

                    while ($row_type = mysqli_fetch_array($run)) {
                        $affialte_no = $row_type['affialte_no'];
                        $affialte_name = $row_type['name'];
                        $affialte_email = $row_type['email'];
                        $phone = $row_type['phone'];
                    }

                    $email_subject = "New order from Merchant Couriers";

                    function died($error)
                    {

                        // your error code can go here

                        echo "We are very sorry, but there were error(s) found with the form you submitted. ";

                        echo "These errors appear below.<br /><br />";

                        echo $error . "<br /><br />";

                        echo "Please go back and fix these errors.<br /><br />";

                        die();
                    }
                    // validation expected data exists

                    if (
                        !isset($aPost['email']) ||
                        !isset($aPost['address']) ||
                        !isset($aPost['drop_address']) ||
                        !isset($aPost['phone']) ||
                        !isset($aPost['drop_phone']) ||
                        !isset($aPost['name']) ||
                        !isset($aPost['drop_name']) ||
                        !isset($aPost['date']) ||
                        !isset($aPost['drop_date']) ||
                        !isset($aPost['weight_of_package']) ||
                        !isset($aPost['package_quantity']) ||
                        !isset($aPost['insurance']) ||
                        !isset($aPost['value_of_package']) ||
                        !isset($aPost['time']) ||
                        !isset($aPost['drop_time'])
                    ) {

                        died('We are sorry, but there appears to be a problem with the form you submitted.');
                    }

                    $email_from = "orders@merchantcouriers.com";
                    $email_client = $aPost['email'];
                    $address = $aPost['address'];
                    $drop_address = $aPost['drop_address'];
                    $phone = $aPost['phone'];
                    $drop_phone = $aPost['drop_phone'];
                    $name = $aPost['name'];
                    $drop_name = $aPost['drop_name'];
                    $date = $aPost['date'];
                    $drop_date = $aPost['drop_date'];
                    $weight_of_package = $aPost['weight_of_package'];
                    $package_quantity = $aPost['package_quantity'];
                    $insurance = $aPost['insurance'];
                    $value_of_package = $aPost['value_of_package'];
                    $note = $aPost['note'];
                    $time = $aPost['time'];
                    $distance = $aPost['distance'];
                    $order_number = $aPost['order_number'];
                    $drop_time = $aPost['drop_time'];
                    $Total_price = $aPost['Total_price'];
                    $OrderID = $ID + 1;


                    $error_message = "";

                    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

                    if (!preg_match($email_exp, $email_from)) {

                        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
                    }

                    $string_exp = "/^[A-Za-z .'-]+$/";

                    if (!preg_match($string_exp, $name)) {

                        $error_message .= 'The First Name you entered does not appear to be valid.<br />';
                    }


                    if (strlen($error_message) > 0) {

                        died($error_message);
                    }

                    $uname = "Fasttrack1";
                    $pwd = "Thelordismyshephered2017";
                    $id = "FleetStar";
                    $sms_drivers = $driver_phone;
                    $book_num = $aPost['order_number'];

                    $get_commission = "SELECT * FROM `prizelist` ";
                    $run_commission = mysqli_query($Connect, $get_commission);

                    while ($row_type = mysqli_fetch_array($run_commission)) {
                        $parcel_driver_commission = $row_type['parcel_driver_commission'];
                    }

                    $cost = ($parcel_driver_commission / 100) * $Total_price;
                    $cost1 = number_format((float)$cost, 2, '.', '');

                    $get = "SELECT * FROM `driver` WHERE type_of_service='Parcel Delivery' AND username !='pending' AND info !='blocked'";

                    $run = mysqli_query($Connect, $get);

                    while ($row_type = mysqli_fetch_array($run)) {
                        $ID = $row_type['driverID'];
                        $Name = $row_type['name'];
                        $driver_phone = $row_type['phone'];
                        $driver_email = $row_type['email'];

                        $email_to =  "$driver_email,";

                        /* $sms_phone = $driver_phone;
                        $uname = "Business";
                        $pwd = "Merchant2017";
                        $id = "b5c57830717b41b6c8b038912a55e641";
                        $sms_msg = "New Parcel Delivery Booking on Merchant Couriers. For more info check your email. Ref: $book_num, Price:$Total_price.";
                        $data ="&u=".$uname."&h=".$id."&op=pv&to=".$sms_phone."&msg=".urlencode($sms_msg);
                        
                        $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        curl_close($ch); */

                        $subject2 = "New Parcel Delivery Booking";

                        $htmlContent2 = '
                                        <html>
                                        <head>
                                            <title>Merchant Couriers</title>
                                        </head>
                                        <body>
                                        <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                            <h1 style="color:#FF8C00">Merchant Couriers</h1>
                                            <h3>We Deliver With Speed!</h3>
                                    		<p>
                                    	     New Parcel Delivery booking on Merchant  Couriers. Below are details of the booking.
                                    		</p>
                                    		<table cellspacing="0" style="border: 2px dashed #FF8C00; width: 300px;">
                                                <tr style="background-color: #e0e0e0;">
                                    			<th>Order Number:</th><td>#' . $order_number . '</td>
                                    			</tr>
                                    
                                    			<tr style="background-color: #e0e0e0;">
                                    			<th>Name:</th><td>' . $name . '</td>
                                    			</tr>
                                    
                                    			<tr style="background-color: #e0e0e0;">
                                    			<th>Pick Up Address:</th><td>' . $address . '</td>
                                    			</tr>
                                    
                                    			<tr style="background-color: #e0e0e0;">
                                    			<th>Drop Off Address:</th><td>' . $drop_address . '</td>
                                    			</tr>
                                    
                                    			<tr style="background-color: #e0e0e0;">
                                    			<th>Quantity:</th><td>' . $package_quantity . '</td>
                                    			</tr>
                                    
                                    			<tr style="background-color: #e0e0e0;">
                                    			<th>Distance:</th><td>' . $distance . '</td>
                                    			</tr>
                                    
                                    			<tr style="background-color: #e0e0e0;">
                                    			<th>Total Price:</th><td>$' . $cost1 . '</td>
                                    			</tr>
                                    
                                            </table>
                                    
                                           <h3> Click <a href="https://www.merchantcouriers.com/driver/"><b>View Order</b></a> to see more details about this order.</h3>
                                    
                                    		<footer>
                                    		<div style="background-color:#CCC; padding:10px;">
                                    		<p>
                                    		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.com. Alternatively you can call/whatsapp +263779495409. <br/>
                                            PLEASE DO NOT REPLY TO THIS EMAIL.
                                    		</p>
                                    
                                    		<h4 style="color:#FF8C00">Merchant Couriers</h4>
                                    		<p>We Deliver With Speed.</p>
                                    		</div>
                                    		</footer>
                                    		</div>
                                        </body>
                                        </html>';

                        // Set content-type header for sending HTML email
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                        // Additional headers
                        $headers .= 'From: Merchant Couriers<orders@merchantcouriers.com>' . "\r\n";

                        // Send email
                        if (mail($email_to, $subject2, $htmlContent2, $headers)) :
                            $successMsg = 'Email has sent successfully.';
                        else :
                            $errorMsg = 'Email sending fail.';
                        endif;
                    }

                    //admin Email
                    $email_to_admin = "merchantcouriers1@gmail.com";
                    $subject4 = "New Parcel Delivery Booking";

                    $htmlContent4 = '
                                    <html>
                                    <head>
                                        <title>Merchant Couriers</title>
                                    </head>
                                    <body>
                                    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                        <h1 style="color:#FF8C00">Merchant Couriers</h1>
                                        <h3>We Deliver With Speed!</h3>
                                		<p>
                                	     New Parcel Delivery booking on Merchant  Couriers. Below are details of the booking.
                                		</p>
                                		<table cellspacing="0" style="border: 2px dashed #FF8C00; width: 300px;">
                                            <tr style="background-color: #e0e0e0;">
                                			<th>Order Number:</th><td>#' . $order_number . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Name:</th><td>' . $name . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Pick Up Address:</th><td>' . $address . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Drop Off Address:</th><td>' . $drop_address . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Quantity:</th><td>' . $package_quantity . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Distance:</th><td>' . $distance . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Total Price:</th><td>$' . $Total_price . '</td>
                                			</tr>
                                
                                        </table>
                                
                                       <h3> Click <a href="https://www.merchantcouriers.com/driver/"><b>View Order</b></a> to see more details about this order.</h3>
                                
                                		<footer>
                                		<div style="background-color:#CCC; padding:10px;">
                                		<p>
                                		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.com. Alternatively you can call/whatsapp on +263779495409. <br/>
                                        PLEASE DO NOT REPLY TO THIS EMAIL.
                                		</p>
                                
                                		<h4 style="color:#FF8C00">Merchant Couriers</h4>
                                		<p>We Deliver With Speed.</p>
                                		</div>
                                		</footer>
                                		</div>
                                    </body>
                                    </html>';

                    // Set content-type header for sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    // Additional headers
                    $headers .= 'From: Merchant Couriers<orders@merchantcouriers.com>' . "\r\n";
                    $headers .= 'Bcc: bamhara1@gmail.com' . "\r\n";

                    // Send email
                    if (mail($email_to_admin, $subject4, $htmlContent4, $headers)) :
                        $successMsg = 'Email has sent successfully.';
                    else :
                        $errorMsg = 'Email sending fail.';
                    endif;

                    //Client Confirmation Email
                    $subject = "Confirmation";

                    $htmlContent = '
                                    <html>
                                    <head>
                                        <title>Merchant Couriers</title>
                                    </head>
                                    <body>
                                    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                        <h1 style="color:#FF8C00">Merchant Couriers</h1>
                                        <h3>We Deliver With Speed!</h3>
                                		<p>
                                		 You just booked a delivery on Merchant Couriers. Ref:' . $order_number . ', Price: $' . $Total_price . ' . Pay to Ecocash Merchant 184532 or Zipit Steward Bnk 1007023878.
                                	     <br/><br/> An email/sms notification with a delivery driver merchant assigned to your delivery will be sent to you shortly.
                                		</p>
                                
                                		<p>Below are details of your booking.</p>
                                
                                		<table cellspacing="0" style="border: 2px dashed #FF8C00; width: 300px;">
                                            <tr style="background-color: #e0e0e0;">
                                			<th>Order Number:</th><td>#' . $order_number . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Pick Up Address:</th><td>' . $address . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Destination Address:</th><td>' . $drop_address . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Distance:</th><td>' . $distance . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Total Price:</th><td>$' . $Total_price . '</td>
                                			</tr>
                                
                                        </table>
                                
                                       <h3> If you have not paid for your delivery please do so using the following link <a href="https://www.merchantcouriers.com/Invoice2.php?orderD=' . $order_number . '">Invoice</a> </h3>
                                
                                
                                		<footer>
                                		<div style="background-color:#CCC; padding:10px;">
                                		<p>
                                		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.com. Alternatively you can call/whatsapp +263779495409. <br/>
                                        PLEASE DO NOT REPLY TO THIS EMAIL.
                                		</p>
                                
                                		<h4 style="color:#FF8C00">Merchant Couriers</h4>
                                		<p>We Deliver With Speed.</p>
                                		</div>
                                		</footer>
                                		</div>
                                    </body>
                                    </html>';

                    // Set content-type header for sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    // Additional headers
                    $headers .= 'From: Merchant Couriers<orders@merchantcouriers.com>' . "\r\n";

                    // Send email
                    if (mail($email_client, $subject, $htmlContent, $headers)) :
                        $successMsg = 'Email has sent successfully.';
                    else :
                        $errorMsg = 'Email sending fail.';
                    endif;

                    // Affiliate Email
                    $subject3 = "New Order";

                    $costt += $Total_price;
                    $cost2 = 10 / 100 * $costt;
                    $tot = number_format((float)$cost2, 2, '.', '');

                    $htmlContent3 = '
                                    <html>
                                    <head>
                                        <title>Merchant Couriers</title>
                                    </head>
                                    <body>
                                    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                        <h1 style="color:#FF8C00">Merchant Couriers</h1>
                                        <h3>We Deliver With Speed!</h3>
                                		<p>
                                		Hello ' . $affialte_name . '
                                		</p>
                                		<p>
                                	     Your client made a Parcel Delivery booking on Merchant  Couriers. Below are details of the booking.
                                		</p>
                                		<table cellspacing="0" style="border: 2px dashed #FF8C00; width: 300px;">
                                            <tr style="background-color: #e0e0e0;">
                                			<th>Order Number:</th><td>#' . $order_number . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Name:</th><td>' . $name . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Total Price:</th><td>$' . $Total_price . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Your Commission:</th><td>$' . $tot . '</td>
                                			</tr>
                                
                                        </table>
                                
                                        <p>You will be notified when we receive payment for this order.</p>
                                       <h3> Click <a href="https://www.merchantcouriers.com/affiliate.user/"><b>View Order</b></a> to see more details about this order.</h3>
                                
                                		<footer>
                                		<div style="background-color:#CCC; padding:10px;">
                                		<p>
                                		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.com. Alternatively you can call/whatsapp on +263779495409. <br/>
                                        PLEASE DO NOT REPLY TO THIS EMAIL.
                                		</p>
                                
                                		<h4 style="color:#FF8C00">Merchant Couriers</h4>
                                		<p>We Deliver With Speed.</p>
                                		</div>
                                		</footer>
                                		</div>
                                    </body>
                                    </html>';

                    // Set content-type header for sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    // Additional headers
                    $headers .= 'From: Merchant Couriers<orders@merchantcouriers.com>' . "\r\n";
                    $headers .= 'Bcc: bamhara1@gmail.com' . "\r\n";

                    // Send email
                    if (mail($affialte_email, $subject3, $htmlContent3, $headers)) :
                        $successMsg = 'Email has sent successfully.';
                    else :
                        $errorMsg = 'Email sending fail.';
                    endif;

                    ?>

                    <h1>Thank you for using Merchant Couriers. <br />
                        your stuff is on its way!</h1> <br /><br />

                    <h5>Pay Cash at Pickup<br />
                        <a href="invoice.php?orderD=<?= $order_number; ?>" target="_blank"><button class="btn">Pay Cash</button></a><br />
                        <?php /*
                            <h5>Pay Online-Visa or Mastercard USD<br/>
                            <a href="#" target="_blank"><button class="btn">PAY</button></a><br/>
                            
                            Pay Online-Local Zimswitch, Ecocash, Onemoney, Telecash. LOCAL CURRENCY<br/>
                            <a href="paynow.php?orderD=<?=$order_number;?>" target="_blank"><button class="btn">PAY</button></a><br/>
                            <br/>
                            
                            Alternatively you can pay directly on our Ecocash Merchant Code 184532 / Steward Bank Via Zipit to 1007023878, Kwame Nkrumah Branch, Code 20 000. Please send payment proof on +263779495409.</h5>
                            
                             //*/ ?>


                <?php
                    unset($_SESSION['POST']);
                }
            }

                ?>
                <?php require_once('db.php'); ?>
                <?php
                if ((isset($aPost["MM_insert"])) && ($aPost["MM_insert"] == "bookingform")) {
                    if (isset($aPost['paymentOpt']) && $aPost['paymentOpt'] != "cash") {
                    } elseif (isset($aPost['paymentOpt']) && $aPost['paymentOpt'] == "cash") {

                        $hostname_Connect = "localhost";
                        $database_Connect = "kundaita_mc_db";
                        $username_Connect = "kundaita_mc_user";
                        $password_Connect = "#;H}MXNXx(kB";
                        $coni = mysqli_connect($hostname_Connect, $username_Connect, $password_Connect, $database_Connect);
                        // $coni=@mysqli_connect("localhost","root","", "kundaita_mc_db");
                        //    $coni=@mysqli_connect("localhost","root","", "merchantco_db");
                        $affialte_no = $aPost['affiliate_no'];
                        $Total_pr = $aPost['Total_price'];
                        $cost1 = 10 / 100 * $Total_pr;
                        $tot = number_format((float)$cost1, 2, '.', '');
                        $getz = "SELECT * FROM affilate_user WHERE affialte_no='$affialte_no'";
                        $run = mysqli_query($coni, $getz);
                        while ($row_price = mysqli_fetch_array($run)) {
                            $ID = $row_price['order_id'];
                            $balance = $row_price['balance'];

                            $show = $tot + $balance;
                        }

                        $update = "UPDATE affilate_user SET balance='$show' WHERE affialte_no='$affialte_no'";
                        $Result1 = mysqli_query($coni, $update);

                        $address = $aPost['address'];
                        $time = $aPost['time'];
                        $date = $aPost['date'];
                        $name = $aPost['name'];
                        $phone = $aPost['phone'];
                        $email = $aPost['email'];
                        $drop_address = $aPost['drop_address'];
                        $drop_date = $aPost['drop_date'];
                        $drop_time = $aPost['drop_time'];
                        $drop_name = $aPost['drop_name'];
                        $countryCode = $aPost['countryCode'];
                        $drop_phone = $countryCode + $aPost['drop_phone'];
                        $Total_price = $aPost['Total_price'];
                        $distance = $aPost['distance'];
                        $weight_of_package = $aPost['weight_of_package'];
                        $insurance = $aPost['insurance'];
                        $package_quantity = $aPost['package_quantity'];
                        $value_of_package = $aPost['value_of_package'];
                        $transport = $aPost['transport'];
                        $vehicle_type = $aPost['vehicle_type'];
                        $order_number = $aPost['order_number'];
                        $note = $aPost['note'];
                        $affiliate_no = $aPost['affiliate_no'];
                        $disc = $aPost['c_disc'];
                        $currency = $aPost['paymentOpt'];
                        $Total_price = $Total_price - $disc;

                        try {
                            $stmt = $Connect->prepare("SELECT * FROM bookings WHERE order_number=:id");
                            $stmt->execute(array(":id" => $order_number));
                            $count = $stmt->rowCount();

                            if ($count == 0) {
                                $stmt = $Connect->prepare("INSERT INTO bookings (pick_up_address, pick_up_time, pick_up_date, Name, phone, email, drop_address, drop_date, drop_time, Drop_name, drop_phone, Total_price, distance, weight, insurance, quantity, `value`, type_of_transport, vehicle_type, order_number, drivers_note, affiliate_no, affiliate_com , coupon_discount, currency) VALUES (:address, :time, :date, :name, :phone, :email, :drop_address, :drop_date, :drop_time, :drop_name, :drop_phone, :Total_price, :distance, :weight_of_package, :insurance, :package_quantity, :value_of_package, :transport, :vehicle_type, :order_number, :note, :affiliate_no, :tot , :disc, :currency)");
                                $stmt->bindparam(":address", $address);
                                $stmt->bindparam(":time", $time);
                                $stmt->bindparam(":date", $date);
                                $stmt->bindparam(":name", $name);
                                $stmt->bindparam(":drop_address", $drop_address);
                                $stmt->bindparam(":Total_price", $Total_price);
                                $stmt->bindparam(":distance", $distance);
                                $stmt->bindparam(":email", $email);
                                $stmt->bindparam(":phone", $phone);
                                $stmt->bindparam(":transport", $transport);
                                $stmt->bindparam(":order_number", $order_number);
                                $stmt->bindparam(":drop_date", $drop_date);
                                $stmt->bindparam(":drop_time", $drop_time);
                                $stmt->bindparam(":drop_name", $drop_name);
                                $stmt->bindparam(":drop_phone", $drop_phone);
                                $stmt->bindparam(":weight_of_package", $weight_of_package);
                                $stmt->bindparam(":insurance", $insurance);
                                $stmt->bindparam(":package_quantity", $package_quantity);
                                $stmt->bindparam(":value_of_package", $value_of_package);
                                $stmt->bindparam(":vehicle_type", $vehicle_type);
                                $stmt->bindparam(":note", $note);
                                $stmt->bindparam(":affiliate_no", $affiliate_no);
                                $stmt->bindparam(":tot", $tot);
                                $stmt->bindparam(":disc", $disc);
                                $stmt->bindparam(":currency", $currency);

                                //check if query executes
                                if ($stmt->execute()) {
                                    $phone_numb = $aPost['phone'];
                                    if (preg_match('[^\+263|263]', $phone_numb)) {
                                        $sms_phone = $aPost['phone'];
                                        $uname = $smsUsername;
                                        $pwd = $smsPwd;
                                        $id_d = $smsID;
                                        $sms_msg = "You just booked a delivery on Merchant Couriers. Ref:$order_number, Price: $$Total_price. Pay to Ecocash Merchant 184532 or Zipit Steward Bnk 1007023878.";
                                        $data = "&u=" . $uname . "&h=" . $id_d . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

                                        $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
                                        curl_setopt($ch, CURLOPT_POST, true);
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        $result = curl_exec($ch);
                                        curl_close($ch);
                                    } else {
                                        $account_sid = $twiliosmsID;
                                        $auth_token = $twiliosmsUsername;

                                        $url = "https://api.twilio.com/2010-04-01/Accounts/$account_sid/SMS/Messages";
                                        $to = $aPost['phone'];
                                        $from = $twilioPhoneNumber; // twilio trial verified number
                                        $body = "You just booked a delivery on Merchant Couriers. Ref:$order_number, Price: $$Total_price. Pay to Ecocash Merchant 184532 or Zipit Steward Bnk 1007023878.";
                                        $data = array(
                                            'From' => $from,
                                            'To' => $to,
                                            'Body' => $body,
                                        );
                                        $post = http_build_query($data);
                                        $x = curl_init($url);
                                        curl_setopt($x, CURLOPT_POST, true);
                                        curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
                                        curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                                        curl_setopt($x, CURLOPT_USERPWD, "$account_sid:$auth_token");
                                        curl_setopt($x, CURLOPT_POSTFIELDS, $post);
                                        $y = curl_exec($x);
                                        curl_close($x);
                                    }


                                    echo "<script>alert('Booking was successful')</script>";
                                    //  echo "<script>window.open('invoice.php?orderD=$book_num','_self')</script>";

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
                    } else {
                        $hostname_Connect = "localhost";
                        $database_Connect = "kundaita_mc_db";
                        $username_Connect = "kundaita_mc_user";
                        $password_Connect = "#;H}MXNXx(kB";
                        $coni = mysqli_connect($hostname_Connect, $username_Connect, $password_Connect, $database_Connect);

                        // $coni=@mysqli_connect("localhost","root","", "kundaita_mc_db");
                        //    $coni=@mysqli_connect("localhost","root","", "merchantco_db");
                        $affialte_no = $aPost['affiliate_no'];
                        $Total_pr = $aPost['Total_price'];
                        $cost1 = 10 / 100 * $Total_pr;
                        $tot = number_format((float)$cost1, 2, '.', '');
                        $getz = "SELECT * FROM affilate_user WHERE affialte_no='$affialte_no'";
                        $run = mysqli_query($coni, $getz);
                        while ($row_price = mysqli_fetch_array($run)) {
                            $ID = $row_price['order_id'];
                            $balance = $row_price['balance'];

                            $show = $tot + $balance;
                        }
                        $update = "UPDATE affilate_user SET balance='$show' WHERE affialte_no='$affialte_no'";
                        $Result1 = mysqli_query($coni, $update);

                        $address = $aPost['address'];
                        $time = $aPost['time'];
                        $date = $aPost['date'];
                        $name = $aPost['name'];
                        $phone = $aPost['phone'];
                        $email = $aPost['email'];
                        $drop_address = $aPost['drop_address'];
                        $drop_date = $aPost['drop_date'];
                        $drop_time = $aPost['drop_time'];
                        $drop_name = $aPost['drop_name'];
                        $countryCode = $aPost['countryCode'];
                        $drop_phone = $countryCode + $aPost['drop_phone'];
                        $Total_price = $aPost['Total_price'];
                        $distance = $aPost['distance'];
                        $weight_of_package = $aPost['weight_of_package'];
                        $insurance = $aPost['insurance'];
                        $package_quantity = $aPost['package_quantity'];
                        $value_of_package = $aPost['value_of_package'];
                        $transport = $aPost['transport'];
                        $vehicle_type = $aPost['vehicle_type'];
                        $order_number = $aPost['order_number'];
                        $note = $aPost['note'];
                        $affiliate_no = $aPost['affiliate_no'];
                        $disc = $aPost['c_disc'];
                        $currency = $aPost['paymentOpt'];
                        $Total_price = $Total_price - $disc;

                        try {

                            $stmt = $Connect->prepare("SELECT * FROM bookings WHERE order_number=:id");
                            $stmt->execute(array(":id" => $order_number));
                            $count = $stmt->rowCount();

                            if ($count == 0) {
                                $stmt = $Connect->prepare("INSERT INTO bookings (pick_up_address, pick_up_time, pick_up_date, Name, phone, email, drop_address, drop_date, drop_time, Drop_name, drop_phone, Total_price, distance, weight, insurance, quantity, `value`, type_of_transport, vehicle_type, order_number, drivers_note, affiliate_no, affiliate_com , coupon_discount, currency) VALUES (:address, :time, :date, :name, :phone, :email, :drop_address, :drop_date, :drop_time, :drop_name, :drop_phone, :Total_price, :distance, :weight_of_package, :insurance, :package_quantity, :value_of_package, :transport, :vehicle_type, :order_number, :note, :affiliate_no, :tot , :disc, :currency)");
                                $stmt->bindparam(":address", $address);
                                $stmt->bindparam(":time", $time);
                                $stmt->bindparam(":date", $date);
                                $stmt->bindparam(":name", $name);
                                $stmt->bindparam(":drop_address", $drop_address);
                                $stmt->bindparam(":Total_price", $Total_price);
                                $stmt->bindparam(":distance", $distance);
                                $stmt->bindparam(":email", $email);
                                $stmt->bindparam(":phone", $phone);
                                $stmt->bindparam(":transport", $transport);
                                $stmt->bindparam(":order_number", $order_number);
                                $stmt->bindparam(":drop_date", $drop_date);
                                $stmt->bindparam(":drop_time", $drop_time);
                                $stmt->bindparam(":drop_name", $drop_name);
                                $stmt->bindparam(":drop_phone", $drop_phone);
                                $stmt->bindparam(":weight_of_package", $weight_of_package);
                                $stmt->bindparam(":insurance", $insurance);
                                $stmt->bindparam(":package_quantity", $package_quantity);
                                $stmt->bindparam(":value_of_package", $value_of_package);
                                $stmt->bindparam(":vehicle_type", $vehicle_type);
                                $stmt->bindparam(":note", $note);
                                $stmt->bindparam(":affiliate_no", $affiliate_no);
                                $stmt->bindparam(":tot", $tot);
                                $stmt->bindparam(":disc", $disc);
                                $stmt->bindparam(":currency", $currency);

                                //check if query executes
                                if ($stmt->execute()) {
                                    $latest_id = $Connect->lastInsertId();
                                    // echo "Insert successful. Latest ID is: " . $latest_id; exit;
                                    if (isset($_SESSION['payment'])) {
                                        $aPayment = json_decode($_SESSION['payment']);
                                        if ($aPayment->status == true) {
                                            $sDetail = json_encode($aPayment->data);
                                            $sInvoice = "PAID";
                                            $sql = $Connect->prepare("update bookings set invoice=:invoice,transaction_details=:transaction_details where order_id=:order_id");
                                            $sql->bindParam(':invoice', $sInvoice);
                                            $sql->bindParam(':transaction_details', $sDetail);
                                            $sql->bindParam(':order_id', $latest_id);
                                            $sql->execute();
                                            // $sQuery = "update bookings set invoice='PAID',transaction_details='".$sDetail."' where order_id=".$latest_id." ";
                                            // echo $sQuery;
                                            // mysqli_query($Connect,$sQuery);
                                        }
                                        unset($_SESSION['payment']);
                                    }

                                    $phone_numb = $aPost['phone'];
                                    if (preg_match('[^\+263|263]', $phone_numb)) {
                                        $sms_phone = $aPost['phone'];
                                        $uname = $smsUsername;
                                        $pwd = $smsPwd;
                                        $id_d = $smsID;
                                        $sms_msg = "You just booked a delivery on Merchant Couriers. Ref:$order_number, Price: $$Total_price. Pay to Ecocash Merchant 184532 or Zipit Steward Bnk 1007023878.";
                                        $data = "&u=" . $uname . "&h=" . $id_d . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

                                        $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
                                        curl_setopt($ch, CURLOPT_POST, true);
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        $result = curl_exec($ch);
                                        curl_close($ch);
                                    } else {
                                        $account_sid = $twiliosmsID;
                                        $auth_token = $twiliosmsUsername;

                                        $url = "https://api.twilio.com/2010-04-01/Accounts/$account_sid/SMS/Messages";
                                        $to = $aPost['phone'];
                                        $from = $twilioPhoneNumber; // twilio trial verified number
                                        $body = "You just booked a delivery on Merchant Couriers. Ref:$order_number, Price: $$Total_price. Pay to Ecocash Merchant 184532 or Zipit Steward Bnk 1007023878.";
                                        $data = array(
                                            'From' => $from,
                                            'To' => $to,
                                            'Body' => $body,
                                        );
                                        $post = http_build_query($data);
                                        $x = curl_init($url);
                                        curl_setopt($x, CURLOPT_POST, true);
                                        curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
                                        curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                                        curl_setopt($x, CURLOPT_USERPWD, "$account_sid:$auth_token");
                                        curl_setopt($x, CURLOPT_POSTFIELDS, $post);
                                        $y = curl_exec($x);
                                        curl_close($x);
                                    }

                                    echo "<script>alert('Booking was successful')</script>";
                                    //  echo "<script>window.open('invoice.php?orderD=$book_num','_self')</script>";

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
                    }
                }
                ?>

        </div>
    </section>

    <!--Bottom-->
    <section id="bottom" class="main">
        <!--Container-->
        <div class="container">

            <!--row-fluids-->
            <div class="row-fluid">

                <!--Contact Form-->
                <div class="span3">
                    <h4>ADDRESS</h4>
                    <ul class="unstyled address">
                        <li>
                            <i class="icon-home"></i><strong>Address:</strong> Harare <br>Zimbabwe
                        </li>
                        <li>
                            <i class="icon-envelope"></i>
                            <strong>Email: </strong> merchantcouriers1@gmail.com
                        </li>
                        <li>
                            <i class="icon-globe"></i>
                            <strong>Website:</strong> www.merchantcouriers.com
                        </li>
                        <li>
                            <i class="icon-phone"></i>
                            <strong>Mobile No:</strong> +263779495409
                        </li>
                    </ul>
                </div>
                <!--End Contact Form-->

                <!--Important Links-->
                <div id="tweets" class="span3">
                    <h4>OUR COMPANY</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="index.php">About Us</a></li>
                            <li><a href="contact-us.php">Support</a></li>
                            <li><a href="terms.php">Terms of Use</a></li>
                            <li><a href="privacy.php">Privacy Policy</a></li>
                            <li><a href="terms.php">Copyright</a></li>
                    </div>
                </div>
                <!--Important Links-->

                <!--Archives-->
                <div id="archives" class="span3">
                    <h4>SERVICES LOCATIONS</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="#">Harare, Zimbabwe</a></li>
                        </ul>
                    </div>
                </div>
                <!--End Archives-->

                <!--Important Links-->
                <div id="tweets" class="span3">
                    <h4>Other Pages</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="blog.php">News & Updates</a></li>
                            <li><a href="driver_registration.php">We're Hiring</a></li>
                        </ul>
                    </div>
                </div>
                <!--Important Links-->
    </section>
    <!--/bottom-->

    <!--Footer-->
    <footer id="footer">
        <div class="container">
            <div class="row-fluid">
                <div class="span5 cp">
                    &copy; 2017 <a target="_blank" href="http://merchantcouriers.com/">Merchant Couriers</a>. All Rights Reserved.
                </div>
                <!--/Copyright-->

                <div class="span6">
                    <ul class="social pull-right">
                        <li><a href="http://www.facebook.com/sharer.php?u=https://merchantcouriers.com" target="_blank"><i class="icon-facebook"></i></a></li>
                        <li><a href="https://twitter.com/share?url=https://merchantcouriers.com&amp;text=merchant%20couriers&amp;hashtags=merchantcouriers" target="_blank"><i class="icon-twitter"></i></a></li>
                        <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=https://merchantcouriers.com" target="_blank"><i class="icon-linkedin"></i></a></li>
                        <li><a href="https://plus.google.com/share?url=https://merchantcouriers.com" target="_blank"><i class="icon-google-plus"></i></a></li>
                        <li><a href="#"><i class="icon-instagram"></i></a></li>
                        <li><a href="whatsapp://send?abid=username&text=HeyThere!"><img src="images/whatsapp.png" width="28px" alt="" /></a></li>
                    </ul>
                </div>

                <div class="span1">
                    <a id="gototop" class="gototop pull-right" href="#"><i class="icon-angle-up"></i></a>
                </div>
                <!--/Goto Top-->
            </div>
        </div>
    </footer>
    <!--/Footer-->

    <!--  Login form -->
    <div class="modal hide fade in" id="loginForm" aria-hidden="false">
        <div class="modal-header">
            <i class="icon-remove" data-dismiss="modal" aria-hidden="true"></i>
            <h4>Login Form</h4>
        </div>
        <!--Modal Body-->
        <div class="modal-body">
            <form class="form-inline" action="<?php echo $loginFormAction; ?>" method="POST" id="form-login">
                <input type="text" class="input-small" name="email" placeholder="Email">
                <input type="password" class="input-small" name="password" placeholder="Password">
                <label class="checkbox">
                    <input type="checkbox"> Remember me
                </label>
                <button type="submit" class="btn btn-primary">Sign in</button>
            </form>
            <a href="#">Forgot your password?</a>
            <p>Don't have an account? <a href="registration.php">register</a> </p>
        </div>
        <!--/Modal Body-->
    </div>
    <!--  /Login form -->

    <script src="js/vendor/jquery-1.9.1.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>

    <script type="text/javascript">
        <?php
        $aData = json_decode(file_get_contents("keys.json")); ?>

        function pay(amount) {
            var handler = StripeCheckout.configure({
                key: '<?php echo $aData->stripePk ?>', // your publisher key id
                locale: 'auto',
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                name: "TEST",
                description: "Pro Subscription ($9.95 per month)",
                panelLabel: "Pay",
                allowRememberMe: false,
                token: function(token) {
                    // You can access the token ID with `token.id`.
                    // Get the token ID to your server-side code for use.
                    console.log('Token Created!!');
                    console.log(token)
                    $('#token_response').html(JSON.stringify(token));

                    $.ajax({
                        url: "stripe/payment.php",
                        method: 'post',
                        data: {
                            tokenId: token.id,
                            amount: amount
                        },
                        dataType: "json",
                        success: function(response) {
                            var resp = response;
                            console.log(resp);
                            if (resp.status === true) {
                                $('#token_response-ok').html('<div class="alert alert-success"><strong>' + resp.msg + '</strong></div>');
                                setTimeout(function() {
                                    window.location.href = "submit_parser1.php";
                                }, 10000);
                            } else {
                                $('#token_response-fail').html('<div class="alert alert-danger"><strong>' + resp.msg + '</strong></div>');
                            }
                            // console.log(response.data);
                            // $('#token_response').append( '<br />' + JSON.stringify(response.data));
                        }
                    })
                }
            });

            handler.open({
                name: 'merchantcouriers.com',
                description: 'enter your card details',
                amount: amount * 100
            });
        }
    </script>

</body>

</html>
