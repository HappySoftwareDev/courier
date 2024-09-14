<?php

require_once('db.php');


// var_dump($_GET['invoice']); die;
if (!empty($_GET['item_number']) && !empty($_GET['tx']) && !empty($_GET['amt']) && !empty($_GET['cc']) && !empty($_GET['st'])) {
    // Get transaction information from URL
    $item_number = $_GET['item_number'];
    $txn_id = $_GET['tx'];
    $payment_gross = $_GET['amt'];
    $currency_code = $_GET['cc'];
    $payment_status = $_GET['st'];

    // Get product info from the database
    $productResult = $db->query("SELECT * FROM products WHERE id = " . $item_number);
    $productRow = $productResult->fetch_assoc();

    // Check if transaction data exists with the same TXN ID.
    $prevPaymentResult = $db->query("SELECT * FROM payments WHERE txn_id = '" . $txn_id . "'");


    // Insert tansaction data into the database
    $insert = $db->query("INSERT INTO paymentdetail(item_number,txn_id,payment_gross,currency_code,payment_status) VALUES('" . $item_number . "','" . $txn_id . "','" . $payment_gross . "','" . $currency_code . "','" . $payment_status . "')");
    $Connect->query("UPDATE bookings SET invoice='PAID' WHERE order_id=" . $_GET['invoice']);

    $payment_id = $db->insert_id;
} else {
    // $insert = $Connect->query("INSERT INTO paymentdetail(item_number,txn_id,payment_gross,currency_code,payment_status) VALUES('abc','123','123','654','987')");
    // $Connect->query("UPDATE bookings SET invoice='PAID' WHERE order_id=".$_GET['invoice']);
}
?>

<?php require ("login-security.php"); ?>

<?php
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "invo_status")) {
    $invoice = $_POST['invoice'];
    $id = $_POST['order_number'];
    $inv_status = "PAID";
    try {

        $stmt = $Connect->prepare("SELECT * FROM bookings WHERE order_id=:id AND invoice=:inv_status");
        $stmt->execute(array(":inv_status" => $inv_status));
        $stmt->execute(array(":id" => $d));
        $count = $stmt->rowCount();

        if ($count == 0) {
            $stmt = $Connect->prepare("UPDATE bookings SET invoice=:invoice WHERE order_number=:id");
            $stmt->bindparam(":invoice", $invoice);
            $stmt->bindparam(":id", $id);

            $coni = @mysqli_connect("localhost", "kundaita_mc_user", "#;H}MXNXx(kB", "kundaita_mc_db");
            $affialte_no = $_POST['affiliate_no'];
            $Total_pr = $_POST['total_price'];
            $getz = "SELECT * FROM affilate_user WHERE affialte_no='$affialte_no'";
            $run = mysqli_query($coni, $getz);
            while ($row_price = mysqli_fetch_array($run)) {
                $ID = $row_price['order_id'];
                $balance = $row_price['balance'];
                $affialte_no = $row_price['affialte_no'];
                $affialte_name = $row_price['name'];
                $affialte_email = $row_price['email'];
                $Aff_phone = $row_price['phone'];

                $cost += $Total_pr;
                $cost1 = 10 / 100 * $cost;
                $tot = number_format((float)$cost1, 2, '.', '');

                $show = $tot + $balance;
            }


            if ($stmt->execute()) {
                $htmlContent3 = '
    <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Merchant Couriers</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">Merchant Couriers</h1>
        <h3>We Deliver With Speed!</h3>
		<p>
		Hie ' . $affialte_name . '
		</p>
		<p>
	     We received payment from your client ' . $name . ' check your balance.
		</p>
       <h3> Click <a href="https://www.merchantcouriers.com/affiliate.user/"><b>Go to Dashboard</b></a>.</h3>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.com. Alternatively you can call/whatsapp on +263772467352 or +263779495409. <br/>
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

                $sms_phone = $_POST['client_phone'];
                $book_num = $_POST['order_number'];
                $uname = "Business";
                $pwd = "Merchant2017";
                $id = "b5c57830717b41b6c8b038912a55e641";
                $sms_msg = "Hi you have SUCCESSFULLY PAID for your booking. Use this link to see your invoice https://www.merchantcouriers.com/Invoice2.php?orderD=$book_num. Thank You for using Merchant Couriers.";
                $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

                $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);


                $email_to = $_POST['clientEmail'];

                $email_subject = "Invoice from Merchant Couriers";

                $email_from = "orders@merchantcouriers.com";
                $order_number = $_POST['order_number'];

                $subject = "Delivery Booking Paid";

                $htmlContent = '
    <html>
    <head>
        <title>Merchant Couriers</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">Merchant Couriers</h1>
        <h3>Booking Paid!</h3>
		<p>
	     Thank You for using Merchant Couriers. <br/><br/>You have SUCCESSFULLY PAID for your booking.
		</p>

       <h3>Click this link <a href="https://www.merchantcouriers.com/Invoice2.php?orderD=' . $order_number . '">Invoice</a> to see your paid invoice.</h3>


		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.com. Alternatively you can call/whatsapp on +263772467352 or +263779495409. <br/>
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
                if (mail($email_to, $subject, $htmlContent, $headers)) :
                    $successMsg = 'Email has sent successfully.';
                else :
                    $errorMsg = 'Email sending fail.';
                endif;
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    
    $get = "SELECT * FROM `users` where Email='$email_to'";
	 $run = mysqli_query($Connect,$get);
	 while ($row_type = mysqli_fetch_array($run)){
		 $push_token = $row_type['push_token'];
	 }
   
    $bk_id = $_POST['id'];
    $title = "Merchant Couriers";
    $msg ="Thank You for using Merchant Couriers. You have SUCCESSFULLY PAID for your booking.";
    $page="invo.php?invoice=$bk_id";
    echo "<script>window.open('send_notification.php?title=$title&message=$msg&token=$push_token&page=$page','_self')</script>";
}
?>

<?php require("function.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Merchant Couriers - Admin Area</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Merchant Couriers</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">

                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">

                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $logoutAction ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="users.php"><i class="fa fa-users fa-fw"></i> Users</a>
                        </li>
                        <li>
                            <a href="invite.php"><i class="fa fa-users fa-fw"></i> Invite</a>
                        </li>
                        <li>
                            <a href="driver.php"><i class="fa fa-car fa-fw"></i> Drivers</a>
                        </li>
                        <li>
                            <a href="map.php"><i class="fa fa-map-marker fa-fw"></i> Map</a>
                        </li>
                        <li>
                            <a href="integration.php"><i class="fa fa-gear fa-fw"></i> Integration</a>
                        </li>
                        <li>
                            <a href="blog.php"><i class="fa fa-list fa-fw"></i> Blog</a>
                        </li>
                        <li>
                            <a href="affiliate.php"><i class="fa fa-bullhorn fa-fw"></i> Affiliate</a>
                        </li>
                        <li class="">
                            <a href="coupons.php"><i class="fa fa-gear fa-fw"></i> coupons</a>
                        </li>
                        <li class="">
                            <a href="usercoupon.php"><i class="fa fa-gear fa-fw"></i> All Users coupons</a>
                        </li>
                        <li class="">
                            <a href="commoncoupon.php"><i class="fa fa-gear fa-fw"></i> Common coupons</a>
                        </li>
                        <li>
                            <a href="affiliate.msg.php"><i class="glyphicon glyphicon-question-sign fa-fw"></i> Affiliate Help</a>
                        </li>
                        <li>
                            <a href="customer_alerts.php"><i class="fa fa-bell fa-fw"></i> Send Alerts</a>
                        </li>
                        <li>
                            <a href="api.php"><i class="fa fa-gear fa-fw"></i> API keys</a>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
                <?php

                if (isset($_GET['invoice'])) {

                    $MrE = $_GET['invoice'];

                    $get = "SELECT * FROM `bookings` where order_id = '$MrE' Limit 1";

                    $run = mysqli_query($Connect, $get);

                    while ($row_type = mysqli_fetch_array($run)) {
                        $ID = $row_type['order_id'];
                        $order_number = $row_type['order_number'];
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
                        $invoice = $row_type['invoice'];

                        $details = "<tr>
                <td>$ID</td>
				<td>$weight_of_package</td>
				<td>$package_quantity</li>
				<td>$value_of_package</td>
				<td>$insurance</td>
				<td>$type_of_transport</td>
				<td><h4 style='color:black;'>From</h4> $address <br/><br/>  <h4 style='color:black;'>TO</h4>$drop_address</td>
				<td>$Total_price</td>
            </tr>";

                        $MC = "    Address: HarareZimbabwe<br>
                                Phone: +263772467352<br/>
                                Email: admin@merchantcouriers.com";

                        $ClientD = "    $address<br>
                                Phone: $phone<br/>
                                Email: $email_fro";
                    }
                }

                ?>

                <section id="services">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- /.panel -->
                                <div class="panel panel-default">
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <section class="content-header">

                                                    <h3 style="color:black;">
                                                        Invoice
                                                        <small>#<?php echo $order_number; ?></small>
                                                    </h3>
                                                    <form method="POST" action="invo.php" name="invo_status">
                                                        <input type="hidden" value="PAID" name="invoice">
                                                        <input type="hidden" value="<?php echo $email_fro; ?>" name="clientEmail">
                                                        <input type="hidden" value="<?php echo $phone; ?>" name="client_phone">
                                                        <input type="hidden" value="<?php echo $ID; ?>" name="id">
                                                        <input type="hidden" value="<?php echo $order_number; ?>" name="order_number">
                                                        <input type="hidden" value="<?php echo $Total_price; ?>" name="total_price">
                                                        <button type="submit" class="btn btn-primary pull-right" style="margin-right: 5px;"><?php echo $invoice; ?></button>
                                                        <input type="hidden" name="MM_update" value="invo_status">
                                                    </form>
                                                </section>

                                                <div class="pad margin no-print">
                                                    <div class="alert alert-info" style="margin-bottom: 0!important;">
                                                        <i class="fa fa-info"></i>
                                                        <b>Note:</b> This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                                                    </div>
                                                </div>

                                                <!-- Main content -->
                                                <section class="content invoice">
                                                    <!-- title row -->
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <h2 class="page-header">
                                                                <img src="../../images/mlogo.png" alt="">
                                                                <small class="pull-right">Date: <?php echo $Date; ?></small>
                                                            </h2>
                                                        </div><!-- /.col -->
                                                    </div>
                                                    <!-- info row -->
                                                    <div class="row invoice-info">
                                                        <div class="col-sm-4 invoice-col">
                                                            From
                                                            <address>
                                                                <strong>Merchant Couriers</strong><br>
                                                                <?php echo $MC; ?>
                                                            </address>
                                                        </div><!-- /.col -->
                                                        <div class="col-sm-4 invoice-col">
                                                            To
                                                            <address>
                                                                <strong><?php echo $name; ?></strong><br>
                                                                <?php echo $ClientD; ?>
                                                            </address>
                                                        </div><!-- /.col -->
                                                        <div class="col-sm-4 invoice-col">
                                                            <b>Invoice #00<?php echo $ID; ?></b><br />
                                                            <br />
                                                            <b>Order ID:</b> <?php echo $ID; ?>A<br />
                                                            <b>Payment Due:</b> <?php echo $drop_date; ?><br />
                                                            <b>Account:</b> <?php echo $name; ?>
                                                        </div><!-- /.col -->
                                                    </div><!-- /.row -->

                                                    <!-- Table row -->
                                                    <div class="row">
                                                        <div class="col-xs-12 table-responsive">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Weight</th>
                                                                        <th>Quantity</th>
                                                                        <th>Package Value</th>
                                                                        <th>Insurance</th>
                                                                        <th>Trasport</th>
                                                                        <th>Description</th>
                                                                        <th>Subtotal</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php echo $details; ?>
                                                                </tbody>
                                                            </table>
                                                        </div><!-- /.col -->
                                                    </div><!-- /.row -->

                                                    <div class="row">
                                                        <!-- accepted payments column -->
                                                        <div class="col-xs-6">
                                                            <p class="lead">Payment Methods:</p>

                                                            <a href="https://www.paynow.com/Payment/Link/?q=c2VhcmNoPWhhcHB5ZzIlNDBsaXZlLmNvbSZhbW91bnQ9MC4wMCZyZWZlcmVuY2U9Jmw9MA%3d%3d" target="_blank"><img style="border: 0;" src="https://www.paynow.com/Content/Buttons/Medium_buttons/button_pay-now_medium.png" /></a>
                                                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                                                Please take Note of the invoice number you will need it when you are making the payment as your reference number.
                                                            </p>
                                                        </div><!-- /.col -->
                                                        <div class="col-xs-6">
                                                            <p class="lead">Amount Due <?php echo $drop_date; ?></p>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <tr>
                                                                        <th style="width:50%">Subtotal:</th>
                                                                        <td>$<?php echo $Total_price; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Total:</th>
                                                                        <td>$<?php echo $Total_price; ?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div><!-- /.col -->
                                                    </div><!-- /.row -->

                                                    <!-- this row will not appear when printing -->
                                                    <div class="row no-print">
                                                        <div class="col-xs-12">
                                                            <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                                                            <?php if (strtoupper($invoice) == "UNPAID") {
                                                                // define('PAYPAL_URL', ("");
                                                            ?>
                                                                <?php

                                                                $aData = json_decode(file_get_contents("keys.json"));
                                                                $paypalid = !empty($aData->paypalid) ? $aData->paypalid : "";
                                                                //var_dump($aData);
                                                                if ($aData->paypal_handle == "1") { ?>

                                                                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="display: contents;">
                                                                        <!-- Identify your business so that you can collect the payments. -->
                                                                        <input type="hidden" name="business" value="<?php echo $paypalid; ?>">

                                                                        <!-- Specify a Buy Now button. -->
                                                                        <input type="hidden" name="cmd" value="_xclick">

                                                                        <!-- Specify details about the item that buyers will purchase. -->
                                                                        <input type="hidden" name="item_name" value="sale">
                                                                        <!-- <input type="hidden" name="item_number" value="<?php echo $row['id']; ?>"> -->
                                                                        <input type="hidden" name="amount" value="<?php echo $Total_price; ?>">
                                                                        <input type="hidden" name="currency_code" value="USD">

                                                                        <!-- Specify URLs -->
                                                                        <input type="hidden" name="return" value="invo.php">
                                                                        <input type="hidden" name="cancel_return" value="invo.php">

                                                                        <!-- Display the payment button. -->
                                                                        <button type="submit" name="submit" class="btn btn-success pull-right" border="0" style="margin-left:20px"><i class="fa fa-credit-card"></i> Pay Via Paypal</button>
                                                                    </form>
                                                                <?php
                                                                }
                                                                ?>
                                                                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" style="display: none;">

                                                                    <!-- <select name="amount">
                                <option value="3.99">6 Months ($3.99)</option>
                                <option value="5.99">12 Months ($5.99)</option>

                                </select> -->
                                                                    <input name="amount" type="hidden" value="<?php echo $Total_price; ?>">
                                                                    <br>
                                                                    <input name="currency_code" type="hidden" value="USD">
                                                                    <input name="shipping" type="hidden" value="0.00">
                                                                    <input name="tax" type="hidden" value="0.00">
                                                                    <input name="return" type="hidden" value="invo.php">
                                                                    <input name="cancel_return" type="hidden" value="invo.php">
                                                                    <input name="notify_url" type="hidden" value="invo.php">
                                                                    <input name="cmd" type="hidden" value="_xclick">
                                                                    <input name="business" type="hidden" value="<?php echo  $paypalid ?>">
                                                                    <input name="item_name" type="hidden" value="sale">
                                                                    <input name="no_note" type="hidden" value="1">
                                                                    <input type="hidden" name="no_shipping" value="1">
                                                                    <input name="lc" type="hidden" value="EN">
                                                                    <input name="bn" type="hidden" value="PP-BuyNowBF">
                                                                    <input name="custom" type="hidden" value="custom data">

                                                                    <button type="submit" border="0" name="submit" value=' ' class="btn btn-success pull-right" style="margin-left:20px"><i class="fa fa-credit-card"></i> Pay Via Paypal</button>
                                                                    <!-- <img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1"> -->

                                                                </form>
                                                                <?php if ($aData->stripe_handle == "1") { ?>
                                                                    <a target="_blank" href="https://merchantcouriers.com/invoice-admin.php?orderD=<?= $order_number; ?>&amount=<?= $Total_price; ?>"><button class="btn btn-success pull-right" style="width: 150px;margin-left: 20px;" onclick="pay(<?php echo $Total_price; ?>)">
                                                                            <i class="fa fa-credit-card"></i> Pay Via Stripe</button>
                                                                    </a>
                                                                <?php
                                                                }
                                                                if ($aData->paynow_handle == "1") {
                                                                ?>
                                                                    <a target="_blank" href="https://merchantcouriers.com/paynow.php?orderD=<?= $order_number; ?>&amount=<?= $Total_price; ?>&ref=invoice"><button class="btn btn-success pull-right" style="width: 150px;" onclick="pay(<?php echo $Total_price; ?>)">
                                                                            <i class="fa fa-credit-card"></i> Pay Via PayNow</button>
                                                                    </a>
                                                                <?php
                                                                } ?>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </section><!-- /.content -->
                                                <!-- /.table-responsive -->
                                            </div>
                                            <!-- /.col-lg-4 (nested) -->
                                            <!-- /.col-lg-8 (nested) -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>

                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-8 -->
                        </div>

                    </div>
                    <!-- /#wrapper -->

                    <!-- jQuery -->
                    <script src="../vendor/jquery/jquery.min.js"></script>

                    <!-- Bootstrap Core JavaScript -->
                    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

                    <!-- Metis Menu Plugin JavaScript -->
                    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

                    <!-- Morris Charts JavaScript -->
                    <script src="../vendor/raphael/raphael.min.js"></script>
                    <script src="../vendor/morrisjs/morris.min.js"></script>
                    <script src="../data/morris-data.js"></script>

                    <!-- Custom Theme JavaScript -->
                    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
