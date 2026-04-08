<?php
require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer();

//$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPDebug = 2;
$mail->SMTPSecure = "ssl";
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = 'mahi9698224@gmail.com';
$mail->Password = 'mahi12345';

$mail->setFrom('clientes@puntoseguro.com', 'Senaid Bacinovic');
$mail->addAddress('mudasarali88@gmail.com');
$mail->Subject = 'SMTP email test';
$mail->Body = 'this is some body';

if ($mail->send())
    echo "Mail sent";


