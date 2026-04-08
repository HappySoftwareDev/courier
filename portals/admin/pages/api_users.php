<?php include_once('db.php'); ?>

<?php require ("login-security.php"); ?>

<?php include ('site_settings.php'); ?>

<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "blogEditForm")) {
    $con_af = @mysqli_connect("localhost", "merchant_admin", "}{kTftfu1449", "merchant_db");
    $updateSQL = sprintf(
        "UPDATE `affiliate_payouts` SET `amount_paid`=%s,`status`=%s WHERE `affiliate_no`=%s",
        GetSQLValueString($_POST['amount'], "text"),
        GetSQLValueString($_POST['status'], "text"),
        GetSQLValueString($_POST['affiliate_no'], "text")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($updateSQL, $Connect) or die(mysql_error());

    $affialte_no = $_POST['affiliate_no'];
    $amount = $_POST['amount'];
    $get = "SELECT * FROM `affilate_user` WHERE affialte_no='$affialte_no'";
    $stmt = $DB->prepare( $get);
    foreach ($results as $1) {
        $Name = $row_type['name'];
        $aff_email = $row_type['email'];
    }

    $email_to = "<?php echo $bus_email ?>";

    $subject = "Payment Confirmation";
    $htmlContent2 = '
    <html>
    <head>
        <title><?php echo $site_name ?></title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00"><?php echo $site_name ?></h1>
        <h3></h3>
		<p>
	     Hello
	     </p>
	     <p>
	     This is a confirmation that ' . $Name . ' received a payment of $' . $amount . '
		</p>

       <h3> Go to <a href="<?php echo $site_name ?>/admin"><b>Dashboard.</b></a></h3>

		<footer>
		<div style="background-color:#CCC; padding:10px;">

		<p>For any further inquiries, please contact us via the contact page on our website <a href="http://<?php echo $web_url; ?>"><?php echo $web_url; ?></a>. Alternatively, you can call/WhatsApp on <b><?php echo $bus_phone; ?></b>.

        PLEASE DO NOT REPLY TO THIS EMAIL.
        </p>

		<h4 style="color:#FF8C00"><?php echo $site_name ?></h4>
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
    $headers .= 'From: Merchant Couriers<admin@' . $web_url . '>' . "\r\n";

    // Send email
    if (mail($email_to, $subject, $htmlContent2, $headers)) :
        $successMsg = 'Email has sent successfully.';
    else :
        $errorMsg = 'Email sending fail.';
    endif;

    $htmlContent = '
    <html>
    <head>
        <title><?php echo $site_name ?></title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00"><?php echo $site_name ?></h1>
        <h3></h3>
		<p>
	     Hello ' . $Name . '
	     </p>
	     <p>
	     This is a confirmation that you received a payment of $' . $amount . ' if you didn`t get any payment don`t hesitate to contact us.
		</p>

       <h3> Go to <a href="<?php echo $web_url ?>/affiliate.user/"><b>Dashboard.</b></a></h3>

		<footer>
		<div style="background-color:#CCC; padding:10px;">

		<p>For any further inquiries, please contact us via the contact page on our website <a href="http://<?php echo $web_url; ?>"><?php echo $web_url; ?></a>. Alternatively, you can call/WhatsApp on <b><?php echo $bus_phone; ?></b>.

        PLEASE DO NOT REPLY TO THIS EMAIL.
        </p>

		<h4 style="color:#FF8C00"><?php echo $site_name; ?></h4>
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
    $headers .= 'From: <?php echo $site_name; ?> <admin@' . $web_url . '>' . "\r\n";
    $headers .= 'Bcc: <customerservice@' . $web_url . '>' . "\r\n";

    // Send email
    if (mail($aff_email, $subject, $htmlContent, $headers)) :
        $successMsg = 'Email has sent successfully.';
    else :
        $errorMsg = 'Email sending fail.';
    endif;

    $updateGoTo = "affiliate.php";
    if ($updateGoTo) {
        echo "<script>alert('Payment status updated!')</script>";
        echo "<script>window.open('affiliate.php','_self')</script>";
    } else {
        echo "<script>alert('error!')</script>";
    }
}
?>
<?php require("function.php");

if (isset($_GET['ban']) && $_GET['ban'] !== "") {
    // var_dump('ededededed'); die;
    $id = $_GET['ban'];
    update_API_user($id, 'ban');
    header('Location:api_users.php');
}
if (isset($_GET['active']) && $_GET['active'] !== "") {
    $id = $_GET['active'];
    update_API_user($id, 'active');
    header('Location:api_users.php');
}

if (isset($_GET['del']) && $_GET['del'] !== "") {
    $id = $_GET['del'];
    delete_API_user($id);
    header('Location:api_users.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - eCommerce API Users</title>


</head>

<body>

    <div id="wrapper">

        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>
        
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Manage API Users</h1>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">

                    <div class="col-lg-4 col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-usd fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php getCountTotalAPIEarned(); ?></div>
                                        <div>Total Bookings</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <!--<span class="pull-left">Total Payouts</span>-->
                                    <!--<span class="pull-right"><i class="fa fa-usd"></i><?php getCountTotalAPIEarned(); ?></span>-->
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user-plus fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php getCountAPIUsers(); ?></div>
                                        <div>Total API Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="sellers.php">
                                <div class="panel-footer">
                                    <!--<span class="pull-left">View Details</span>-->
                                    <!--<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php getCountAPIUserOrders();  ?></div>
                                        <div>Total Orders!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="seller_orders.php?more=<?php echo $seller_email; ?>">
                                <div class="panel-footer">
                                    <!--<span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!--<div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php getCountAffilateClients(); ?></div>
                                    <div>Total Registered</div>
                                </div>
                            </div>
                        </div>
                        <a href="driver.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>-->
                    <!--<div class="col-lg-12 col-md-12">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-history fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div>Total Shares!</div>
                                    <div class="huge"><?php getCountAffilateShares();  ?></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>-->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                API Users
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive table-bordered">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Stores</th>
                                                <th>join date</th>
                                                <th>Orders</th>
                                                <!--<th>Balance</th>-->
                                                <th>Contact</th>
                                                <th>Address</th>
                                                <!-- <th>Request</th> -->
                                                <th>Action</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $data = getApiUsers(); ?>
                                            <?php //var_dump($data); 
                                            ?>
                                            <?php foreach ($data as $item) : ?>
                                                <?php
                                                $stores = getUserStores($item['id']);
                                                $orders = getUserorders($item['id']);
                                                ?>
                                                <tr>
                                                    <td><?= $item['business_name'] ?></td>
                                                    <td><?= $stores ?></td>
                                                    <td><?= $item['join_date'] ?></td>
                                                    <td><?= $orders ?></td>
                                                    <!--<td>Balance</td>-->
                                                    <td><?= $item['business_email'] ?>
                                                        <br>
                                                        <?= $item['business_phone'] ?>
                                                    </td>
                                                    <td><?= $item['address'] ?></td>
                                                    <td>
                                                        <?php
                                                        if ($item['status'] == 'active') :
                                                        ?>
                                                            <a href="api_users.php?ban=<?= $item['id'] ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ban this user?')">
                                                                <i class="fa fa-ban"></i>
                                                            </a>
                                                        <?php else : ?>
                                                            <a href="api_users.php?active=<?= $item['id'] ?>" class="btn btn-xs btn-success">
                                                                <i class="fa fa-check-circle"></i>
                                                            </a>
                                                        <?php endif; ?> |

                                                        <a href="api_users.php?del=<?= $item['id'] ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure delete this user?')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>

                                        </tbody>
                                    </table>

                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->

                        <?php
                        if (isset($_GET['block_aff'])) {

                            $block_aff = $_GET['block_aff'];

                            $get = "SELECT * FROM `affilate_user` WHERE `affialte_no`='$block_aff'";
                            $stmt = $DB->prepare( $get);
                            foreach ($results as $1) {
                                $ID = $row_type['id'];
                                $password = $row_type['password'];
                                $u = "b10ck3d";
                            }
                            $delet = "UPDATE `affilate_user` SET `password`='$u', reserve='$password' WHERE `affilate_user`.`affialte_no`='$block_aff' ";

                            $stmt = $DB->prepare( $delet);

                            if ($block_aff) {

                                echo "<script>alert('Affiliate Blocked!')</script>";
                                echo "<script>window.open('affiliate.php','_self')</script>";
                            }
                        }

                        if (isset($_GET['unblock_aff'])) {

                            $block_aff = $_GET['unblock_aff'];

                            $get = "SELECT * FROM `affilate_user` WHERE `affialte_no`='$block_aff'";
                            $stmt = $DB->prepare( $get);
                            foreach ($results as $1) {
                                $reserve = $row_type['reserve'];
                            }
                            $delet = "UPDATE `affilate_user` SET `password`='$reserve' WHERE `affilate_user`.`affialte_no`='$block_aff' ";

                            $stmt = $DB->prepare( $delet);

                            if ($block_aff) {

                                echo "<script>alert('Affiliate Unblocked!')</script>";
                                echo "<script>window.open('affiliate.php','_self')</script>";
                            }
                        }
                        ?>


                    </div>

                    <!-- /.col-lg-6 -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>




