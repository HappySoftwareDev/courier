<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['down'])) {
    $type = "driver_app";

    $insertSQL = sprintf("INSERT INTO `app_download`(`app`) VALUES ('$type')");

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());
    echo "<script>window.open('mobile_apps/MerchantCouriersDriver.apk','_self')</script>";
}

?>
