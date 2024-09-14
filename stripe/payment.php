<?php
if (!isset($_SESSION)) session_start();
$data = array('status' => false, 'msg' => "", 'data'=> array());

// Check whether stripe token is not empty 
if(!empty($_POST['tokenId'])){
    // Retrieve stripe token, card and user info from the submitted form data 
    $token  = $_POST['tokenId']; 
    // $name = $_POST['name']; 
    // $email = $_POST['email']; 
     
    // Include Stripe PHP library 
    require_once('vendor/autoload.php');
      $aData = json_decode(file_get_contents("../keys.json"));
    // $stripeSecret = 'sk_test_Tu3yfabqo5dOPDi4VAwzx2Oq';
    $stripeSecret = $aData->stripeSk;
    // Set API key 
    \Stripe\Stripe::setApiKey($stripeSecret); 
     
    // Add customer to stripe 
    // try {  
    //    $customer = \Stripe\Customer::create(array( 
    //        'email' => $email, 
    //        'source'  => $token 
    //    )); 
    // }catch(Exception $e) {  
    //    $api_error = $e->getMessage();  
    //} 
     
    // if(empty($api_error) && $customer){  
         
    // Convert price to cents 
       $itemPriceCents = ($_POST['amount']*100); 
         
    // Charge a credit or a debit card 
        try {  
            $charge = \Stripe\Charge::create(array(
                "amount" => $itemPriceCents,
                "currency" => "usd",
                "description" => "stripe integration in PHP with source code - tutsmake.com",
                "source" => $token,
       ));
        }catch(Exception $e) {  
            $api_error = $e->getMessage();  
        } 
         
        if(empty($api_error) && $charge){ 
         
            // Retrieve charge details 
            $chargeJson = $charge->jsonSerialize(); 
            // $data['msg'] = 'Your Payment has been Successful!'; 
            // $data['status'] = true;
            // $data['data'] = $chargeJson;
            // Check whether the charge is successful 
            if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){ 
                // Transaction details  
                $transactionID = $chargeJson['balance_transaction']; 
                $paidAmount = $chargeJson['amount']; 
                $paidAmount = ($paidAmount/100); 
                $paidCurrency = $chargeJson['currency']; 
                $payment_status = $chargeJson['status']; 
                 
                // Include database connection file  
                // include_once 'dbConnect.php'; 
                 
                // Insert tansaction data into the database 
                // $sql = "INSERT INTO orders(name,email,item_name,item_number,item_price,item_price_currency,paid_amount,paid_amount_currency,txn_id,payment_status,created,modified) VALUES('".$name."','".$email."','".$itemName."','".$itemNumber."','".$itemPrice."','".$currency."','".$paidAmount."','".$paidCurrency."','".$transactionID."','".$payment_status."',NOW(),NOW())"; 
                // $insert = $db->query($sql); 
                // $payment_id = $db->insert_id; 
                 
                // If the order is successful 
                if($payment_status == 'succeeded'){ 
                    // $ordStatus = 'success';
                    $data['msg'] = 'Your Payment has been Successful!'; 
                    $data['status'] = true;
                    $data['data'] = $chargeJson;
                }else{ 
                    $data['msg'] = "Your Payment has Failed!"; 
                } 
            }else{ 
                $data['msg'] = "Transaction has been failed!"; 
            } 
        }else{ 
            $data['msg'] = "Charge creation failed! $api_error";  
        } 
    //}else{  
    //    $data['msg'] = "Invalid card details! $api_error";  
    //} 
}else{ 
    $data['msg'] = "Error on form submission."; 
}
$sResponse = json_encode($data);
$_SESSION['payment'] = $sResponse;
echo $sResponse;
