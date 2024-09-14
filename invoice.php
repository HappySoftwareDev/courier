<?php
error_reporting(0);
if (!isset($_SESSION)) session_start();
require("function.php");
// error_reporting(0);
if (isset($_GET['status'])) {
    if (isset($_SESSION['payment'])) {
        $aPayment = json_decode($_SESSION['payment']);
        if ($aPayment->status == true) {
            $sDetail = json_encode($aPayment->data);

            $sQuery = "update bookings set invoice='PAID',transaction_details='" . $sDetail . "' where order_number=" . $_GET['orderD'] . " ";
            // echo $sQuery;
            mysqli_query($Connect, $sQuery);
        }
        unset($_SESSION['payment']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Merchant Couriers - Invoice</title>

    <!-- Bootstrap Core CSS -->
    <link href="admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="admin/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="admin/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <?php

    if (isset($_GET['orderD'])) {

        $MrE = $_GET['orderD'];

        $get = "SELECT * FROM `bookings` WHERE order_number='$MrE' Limit 1";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['order_id'];
            $order_number = $row_type['order_number'];
            $Date = $row_type['Date'];
            $email_fro = $row_type['email'];
            $address = $row_type['pick_up_address'];
            $drop_address = $row_type['drop_address'];
            $name = $row_type['Name'];
            $invoicestatus = $row_type['invoice'];
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

            $details = "<tr>
                <td>$order_number</td>
				<td>$weight_of_package</td>
				<td>$package_quantity</li>
				<td>$value_of_package</td>
				<td>$insurance</td>
				<td>$type_of_transport</td>
				<td><h4 style='color:black;'>From</h4> $address <br/><br/>  <h4 style='color:black;'>TO</h4>$drop_address</td>
				<td>$$Total_price</td>
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

    <section Style="background-color:#193b50" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
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
                                        <button class="btn btn-primary pull-right" style="margin-right: 5px;"><?= $invoicestatus; ?></button>
                                    </section>

                                    <div class="pad margin no-print">
                                        <div id="token_response-fail" style="margin-bottom: 0!important;"></div>
                                        <div id="token_response-ok" style="margin-bottom: 0!important;">
                                            <div class="alert alert-info" style="margin-bottom: 0!important;">
                                                <i class="fa fa-info"></i>
                                                <b>Note:</b> This page has been enhanced for printing. Click the print button at the bottom of the invoice to print.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Main content -->
                                    <section class="content invoice">
                                        <!-- title row -->
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h2 class="page-header">
                                                    <img src="images/mlogo.png" alt="" class="col-lg-4">
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
                                                <b>Invoice #<?php echo $order_number; ?></b><br />
                                                <br />
                                                <b>Order ID:</b> <?php echo $order_number; ?>A<br />
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

                                                <a href="#"><img style="border: 0;width: 100%;" src="stripe.png" /></a>
                                                <a href="#"><img style="border: 0;width: 100%;" src="rtgs.png"></a>
                                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                                    PLEASE TAKE NOTE of the invoice number. This is your reference number when you make the payment on PayNow.
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
                                                <?php if (strtoupper($invoicestatus) == "UNPAID") { ?>
                                                    <a href="#"><button class="btn btn-success pull-right" style="width: 150px;margin-left: 20px;" onclick="pay(<?php echo $Total_price; ?>)">
                                                            <i class="fa fa-credit-card"></i> Pay Via Stripe</button>
                                                    </a>
                                                    <a href="paynow.php?orderD=<?= $order_number; ?>&amount=<?= $Total_price; ?>&ref=invoice"><button class="btn btn-success pull-right" style="width: 150px;" onclick="pay(<?php echo $Total_price; ?>)">
                                                            <i class="fa fa-credit-card"></i> Pay Via PayNow</button>
                                                    </a>
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

            <!-- jQuery -->
            <script src="admin/vendor/jquery/jquery.min.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="admin/vendor/bootstrap/js/bootstrap.min.js"></script>

            <!-- Metis Menu Plugin JavaScript -->
            <script src="admin/htdocs/vendor/metisMenu/metisMenu.min.js"></script>

            <!-- Custom Theme JavaScript -->
            <script src="admin/dist/js/sb-admin-2.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
            <script src="https://checkout.stripe.com/checkout.js"></script>

            <script type="text/javascript">
                function pay(amount) {
                    var handler = StripeCheckout.configure({
                        key: 'pk_test_i2DzNF04CcxQ6xVdJi7xEVDA', // your publisher key id
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
                                            window.location.href = "invoice.php?orderD=<?php echo $order_number; ?>&status=1";
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
