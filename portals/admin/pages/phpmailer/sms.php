<?php
	$to = "+923086932462@jazz.com.pk";
$from = "info@siteronics.com";
$message = "This is a text message\nNew line...";
$headers = "From: $from\n";
if(mail($to, '', $message, $headers))
{
	echo "done";
}


