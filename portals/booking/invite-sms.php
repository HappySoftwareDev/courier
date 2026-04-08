<?php include ("../admin/pages/site_settings.php"); ?>

<?php
if (isset($_POST['phone'])) {

    $sms_phone = $_POST['phone'];
    $MM_redirect = "sms:$sms_phone?body=Hey there! You are being invited to try our transportation services at. We offer Parcel delivery, cargo freight, furniture removal, towing, and taxi bookings, visit<a href="https://<?php echo $web_url ?>/book/" ><?php echo ' . $web_url . '/book ; ?></a> signup today and do transportation the easy way.";
    header("Location: " . $MM_redirect);
}

?>


