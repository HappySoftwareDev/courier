<?php 
	function send_mail($message='This is test message', $subject='Test Mail', $to='mudasarali88@gmail.com')
	{
	   $email = \Config\Services::email();
	 	$config['protocol'] = 'mail';
// 	 	$config['protocol'] = 'smtp';
	 	$config['SMTPHost'] = 'smtp.gmail.com';
	 	$config['SMTPUser'] = 'mahi9698224@gmail.com';
	 	$config['SMTPPort'] = 587;
	 	$config['SMTPPass'] = 'visitlahore';
	 	$config['SMTPCrypto'] = 'ssl';
		$config['charset']  = 'iso-8859-1';
		$config['wordWrap'] = true;
		$config['mailType'] = 'html';

		$email->initialize($config);
	   
	   $email->setFrom('api@merchantcouriers.com', 'Merchant Couriers');
	   $email->setTo($to);
	   $email->setSubject($subject.' | merchantcouriers.com');
	   $email->setMessage($message);//your message here
	 
	   /*$email->setCC('another@emailHere');//CC
	   $email->setBCC('thirdEmail@emialHere');// and BCC
	   $filename = '/img/yourPhoto.jpg'; //you can use the App patch 
	   $email->attach($filename);*/
	    // var_dump($email);
	   if($email->send())
	   {
	   	return true;
	   	//var_dump('expression');
	   }
	   else
	   {
	   	$ok = $email->printDebugger();

	   	var_dump($ok); die;

	   }
}
 ?>