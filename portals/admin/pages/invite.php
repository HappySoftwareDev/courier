<?php
include('login-security.php');
include('site_settings.php');

require_once('../../config/bootstrap.php');
require_once('../../function.php');
require('function.php');

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "invite")) {
    $email = trim($_POST['email']);
    $msg = trim($_POST['msg']);

    // Use PDO prepared statement
    try {
        $stmt = $DB->prepare("INSERT INTO invite (email, msg) VALUES (?, ?)");
        if ($stmt->execute([$email, $msg])) {
        // Sending email
        $email_to = $email;
        $subject2 = "You Are Being Invited";
        $from = "registrations@" . $web_url;

        $htmlContent2 = "<html>
        <head>
            <title>$site_name</title>
        </head>
        <body>
        <div style='font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; '>
            <h1 style='color:#FF8C00'>$site_name</h1>
            <p>Hello,</p>
            <p>$msg</p>
            <h3>Visit <a href='https://$web_url'><b>$web_url</b></a> and sign up.</h3>
            <footer>
                <div style='background-color:#CCC; padding:10px;'>
                    <p>For any further inquiries, please contact us via the contact page on our website <a href='http://$web_url'>$web_url</a>. Alternatively, you can call/WhatsApp on <b>$bus_phone</b>.</p>
                    <p>PLEASE DO NOT REPLY TO THIS EMAIL.</p>
                    <h4 style='color:#FF8C00'>$site_name</h4>
                </div>
            </footer>
        </div>
        </body>
        </html>";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: $site_name <$from>" . "\r\n";

        // Send email
        if (mail($email_to, $subject2, $htmlContent2, $headers)) {
            echo "<script>alert('Invitation sent!')</script>";
        } else {
            echo "<script>alert('Failed to send email.')</script>";
        }

        // Redirect for notification
        $title = "$site_name";
        $notification_msg = "You Are Being Invited to try $site_name";
        $page = "invite.php";
        echo "<script>window.open('../../web_push/send_notification.php?title=$title&message=$notification_msg&token=$push_token&page=$page','_self')</script>";
    } else {
        echo "<script>alert('Failed to save invitation.')</script>";
    }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "')</script>";
    }
}

// No need to close $Connect here as it is global and might be reused elsewhere
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Invite Clients</title>

    

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
                        <h1 class="page-header">Invitations</h1>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Invited People
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
                                                    <?php getInvited(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>
                                <!-- /.panel -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <form role="form" method="POST" name="invite" action="invite.php">
                                    <div class="form-group">
                                        <p><span id="sent"></span></p>
                                        <p class="help-block">Invite a new Customers & Drivers to register.</p> <br />
                                        <label>Email</label>
                                        <input class="form-control" name="email" placeholder="Email" required><br />
                                        <textarea class="form-control" rows="5" name="msg" placeholder="Message" required></textarea><br />
                                        <input type="submit" name="invite" class="btn btn-primary btn-lg btn-block" value="Send Invitation">
                                        <input type="hidden" name="MM_insert" value="invite">
                                        <p class="help-block"> Invited Customers & Drivers here.</p>
                                    </div>
                                </form>
                                <hr />

                            </div>

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


