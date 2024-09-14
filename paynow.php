<?php
session_start();
error_reporting(E_ERROR);
$Connect = @mysqli_connect("localhost", "root", "", "kundaita_mc_db");

require_once 'paynow/autoloader.php';


$paynow = new Paynow\Payments\Paynow(
    '3983',
    '35ae8280-ff18-4c62-af87-c83ce1d9c44c',
    'http://merchantcouriers.com/paynow.php',
    'http://merchantcouriers.com/paynow.php'
);

$paynow->setResultUrl('https://merchantcouriers.com/paynow.php');
$paynow->setReturnUrl('https://merchantcouriers.com/callback.php?paynow-return=true&ref=' . $_GET['ref']);


/*
	if (isset($_GET['orderD'])){

	 $MrE = $_GET['orderD'];

	 $get = "SELECT * FROM `bookings` WHERE order_number='$MrE' Limit 1";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
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
$payment = $paynow->createPayment($mdescription, 'admin@merchantcouriers.co.zw');

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
