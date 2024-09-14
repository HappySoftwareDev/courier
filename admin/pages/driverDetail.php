<?php

require_once('db.php');

<?php require ("login-security.php"); ?>

<?php
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "driverUploadDoc")) {
    $fullname = $_POST['fullname'];
    $email_2 = $_POST['email_2'];
    $driver_number = $_POST['driver_number'];
    $name_array = $_FILES['documents']['name'];
    $tmp_name_array = $_FILES['documents']['tmp_name'];
    $type_array = $_FILES['documents']['type'];
    $size_array = $_FILES['documents']['size'];
    $userNa = $_POST['fullname'];
    $desired_dir = "../../driver_documents/" . $userNa;

    if (is_dir($desired_dir) == false) {
        mkdir("$desired_dir", 0700);
        if (is_dir("$desired_dir/" . $userNa) == false) {
            move_uploaded_file($tmp_name_array[$i], "$desired_dir/" . $name_array);
        } else {
            rename($tmp_name_array[$i], "$desired_dir/" . $name_array[$i]);

            # rename can move the file along with renaming it
        }
    }

    try {

        $stmt = $Connect->prepare("SELECT * FROM driver WHERE email=:email_2");
        $stmt->execute(array(":email_2" => $email_2));
        $count = $stmt->rowCount();
        if ($count == "1") {
            move_uploaded_file($tmp_name_array, "$desired_dir/" . $name_array);
            $stmt = $Connect->prepare("INSERT INTO `driver_doc`(`DriverName`, `email`, `documents`)VALUES (:fullname, :email, '$name_array')");

            $stmt->bindparam(":fullname", $fullname);
            $stmt->bindparam(":email", $email_2);


            //check if query executes
            if ($stmt->execute()) {
                echo "<script>alert('Upload Successful.')</script>";
                echo "<script>window.open('driverDetail.php?detail=$driver_number','_self')</script>";
            } else {

                echo "<script>alert('username is taken go back and try a different name')</script>";
            }
        } //end of integrity check

        else {
            echo "Upload failed error 1"; // user email is taken
        }
    } // end of try block

    catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
<?php
if (isset($_POST['email'])) {
    $driverID = $_POST['driverID'];
    $note = $_POST['note'];
    $to = $_POST['email'];
    $driver_phone = $_POST['phone'];
    $driver_name = $_POST['name'];

    $subject2 = "Invitation To Drive With Merchant Couriers";

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
	     Hello ' . $driver_name . ' thank you for registering to become a driver at Merchant Couriers.
		</p>
		<p>' . $note . '</p>

       <h3>Your registration was approved click <a href=https://www.merchantcouriers.com/admin/pages/addDriver.php?approvedDriver=' . $driverID . '"><b>this link</b></a> to complete your registration.</h3>

       <p>If you didn`t sign-up to become a driver ignore this email.</p>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.com. Alternatively you can call/whatsapp on +263772467352 or +263779495409. <br/>
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
    $headers .= 'From: Merchant Couriers<registrations@merchantcouriers.com>' . "\r\n";

    // Send email
    if (mail($to, $subject2, $htmlContent2, $headers)) :
        $successMsg = 'Email has sent successfully.';
    else :
        $errorMsg = 'Email sending fail.';
    endif;

    $sms_phone = $driver_phone;
    $uname = "Business";
    $pwd = "Merchant2017";
    $id = "5cb7afb730f8fefe60780e67871c117f";
    $sms_msg = "Hey $driver_name thank you for registering to become a driver at Merchant Couriers. Your registration was approved check your email to complete the registration.";
    $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

    $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    echo "<script>alert('Invitation sent!')</script>";
    echo "<script>window.open('driver.php','_self')</script>";
}
?>

<?php require("function.php"); ?>
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

                        <?php getChatAlert(); ?>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="message.php">
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
                            <a href="invite.php"><i class="fa fa-users fa-fw"></i> Invite</a>
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
                        <li>
                            <a href="blog.php"><i class="fa fa-list fa-fw"></i> Blog</a>
                        </li>
                        <li>
                            <a href="affiliate.php"><i class="fa fa-bullhorn fa-fw"></i> Affiliate</a>
                        </li>
                        <li class="">
                            <a href="coupons.php"><i class="fa fa-gear fa-fw"></i> coupons</a>
                        </li>
                        <li class="">
                            <a href="usercoupon.php"><i class="fa fa-gear fa-fw"></i> All Users coupons</a>
                        </li>
                        <li class="">
                            <a href="commoncoupon.php"><i class="fa fa-gear fa-fw"></i> Common coupons</a>
                        </li>
                        <li>
                            <a href="affiliate.msg.php"><i class="glyphicon glyphicon-question-sign fa-fw"></i> Affiliate Help</a>
                        </li>
                        <li>
                            <a href="customer_alerts.php"><i class="fa fa-bell fa-fw"></i> Send Alerts</a>
                        </li>
                        <li>
                            <a href="api.php"><i class="fa fa-gear fa-fw"></i> API keys</a>
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
                    <h1 class="page-header">Driver Details</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <div class="list-group">
                                            <?php getDriverDetails(); ?>
                                            <?php getDriverDocs(); ?>
                                        </div>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>

                    <div>
                        <!-- /.panel -->

                    </div>

                    <!-- /.col-lg-8 -->

                    <!-- /.col-lg-4 -->

                </div>

                <?php
                if (isset($_GET['detail'])) {
                    $MrE = $_GET['detail'];
                    global $Connect;

                    $get = "SELECT * FROM `driver` where driver_number='$MrE' ";

                    $run = mysqli_query($Connect, $get);

                    while ($row_type = mysqli_fetch_array($run)) {
                        $ID = $row_type['driverID'];
                        $driver_number = $row_type['driver_number'];
                        $Name = $row_type['name'];
                        $phone = $row_type['phone'];
                        $email = $row_type['email'];
                        $address = $row_type['address'];
                        $mode_of_transport = $row_type['mode_of_transport'];
                        $vehicleMake = $row_type['vehicleMake'];
                        $model = $row_type['model'];
                        $year = $row_type['year'];
                        $engineCapacity = $row_type['engineCapacity'];
                        $dob = $row_type['DOB'];
                        $occupation = $row_type['occupation'];
                        $regNo = $row_type['RegNo'];
                        $username = $row_type['username'];
                        $online = $row_type['online'];
                        $profileImage = $row_type['profileImage'];

                        $display = "none";
                        if ($username == "pending") {
                            $display = "block";
                        }
                    }
                }

                ?>

                <div class="col-lg-4" style="display:<?php echo $display; ?>">
                    <form role="form" method="POST" action="driverDetail.php" name="driverinv">
                        <div class="form-group">
                            <p><span id="sent"></span></p>
                            <h4 class="help-block">Invite a new driver.</h4> <br />
                            <label>Email</label>
                            <input class="form-control" type="text" name="email" value="<?php echo $email; ?>" placeholder="Email" required><br />
                            <textarea class="form-control" rows="3" type="text" name="note" placeholder="invitation note" required></textarea><br />
                            <input class="form-control" type="hidden" name="driverID" value="<?php echo $driver_number; ?>" placeholder="Driver ID" required>
                            <input class="form-control" type="hidden" name="phone" value="<?php echo $phone; ?>" placeholder="Driver ID" required>
                            <input class="form-control" type="hidden" name="name" value="<?php echo $Name; ?>" placeholder="Driver ID" required>
                            <input type="submit" name="sendinv" class="btn btn-primary btn-lg btn-block" value="Invite Drivers">
                            <p class="help-block">Only approved drivers are to be invited here.</p>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <form method="POST" action="driverDetail.php" enctype="multipart/form-data" name="driverUploadDoc">
                        <div class="form-group">
                            <p><span id="sent"></span></p>
                            <h4 class="help-block">Add driver documents.</h4> <br />
                            <label>Upload Driver Doc</label>
                            <input class="form-control" type="file" name="documents" multiple="multiple" required><br />
                            <input class="form-control" type="hidden" name="email_2" value="<?php echo $email; ?>" placeholder="Email" required>
                            <input type="hidden" name="fullname" value="<?php echo $Name; ?>">
                            <input type="hidden" name="driver_number" value="<?php echo $driver_number; ?>">

                            <button type="submit" class="btn btn-primary btn-lg btn-block">Upload Documents</button>
                            <input type="hidden" name="MM_insert" value="driverUploadDoc">
                            <p class="help-block">Upload driver documents here.</p>
                        </div>
                    </form>
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

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
