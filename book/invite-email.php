<?php
if (isset($_POST['email'])) {
    $email_client = $_POST['email'];
    $subject = "Invitation";

    $htmlContent = '
    <html>
    <head>
        <title>Merchant Couriers</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">Merchant Couriers</h1>
        <h3>We Deliver With Speed!</h3>
		<p>Hello<p/>
		<p>You are being invited to try our delivery booking app www.merchantcouriers.com/book/</p>

		<p>Below is a list of our services.</p>

		<table cellspacing="0" style="border: 2px dashed #FF8C00; width: 300px;">
            <tr style="background-color: #e0e0e0;">
			<th>Parcel delivery:</th><td>Motorbikes & Small cars</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Light Freight:</th><td>Vans & Small trucks</td>
			</tr>

			<tr style="background-color: #e0e0e0;">
			<th>Heavy haualage:</th><td>30t trucks & Box trucks</td>
			</tr>

        </table>

       <h3> <a href="www.merchantcouriers.com/book/">Go ahead and try us we offer quality affordable services.</a> </h3>


		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.com. Alternatively you can call/whatsapp on +263772467352 or +263779495409. <br/>
        PLEASE DO NOT REPLY TO THIS EMAIL.
		</p>

		<h4 style="color:#FF8C00">Merchant Couriers</h4>
		<p>We Deliver With Speed.</p>
		</div>
		</footer>
		</div>
    </body>
    </html>';

    // Set content-type header for sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Additional headers
    $headers .= 'From: Merchant Couriers<admin@merchantcouriers.com>' . "\r\n";

    // Send email
    if (mail($email_client, $subject, $htmlContent, $headers)) :
        $successMsg = 'Email has sent successfully.';
    else :
        $errorMsg = 'Email sending fail.';
    endif;

    $MM_redirect = "signin.php";
    echo "<script>alert('Invitation sent thank you for sharing our services!')</script>";
    header("Location: " . $MM_redirect);
}

?>