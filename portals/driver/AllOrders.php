<?php
// Start the session before any other output
if (!isset($_SESSION)) {
    session_start();
}

// Enable error reporting for debugging (This should be done early in the script)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include ('../admin/pages/site_settings.php');


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
                <!--overview start-->
                <div class="row">

                    <div class="col-lg-12">

                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="new_orders.php">Home</a></li>
                            <li><i class="fa fa-laptop"></i>Archived Orders</li>

                        </ol>

                    </div>
                </div>

                <div class="row">

                </div>
                <!--/.row-->


                <div class="row">

                </div>

                <div class="panel-group m-bot20" id="accordion">
                    <?php getAllarchivedBookingsToDriver(); ?>
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
        <!-- Whatsapp button -->
        <a href="https://api.whatsapp.com/send?phone=+263779495409&text=Hi, I'd like to book a delivery." id="myBtn"><img src="../images/wats2.png" width="50px"></a>
    </section>
    <!-- container section start -->
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
        
    <?php include 'footer_scripts.php'; ?>

</body>

</html>


