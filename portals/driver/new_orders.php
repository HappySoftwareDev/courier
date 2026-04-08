<?php
// Start the session before any other output
if (!isset($_SESSION)) {
    session_start();
}
// Enable error reporting for debugging (This should be done early in the script)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

error_reporting(0);

include('../admin/pages/site_settings.php');

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


        <header class="header dark-bg">
            <div class="toggle-nav">
                <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
            </div>

            <?php
            $user = $_SESSION['MM_Username'];
            $get = "SELECT * FROM `driver` where username = '$user' ";

            $stmt = $DB->prepare( $get);

            foreach ($results as $1) {
                $ID = $row_type['driverID'];
                $Name = $row_type['name'];
                $company_name = $row_type['company_name'];
                $phone = $row_type['phone'];
                $email = $row_type['email'];
                $address = $row_type['address'];
                $vehicleMake = $row_type['vehicleMake'];
                $model = $row_type['model'];
                $year = $row_type['year'];
                $engineCapacity = $row_type['engineCapacity'];
                $dob = $row_type['DOB'];
                $occupation = $row_type['occupation'];
                $documents = $row_type['documents'];
                $status = $row_type['online'];
                $profileImage = $row_type['profileImage'];
                $type_of_service = $row_type['type_of_service'];

                $srv = "";

                if ($type_of_service == "Taxi") {
                    $srv = "Taxi";
                }
                if ($type_of_service == "Parcel Delivery") {
                    $srv = "Deliveries";
                }
                if ($type_of_service == "Freight Delivery") {
                    $srv = "Freight & Log";
                }
                if ($type_of_service == "Tow Truck") {
                    $srv = "Towing";
                }
            }
            ?>

            <!-- Logo Start -->
            <a href="new_orders.php" class="logo">
                <?php echo $site_name; ?>
                <span class="lite"><?php echo $srv; ?></span>
            </a>
            <!-- Logo End -->


            <div class="top-nav notification-row">
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">

                    <!-- task notificatoin end -->
                    <!-- inbox notificatoin start-->

                    <!-- inbox notificatoin end -->
                    <!-- alert notification start-->

                    <!-- alert notification end-->
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">

                            </span>
                            <span class="username"><?php getDriversNameOnApp(); ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li class="eborder-top">
                                <a href="profile.php"><i class="icon_profile"></i> My Profile</a>
                            </li>
                            <li>
                                <a href="massage.php"><i class="icon_mail_alt"></i> My Inbox</a>
                            </li>

                            <li>
                                <a href="index.php"><i class="icon_key_alt"></i> Log Out</a>
                            </li>

                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
        </header>
        <!--header end-->
        <?php
        $user = $_SESSION['MM_Username'];

        $get_driver = "SELECT * FROM driver WHERE username='$user' ";

        $stmt = $DB->prepare( $get_driver);

        foreach ($results as $1) {
            $ID = $row_type['driverID'];
            $company_name = $row_type['company_name'];
            $online = $row_type['online'];
            $mode_of_transport = $row_type['mode_of_transport'];
            $username = $row_type['username'];
            $type_of_service = $row_type['type_of_service'];

            $link = "afterPick.php";

            if ($type_of_service == "Taxi") {
                $link = "taxi.afterPick.php";
            }

            $get = "SELECT * FROM `users` WHERE Name='$company_name'";

            $stmt = $DB->prepare( $get);

            foreach ($results as $1) {
                $ID = $row_type['ID'];
                $Name = $row_type['Name'];
                $Email = $row_type['email'];
                $date = $row_type['date'];
                $days = $row_type['days'];

                $expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . "+ $days day"));


                if (date("Y-m-d") < $expire) {
                    $show = "
		    <li class='active'>
                      <a class='' href='new_orders.php'>
                          <i class='icon_house_alt'></i>
                          <span>New Orders</span>
                      </a>
                  </li>
				   <li>
                      <a class=''  href='accepted_orders.php'>
                          <i class='icon_download'></i>
                          <span>Accepted Orders</span>

                      </a>

                  </li>
                  <li class='sub-menu'>
                      <a href='javascript:;' class=''>
                          <i class='icon_clock'></i>
                          <span>Archived Orders</span>
                          <span class='menu-arrow arrow_carrot-right'></span>
                      </a>
                      <ul class='sub'>
                          <li><a class='' href='AllOrders.php'>All</a></li>
                          <li><a class='' href='completedOrders.php'>Completed Orders</a></li>
                          <li><a class='' href='$link'>Live Orders</a></li>
                      </ul>
                  </li>
                  <li>
                      <a class='' href='profile.php'>
                          <i class='icon_profile'></i>
                          <span>My Account</span>
                      </a>
                  </li>
				  <li>
                      <a class='' href='map.php'>
                          <i class='fa fa-map-marker'></i>
                          <span>map</span>
                      </a>
                  </li>
                   <li>
                      <a class='' href='../affiliate.user/index.php'>
                          <i class='fa fa-certificate'></i>
                          <span>Join Affiliate Program</span>
                      </a>
                  </li>
                  <li>
                      <a class='' href='message.php'>
                          <i class='icon_mail'></i>
                          <span>Messages</span>

                      </a>

                  </li>
                   <li>
                     <a href='index.php'><i class='icon_key_alt'></i> Log Out</a>
                   </li>
		    ";
                } else {
                    $show = "<div style='color:red'><h2>Your account has expired please recharge!<h2></div>";
                }
            }
        }
        ?>
        
        <?php include 'side-menu.php'; ?>

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <!--overview start-->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="new_orders.php">New Orders</a></li>
                            <li><i class="fa fa-user"></i><?php echo $status; ?></li>
                            <li class="pull-right"><a href="new_orders.php"><i class="fa fa-rotate-right"></i></a></li>
                        </ol>
                    </div>
                </div>

                <div class="row">

                </div>
                <!--/.row-->


                <div class="row">

                </div>

                <div class="panel-group m-bot20" id="accordion">
                    <?php getBookingsToDriver(); ?>
                    <?php getBookingsToTaxiDrivers(); ?>
                    <?php getExDateToDriver(); ?>
                </div>
                <!--collapse end-->


                <!-- project team & activity start -->

                </div>


                <!-- project team & activity end -->

            </section>
            <div class="text-right">

            </div>
            <!-- Whatsapp button -->
            <a href="https://api.whatsapp.com/send?phone=+263779495409&text=Hi admin I'm a driver." id="myBtn"><img src="../images/wats2.png" width="50px"></a>
        </section>
        <!--main content end-->
    </section>
    <!-- container section start -->
   
    <!--Firebase Push-->
    <script>
    // Load Firebase configuration from site management
    <?php include '../../web_push/firebase-config.php'; ?>
    firebase.initializeApp(firebaseConfig);
    const messaging=firebase.messaging();

    function IntitalizeFireBaseMessaging() {
        messaging
            .requestPermission()
            .then(function () {
                console.log("Notification Permission");
                return messaging.getToken();
            })
            .then(function (token) {
                console.log("Token : "+token);
                // document.getElementById("token").innerHTML=token;
                $.ajax({
                url: '../../web_push/save_token.php',
                type: 'POST',
                data: 'token=' + token,
                success: function(result) {
                    if(result == "OK"){
                        console.log("token saved");
                    }
                    else if(result == "exist"){
                        console.log("token already exist")
                    };
                }
                 });
            })
            .catch(function (reason) {
                console.log(reason);
            });
    }

    messaging.onMessage(function (payload) {
        console.log(payload);
        const notificationOption={
            body:payload.notification.body,
            icon:payload.notification.icon
        };

        if(Notification.permission==="granted"){
            var notification=new Notification(payload.notification.title,notificationOption);

            notification.onclick=function (ev) {
                ev.preventDefault();
                window.open(payload.notification.click_action,'_blank');
                notification.close();
            }
        }

    });
    messaging.onTokenRefresh(function () {
        messaging.getToken()
            .then(function (newtoken) {
                console.log("New Token : "+ newtoken);
            })
            .catch(function (reason) {
                console.log(reason);
            })
    })
    IntitalizeFireBaseMessaging();
</script>
<!--End Firebase Push-->


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
    <?php include 'footer_scripts.php'; ?>

</body>

</html>


