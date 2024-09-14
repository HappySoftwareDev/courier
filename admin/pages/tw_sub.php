<?php require ("get-sql-value.php");

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['affiliate_no'])) {
    $affiliate_no = $_POST['affiliate_no'];
    $type = "twitter";

    $insertSQL = sprintf("INSERT INTO `affilate_invites`(`type`, `affiliate_no`) VALUES ('$type', '$affiliate_no')");

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());
    echo "<script>window.open('index.php','_self')</script>";
}

?>
