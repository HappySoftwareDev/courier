<?php
// Start the session before anything else is sent to the browser
if (!isset($_SESSION)) {
    session_start();
}

// Enable error reporting for debugging (This should be done early in the script)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


// Include the site settings
include ("../admin/pages/site_settings.php");

require_once '../config/bootstrap.php';
require_once '../function.php';

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
    exit; // Always call exit after header to stop further execution
}
?>


<?php

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "driverUploadDoc")) {
    $name_array = $_FILES['documents']['name'];
    $tmp_name_array = $_FILES['documents']['tmp_name'];
    $type_array = $_FILES['documents']['type'];
    $size_array = $_FILES['documents']['size'];
    $userNa = $_POST['fullname'];
    $desired_dir = "../driver_documents/" . $userNa;


    $username = $_POST['fullname'];
    $email = $_POST['email'];
    try {
        $stmt = $DB_con->prepare("SELECT * FROM driver_doc WHERE email=:email");
        $stmt->execute(array(":email" => $email));
        $count = $stmt->rowCount();
        if ($count == "") {
            if (is_dir($desired_dir) == false) {
                mkdir("$desired_dir", 0700);
                if (is_dir("$desired_dir/" . $userNa) == false) {
                    move_uploaded_file($tmp_name_array[$i], "$desired_dir/" . date('d-m-Y-H-i-s') . '-' . $name_array[$i]);
                } else {
                    rename($tmp_name_array[$i], "$desired_dir/" . date('d-m-Y-H-i-s') . '-' . $name_array[$i]);

                    # rename can move the file along with renaming it

                    for ($i = 0; $i < count($tmp_name_array); $i++) {
                        move_uploaded_file($tmp_name_array[$i], "$desired_dir/" . $name_array[$i]);

                        $stmt = $Connect->prepare("INSERT INTO `driver_doc`(`DriverName`, `email`, `documents`)VALUES (:username, :email, '$name_array[$i]')");

                        $stmt->bindparam(":username", $username);
                        $stmt->bindparam(":email", $email);
                    }
                }
            }

            //check if query executes
            if ($stmt->execute()) {
                echo "<script>alert('Upload successful.')</script>";
                echo "<script>window.open('index.php','_self')</script>";
            } else {

                echo "<script>alert('Error Upload failed')</script>";
            }
        } //end of integrity check

        else if ($count == 1) {
            if (is_dir($desired_dir) == false) {
                mkdir("$desired_dir", 0700);
                if (is_dir("$desired_dir/" . $userNa) == false) {
                    move_uploaded_file($tmp_name_array[$i], "$desired_dir/" . date('d-m-Y-H-i-s') . '-' . $name_array[$i]);
                } else {
                    rename($tmp_name_array[$i], "$desired_dir/" . date('d-m-Y-H-i-s') . '-' . $name_array[$i]);

                    # rename can move the file along with renaming it

                    for ($i = 0; $i < count($tmp_name_array); $i++) {
                        move_uploaded_file($tmp_name_array[$i], "$desired_dir/" . $name_array[$i]);

                        $stmt = $DB_con->prepare("UPDATE `driver_doc` SET DriverName =:username, email=:email, documents='$name_array[$i]'");

                        $stmt->bindparam(":username", $username);
                        $stmt->bindparam(":email", $email);
                    }
                }
            }

            //check if query executes
            if ($stmt->execute()) {
                echo "<script>alert('Upload successful.')</script>";
                echo "<script>window.open('index.php','_self')</script>";
            } else {

                echo "<script>alert('Error Upload Failed')</script>";
            }
        }
    } // end of try block

    catch (PDOException $e) {
        echo $e->getMessage();
    }
} //end post

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "driverOnline")) {
    $timeOn = $_POST['timeOn'];
    $goOn = $_POST['goOn'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $driverID = $_POST['id'];
    try {

        $stmt = $DB_con->prepare("SELECT * FROM driver WHERE driverID=:driverID");
        $stmt->execute(array(":driverID" => $driverID));
        $count = $stmt->rowCount();
        if ($count == 1) {
            $stmt = $DB_con->prepare("UPDATE driver SET `online`=:goOn, `time`=:timeOn, lat=:lat, lng=:lng WHERE driverID=:driverID");

            $stmt->bindparam(":timeOn", $timeOn);
            $stmt->bindparam(":goOn", $goOn);
            $stmt->bindparam(":lat", $lat);
            $stmt->bindparam(":lng", $lng);
            $stmt->bindparam(":driverID", $driverID);


            //check if query executes
            if ($stmt->execute()) {
                echo "";
            } else {

                echo "Failed to change status";
            }
        } //end of integrity check

        else {
            echo "1"; // user email is taken
        }
    } // end of try block

    catch (PDOException $e) {
        echo $e->getMessage();
    }
} //end post



if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "driverOffline")) {

    $timeOff = $_POST['timeOff'];
    $goOff = $_POST['goOff'];
    $driverID = $_POST['ID'];
    try {

        $stmt = $DB_con->prepare("SELECT * FROM driver WHERE driverID=:driverID");
        $stmt->execute(array(":driverID" => $driverID));
        $count = $stmt->rowCount();
        if ($count == 1) {
            $stmt = $DB_con->prepare("UPDATE driver SET `online`=:goOff, `time`=:timeOff WHERE driverID=:driverID");

            $stmt->bindparam(":timeOff", $timeOff);
            $stmt->bindparam(":goOff", $goOff);
            $stmt->bindparam(":driverID", $driverID);


            //check if query executes
            if ($stmt->execute()) {
                echo "";
            } else {

                echo "Failed to change status";
            }
        } //end of integrity check

        else {
            echo "1"; // user email is taken
        }
    } // end of try block

    catch (PDOException $e) {
        echo $e->getMessage();
    }
} //end post


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "driverUpdate")) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $vehicleMake = $_POST['vehicleMake'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $engineCapacity = $_POST['engineCapacity'];
    $dob = $_POST['dob'];
    $occupation = $_POST['occupation'];
    $email = $_POST['email'];
    $driverID = $_POST['id'];
    try {

        $stmt = $DB_con->prepare("SELECT * FROM driver WHERE driverID=:driverID");
        $stmt->execute(array(":driverID" => $driverID));
        $count = $stmt->rowCount();
        if ($count == 1) {
            $stmt = $DB_con->prepare("UPDATE driver SET name=:name, phone=:phone, address=:address, vehicleMake=:vehicleMake, model=:model, `year`=:year, engineCapacity=:engineCapacity, DOB=:dob, occupation=:occupation, email=:email WHERE driverID=:driverID");

            $stmt->bindparam(":name", $name);
            $stmt->bindparam(":phone", $phone);
            $stmt->bindparam(":address", $address);
            $stmt->bindparam(":vehicleMake", $vehicleMake);
            $stmt->bindparam(":model", $model);
            $stmt->bindparam(":year", $year);
            $stmt->bindparam(":engineCapacity", $engineCapacity);
            $stmt->bindparam(":dob", $dob);
            $stmt->bindparam(":occupation", $occupation);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":driverID", $driverID);


            //check if query executes
            if ($stmt->execute()) {
                echo "";
            } else {

                echo "Failed to change status";
            }
        } //end of integrity check

        else {
            echo "1"; // user email is taken
        }
    } // end of try block

    catch (PDOException $e) {
        echo $e->getMessage();
    }
} //end post
?>

<?php require("../function.php"); ?>

<?php
$time = time();
$time_check = $time - 600; //SET TIME 10 Minute
$user = $_SESSION['MM_Username'];
$get = "SELECT * FROM `driver` where username = '$user' ";

$stmt = $DB->prepare( $get);

foreach ($results as $1) {
    $ID = $row_type['driverID'];
}
if (isset($_POST['go_online'])) {
    $get = "UPDATE driver SET online='online' time='$time' WHERE username = '$ID'";
    mysqli_select_db($Connect, $database_Connect);
    $stmt = $DB->prepare( $get);

    echo "<script>alert('online!')</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title>Profile - <?php echo $site_name ?></title>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        function _(x) {
            return document.getElementById(x);
        }

        function calculateOn() {
            _("bk").style.display = "none";
            _("bkk").style.display = "none";
        }

        function calculateOFF() {
            _("bk").style.display = "block";
            _("bkk").style.display = "none";
        }
    </script>

    <style>
        #myBtn {
            display: block;
            position: fixed;
            bottom: 5px;
            left: 10px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 4px;
        }
    </style>

</head>

<body>
    <!-- container section start -->
    <section id="container" class="">


        <?php include 'side-menu.php'; ?>

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <div class="btn-row pull-right">
                                <div class="btn-group">

                                    <form method="POST" action="profile.php" role="form" name="driverOnline">
                                        <input type="hidden" value="online" name="goOn">
                                        <input type="hidden" value="<?php echo $time; ?>" name="timeOn">
                                        <input type="hidden" id="out" name="lat">
                                        <input type="hidden" id="ou" name="lng">
                                        <input type="hidden" value="<?php echo $ID; ?>" name="id">
                                        <button type="submit" class="btn btn-success" onclick="geoFindMe()">GO Online</button>
                                        <input type="hidden" name="MM_update" value="driverOnline">
                                    </form>
                                </div>
                            </div>
                            <div class="btn-row pull-right">

                                <form method="POST" action="profile.php" role="form" name="driverOffline">
                                    <input type="hidden" value="offline" name="goOff">
                                    <input type="hidden" value="<?php echo $time; ?>" name="timeOff">
                                    <input type="hidden" value="<?php echo $ID; ?>" name="ID">
                                    <button type="submit" class="btn btn-danger">GO Offline</button>
                                    <input type="hidden" name="MM_update" value="driverOffline">
                                </form>
                            </div>
                            <li><i class="fa fa-user-md"></i>Profile </li>
                        </ol>
                    </div>
                </div>


                <?php
                $user = $_SESSION['MM_Username'];
                $get = "SELECT * FROM `driver` where username = '$user' ";

                $stmt = $DB->prepare( $get);

                foreach ($results as $1) {
                    $ID = $row_type['driverID'];
                    $Name = $row_type['name'];
                    $phone = $row_type['phone'];
                    $email = $row_type['email'];
                    $address = $row_type['address'];
                    $vehicleMake = $row_type['vehicleMake'];
                    $model = $row_type['model'];
                    $year = $row_type['year'];
                    $engineCapacity = $row_type['engineCapacity'];
                    $dob = $row_type['DOB'];
                    $occupation = $row_type['occupation'];
                    $status = $row_type['online'];
                    $profileImage = $row_type['profileImage'];



                    $MrE = " <div class='bio-row'>
              <p><span> Name </span>: $Name </p>
              </div>
              <div class='bio-row'>
                  <p><span>Address </span>: $address</p>
              </div>
              <div class='bio-row'>
                  <p><span>Birthday</span>: $dob</p>
              </div>
              <div class='bio-row'>
                  <p><span>Country </span>: Zimbabwe</p>
              </div>
              <div class='bio-row'>
                  <p><span>Occupation </span>: $occupation</p>
              </div>
              <div class='bio-row'>
                  <p><span>Mobile </span>: $phone</p>
              </div>
	  ";
                }

                ?>



                <?php
                $date = date("Y-m-d");
                $time = date("H:m") . " hrs";
                ?>

                <div class="row">
                    <!-- profile-widget -->
                    <div class="col-lg-12">
                        <div class="profile-widget profile-widget-info">
                            <div class="panel-body">
                                <div class="col-lg-2 col-sm-2">
                                    <h4><?php echo $Name; ?></h4>
                                    <div class="follow-ava">
                                        <img src="../images/driverProfile/<?php echo $profileImage; ?>" alt="">
                                    </div>
                                    <h6>Driver <b style="color:FF8C00; text-transform:uppercase;"><?php echo $status; ?></b></h6>
                                </div>
                                <div class="col-lg-4 col-sm-4 follow-info">
                                    <p>Hello I’m <?php getDriversNameOnApp(); ?>, a driver on <?php echo $site_name ?> .</p>
                                    <h6>
                                        <span><i class="icon_clock_alt"></i><?php echo $time; ?></span>
                                        <span><i class="icon_calendar"></i><?php echo $date; ?></span>
                                        <span><i class="icon_pin_alt"></i>Zimbabwe</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- page start-->
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading tab-bg-info">
                                <ul class="nav nav-tabs">
                                    <li>
                                        <a data-toggle="tab" href="#profile">
                                            <i class="icon-user"></i>
                                            Profile
                                        </a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#edit-profile">
                                            <i class="icon-envelope"></i>
                                            Edit Profile
                                        </a>
                                    </li>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">

                                    <!-- profile -->
                                    <div id="profile" class="tab-pane">
                                        <section class="panel">
                                            <div class="panel-body bio-graph-info">
                                                <h1>Bio Graph</h1>
                                                <div class="row">
                                                    <?php echo $MrE; ?>
                                                </div>
                                            </div>
                                        </section>
                                        <section>
                                            <div class="row">
                                            </div>
                                        </section>
                                    </div>
                                    <!-- edit-profile -->
                                    <div id="edit-profile" class="tab-pane">
                                        <section class="panel">
                                            <div class="panel-body bio-graph-info">
                                                <h1> Profile Info</h1>
                                                <form method="POST" action="profile.php" class="form-horizontal" role="form" name="driverUpdate">
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Full Name</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" id="f-name" name="name" value="<?php echo $Name; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Phone</label>
                                                        <div class="col-lg-6">
                                                            <input type="tel" class="form-control" id="l-name" name="phone" value="<?php echo $phone; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">E-mail</label>
                                                        <div class="col-lg-6">
                                                            <input type="tel" class="form-control" id="l-name" name="email" value="<?php echo $email; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Address</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" id="c-name" name="address" value="<?php echo $address; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Birthday</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" id="b-day" name="dob" value="<?php echo $dob; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Occupation</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" id="occupation" name="occupation" value="<?php echo $occupation; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Vehicle Make</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" id="email" name="vehicleMake" value="<?php echo $vehicleMake; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Model</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" id="mobile" name="model" value="<?php echo $model; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Year</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" id="mobile" name="year" value="<?php echo $year; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Engine Capacity</label>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" id="mobile" name="engineCapacity" value="<?php echo $engineCapacity; ?>">
                                                            <input type="hidden" class="form-control" name="id" value="<?php echo $ID; ?>">
                                                        </div>
                                                    </div>



                                                    <div class="form-group">
                                                        <div class="col-lg-offset-2 col-lg-10">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                            <a href="profile.php"><button type="button" class="btn btn-danger">Cancel</button></a>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="MM_update" value="driverUpdate">
                                                </form>
                                                <h4>Please Upload your Documents In (pdf) Format </h4>
                                                <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal" enctype="multipart/form-data" name="driverUploadDoc">
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Upload Documents</label>
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control" name="documents[]" multiple="multiple" required>
                                                            <input type="hidden" id="username" name="fullname" value="<?php echo $Name; ?>" class="input-block-level" required>
                                                            <input type="hidden" name="email" value="<?php echo $email; ?>" class="input-block-level" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-lg-offset-2 col-lg-10">
                                                            <button type="submit" class="btn btn-primary">Upload Documents</button>
                                                            <input type="hidden" name="MM_insert" value="driverUploadDoc">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>
    <!-- container section end -->
    <!-- Whatsapp button -->
    <a href="https://api.whatsapp.com/send?phone=+263779495409&text=Hi, I'd like to book a delivery." id="myBtn"><img src="../images/wats2.png" width="50px"></a>
    <!-- Whatsapp script -->
    <script>
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("myBtn").style.display = "block";
            } else {
                document.getElementById("myBtn").style.display = "block";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>

     <?php include 'footer_scripts.php'; ?>

    <script>
        function geoFindMe() {
            var output = document.getElementById("out");
            var outpu = document.getElementById("ou");

            function success(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                output.value = latitude;
                outpu.value = longitude;

            }


            output.innerHTML = "<p>Locating…</p>";

            navigator.geolocation.getCurrentPosition(success);


        }

        $(document).ready(function() {
            geoFindMe();
        });
    </script>

</body>

</html>


