<?php


	header('Content-type: application/json');
	$status = array(
		'type'=>'success',
		'message'=>'Email sent!'
	);

    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $email_from =  "orders@merchantcouriers.co.zw";
    $email_to = 'bamhara1@gmail.com';
    $subject = 'New Message';

    $body = 'Name: ' . $name . $lastname. "\n\n" . 'Email: ' . $email . "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;

    $success = @mail($email_to, $subject, $body, 'From: <'.$email_from.'>');


    echo json_encode($status);
    die;
