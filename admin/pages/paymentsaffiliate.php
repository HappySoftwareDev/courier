<?php require ("login-securityaffiliate.php"); ?>

<?php require ("get-sql-value.php");
?>
<?php

$loginFormAction = $_SERVER['PHP_SELF'];
// *** Redirect if username exists
$MM_flag = "MM_insert";
if (isset($_POST[$MM_flag])) {
    $MM_dupKeyRedirect = "signup.php";
    $loginUsername = $_POST['email'];
    $LoginRS__query = sprintf("SELECT email FROM affilate_user WHERE email=%s", GetSQLValueString($loginUsername, "text"));
    mysql_select_db($database_Connect, $Connect);
    $LoginRS = mysql_query($LoginRS__query, $Connect) or die(mysql_error());
    $loginFoundUser = mysql_num_rows($LoginRS);

    //if there is a row in the database, the username was found - can not add the requested username
    if ($loginFoundUser) {
        echo "<span style='color:red'>Email is taken go back and try a different email.</span>";
        return false;
    }
}

if (isset($_POST['affiliate_no'])) {
    $coni = @mysqli_connect("localhost", "merchant_admin", "}{kTftfu1449", "merchant_db");
    $affialte_no = $_POST['affiliate_no'];
    $getz = "SELECT * FROM affilate_user WHERE affialte_no='$affialte_no'";
    $run = mysqli_query($coni, $getz);
    while ($row_price = mysqli_fetch_array($run)) {
        $balance = $row_price['balance'];
        $amount = $_POST['amount'];

        $e = $balance - $amount;
    }
    if ($amount > $balance) {
        echo "<script>alert('You cannot request more than your balance!')</script>";
        echo "<script>window.open('payments.php','_self')</script>";
        return false;
    } else {
        $update = "UPDATE affilate_user SET balance='$e' WHERE affialte_no='$affialte_no'";
        mysql_select_db($database_Connect, $Connect);
        $Result1 = mysql_query($update, $Connect) or die(mysql_error());

        $insertSQL = sprintf(
            "INSERT INTO `affiliate_payouts`(`affiliate_no`, `amount`, `order_id`, `payment_method`) VALUES (%s, %s, %s, %s)",
            GetSQLValueString($_POST['affiliate_no'], "text"),
            GetSQLValueString($_POST['amount'], "text"),
            GetSQLValueString($_POST['order_id'], "text"),
            GetSQLValueString($_POST['payment_methods'], "text")
        );

        mysql_select_db($database_Connect, $Connect);
        $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

        $get = "SELECT * FROM `payment_methods` WHERE affiliate_no='$affialte_no'";

        $run = mysqli_query($coni, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $bank_acc = $row_type['bank_acc'];
            $bank_acc_name = $row_type['bank_acc_name'];
            $bank_name = $row_type['bank_name'];
            $ecocash_num = $row_type['ecocash_num'];
            $branch = $row_type['branch'];
            $affiliate_no = $row_type['affialte_no'];
        }

        $subject = "Payment Request";
        $name = $_POST['name'];
        $amount = $_POST['amount'];
        $payment_methods = $_POST['payment_methods'];
        $email_to = "merchantcouriers1@gmail.com";
        $show = "";
        if ($payment_methods == "BANK TRANSFER") {

            $show = "<p><b>Account No:</b> $bank_acc</p>
              <p><b>Account Name:</b> $bank_acc_name</p>
              <p><b>Bank Name:</b> $bank_name</p>
              <p><b>Branch:</b> $branch</p>
      ";
        } else if ($payment_methods == "ECOCASH") {
            $show = "<p><b>Ecocash No:</b> $ecocash_num</p>
               <p><b>Ecocash Name:</b> $bank_acc_name</p>";
        }

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
	     ' . $name . ' is requesting a payment
		</p>
		<h3><b>Amount:</b> $' . $amount . '</h3>
		<p><b>Payment method:</b> ' . $payment_methods . '</p>
		' . $show . '
       <h3> Click <a href="https://www.merchantcouriers.co.zw/admin/">here</a> to see more details. </h3>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.co.zw. Alternatively you can call/whatsapp on +263772467352 or +263779495409. <br/>
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
        $headers .= 'From: Merchant Couriers<billing@merchantcouriers.co.zw>' . "\r\n";
        $headers .= 'Bcc: bamhara1@gmail.com' . "\r\n";
        // Send email
        if (mail($email_to, $subject, $htmlContent, $headers)) :
            $successMsg = 'Email has sent successfully.';
        else :
            $errorMsg = 'Email sending fail.';
        endif;

        $subject2 = "Payment Request";
        $affiliate_email = $_POST['email_aff'];
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
	     Hello ' . $name . '
	     </p>
	     <p>
	     You sent a payment request of <b>$' . $amount . '</b> your payment is being processed you will recieve your payment within 48hrs.
		</p>
		<p>Your remaining balance is <b>$' . $e . '</b></p>

       <h3> Click <a href="https://www.merchantcouriers.co.zw/affiliate.user/"><b>View details</b></a> to see more details.</h3>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.co.zw. Alternatively you can call/whatsapp on +263772467352 or +263779495409. <br/>
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
        $headers .= 'From: Merchant Couriers<registrations@merchantcouriers.co.zw>' . "\r\n";
        $headers .= 'Bcc: bamhara1@gmail.com' . "\r\n";

        // Send email
        if (mail($affiliate_email, $subject2, $htmlContent2, $headers)) :
            $successMsg = 'Email has sent successfully.';
        else :
            $errorMsg = 'Email sending fail.';
        endif;

        $insertGoTo = "login.php";
        if ($insertGoTo) {
            echo "<script>alert('Request sent!')</script>";
            echo "<script>window.open('payments.php','_self')</script>";
        } else {
            echo "<script>alert('error!')</script>";
        }
    }
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

    <title>Merchant Couriers - Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

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
    <?php
    $user = $_SESSION['affilate_Username'];

    $get = "SELECT * FROM `affilate_user` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['id'];
        $Name = $row_type['name'];
        $Email = $row_type['email'];
        $phone = $row_type['phone'];
        $affialte_no = $row_type['affialte_no'];
    }

    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="text-center">
                        <a href="index.php"> <img src="../../images/logo.png" width="200px" alt=" Logo" /></a>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <center><b>Request Payment</b></center>
                        </h3>
                    </div>
                    <div class="panel-body">

                        <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" role="form" name="adminlogin">
                            <fieldset>
                                <div class="form-group">
                                    <select class="form-control" placeholder="Payment Methods" name="payment_methods" type="text" autofocus>
                                        <option>ECOCASH</option>
                                        <option>BANK TRANSFER</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Withdrawal Amount" name="amount" type="text">
                                    <input class="form-control" name="affiliate_no" value="<?php echo $affialte_no; ?>" type="hidden">
                                    <input class="form-control" name="name" value="<?php echo $Name; ?>" type="hidden">
                                    <input class="form-control" name="email_aff" value="<?php echo $Email; ?>" type="hidden">

                                    <?php
                                    $getz = "SELECT * FROM bookings WHERE affiliate_no='$affialte_no'";

                                    $run = mysqli_query($Connect, $getz);
                                    while ($row_price = mysqli_fetch_array($run)) {
                                        $ID = $row_price['order_id'];
                                    }
                                    ?>
                                    <input class='form-control' placeholder='Withdrawal Amount' name='order_id' value='<?php echo $ID ?>' type='hidden'>

                                </div>
                                <p>Available amount to payment: $<?php getCountTotalSales(); ?></p>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-sm btn-success btn-block" value="Send Request">
                                <p />
                                <p><a href="integration.php" class="btn btn-sm btn-primary btn-block">Payment Details Edit</a>
                                    <p />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
