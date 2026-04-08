<?php
	$aData = json_decode(file_get_contents("website.json"));
	$aLogoData = json_decode(file_get_contents("logo.json"));
	$site_name = !empty($aData->site_name) ? $aData->site_name : "";
	$web_url = !empty($aData->url) ? $aData->url : "";
	$logo = !empty($aLogoData->logo->name) ? $aLogoData->logo->name : "";
	$bus_address = !empty($aData->bus_address) ? $aData->bus_address : "";
	$bus_phone = !empty($aData->bus_phone) ? $aData->bus_phone : "";
	$bus_email = !empty($aData->bus_email) ? $aData->bus_email : "";
	$firebase_config = !empty($aData->firebase_config) ? $aData->firebase_config : "";
	$firebase_push_key = !empty($aData->firebase_push_key) ? $aData->firebase_push_key : "";
	$recapcha_key = !empty($aData->recapcha_key) ? $aData->recapcha_key : "";
	$facebook_pixel = !empty($aData->facebook_pixel) ? $aData->facebook_pixel : "";
	$analytics_key = !empty($aData->analytics_key) ? $aData->analytics_key : "";
	
	
?>

<!-- Include sidebar navigation and menu -->
<?php include 'admin-nav.php'; ?>


