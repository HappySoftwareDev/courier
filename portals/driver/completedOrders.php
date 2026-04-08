<?php
// Start the session before any other output
if (!isset($_SESSION)) {
    session_start();
}
//error_reporting(0);

require_once '../config/bootstrap.php';
require_once('../function.php');

// Unified auth check
if (!isset($_SESSION['user_email']) && !isset($_SESSION['user_id'])) {
    header('Location: ../book/signin.php');
    exit;
}

$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup)
{
    // For security, start by assuming the visitor is NOT authorized.
    $isValid = False;

    // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
    // Therefore, we know that a user is NOT logged in if that Session variable is blank.
    if (!empty($UserName)) {
        // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
        // Parse the strings into arrays.
        $arrUsers = Explode(",", $strUsers);
        $arrGroups = Explode(",", $strGroups);
        if (in_array($UserName, $arrUsers)) {
            $isValid = true;
        }
        // Or, you may restrict access to only certain users based on their username.
        if (in_array($UserGroup, $arrGroups)) {
            $isValid = true;
        }
        if (($strUsers == "") && true) {
            $isValid = true;
        }
    }
    return $isValid;
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
    $MM_qsChar = "?";
    $MM_referrer = $_SERVER['PHP_SELF'];
    if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
        $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
    $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
    header("Location: " . $MM_restrictGoTo);
    exit; // Make sure to call exit after header to prevent further code execution
}
?>

<?php require("../function.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title>Driver - <?php echo $site_name ?></title>
    
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

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <!--overview start-->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="new_orders.php">Home</a></li>
                            <li><i class="fa fa-laptop"></i>Completed Orders</li>
                        </ol>
                    </div>
                </div>

                <?php
                if (isset($_POST['onway'])) {
                    $to1 = $_POST['email'];
                    //$to2 = "bamhara1@gmail.com";

                    $from = $_POST['driveremail'];
                    $message = "Driver is on the way";
                    $headers = "From: $from\n";
                    mail($to1, '', $message, $headers);
                    //mail($to2, '', $message, $headers);
                }

                ?>

                <?php

                if (isset($_GET['orderD'])) {

                    $MrE = $_GET['orderD'];

                    $get = "SELECT * FROM `bookings` where order_id= '$MrE' ";

                    $stmt = $DB->prepare( $get);

                    foreach ($results as $1) {
                        $ID = $row_type['order_id'];
                        $Date = $row_type['Date'];
                        $email_fro = $row_type['email'];
                        $address = $row_type['pick_up_address'];
                        $drop_address = $row_type['drop_address'];
                        $name = $row_type['Name'];
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
                        $status = $row_type['status'];

                        $details = "<tr>
                        <td>$ID</td>
        				<td>$name</td>
        				<td>$address</td>
        				<td>$drop_address</td>
        				<td><a class='btn btn-info' href='' title='Bootstrap 3 themes generator'><span class='fa fa-file-o'></span> Info</a></td></tr>";

                        $MC = "<ul class='list-group'>
                               <li class='list-group-item'><h3>From</h3></li>
            			       <li class='list-group-item'><b>Name:</b> $name<br></li>
                               <li class='list-group-item'><b>Phone:</b> $phone<br/></li>
                               <li class='list-group-item'><b>Email:</b> $email_fro <br/></li>

            				   <li class='list-group-item'><h3>Deliver To</h3></li>
            				   <li class='list-group-item'><b>Name:</b> $Drop_name<br></li>
                               <li class='list-group-item'><b>Phone:</b> $drop_phone<br/></li>

            				  <li class='list-group-item'> <h3>Pick Up Address</h3></li>
                               <li class='list-group-item'><b>Address:</b> $address <br/></li>
                               <li class='list-group-item'><b>Pick Up Date:</b> $pick_up_date <br/></li>
                               <li class='list-group-item'><b>Pick Up Time:</b> $time <br/><br/></li>

            				   <li class='list-group-item'><h3>Delivery Address</h3></li>
                               <li class='list-group-item'><b>Address:</b> $drop_address <br/></li>
                               <li class='list-group-item'><b>Delivery Date:</b> $drop_date <br/></li>
                               <li class='list-group-item'><b>Delivery Time:</b> $drop_time <br/><br/></li>

            				   <li class='list-group-item'><h3>Package Details</h3></li>
            				  <li class='list-group-item'> <b>Weight:</b> $weight_of_package<br></li>
                               <li class='list-group-item'><b>Quantity:</b> $package_quantity<br/></li>
                               <li class='list-group-item'><b>Prefered Type Of Transport:</b> $type_of_transport <br/><br/></li>
                              <li class='list-group-item'> <b>Note:</b> $note <br/>

            				   </ul>";

                        $ClientD = "$address<br>
                                Phone: $phone<br/>
                                Email: $email_fro";
                    }
                }


                ?>





                <!-- project team & activity start -->

                <?php $date = date("Y-m-d");
                $time = date("H:m");
                $datetime = $date . "T" . $time;

                $user = $_SESSION['MM_Username'];

                $get = "SELECT * FROM `driver` where username = '$user' LIMIT 1 ";

                $stmt = $DB->prepare( $get);

                foreach ($results as $1) {
                    $driverID = $row_type['driverID'];
                    $username = $row_type['username'];
                    $email = $row_type['email'];
                    $drivername = $row_type['name'];
                }
                ?>



                <form method="POST" action="<?php echo $editFormAction; ?>" name="acceptForm">
                    <input type="hidden" class="form-control" name="status" value="<?php echo $username; ?>">
                    <input type="hidden" class="form-control" name="status_up_date" value="<?php echo $datetime; ?>">
                    <input type="hidden" class="form-control" name="driveremail" value="<?php echo $email; ?>">
                    <input type="hidden" class="form-control" name="name" value="<?php echo $drivername; ?>">
                    <input type="hidden" class="form-control" name="clientEmail" value="<?php echo $email_fro; ?>">
                    <input type="hidden" class="form-control" name="order_id" value="<?php echo $ID; ?>">
                    <input type="hidden" name="MM_ontheway" value="acceptForm">

                </form>


                <div class="row">

                </div>
                <!--/.row-->


                <div class="row">

                </div>

                <div class="panel-group m-bot20" id="accordion">
                    <?php getCompletedBookingsToDriver(); ?>
                    <div class='btn-group'>

                    </div>
                </div>
                <!--collapse end-->


                <!-- project team & activity start -->


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


