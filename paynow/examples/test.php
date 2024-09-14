<?php

require_once '../autoloader.php';
$paynow = new Paynow\Payments\Paynow(
	 '3983',
    '35ae8280-ff18-4c62-af87-c83ce1d9c44c',
	'https://merchantcouriers.com/paynow/examples/test.php',

	// The return url can be set at later stages. You might want to do this if you want to pass data to the return url (like the reference of the transaction)
	'https://merchantcouriers.com/paynow/examples/callback.php?gateway=paynow'
);

$paynow->setResultUrl('https://merchantcouriers.com/paynow/examples/test.php');
$paynow->setReturnUrl('https://merchantcouriers.com/paynow/examples/callback.php');

$payment = $paynow->createPayment('Invoice 35', 'admin@merchantcouriers.co.zw');

$payment->add('Sadza and Beans', 1.25);

$response = $paynow->send($payment);


if($response->success()) {
    // Redirect the user to Paynow
    $response->redirect();

//     // Or if you prefer more control, get the link to redirect the user to, then use it as you see fit
//     $link = $response->redirectLink();

// 	$pollUrl = $response->pollUrl();


// 	// Check the status of the transaction
// 	$status = $paynow->pollTransaction($pollUrl);

}
?>