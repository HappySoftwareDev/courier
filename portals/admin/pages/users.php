<?php require ("login-security.php"); ?>

<?php require ("function.php"); ?>

<?php include ('site_settings.php'); ?>


<?php

if (isset($_POST['invite'])) {
    // Retrieve the email from the form input
    $to = $_POST['email'];

    // Ensure $web_url, $site_name, and $bus_phone are defined
    $from = "registrations@" . $web_url;

    // Use the provided HTML template for the email content
    $message = '
        <html>
            <head>
                <title>' . $site_name . '</title>
            </head>
            <body>
                <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                    <h1 style="color:#FF8C00">' . $site_name . '</h1>
                    <h3>Invitation to Become an Admin</h3>
                    <p>Hello, you have been invited to become an Admin at <strong>' . $site_name . '</strong>.</p>
                    
                    <p><a href="http://' . $web_url . '/admin/pages/adiminUsers.php" style="color:#FF8C00;"><strong>Proceed to Admin Invitation</strong></a></p>

                    <footer>
                        <div style="background-color:#CCC; padding:10px;">
                            <p>For inquiries, visit <a href="http://' . $web_url . '">' . $web_url . '</a>. Call/WhatsApp <b>' . $bus_phone . '</b>.</p>
                            <p>If you do not understand this email,are note the intended recipient of it, feel free to ignore and delete it. Otherwise, click the link above to proceed:</p>
                            <p>PLEASE DO NOT REPLY TO THIS EMAIL.</p>
                            <h4 style="color:#FF8C00">' . $site_name . '</h4>
                        </div>
                    </footer>
                </div>
            </body>
        </html>
    ';

    // Set up headers for the email with MIME type for HTML
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $from . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    // Send the email and check the result
    if (mail($to, "Admin Invitation", $message, $headers)) {
        echo "<script>alert('Email sent successfully!');</script>";
    } else {
        echo "<script>alert('Failed to send email. Please check your configuration.');</script>";
    }

    if ($to != "") {
        // Check if the email already exists in the database
        $get = "SELECT * FROM `admin` WHERE Email='$to'";
        $stmt = $DB->prepare( $get);

        foreach ($results as $1) {
            // Retrieve the push token from the database
            $push_token = $row_type['push_token'];
            
            if ($push_token != "") {
                // Prepare and send a push notification if the push token exists
                $title = $site_name;
                $msg = "Hello, you have been invited to become an Admin at " . $site_name;
                $page = "adiminUsers.php";

                // Open a new window with the push notification details
                echo "<script>window.open('../../web_push/send_notification.php?title=$title&message=$msg&token=$push_token&page=$page', '_self');</script>";
            }
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Admin Users</title>


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
                        <h1 class="page-header">Admin Users</h1>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Current Admin Users
                                    </div>
                                    <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Full Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php getUsers(); ?>
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
                                <form role="form" method="POST" action="users.php">
                                    <div class="form-group">
                                        <p><span id="sent"></span></p>
                                        <p class="help-block">Invite a new user to manage this admin dashboard.</p> <br />
                                        <label>Email</label>
                                        <input class="form-control" name="email" placeholder="Email" required><br />
                                        <input type="submit" name="invite" class="btn btn-primary btn-lg btn-block" value="Send Invitation">
                                        <p class="help-block">Only adminstrators are to be added here.</p>
                                    </div>
                                </form>
                                <a href="adiminUsers.php"><button type="button" class="btn btn-primary btn-lg btn-block">Add user</button></a>
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


