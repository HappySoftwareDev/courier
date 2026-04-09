<?php
require_once '../../config/bootstrap.php';
require_once '../../function.php';
require_once 'signin-security.php';

error_reporting(0);

// Get site name
$site_name = defined('SITE_NAME') ? SITE_NAME : 'WG ROOS Courier';
?>

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


