<?php require("function.php"); ?>

<?php require ("login-security.php"); ?>

<?php require ("get-sql-value.php"); 

require_once 'paynow/autoloader.php';


/**
 * Just a small dummy logger. Remove in production
 *
 * @param StatusResponse $status
 * @return void
 */
function dummy_logger($status)
{

    $str =  sprintf("Recieved updated from Paynow --> Payment Status: %s || ", $status->status());

    $str .= sprintf("Transaction ID: %s || ", $status->reference());
    $str .= sprintf("Paynow Reference: %s \n\n", $status->paynowReference());

    file_put_contents(__DIR__ . '/status.logs', $str);
}

$paynow = new Paynow\Payments\Paynow(
    '3983',
    '35ae8280-ff18-4c62-af87-c83ce1d9c44c',
    'https://merchantcouriers.com/paynow/examples/index.php?paynow-return=true',
    'https://merchantcouriers.com/paynow/examples/callback.php'
);

$paynow->setResultUrl('https://merchantcouriers.com/paynow/examples/index.php?paynow-return=true');
$paynow->setReturnUrl('https://merchantcouriers.com/paynow/examples/callback.php');

$pollUrl = $_SESSION['pollurl'];



$status = $paynow->pollTransaction($pollUrl);
$data = array('status' => false, 'msg' => "", 'data' => array());
$_SESSION['payment'] = json_encode($data);
if ($status->paid()) {
    unset($_SESSION['pollurl']);
    // Update transaction in DB maybe?
    $reference =  $status->reference();
    $data['msg'] = 'Your Payment has been Successful!';
    $data['status'] = true;
    $data['data'] = $status;
    $_SESSION['payment'] = json_encode($data);
    // Get the reference of the Payment in paynow
    // $paynowReference = $status->paynowReference();
    // $transaction_details=json_encode($status);
    // $_SESSION['pay_msg']="PAYMENT SUCEESS";
    // mysqli_query($Connect,"update bookings set invoice='PAID',transaction_details='".$transaction_details."' where order_id='".$_SESSION['ID']."' ");
    if ($_GET['ref'] == "parcel") $link = "submit_parser1.php";
    if ($_GET['ref'] == "freight") $link = "courier_submit.php";
    if ($_GET['ref'] == "furniture") $link = "furniture_sub.php";
    if ($_GET['ref'] == "invoice") $link = "invoice.php?orderD=" . $_SESSION['orderD'] . "&status=1";
    // unset($_SESSION['ID']);
    // unset($_SESSION['oid']);
    header("Location:$link");
    exit;
} else {
    if ($_GET['ref'] == "parcel") $link = "submit_parser1.php";
    if ($_GET['ref'] == "freight") $link = "courier_submit.php";
    if ($_GET['ref'] == "furniture") $link = "furniture_sub.php";
    if ($_GET['ref'] == "invoice") $link = "invoice.php?orderD=" . $_GET['orderD'];
    header("Location:$link");

    exit;
}

?>