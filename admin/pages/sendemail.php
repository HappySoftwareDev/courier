<?php
header('Content-type: application/json');
require_once ('admin/pages/site_settings.php');
$status = array(
    'type' => 'success',
    'message' => 'Email sent!'
);

$name = @trim(stripslashes($_POST['name']));
$email = @trim(stripslashes($_POST['email']));

$email_from = <?php echo $bus_email ?>;
$email_to = $email;
$subject = '<img src="//images/logo.png" alt="logo">';
$message = 'Hi!\n '.<?php echo $site_name ?>.'  has invited you to signup to become a driver.\n\n <a href="adminSignup.php">Click here</a> to enter your details.';

$body = 'Email: ' . $email . "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;

$success = @mail($email_to, $subject, $body, 'From: <' . $email_from . '>');

echo json_encode($status);
die;
