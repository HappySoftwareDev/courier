<?php require_once('../../config/bootstrap.php'); require_once('../../function.php'); ?>

<?php require ("login-security.php"); ?>

<?php include ('site_settings.php'); ?>

<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "msgAdForm")) {
    $insertSQL = sprintf(
        "INSERT INTO contact_reply (Name, Email, phone, Subject, message, reply_id) VALUES (%s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['adName'], "text"),
        GetSQLValueString($_POST['email'], "text"),
        GetSQLValueString($_POST['phone'], "text"),
        GetSQLValueString($_POST['subject'], "text"),
        GetSQLValueString($_POST['message'], "text"),
        GetSQLValueString($_POST['reply_id'], "text")
    );


    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

    $CustomerName = $_POST['CustomerName'];
    $email = $_POST['customer_email'];
    $msg = $_POST['message'];
    $subject = $_POST['subject'];
    $to = $email;
    $from = "customerservice@<?php echo $web_url; ?>";

    $htmlContent = '
    <html>
    <head>
        <title><?php echo $site_name; ?></title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00"><?php echo $site_name; ?></h1>
        <h3>' . $subject . '</h3>
		<p>
		' . $msg . '
		</p>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.co.zw.
		Alternatively you can call/whatsapp on +263772467352. <br/>

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
    $headers .= 'From: <?php echo $site_name; ?><customerservice@' . $web_url . '>' . "\r\n";

    // Send email
    if (mail($to, $subject, $htmlContent, $headers)) :
        $successMsg = 'Email has sent successfully.';
    else :
        $errorMsg = 'Email sending fail.';
    endif;

    $uname = "Merchants";
    $pwd = "mer2017";
    $id = "Courie";
    $Key = "fuGAC57sJkWb9W56CoYhsw";
    $DCS = "0";
    $channel = "Normal";
    $flashsms = "0";
    $to = $_POST['phone'];
    $name = $_POST['CustomerName'];

    $message = $subject;

    $data = "user=" . $uname . "&password=" . $pwd . "&senderid=" . $id . "&channel=" . $channel . "&DCS=" . $DCS . "&flashsms=" . $flashsms . "&number=" . $to . "&text=" . $message;

    $ch = curl_init("http://www.bluedotsms.com/api/mt/SendSMS?");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    $backh = $_POST['reply_id'];

    $insertGoTo = "reply_message.php";
    if ($insertGoTo) {
        echo "<script>alert('Message sent!')</script>";
        echo "<script>window.open('reply_message.php?chatD=$backh','_self')</script>";
    } else {
        echo "<script>alert('error!')</script>";
    }
}
?>
<?php require("function.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Reply Driver Messages</title>



</head>

<body>

    <div id="wrapper">

        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Messages</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <?php
            if (isset($_GET['chatD'])) {
                $MrE = $_GET['chatD'];
                global $DB;

                $get = "SELECT * FROM `contacts` where ID = '$MrE'";

                $stmt = $DB->prepare( $get);

                foreach ($results as $1) {
                    $CustID = $row_type['ID'];
                    $Date = $row_type['Date'];
                    $Name = $row_type['Name'];
                    $Surname = $row_type['Subject'];
                    $customer_email = $row_type['Email'];
                    $phone = $row_type['phone'];
                    $msg = $row_type['message'];

                    $contact = "<li class='left clearfix'>
                                    <span class='chat-img pull-left'>
                                        <img src='http://placehold.it/50/55C1E7/fff' alt='User Avatar' class='img-circle' />
                                    </span>
                                    <div class='chat-body clearfix'>
                                        <div class='header'>
                                            <strong class='primary-font'>$Name </strong>
                                            <small class='pull-right text-muted'>
                                                <i class='fa fa-clock-o fa-fw'></i> $Date
                                            </small>
											<h4>$Surname<h4>
                                        </div>
                                        <p>
                                           $msg
										 <br><br>
										</p>
										<p><b>Tel:</b> $phone</p>
										<p>
                                           <b>E-mail:</b> <a href='$customer_email' target='_blank'>$customer_email</a>
										</p>

                                    </div>
                                </li>";
                }
            }

            ?>

            <?php
            if (isset($_GET['chatD'])) {
                $MrE = $_GET['chatD'];
                global $DB;

                $get = "SELECT * FROM `contact_reply` where reply_id = '$MrE'";

                $stmt = $DB->prepare( $get);

                foreach ($results as $1) {
                    $ID = $row_type['ID'];
                    $Date = $row_type['Date'];
                    $Name = $row_type['Name'];
                    $Surname = $row_type['Subject'];
                    $Email = $row_type['Email'];
                    $phone = $row_type['phone'];
                    $msg = $row_type['message'];

                    $contact_reply = "<li class='right clearfix'>
                                    <span class='chat-img pull-right'>
                                        <img src='http://placehold.it/50/FA6F57/fff' alt='User Avatar' class='img-circle' />
                                    </span>

                                    <div class='chat-body clearfix'>
                                        <div class='header'>
                                            <small class=' text-muted'>
                                                <i class='fa fa-clock-o fa-fw'></i>$Date</small>
                                            <strong class='pull-right primary-font'>$Name</strong>
                                            <h4>$Surname<h4>
                                        </div>
                                        <p>
                                          $msg
										 <br><br>
										</p>
										<p><b>Tel:</b> $phone</p>
										<p>
                                           <b>E-mail:</b> <a href='$Email' target='_blank'>$Email</a>
										</p>
                                    </div>
                                </li>";
                }
            }

            ?>

            <?php
            $user = $_SESSION['MM_Username'];
            $get = "SELECT * FROM `admin` where Email = '$user' ";

            $stmt = $DB->prepare( $get);

            foreach ($results as $1) {
                $AdID = $row_type['ID'];
                $AdName = $row_type['Name'];
                $AdEmail = $row_type['Email'];
                $Adphone = $row_type['phone'];
                $Adpass = $row_type['Password'];
            }
            ?>

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <!-- /.panel -->
                    <div class="chat-panel panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i> Messages From Drivers
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-chevron-down"></i>
                                </button>

                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="chat">
                                <?php echo $contact; ?>
                                <?php echo $contact_reply; ?>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <form action="<?php echo $editFormAction; ?>" method="POST" name="msgAdForm">
                                <input type="text" class="form-control" placeholder="Subject" name="subject" required><br />
                                <div class="input-group">
                                    <textarea id="btn-input" type="text" name="message" class="form-control input-sm" placeholder="Type your message here..."></textarea>
                                    <input type="hidden" name="reply_id" value="<?php echo $CustID; ?>">
                                    <input type="hidden" name="adName" value="<?php echo $AdName; ?>">
                                    <input type="hidden" name="email" value="<?php echo $AdEmail; ?>">
                                    <input type="hidden" name="customer_email" value="<?php echo $customer_email; ?>">
                                    <input type="hidden" name="phone" value="<?php echo $Adphone; ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-warning btn-lg" type="submit" id="btn-chat">Send</button>
                                </div>
                                <input type="hidden" name="MM_insert" value="msgAdForm">
                            </form>
                            </span>
                        </div>
                        <!-- /.panel-footer -->
                    </div>
                </div>
                <!-- /.panel -->

                <!-- /.panel -->

                <!-- /.col-lg-8 -->


                <div class="col-lg-6">

                    <!-- /.panel -->
                    <div class="chat-panel panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i> Messages
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-chevron-down"></i>
                                </button>

                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="chat">
                                <?php getContacts(); ?>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">

                        </div>
                        <!-- /.panel-footer -->
                    </div>
                    <!-- /.panel .chat-panel -->
                </div>


                <!-- /.row -->

                <!-- /#page-wrapper -->

            </div>
            <!-- /#wrapper -->

        <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>


