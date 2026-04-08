<?php include ('site_settings.php'); ?>

<?php require ("login-security.php");

require_once('../../config/bootstrap.php');
require_once('../../function.php'); 

require("function.php"); 

require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "invite")) {
    $insertSQL = sprintf(
        "INSERT INTO `driver_alerts`(`msg`, `subject`) VALUES (%s, %s)",
        GetSQLValueString($_POST['msg'], "text"),
        GetSQLValueString($_POST['subject'], "text")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

    $email_to = $_POST['email'];
    $msg = $_POST['msg'];

    $from = "registrations@<?php echo $web_url ?>";
    $subject2 = $_POST['subject'];

    $htmlContent2 = '
    <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title><?php echo $site_name ?></title>

    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00"><?php echo $site_name ?></h1>
        <h3></h3>
        <p>Hello</p>
		<p>
	     ' . $msg . '
		</p>
		<p>If you need help talk to us <a href="<?php echo $web_url ?>/contact-us.php">here.</p>
        
       <h3> Go to <a href="<?php echo $web_url ?>/driver/"><b>Dashboard.</b></a></h3>

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
    $headers .= 'From: <?php echo $site_name ?> <customerservice@' . $web_url .'>' . "\r\n";
    $headers .= 'Bcc:' . $email_to . "\r\n";

    // Send email
    mail(null, $subject2, $htmlContent2, $headers);


    echo "<script>alert('Alert sent!')</script>";
    echo "<script>window.open('driver_alerts.php','_self')</script>";

}

?>



<?php
if ((isset($_POST["MM_insert_sms"])) && ($_POST["MM_insert_sms"] == "invite_sms")) {
    $insertSQL = sprintf(
        "INSERT INTO `affiliate_msg`(`msg`, `subject`) VALUES (%s, %s)",
        GetSQLValueString($_POST['msg'], "text"),
        GetSQLValueString($_POST['subject'], "text")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

    $email_to = $_POST['email'];
    $msg = $_POST['msg'];

    $from = "registrations@<?php echo $web_url ?>";
    $subject2 = $_POST['subject'];

    // Send email
    mail(null, $subject2, $htmlContent2, $headers);

    $sms_phone = $_POST['phone'];
    $uname = "Business";
    $pwd = "Merchant2017";
    $id = "5cb7afb730f8fefe60780e67871c117f";
    $sms_msg = "$msg";
    $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

    $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    echo "<script>alert('Alert sent!')</script>";
    echo "<script>window.open('driver_alerts.php','_self')</script>";

}

?>


<!DOCTYPE html>
<html lang="en">

<head>


    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Driver Alerts</title>


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
                        <h1 class="page-header">Driver Alerts</h1>
                        <div class="row">
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <form role="form" method="POST" name="invite" action="driver_alerts.php">
                                    <div class="form-group">
                                        <p><span id="sent"></span></p>
                                        <p class="help-block">Send Email Alerts to Drivers.</p> <br />
                                        <label>Subject</label>
                                        <input type="text" class="form-control" name="subject" placeholder="Subject" required /><br />
                                        <input type="hidden" class="form-control" name="email" placeholder="Email" value="<?php
                                                                                                                            $get = "SELECT * FROM `driver` GROUP BY email LIMIT 50";
                                                                                                                            $stmt = $DB->prepare( $get);
                                                                                                                            foreach ($results as $1) {
                                                                                                                                $Email = $row_type['email'];

                                                                                                                                echo "$Email, ";
                                                                                                                            }
                                                                                                                            ?>" />
                                        <textarea class="form-control" rows="5" name="msg" placeholder="Message" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea><br />
                                        <input type="submit" name="invite" class="btn btn-primary btn-lg btn-block" value="Send Email">
                                        <input type="hidden" name="MM_insert" value="invite">
                                        <p class="help-block"> Send email alerts to all drivers here.</p>
                                    </div>
                                </form>
                                <hr />

                            </div>

                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <form role="form" method="POST" name="invite_sms" action="driver_alerts.php">
                                    <div class="form-group">
                                        <p><span id="sent"></span></p>
                                        <p class="help-block">Send SMS Alerts to Drivers.</p> <br />
                                        <label>Subject</label>
                                        <input type="text" class="form-control" name="subject" placeholder="Subject" required /><br />
                                        <input type="hidden" class="form-control" name="phone" placeholder="Email" value="<?php
                                                                                                                            $get = "SELECT * FROM `driver` ";
                                                                                                                            $stmt = $DB->prepare( $get);
                                                                                                                            foreach ($results as $1) {
                                                                                                                                $phone = $row_type['phone'];

                                                                                                                                echo $e = "$phone,";
                                                                                                                            }
                                                                                                                            ?>" />
                                        <textarea class="form-control" rows="5" name="msg" placeholder="Message" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea><br />
                                        <input type="submit" name="invite_sms" class="btn btn-warning btn-lg btn-block" value="Send SMS">
                                        <input type="hidden" name="MM_insert_sms" value="invite_sms">
                                        <p class="help-block"> Send sms alerts to all drivers here.</p>
                                    </div>
                                </form>
                                <hr />

                            </div>

                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Driver
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Email</th>
                                                        <th>Message</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php getDriverAlerts(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <?php
                            if (isset($_GET['delete_drAlert'])) {

                                $delete_alert = $_GET['delete_drAlert'];

                                $delet = "DELETE FROM `driver_alerts` WHERE `driver_alerts`.`id`='$delete_alert' ";

                                $stmt = $DB->prepare( $delet);

                                if ($delete_alert) {

                                    echo "<script>alert('Alert deleted')</script>";
                                    echo "<script>window.open('driver_alerts.php','_self')</script>";
                                }
                            }

                            ?>
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


