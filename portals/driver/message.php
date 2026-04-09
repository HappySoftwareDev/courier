<?php
require_once '../../config/bootstrap.php';
require_once '../../function.php';
require_once 'signin-security.php';

error_reporting(0);

// Get site name
$site_name = defined('SITE_NAME') ? SITE_NAME : 'WG ROOS Courier';
?>
}
?>


<?php
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "chatDriver")) {
    $message = $_POST['message'];
    $name = $_POST['name'];
    $driverID = $_POST['driverID'];

    try {

        

        // $stmt = $DB_con->prepare("SELECT * FROM driver WHERE driverID='$driverID'");
        // $stmt->execute(array(":status" => $driverID));
        // $count = $stmt->rowCount();

        // Assuming $driverID is properly defined and sanitized
        $stmt = $DB_con->prepare("SELECT * FROM driver WHERE driverID=:driverID"); 
        $stmt->execute(array(":driverID" => $driverID));
        $count = $stmt->rowCount();


        // var_dump($count); 
        // die();

        if ($count == 1) {
            $stmt = $DB_con->prepare("INSERT INTO chat_drivers (message, name, IDFrom) VALUES ('$message', '$name', '$driverID')");
        }

        
        if ($stmt->execute()) {
            // echo"<script> alert('sent!') </script>";
            echo "<script>window.open('message.php','_self')</script>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<?php require("../function.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Driver - Merchant Couriers</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- full calendar css-->
    <link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
    <link href="assets/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
    <!-- easy pie chart-->
    <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen" />
    <!-- owl carousel -->
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
    <link href="css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <!-- Custom styles -->
    <link rel="stylesheet" href="css/fullcalendar.css">
    <link href="css/widgets.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <link href="css/xcharts.min.css" rel=" stylesheet">
    <link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <!-- =======================================================
        Theme Name: NiceAdmin
        Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        Author: BootstrapMade
        Author URL: https://bootstrapmade.com
    ======================================================= -->
</head>

<body>
    <!-- container section start -->
    <section id="container" class="">

    <?php include 'side-menu.php'; ?>
        
        <?php
        // $user = $_SESSION['MM_Username'];
        // global $DB;

        // $get = "SELECT * FROM `driver` where username = '$user' LIMIT 1 ";

        // $stmt = $DB->prepare( $get);

        // foreach ($results as $1) {
        //     $ID = $row_type['driverID'];
        //     $Name = $row_type['name'];
        //     $phone = $row_type['phone'];
        //     $address = $row_type['address'];
        //     $vehicleMake = $row_type['vehicleMake'];
        //     $model = $row_type['model'];
        //     $year = $row_type['year'];
        //     $engineCapacity = $row_type['engineCapacity'];
        //     $dob = $row_type['DOB'];
        //     $occupation = $row_type['occupation'];
        // }

        ?>

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <!--overview start-->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="new_orders.php">Home</a></li>
                            <li><i class="fa fa-laptop"></i>Messages</li>
                        </ol>
                    </div>
                </div>

                <div class="row">

                </div>
                <!--/.row-->


                <div class="row">

                </div>


                <!-- Today status end -->



                <div class="row">


                </div>



                <!-- statics end -->




                <div class="row">
                    <div class="col-md-4 portlets">
                        <!-- Widget -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <!-- Widget content -->
                                <div class="padd sscroll">

                                    <ul class="chats">

                                        <?php getChatsFroDr(); ?>
                                        <?php getReplyChatsFroDr(); ?>

                                    </ul>

                                </div>
                                <!-- Widget footer -->
                                <div class="widget-foot">

                                    <form method="POST" action="message.php" name="chatDriver">
                                        <div class="form-group">
                                            <textarea type="text" rows="3" name="message" class="form-control" required placeholder="Type your message here..."></textarea>
                                            <input type="hidden" rows="3" name="name" class="form-control" required value="<?php getDriversNameOnApp(); ?>">
                                            <input type="hidden" rows="3" name="driverID" class="form-control" required value="<?php echo $ID; ?>">
                                        </div>
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-info">Send</button>
                                        </div>
                                        <input type="hidden" name="MM_insert" value="chatDriver">
                                    </form>



                                </div>
                            </div>


                        </div>
                    </div>


                </div><br><br>


                <!-- project team & activity end -->

            </section>
            <div class="text-right">

            </div>
        </section>
        <!--main content end-->
    </section>
    <!-- container section start -->

    <?php include 'footer_scripts.php'; ?>

</body>

</html>


