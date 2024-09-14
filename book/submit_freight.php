<?php
if (!isset($_SESSION)) session_start();
// require("../function.php");
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
$smsData = json_decode(file_get_contents("../admin/pages/keys.json"));
$smsID = !empty($smsData->smsId) ? $smsData->smsId : "";
$smsUsername = !empty($smsData->smsUsername) ? $smsData->smsUsername : "";
$smsPwd = !empty($smsData->smsPwd) ? $smsData->smsPwd : "";
$twiliosmsID = !empty($aData->twiliosmsID) ? $aData->twiliosmsID : "";
$twiliosmsUsername = !empty($aData->twiliosmsUsername) ? $aData->twiliosmsUsername : "";
$twilioPhoneNumber = !empty($aData->twilioPhoneNumber) ? $aData->twilioPhoneNumber : "";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="assets/images/favicon.png"
      type="image/x-icon"
    />
    <title>Invoice | Merchant Couriers</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/lineicons.css" />
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    
   
  </head>
  <body>
    <!-- ======== sidebar-nav start =========== -->
    <?php include("header.php"); ?>
      <!-- ========== header end ========== -->
      
      

      <!-- ========== section start ========== -->
      <section>
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="title d-flex align-items-center flex-wrap mb-30">
                  <h2 class="mr-40">Freight Booking</h2>
                </div>
              </div>
              <!-- end col -->
              <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="#0">Dashboard</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Invoice
                      </li>
                      
                    </ol>
                  </nav>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!--========================================= Submit Start ==================================-->
            <?php
            if ($_POST) {
                $aPost = $_POST;
            } else {
                $aPost = unserialize($_SESSION['POST']);
                if (isset($aPost['paymentOpt'])) {
                    unset($aPost['paymentOpt']);
                }
                //   echo "<pre>" . print_r($aPost, true) . "</pre>";
            }
            // echo "<pre>" . print_r($aPost, true) . "</pre>"; exit;
            if (isset($aPost['MM_insert'])) {
                if (isset($aPost['paymentOpt']) && $aPost['paymentOpt'] != "cash") {
                    // if (!isset($_SESSION)) session_start();
                    $_SESSION['POST'] = serialize($aPost); #Copy _POST to _SESSION
                    // $aPost = unserialize($_SESSION['POST']); #Copy it back.
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
                            <a href="paynow.php?orderD=<?= $aPost['order_number']; ?>&amount=<?= $aPost['Total_price']; ?>&ref=freight">
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
                    $note = $aPost['note'];
                    $time = $aPost['time'];
                    $Total_price = $aPost['Total_price'];
                    $distance = $aPost['distance'];
                    $price = $aPost['price'];
                    $order_number = $aPost['order_number'];
                    $drop_time = $aPost['drop_time'];
                    $insure = $aPost['insure'];
                    $OrderID = $ID + 1;
                    $Veh = $aPost['vehicle_type'];
                    $transport = $aPost['transport'];

                    $get_commission = "SELECT * FROM `prizelist` ";
                    $run_commission = mysqli_query($Connect, $get_commission);

                    while ($row_type = mysqli_fetch_array($run_commission)) {
                        $parcel_driver_commission = $row_type['parcel_driver_commission'];
                        $freight_driver_commission = $row_type['freight_driver_commission'];
                        $furniture_driver_commission = $row_type['furniture_driver_commission'];
                    }

                    $dr_cost = $furniture_driver_commission * $Total_price;
                    $dr_cost1 = number_format((float)$dr_cost, 2, '.', '');

                    $sms_drivers = $driver_phone;
                    $book_num = $aPost['order_number'];
                    $cost = $freight_driver_commission * $Total_price;
                    $cost1 = number_format((float)$cost, 2, '.', '');

                    $get = "SELECT * FROM `driver` WHERE type_of_service='Freight Delivery' AND username !='pending' AND info !='blocked' ";

                    $run = mysqli_query($Connect, $get);

                    while ($row_type = mysqli_fetch_array($run)) {
                        $ID = $row_type['driverID'];
                        $Name = $row_type['name'];
                        $driver_phone = $row_type['phone'];
                        $driver_email = $row_type['email'];

                        $email_to =  "$driver_email,";

                        /*$sms_phone = "$driver_phone,";
                        $uname = "Business";
                        $pwd = "Merchant2017";
                        $id = "b5c57830717b41b6c8b038912a55e641";
                        $sms_msg = "New Freight delivery on Merchant Couriers From: $address To: $drop_address. For more info check your email or login on the app. Ref: $order_number, Price: $$Total_price. ";
                        $data ="&u=".$uname."&h=".$id."&op=pv&to=".$sms_phone."&msg=".urlencode($sms_msg);
                        
                        $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        curl_close($ch); */

                        $subject2 = "New Order";
                        $htmlContent2 = '
                                        <html>
                                        <head>
                                            <title>Merchant Couriers</title>
                                        </head>
                                        <body>
                                        <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                            <h1 style="color:#FF8C00">Merchant Couriers</h1>
                                            <h3>Freight Booking</h3>
                                    		<p>
                                    	     New Freight delivery order on Merchant  Couriers. Below are details of the order.
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
                                    			<th>Delivery Address:</th><td>' . $drop_address . '</td>
                                    			</tr>
                                    
                                    			<tr style="background-color: #e0e0e0;">
                                    			<th>Distance:</th><td>' . $distance . '</td>
                                    			</tr>
                                    
                                    			<tr style="background-color: #e0e0e0;">
                                    			<th>Preferred Vehicle:</th><td>' . $transport . '</td>
                                    			</tr>
                                    
                                    			<tr style="background-color: #e0e0e0;">
                                    			<th>Truck Size:</th><td>' . $weight_of_package . '</td>
                                    			</tr>
                                    
                                    			<tr style="background-color: #e0e0e0;">
                                    			<th>Total Price:</th><td>$' . $cost1 . '</td>
                                    			</tr>
                                    
                                            </table>
                                    
                                            <a href="https://www.merchantcouriers.com/driver/"><h2>View Order</h2></a>
                                    
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

                        // Send email
                        if (mail($email_to, $subject2, $htmlContent2, $headers)) :
                            $successMsg = 'Email has sent successfully.';
                        else :
                            $errorMsg = 'Email sending fail.';
                        endif;
                    }
                    // Admin Email
                    $subject4 = "New Order";
                    $email_to_admin = "merchantcouriers1@gmail.com";
                    $htmlContent4 = '
                                    <html>
                                    <head>
                                        <title>Merchant Couriers</title>
                                    </head>
                                    <body>
                                    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                        <h1 style="color:#FF8C00">Merchant Couriers</h1>
                                        <h3>Freight Booking</h3>
                                		<p>
                                	     New Freight delivery order on Merchant  Couriers. Below are details of the order.
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
                                			<th>Delivery Address:</th><td>' . $drop_address . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Distance:</th><td>' . $distance . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Preferred Vehicle:</th><td>' . $transport . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Truck Size:</th><td>' . $weight_of_package . '</td>
                                			</tr>
                                
                                			<tr style="background-color: #e0e0e0;">
                                			<th>Total Price:</th><td>$' . $Total_price . '</td>
                                			</tr>
                                
                                        </table>
                                
                                        <a href="https://www.merchantcouriers.com/driver/"><h2>View Order</h2></a>
                                
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

                    //Client Confirmation email
                    $subject = "Confirmation";

                    $htmlContent = '
                                <html>
                                <head>
                                    <title>Merchant Couriers</title>
                                </head>
                                <body>
                                <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                                    <h1 style="color:#FF8C00">Merchant Couriers</h1>
                                    <h3>Freight Booking</h3>
                            		<p>
                            		 You just booked a delivery on Merchant Couriers. Ref: ' . $order_number . ', Price: $' . $Total_price . '. Pay to Ecocash Merchant 184532 or Zipit Steward Bnk 1007023878.
                            	     <br/> An email/sms notification confirming your transporter will be sent to you shortly. You receive a notification confirming a verified transporter.
                            <br/>Pay your invoice using Pay Now Zimbabwe which offers Zimswitch, Forex Visa or MasterCard and mobile money platforms Ecocash, Telecash or OneMoney.
                            Alternatively you can pay directly on our Ecocash Merchant Code 184532 / Steward Bank Via Zipit to 1007023878, Kwame Nkrumah Branch, Code 20 000. Please send payment proof on +263779495409.
                            	</p>
                            
                            		<p>Below are details of your order.</p>
                            
                            		<table cellspacing="0" style="border: 2px dashed #FF8C00; width: 300px;">
                                        <tr style="background-color: #e0e0e0;">
                            			<th>Order Number:</th><td>#' . $order_number . '</td>
                            			</tr>
                            
                            			<tr style="background-color: #e0e0e0;">
                            			<th>Pick Up Address:</th><td>' . $address . '</td>
                            			</tr>
                            
                            			<tr style="background-color: #e0e0e0;">
                            			<th>Delivery Address:</th><td>' . $drop_address . '</td>
                            			</tr>
                            
                            			<tr style="background-color: #e0e0e0;">
                            			<th>Distance:</th><td>' . $distance . '</td>
                            			</tr>
                            
                                    </table>
                            
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

                    // Send email
                    if (mail($email_client, $subject, $htmlContent, $headers)) :
                        $successMsg = 'Email has sent successfully.';
                    else :
                        $errorMsg = 'Email sending fail.';
                    endif;

                    //Affiliate Email
                    $subject3 = "New Order";

                    $cost += $Total_price;
                    $cost1 = 10 / 100 * $cost;
                    $tot = number_format((float)$cost1, 2, '.', '');

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
                            	     Your client made a Freight Delivery booking on Merchant  Couriers. Below are details of the booking.
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
                            
                                    <p>You will be notified when we receive your payment for this order.</p>
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

                    // Send email
                    if (mail($affialte_email, $subject3, $htmlContent3, $headers)) :
                        $successMsg = 'Email has sent successfully.';
                    else :
                        $errorMsg = 'Email sending fail.';
                    endif;

                    ?>

                    <h1>Thank you for using Merchant Couriers.</h1> <br />
                    <h4>
                        <br />
                        You'l receive a notification confirming a verified transporter.
                        <br /><br />
                       
                        If you have any inquiries contact +263779495409.
                    </h4>

            <?php
                    unset($_SESSION['POST']);
                }
            }

            ?>
            <?php require_once('../db.php'); ?>
            <?php
            if ((isset($aPost["MM_insert"])) && ($aPost["MM_insert"] == "bookingform")) {
                if (isset($aPost['paymentOpt']) && $aPost['paymentOpt'] != "cash") {
                } elseif (isset($aPost['paymentOpt']) && $aPost['paymentOpt'] == "cash") {

                    $coni = @mysqli_connect("localhost", "merchant_admin", "}{kTftfu1449", "merchant_db");
                    $affialte_no = $aPost['affiliate_no'];
                    $Total_pr = $aPost['Total_price'];
                    $cost1 = 10 / 100 * $Total_pr;
                    $tot = number_format((float)$cost1, 2, '.', '');
                    $getz = "SELECT * FROM affilate_user WHERE affialte_no='$affialte_no' LIMIT 1";
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
                    $delivery_type = $aPost['delivery_type'];
                    $goods = $aPost['goods'];
                    $drop_address = $aPost['drop_address'];
                    $drop_date = $aPost['drop_date'];
                    $drop_time = $aPost['drop_time'];
                    $drop_name = $aPost['drop_name'];
                    $drop_phone = $aPost['drop_phone'];
                    $Total_price = $aPost['Total_price'];
                    $distance = $aPost['distance'];
                    $price = $aPost['price'];
                    $weight_of_package = $aPost['weight_of_package'];
                    $trucks_num = $aPost['trucks_num'];
                    $vehicle_type = $aPost['vehicle_type'];
                    $transport = $aPost['transport'];
                    $order_number = $aPost['order_number'];
                    $insure = $aPost['insure'];
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
                            $stmt = $Connect->prepare("INSERT INTO bookings (pick_up_address, pick_up_time, pick_up_date, Name, phone, email, delivery_type, goods, drop_address, drop_date, drop_time, Drop_name, drop_phone, Total_price, distance, offerPrice_km, weight, trucks_num, vehicle_type, type_of_transport, order_number, insurance, drivers_note, affiliate_no, affiliate_com , coupon_discount, currency) VALUES (:address, :time, :date, :name, :phone, :email,  :delivery_type, :goods, :drop_address, :drop_date, :drop_time, :drop_name, :drop_phone, :Total_price, :distance, :price, :weight_of_package, :trucks_num, :vehicle_type, :transport, :order_number, :insure, :note, :affiliate_no, :tot , :disc, :currency)");
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
                            $stmt->bindparam(":insure", $insure);
                            $stmt->bindparam(":delivery_type", $delivery_type);
                            $stmt->bindparam(":goods", $goods);
                            $stmt->bindparam(":vehicle_type", $vehicle_type);
                            $stmt->bindparam(":note", $note);
                            $stmt->bindparam(":affiliate_no", $affiliate_no);
                            $stmt->bindparam(":trucks_num", $trucks_num);
                            $stmt->bindparam(":price", $price);
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
                                //     echo "<script>window.open('invoice.php?orderD=$book_num','_self')</script>";

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
                    $coni = @mysqli_connect("localhost", "merchant_admin", "}{kTftfu1449", "merchant_db");
                    $affialte_no = $aPost['affiliate_no'];
                    $Total_pr = $aPost['Total_price'];
                    $cost1 = 10 / 100 * $Total_pr;
                    $tot = number_format((float)$cost1, 2, '.', '');
                    $getz = "SELECT * FROM affilate_user WHERE affialte_no='$affialte_no' LIMIT 1";
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
                    $delivery_type = $aPost['delivery_type'];
                    $goods = $aPost['goods'];
                    $drop_address = $aPost['drop_address'];
                    $drop_date = $aPost['drop_date'];
                    $drop_time = $aPost['drop_time'];
                    $drop_name = $aPost['drop_name'];
                    $drop_phone = $aPost['drop_phone'];
                    $Total_price = $aPost['Total_price'];
                    $distance = $aPost['distance'];
                    $price = $aPost['price'];
                    $weight_of_package = $aPost['weight_of_package'];
                    $trucks_num = $aPost['trucks_num'];
                    $vehicle_type = $aPost['vehicle_type'];
                    $transport = $aPost['transport'];
                    $order_number = $aPost['order_number'];
                    $insure = $aPost['insure'];
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
                            $stmt = $Connect->prepare("INSERT INTO bookings (pick_up_address, pick_up_time, pick_up_date, Name, phone, email, delivery_type, goods, drop_address, drop_date, drop_time, Drop_name, drop_phone, Total_price, distance, offerPrice_km, weight, trucks_num, vehicle_type, type_of_transport, order_number, insurance, drivers_note, affiliate_no, affiliate_com , coupon_discount, currency) VALUES (:address, :time, :date, :name, :phone, :email,  :delivery_type, :goods, :drop_address, :drop_date, :drop_time, :drop_name, :drop_phone, :Total_price, :distance, :price, :weight_of_package, :trucks_num, :vehicle_type, :transport, :order_number, :insure, :note, :affiliate_no, :tot , :disc, :currency)");
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
                            $stmt->bindparam(":insure", $insure);
                            $stmt->bindparam(":delivery_type", $delivery_type);
                            $stmt->bindparam(":goods", $goods);
                            $stmt->bindparam(":vehicle_type", $vehicle_type);
                            $stmt->bindparam(":note", $note);
                            $stmt->bindparam(":affiliate_no", $affiliate_no);
                            $stmt->bindparam(":trucks_num", $trucks_num);
                            $stmt->bindparam(":price", $price);
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
                                //     echo "<script>window.open('invoice.php?orderD=$book_num','_self')</script>";

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
           <!--========================================= Submit End ===================================-->
        </div>
        <!-- end container -->
      </section>
      <!-- ========== section end ========== -->

      <!-- ========== footer start =========== -->
      <?php include("footer.php") ?>
      <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->
   
    <!-- ========= All Javascript files linkup ======== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/js/dynamic-pie-chart.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/fullcalendar.js"></script>
    <script src="assets/js/jvectormap.min.js"></script>
    <script src="assets/js/world-merc.js"></script>
    <script src="assets/js/polyfill.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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
