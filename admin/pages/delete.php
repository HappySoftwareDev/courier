
<?php include("function.php"); ?>
<?php
if (isset($_GET['delete'])) {

    $delete_cli = $_GET['delete'];

    $delet = "DELETE FROM `clients` WHERE `clients`.`client_id`='$delete_cli' ";

    $run_delete = mysqli_query($Connect, $delet);

    if ($delete_cli) {

        echo "<script>alert('User has been deleted')</script>";
        echo "<script>window.open('users.php','_self')</script>";
    }
}


if (isset($_GET['deleteOrder'])) {

    $delete_order = $_GET['deleteOrder'];

    $delet = "DELETE FROM `bookings` WHERE `bookings`.`order_id`='$delete_order' ";

    $run_delete = mysqli_query($Connect, $delet);

    if ($delete_order) {

        echo "<script>alert('Order deleted!')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    }
}


if (isset($_GET['CancelOrder'])) {

    $cancel_order = $_GET['CancelOrder'];
    $v = 'cancelled';
    $cancel = "UPDATE `bookings` SET `status`='$v' WHERE `order_id`='$cancel_order' ";

    $run_cancel = mysqli_query($Connect, $cancel);

    $s = "SELECT * FROM bookings WHERE `order_id`='$cancel_order'";
    $run = mysqli_query($Connect, $s);

    while ($row_type = mysqli_fetch_array($run)) {
        $email = $row_type['email'];
        $Name = $row_type['Name'];
        $order_number = $row_type['order_number'];


        if ($run) {


            $email_to = "bamhara1@gmail.com";
            $subject2 = "Order Cancelled";

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
		Hi' . $Name . '
	     Your order has been cancelled click the link below to see the invoice with your cancelation fee.
		</p>


       <h3> Click <a href="https://www.merchantcouriers.co.zw/cancelled_invo.php?cancelled=' . $order_number . '"><b>View Invoice</b></a> to see your invoice.</h3>

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
            $headers .= 'From: Merchant Couriers<orders@merchantcouriers.co.zw>' . "\r\n";
            $headers .= 'Bcc: bamhara1@gmail.com' . "\r\n";
            $headers .= 'Cc: merchantcouriers1@gmail.com' . "\r\n";

            // Send email
            if (mail($email_to, $subject2, $htmlContent2, $headers)) :
                $successMsg = 'Email has sent successfully.';
            else :
                $errorMsg = 'Email sending fail.';
            endif;

            echo "<script>alert('$Name Order has been cancelled!')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        }
    }
}


if (isset($_GET['RenewOrder'])) {

    $renew_order = $_GET['RenewOrder'];
    $r = 'new';
    $renew = "UPDATE `bookings` SET `status`='$r' WHERE `order_id`='$renew_order' ";

    $run_renew = mysqli_query($Connect, $renew);

    if ($renew) {

        echo "<script>alert('Order Renewed!')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    }
}


if (isset($_GET['deleteBus'])) {

    $delete_client = $_GET['deleteBus'];

    $delet = "DELETE FROM `businesspartners` WHERE `businesspartners`.`businessID`='$delete_client' ";

    $run_delete = mysqli_query($Connect, $delet);

    if ($run_delete) {

        echo "<script>alert('Client deleted!')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    }
}


if (isset($_GET['delete_blog'])) {

    $delete_blog = $_GET['delete_blog'];

    $delet = "DELETE FROM `blog` WHERE `blog`.`ID`='$delete_blog' ";

    $run_delete = mysqli_query($Connect, $delet);

    if ($run_delete) {

        echo "<script>alert('Blog has been deleted!')</script>";
        echo "<script>window.open('blog_edit.php','_self')</script>";
    }
}


if (isset($_GET['deleteAdUser'])) {

    $delete_user = $_GET['deleteAdUser'];

    $delet = "DELETE FROM `admin` WHERE `admin`.`ID`='$delete_user' ";

    $run_delete = mysqli_query($Connect, $delet);

    if ($delete_user) {

        echo "<script>alert('Admin User has been deleted')</script>";
        echo "<script>window.open('users.php','_self')</script>";
    }
}


if (isset($_GET['deleteDriver'])) {

    $delete_user = $_GET['deleteDriver'];

    $delet = "DELETE FROM `driver` WHERE `driver`.`driverID`='$delete_user' ";

    $run_delete = mysqli_query($Connect, $delet);

    if ($delete_user) {

        echo "<script>alert('Driver has been deleted')</script>";
        echo "<script>window.open('driver.php','_self')</script>";
    }
}


if (isset($_GET['deleteInvitation'])) {

    $delete_user = $_GET['deleteInvitation'];

    $delet = "DELETE FROM `invite` WHERE `invite`.`id`='$delete_user' ";

    $run_delete = mysqli_query($Connect, $delet);

    if ($delete_user) {

        echo "<script>alert('Invitation deleted')</script>";
        echo "<script>window.open('invite.php','_self')</script>";
    }
}


if (isset($_GET['revokeDriver'])) {

    $delete_user = $_GET['revokeDriver'];

    $sel = "SELECT username FROM `driver` WHERE driverID ='$delete_user'";

    $info = "blocked";
    $off = "offline";

    $sel = "SELECT username FROM `driver` WHERE driverID ='$delete_user'";
    $run = mysqli_query($Connect, $sel);

    while ($row_type = mysqli_fetch_array($run)) {
        $Name = $row_type['username'];

        $usern = "(blocked)" . $Name;

        $delet = "UPDATE `driver` SET `info`= '$info', `online`='$off', `username`='$usern', username_backup='$Name' WHERE driverID ='$delete_user' ";

        $run_delete = mysqli_query($Connect, $delet);

        if ($delete_user) {

            echo "<script>alert('Driver has been revoked')</script>";
            echo "<script>window.open('driver.php','_self')</script>";
        }
    }
}


if (isset($_GET['unblockDriver'])) {

    $delete_user = $_GET['unblockDriver'];

    $info = "unblocked";
    $off = "offline";

    $sel = "SELECT * FROM `driver` WHERE driverID ='$delete_user'";
    $run = mysqli_query($Connect, $sel);

    while ($row_type = mysqli_fetch_array($run)) {
        $Name = $row_type['username'];
        $username_backup = $row_type['username_backup'];

        $delet = "UPDATE `driver` SET `info`= '$info', `online`='$off', `username`='$username_backup' WHERE driverID ='$delete_user' ";

        $run_delete = mysqli_query($Connect, $delet);

        if ($delete_user) {

            echo "<script>alert('Driver has been unblocked')</script>";
            echo "<script>window.open('driver.php','_self')</script>";
        }
    }
}



if (isset($_GET['unblock_sub'])) {

    $delete_user = $_GET['unblock_sub'];

    $sel = "SELECT * FROM `businesspartners` WHERE businessName ='$delete_user'";
    $run = mysqli_query($Connect, $sel);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['businessID'];
        $email = $row_type['email'];
        $address = $row_type['pick_up_address'];
        $PersonPhone = $row_type['PersonPhone'];
        $NameOfContact = $row_type['NameOfContact'];
        $businessName = $row_type['businessName'];
        $phone = $row_type['phone'];
        $password = $row_type['password'];
    }

    $date = date("Y-m-d");

    $delet = "UPDATE `users` SET `date`='$date', `days`='30', Name='$businessName', email='$email', phone='$phone', password='$password' WHERE Name ='$delete_user' ";

    $run_delete = mysqli_query($Connect, $delet);

    if ($delete_user) {

        echo "<script>alert('User has been unblocked')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    }
}



if (isset($_GET['block_sub'])) {

    $delete_user = $_GET['block_sub'];

    $date = date("Y-m-d");

    $delet = "UPDATE `users` SET `date`='$date', `days`='0', email='k4!2#@;k', password='k4!2#@;k' WHERE Name ='$delete_user' ";

    $run_delete = mysqli_query($Connect, $delet);

    if ($delete_user) {

        echo "<script>alert('User has been blocked!')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    }
}

if (isset($_GET['block_aff'])) {

    $block_aff = $_GET['block_aff'];

    $get = "SELECT * FROM `affilate_user` WHERE `affialte_no`='$block_aff'";
    $run = mysqli_query($Connect, $get);
    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['id'];
        $password = $row_type['password'];
        $u = "b10ck3d";
    }
    $delet = "UPDATE `affilate_user` SET `password`='$u', reserve='$password' WHERE `affilate_user`.`affialte_no`='$block_aff' ";

    $run_delete = mysqli_query($Connect, $delet);

    if ($block_aff) {

        echo "<script>alert('Affiliate Blocked!')</script>";
        echo "<script>window.open('affiliate.php','_self')</script>";
    }
}

if (isset($_GET['unblock_aff'])) {

    $block_aff = $_GET['unblock_aff'];

    $get = "SELECT * FROM `affilate_user` WHERE `affialte_no`='$block_aff'";
    $run = mysqli_query($Connect, $get);
    while ($row_type = mysqli_fetch_array($run)) {
        $reserve = $row_type['reserve'];
    }
    $delet = "UPDATE `affilate_user` SET `password`='$reserve' WHERE `affilate_user`.`affialte_no`='$block_aff' ";

    $run_delete = mysqli_query($Connect, $delet);

    if ($block_aff) {

        echo "<script>alert('Affiliate Unblocked!')</script>";
        echo "<script>window.open('affiliate.php','_self')</script>";
    }
}

?>
