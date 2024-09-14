<?php

require_once '../autoloader.php';
session_start();
echo $_SESSION['pollurl'];

/**
 * Just a small dummy logger. Remove in production
 *
 * @param StatusResponse $status
 * @return void
 */
function dummy_logger($status) {

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

  $pollUrl =$_SESSION['pollurl'];
  

    // Check the status of the transaction
    
    $status = $paynow->pollTransaction($pollUrl);

if($status->paid()) {
    unset($_SESSION['pollurl']);
    // Update transaction in DB maybe? 
    $reference =  $status->reference();


    // Get the reference of the Payment in paynow
    $paynowReference = $status->paynowReference();

    // Log out the data
    dummy_logger($status);
    echo  "Yay! Transaction was paid for";
} else {
    print("Why you no pay?");
}

