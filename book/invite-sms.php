<?php
if (isset($_POST['phone'])) {

    $sms_phone = $_POST['phone'];
    $MM_redirect = "sms:$sms_phone?body=Hey there! You are being invited to try our delivery booking app.
    We offer Parcel delivery, Light Freight and Heavy haualage visit www.merchantcouriers.com/book/ 
    and signup today and start delivering your goods the easy way.";
    header("Location: " . $MM_redirect);
}

?>
