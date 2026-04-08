<?php
/**
 * Paynow Payment Gateway Integration
 * Handles PayNow payment processing for bookings
 */

// Load centralized bootstrap
require_once '../../config/bootstrap.php';

// Load legacy site settings for compatibility
if (file_exists('../../admin/pages/site_settings.php')) {
    include('../../admin/pages/site_settings.php');
}

// Load Paynow payment library
require_once '../../paynow/autoloader.php';

// Initialize Paynow payment gateway
$paynow = new Paynow\Payments\Paynow(
    '3983',
    '35ae8280-ff18-4c62-af87-c83ce1d9c44c',
    'https://' . ($web_url ?? $_SERVER['HTTP_HOST']) . '/portals/payments/paynow.php',
    'https://' . ($web_url ?? $_SERVER['HTTP_HOST']) . '/portals/payments/paynow.php'
);

$paynow->setResultUrl('https://' . ($web_url ?? $_SERVER['HTTP_HOST']) . '/portals/payments/paynow.php');
$paynow->setReturnUrl('https://' . ($web_url ?? $_SERVER['HTTP_HOST']) . '/portals/payments/callback.php?method=paynow&ref=' . ($_GET['ref'] ?? 'unknown'));


/*
	if (isset($_GET['orderD'])){

	 $MrE = $_GET['orderD'];

	 $get = "SELECT * FROM `bookings` WHERE order_number='$MrE' Limit 1";

	 $stmt = $DB->prepare($get); $stmt->execute(); $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	 foreach ($results as $1){
		$ID = $row_type['order_id'];
		$order_number = $row_type['order_number'];
		$Date = $row_type['Date'];
		$email_fro = $row_type['email'];
	    $address = $row_type['pick_up_address'];
        $drop_address = $row_type['drop_address'];
		$name = $row_type['Name'];
		$phone = $row_type['phone'];
		$pick_up_date = $row_type['pick_up_date'];
		$drop_date = $row_type['drop_date'];
		$Drop_name = $row_type['Drop_name'];
		$Total_price = $row_type['Total_price'];
		$drop_phone = $row_type['drop_phone'];
		$weight_of_package = $row_type['weight'];
		$package_quantity = $row_type['quantity'];
		$insurance = $row_type['insurance'];
		$value_of_package = $row_type['value'];
		$type_of_transport = $row_type['type_of_transport'];
		$note = $row_type['drivers_note'];
		$time = $row_type['pick_up_time'];
		$drop_time = $row_type['drop_time'];
		$invoice = $row_type['invoice'];



	  }
	  }
	 //*/

$order_number = $_GET['orderD'];
$Total_price = $_GET['amount'];
$mdescription = $order_number . " order payment";
$payment = $paynow->createPayment($mdescription, 'admin@' . $web_url . '');

$description = $order_number . " Invoice Payment";
$payment->add($description, $Total_price);

// Optionally set a description for the order.
// By default, a description is generated from the items
// added to a payment
$payment->setDescription($description);


// Initiate a Payment
$response = $paynow->send($payment);


?>




<?php if (!$response->success) { ?>

    <h2>An error occured while communicating with Paynow</h2>
    <p><?= print_r($response); ?></p>

<?php } else {

    unset($_SESSION['ID']);
    unset($_SESSION['oid']);
    unset($_SESSION['pollurl']);
    unset($_SESSION['orderD']);

    $_SESSION['pollurl'] = $response->pollUrl();
    $_SESSION['ID'] = $ID;
    $_SESSION['oid'] = $order_number;
    $_SESSION['orderD'] = $order_number;
?>

    <!--a id="paymentlink" href="<?= $response->redirectUrl() ?>" >Click here to make payment of $<?= $payment->total ?></a-->
    <script type="text/javascript">
        // document.getElementById("paymentlink").click();
        window.location = "<?php echo $response->redirectUrl(); ?>";
    </script>
<?php }  ?>

