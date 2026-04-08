<?php 
require_once '../../config/bootstrap.php';

error_reporting(0);
if (!isset($_SESSION)) session_start();
require_once('../../function.php');
// Updated to use new bootstrap system

if (isset($_GET['status'])) {
    if (isset($_SESSION['payment'])) {
        $aPayment = json_decode($_SESSION['payment']);
        if ($aPayment->status == true) {
            $sDetail = json_encode($aPayment->data);

            // Use PDO instead of MySQLi
            $sQuery = "UPDATE bookings SET invoice=?, transaction_details=? WHERE order_number=?";
            $stmt = $DB->prepare($sQuery);
            $stmt->execute(['PAID', $sDetail, $_GET['orderD']]);
        }
        unset($_SESSION['payment']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include common meta and links -->
    <?php include '../../head.php'; ?>

    <title><?php echo $site_name ?> - Invoice</title>


</head>

<body>
    <?php

    if (isset($_GET['orderD'])) {

        $MrE = $_GET['orderD'];

        $get = "SELECT * FROM `bookings` WHERE order_number = ? LIMIT 1";
        $stmt = $DB->prepare($get);
        $stmt->execute([$MrE]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row_type) {
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

            $MC = "    Address: <?php echo $bus_address ?><br>
                                Phone: <?php echo $bus_phone ?><br/>
                                Email: admin@<?php echo $web_url ?>";

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

            <!-- Include footer template scripts -->
            <?php include '../../footer-template-scripts.php'; ?>

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
                                url: "../payments/stripe/payment.php",
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
                        name: '<?php echo $web_url ?>',
                        description: 'enter your card details',
                        amount: amount * 100
                    });
                }
            </script>

</body>

</html>


