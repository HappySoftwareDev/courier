<?php 

require_once '../autoloader.php';
session_start();

$paynow = new Paynow\Payments\Paynow(
    '3983',
    '35ae8280-ff18-4c62-af87-c83ce1d9c44c',
    'http://merchantcouriers.com/paynow/examples/index.php',
    'http://merchantcouriers.com/paynow/examples/index.php'
);

$paynow->setResultUrl('https://merchantcouriers.com/paynow/examples/index.php');
$paynow->setReturnUrl('https://merchantcouriers.com/paynow/examples/callback.php?paynow-return=true');


$payment = $paynow->createPayment('Order 4','admin@merchantcouriers.co.zw');


$payment->add('Sadza and Cold Water',10);
        

// Optionally set a description for the order.
// By default, a description is generated from the items
// added to a payment
$payment->setDescription("Mr Maposa's lunch order");


// Initiate a Payment 
$response = $paynow->send($payment);


?>

<?php if(isset($_GET['paynow-return'])): ?>
<script>
    alert('Thank you for your payment!');
    
</script>

<?php 

if($response->success()) {
    // Or if you prefer more control, get the link to redirect the user to, then use it as you see fit
    $link = $response->redirectUrl();

  
    
}
?>
<?php endif; ?>

<?php if(!$response->success): ?>

    <h2>An error occured while communicating with Paynow</h2>
    <p><?= $response->error ?></p>

<?php else:
$_SESSION['pollurl']=$response->pollUrl();
?>

    <a href="<?= $response->redirectUrl() ?>">Click here to make payment of $<?= $payment->total ?></a>

<?php endif; ?>


