<?php
// Start the session before any other output
if (!isset($_SESSION)) {
    session_start();
}

// Enable error reporting for debugging (This should be done early in the script)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include ("../admin/pages/site_settings.php");

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


<?php
require_once '../config/bootstrap.php';
require_once '../function.php';

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "completeSignature")) {
    $name_image = $_FILES['img']['name'];
    $tmp_name_array = $_FILES['img']['tmp_name'];
    $type_array = $_FILES['img']['type'];
    $size_array = $_FILES['img']['size'];
    move_uploaded_file($tmp_name_array, "proof_img/$name_image");

    $status_update = trim($_POST['status_update']);
    $status = trim($_POST['status']);
    $ReciepientName = trim($_POST['name']);
    $ReciepientSignature = trim($_POST['output']);
    $username = trim($_POST['username']);
    $order_id = trim($_POST['order_number']);
    $to = $_POST['email_fro'];
    $driverName = $_POST['driverName'];
    $driverEmail = $_POST['driverEmail'];
    $driver_amount = $_POST['driver_amount'];
    $clientName = $_POST['clientName'];
    $drop_name = $_POST['drop_name'];
    $delivery_type = $_POST['delivery_type'];

    try {
        // Corrected query to fetch booking data by order number
        $stmt = $DB_con->prepare("SELECT * FROM bookings WHERE order_number=:order_id");
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count == 1) {
            // Corrected query to update booking details with bound parameters
            $stmt = $DB_con->prepare("UPDATE `bookings` 
                SET status=:status, status_update_date=:status_update, ReciepientName=:ReciepientName, ReciepientSignature=:ReciepientSignature, 
                username=:username, proof_img=:name_image 
                WHERE order_number=:order_id");
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":status_update", $status_update);
            $stmt->bindParam(":ReciepientName", $ReciepientName);
            $stmt->bindParam(":ReciepientSignature", $ReciepientSignature);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":name_image", $name_image);
            $stmt->bindParam(":order_id", $order_id);

            // Check if the query executed
            if ($stmt->execute()) {
                $toAD = $bus_email;
                $messageAD = "Order from $clientName has been Completed, by $driverName.\n\nNo Injuries, No Lost Time, Great Work!! \n\nRegards\n\n' . $site_name . '\n\n Courier. Freight. Transportation ";
                $headerrs = "orders@" . $web_url;
                mail($toAD, $email_subject, $messageAD, $headerrs);

                if ($delivery_type == "Taxi") {
                    // Email for taxi delivery
                    $subject = "Arrived safely";
                    $htmlContent = '
                    <html>
                    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>' . $site_name . '</title>
                    </head>
                    <body>
                    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                        <h1 style="color:#FF8C00">' . $site_name . '</h1>
                        <p>Thank You for using ' . $site_name . '. ORDER COMPLETED Successfully and your stuff has been DELIVERED to ' . $drop_name . '.</p>
                        <footer>
                        <p>For inquiries, visit <a href="http://' . $web_url . '">' . $web_url . '</a>. Call/WhatsApp <b>' . $bus_phone . '</b>.</p>
                        <p>PLEASE DO NOT REPLY TO THIS EMAIL.</p>
                        <h4 style="color:#FF8C00">' . $site_name . '</h4>
                        </footer>
                    </body>
                    </html>';

                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: ' . $site_name . '<orders@' . $web_url . '>' . "\r\n";

                    if (mail($to, $subject, $htmlContent, $headers)) {
                        $successMsg = 'Email has sent successfully.';
                    } else {
                        $errorMsg = 'Email sending failed.';
                    }

                    echo "<script>alert('Order completed!')</script>";
                    echo "<script>window.open('new_orders.php','_self')</script>";

                } else {
                    // Email for other deliveries
                    $subject = "Delivery COMPLETED";
                    $name_img = $_FILES['img']['name'];

                    $htmlContent = '
                    <html>
                    <head>
                        <title>' . $site_name . '</title>
                    </head>
                    <body>
                    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                        <h1 style="color:#FF8C00">' . $site_name . '</h1>
                        <p>ORDER COMPLETED Successfully. Your goods were DELIVERED by driver ' . $driverName . '. Kindly take time to rate our service <a href="https://m.facebook.com/pg/' . $site_name . '/reviews/?ref=page_internal&mt_nav=0">RATE</a>.</p>
                        <p><a href="' . $web_url . '/driver/proof_img/' . $name_img . '">Download proof of delivery</a></p>
                        <footer>
                        <p>For inquiries, visit <a href="http://' . $web_url . '">' . $web_url . '</a>. Call/WhatsApp <b>' . $bus_phone . '</b>.</p>
                        <p>PLEASE DO NOT REPLY TO THIS EMAIL.</p>
                        <h4 style="color:#FF8C00">' . $site_name . '</h4>
                        </footer>
                    </body>
                    </html>';

                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: ' . $site_name . '<orders@' . $web_url . '>' . "\r\n";

                    if (mail($to, $subject, $htmlContent, $headers)) {
                        $successMsg = 'Email has sent successfully.';
                    } else {
                        $errorMsg = 'Email sending failed.';
                    }

                    // Send email to the driver
                    $subject = "Delivery COMPLETED";
                    $htmlContent = '
                    <html>
                    <head>
                        <title>' . $site_name . '</title>
                    </head>
                    <body>
                    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
                        <h1 style="color:#FF8C00">' . $site_name . '</h1>
                        <p></p>
                        <p>ORDER COMPLETED Successfully. On this delivery, you made ' . $driver_amount . '.</p>
                        <footer>
                        <p>For inquiries, visit <a href="http://' . $web_url . '">' . $web_url . '</a>. Call/WhatsApp <b>' . $bus_phone . '</b>.</p>
                        <p>PLEASE DO NOT REPLY TO THIS EMAIL.</p>
                        <h4 style="color:#FF8C00">' . $site_name . '</h4>
                        </footer>
                    </body>
                    </html>';

                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: ' . $site_name . '<orders@' . $web_url . '>' . "\r\n";

                    if (mail($driverEmail, $subject, $htmlContent, $headers)) {
                        $successMsg = 'Email has sent successfully.';
                    } else {
                        $errorMsg = 'Email sending failed.';
                    }

                    echo "<script> alert('Order completed!') </script>";
                    echo "<script>window.open('new_orders.php','_self')</script>";
                }

                // Get the user token using PDO
                $get_user = "SELECT * FROM `users` WHERE email = :email_to"; // Use a parameterized query
                $stmt = $Connect->prepare($get_user); // Prepare the statement
                $stmt->bindParam(':email_to', $to, PDO::PARAM_STR); // Bind the email parameter to avoid SQL injection
                $stmt->execute(); // Execute the query
                
                // Fetch the user data and display the token
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    echo "User Token: " . $row['user_token'];
                }

            } else {
                echo "<script>alert('Update failed. Please try again!')</script>";
            }
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


<?php require("../function.php"); ?>


<!DOCTYPE html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @font-face {
            font-family: 'Journal';
            src: url('journal.eot');
            src: url('journal.eot?#iefix') format('embedded-opentype'),
                url('journal.woff') format('woff'),
                url('journal.ttf') format('truetype'),
                url('journal.svg#JournalRegular') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        .sigPad {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .sigPad label {
            display: block;
            margin: 0 0 0.515em;
            padding: 0;

            color: #000;
            font: italic normal 1em/1.375 Georgia, Times, serif;
        }

        .sigPad label.error {
            color: #f33;
        }

        .sigPad input {
            margin: 0;
            padding: 0.2em 0;
            width: 100%;

            border: 1px solid #666;

            font-size: 1em;
        }

        .sigPad input.error {
            border-color: #f33;
        }

        .sigPad button {
            margin: 1em 0 0 0;
            padding: 0.6em 0.6em 0.7em;

            background-color: #FF8C00;
            border: 0;
            -moz-border-radius: 8px;
            -webkit-border-radius: 8px;
            border-radius: 8px;

            cursor: pointer;

            color: #555;
            font: bold 1em/1.375 sans-serif;
            text-align: left;
        }

        .sigPad button:hover {
            background-color: #333;

            color: #fff;
        }

        .sig {
            display: none;
        }

        .sigNav {
            display: none;
            height: 2.25em;
            margin: 0;
            padding: 0;
            position: relative;

            list-style-type: none;
        }

        .sigNav li {
            display: inline;
            float: left;
            margin: 0;
            padding: 0;
        }

        .sigNav a,
        .sigNav a:link,
        .sigNav a:visited {
            display: block;
            margin: 0;
            padding: 0 0.6em;

            border: 0;

            color: #333;
            font-weight: bold;
            line-height: 2.25em;
            text-decoration: underline;
        }

        .sigNav a.current,
        .sigNav a.current:link,
        .sigNav a.current:visited {
            background-color: #666;
            -moz-border-radius-topleft: 8px;
            -moz-border-radius-topright: 8px;
            -webkit-border-top-left-radius: 8px;
            -webkit-border-top-right-radius: 8px;
            border-radius: 8px 8px 0 0;

            color: #fff;
            text-decoration: none;
        }

        .sigNav .typeIt a.current,
        .sigNav .typeIt a.current:link,
        .sigNav .typeIt a.current:visited {
            background-color: #ccc;

            color: #555;
        }

        .sigNav .clearButton {
            bottom: 0.2em;
            display: none;
            position: absolute;
            right: 0;

            font-size: 0.75em;
            line-height: 1.375;
        }

        .sigWrapper {
            clear: both;
            height: 400px;
            width: 100%;

            border: 1px solid #ccc;
        }

        .sigWrapper.current {
            border-color: #666;
        }

        .signed .sigWrapper {
            border: 0;
        }

        .pad {
            position: relative;

            /**
   * For cross browser compatibility, this should be an absolute URL
   * In IE the cursor is relative to the HTML document
   * In all other browsers the cursor is relative to the CSS file
   *
   * http://www.useragentman.com/blog/2011/12/21/cross-browser-css-cursor-images-in-depth/
   */
            cursor: url("signature/assets/pen.cur"), crosshair;
            /**
   * IE will ignore this line because of the hotspot position
   * Unfortunately we need this twice, because some browsers ignore the hotspot inside the .cur
   */
            cursor: url("pen.cur") 16 16, crosshair;

            -ms-touch-action: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
        }

        .typed {
            height: 85px;
            margin: 0;
            padding: 0 5px;
            position: absolute;
            z-index: 90;

            cursor: default;

            color: #145394;
            font: normal 1.875em/50px "Journal", Georgia, Times, serif;
        }

        .typeItDesc,
        .drawItDesc {
            display: none;
            margin: 0.75em 0 0.515em;
            padding: 0.515em 0 0;

            border-top: 3px solid #ccc;

            color: #000;
            font: italic normal 1em/1.375 Georgia, Times, serif;
        }

        p.error {
            display: block;
            margin: 0.5em 0;
            padding: 0.4em;

            background-color: #f33;

            color: #fff;
            font-weight: bold;
        }
    </style>
    <!--[if lt IE 9]><script src="../assets/flashcanvas.js"></script><![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
</head>

<body>

    <?php

    if (isset($_GET['orderD'])) {

        $MrE = $_GET['orderD'];

        $get = "SELECT * FROM `bookings` where order_id= '$MrE' ";

        $stmt = $DB->prepare( $get);

        foreach ($results as $1) {
            $ID = $row_type['order_id'];
            $Date = $row_type['Date'];
            $email_fro = $row_type['email'];
            $name = $row_type['Name'];
            $phone = $row_type['phone'];
            $delivery_type = $row_type['delivery_type'];
            $Total_price = $row_type['Total_price'];
            $service = $row_type['vehicle_type'];
            $order_number = $row_type['order_number'];
            $cost = "";
            $url = "";

            $get_commission = "SELECT * FROM `prizelist` ";

            $stmt = $DB->prepare( $get_commission);

            foreach ($results as $1) {

                $parcel_driver_commission = $row_type['parcel_driver_commission'];
                $freight_driver_commission = $row_type['freight_driver_commission'];
                $furniture_driver_commission = $row_type['furniture_driver_commission'];
            }

            if ($service == "Parcel Delivery") {
                $cost = $parcel_driver_commission / 100 * $Total_price;
            } else if ($service == "Freight Delivery") {
                $cost = $freight_driver_commission / 100 * $Total_price;
            } else if ($service == "Furniture Delivery") {
                $cost = $furniture_driver_commission / 100 * $Total_price;
            }
            $cost1 = number_format((float)$cost, 2, '.', '');
        }
    }

    ?>

    <?php
    $date = date("Y-m-d");
    $time = date("H:m");
    $datetime = $date . " " . $time;

    $user = $_SESSION['MM_Username'];

    $get = "SELECT * FROM `driver` where username = '$user' LIMIT 1 ";

    $stmt = $DB->prepare( $get);

    foreach ($results as $1) {
        $driverID = $row_type['driverID'];
        $username = $row_type['username'];
        $email = $row_type['email'];
        $drivername = $row_type['name'];
        $driverphone = $row_type['phone'];
    }

    ?>
    <form method="POST" action="signature.php" class="sigPad" name="completeSignature" enctype="multipart/form-data">
        <label for="name">Write your name</label>
        <input type="text" name="name" id="name" class="name">
        <input type="hidden" name="status" value="deliverd">
        <input type="hidden" name="delivery_type" value="<?php echo $delivery_type; ?>">
        <input type="hidden" name="status_update" value="<?php echo $datetime; ?>">
        <input type="hidden" name="id" value="<?php echo $ID; ?>">
        <input type="hidden" name="email_fro" value="<?php echo $email_fro; ?>">
        <input type="hidden" name="clientName" value="<?php echo $name; ?>">
        <input type="hidden" name="driverName" value="<?php echo $drivername; ?>">
        <input type="hidden" name="driverEmail" value="<?php echo $email; ?>">
        <input type="hidden" name="driverphone" value="<?php echo $driverphone; ?>">
        <input type="hidden" name="username" value="<?php echo  $username; ?>">
        <input type="hidden" name="phone" value="<?php echo  $phone; ?>">
        <input type="hidden" name="driver_amount" value="<?php echo  $cost1; ?>">
        <input type="hidden" name="order_number" value="<?php echo  $order_number; ?>">
        <p class="typeItDesc">Review your signature</p>
        <p class="drawItDesc">Draw your signature</p>
        <ul class="sigNav">
            <li class="typeIt"><a href="#type-it" class="current">Type It</a></li>
            <li class="drawIt"><a href="#draw-it">Draw It</a></li>
            <li class="clearButton"><a href="#clear">Clear</a></li>
        </ul>
        <div class="sig sigWrapper">
            <div class="typed"></div>
            <canvas class="pad" width="600" height="400"></canvas>
            <input type="hidden" name="output" class="output">
        </div>
        <label>Upload Proof Of delivery</label>
        <input type="file" name="img" class="form-control">
        <button type="submit">Submit</button>
        <input type="hidden" name="MM_update" value="completeSignature">
        <a href="new_orders.php"><button type="button">Back</button></a>
        <button type="submit" name="complete">Complete Order</button>

    </form>

    </div>
    </div>
    <!--collapse end-->

    <script src="signature/jquery.signaturepad.js"></script>
    <script>
        $(document).ready(function() {
            $('.sigPad').signaturePad();
        });
    </script>
    <script src="signature/assets/json2.min.js"></script>
</body>

</html>


