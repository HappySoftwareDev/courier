<?php
if(isset($_POST['phone'])) {
$phone_client = $_POST['phone'];
$from_add2 = $_POST['address'];
$to_add2 = $_POST['drop_address'];
$p_weight = $_POST['weight'];
$p_insure = $_POST['insurance'];
$num_item = $_POST['quantity'];
$d_price = $_POST['Total_price'];
$distance = $_POST['distance'];
$p_value = $_POST['value'];
$v_type = $_POST['transport'];


 $sms_phone = $phone_client;
     $uname = "Business";
     $pwd = "Merchant2017";
     $id = "5cb7afb730f8fefe60780e67871c117f";
     $sms_msg = 'Pick Up Address:'.$from_add2.'. Destination Address: '.$to_add2.'. Weight: '.$p_weight.'. Value:'.$p_value.'. Quantity:'.$num_item.'. Transport:'.$v_type.'. Insurance:'.$p_insure.'. Distance:'.$distance.' Merchan Couries! Your quote Price is ' . $d_price.' https://www.merchantcouriers.com/booking.php click here to book now.  For any further inquiries please contact us via the contact page on our website www.merchantcouriers.com. Alternatively you can call/whatsapp on +263772467352 or +263779495409. ';
     $data ="&u=".$uname."&h=".$id."&op=pv&to=".$sms_phone."&msg=".urlencode($sms_msg);

     $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     $result = curl_exec($ch);
     curl_close($ch);
      echo "OK";

    }
