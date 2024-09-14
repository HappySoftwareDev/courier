<?php require ("login-securityaffiliate.php"); ?>

<?php require ("get-sql-value.php");

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "invo_status")) {
    $updateSQL = sprintf(
        "UPDATE bookings SET invoice=%s WHERE order_id=%s",
        GetSQLValueString($_POST['invoice'], "text"),
        GetSQLValueString($_POST['id'], "int")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($updateSQL, $Connect) or die(mysql_error());

    $updateGoTo = "invo.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
}
?>
<?php
if (isset($_POST['MM_update'])) {

    $email_to = $_POST['clientEmail'];

    $email_subject = "Invoice from Merchant Couriers";

    $email_from = "orders@merchantcouriers.co.zw";
    $id = $_POST['id'];

    $email_message = "\n";



    function clean_string($string)
    {

        $bad = array("content-type", "bcc:", "to:", "cc:", "href");

        return str_replace($bad, "", $string);
    }
    $email_subject = "Delivery Booking Paid";
    $email_message .= "Thank You for using Merchant Couriers. \n\nYou have SUCCESSFULLY PAID for your order. Click the following link to see your paid invoice http://www.merchantcouriers.co.zw/Invoice2.php?orderD=$id. For any further inquiries please contact us via the contact page on our website www.merchantcouriers.co.zw. Alternatively you can call/whatsapp on +263779495409.\n\nAt Merchant Couriers We Deliver With Speed
PLEASE DO NOT REPLY TO THIS EMAIL.";

    $headers = 'From: ' . $email_from . "\r\n" .

        'Reply-To: ' . $email_from . "\r\n" .

        'X-Mailer: PHP/' . phpversion();

    @mail($email_to, $email_subject, $email_message, $headers);

?>

<?php
}
?>
<?php require("functionaffiliate.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
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
                            <a href="driver.php"><i class="fa fa-car fa-fw"></i> Drivers</a>
                        </li>
                        <li>
                            <a href="map.php"><i class="fa fa-map-marker fa-fw"></i> Map</a>
                        </li>
                        <li>
                            <a href="integration.php"><i class="fa fa-gear fa-fw"></i> Integration</a>
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
                                Email: admin@merchantcouriers.co.zw";

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
                                                        <small>#00<?php echo $ID; ?></small>
                                                    </h3>
                                                    <form method="POST" action="<?php echo $editFormAction; ?>" name="invo_status">
                                                        <input type="hidden" value="PAID" name="invoice">
                                                        <input type="hidden" value="<?php echo $email_fro; ?>" name="clientEmail">
                                                        <input type="hidden" value="<?php echo $ID; ?>" name="id">
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

                                                            <a href="https://www.paynow.co.zw/Payment/Link/?q=c2VhcmNoPWhhcHB5ZzIlNDBsaXZlLmNvbSZhbW91bnQ9MC4wMCZyZWZlcmVuY2U9Jmw9MA%3d%3d" target="_blank"><img style="border: 0;" src="https://www.paynow.co.zw/Content/Buttons/Medium_buttons/button_pay-now_medium.png" /></a>
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
                                                            <a href="https://www.paynow.co.zw/Payment/Link/?q=c2VhcmNoPWhhcHB5ZzIlNDBsaXZlLmNvbSZhbW91bnQ9MC4wMCZyZWZlcmVuY2U9Jmw9MA%3d%3d"><button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button> </a>

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
