<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

define('DBhost','localhost');
define('DBuser','iobagcmg_merchant_admin');
define('DBname','iobagcmg_merchant_db');
define('DBpass','}{kTftfu1449');

 try{

  $DB_con = new PDO("mysql:host=".DBhost.";dbname=".DBname,DBuser,DBpass);

 }catch(PDOException $e){

  die($e->getMessage());
 }

if (isset($_POST['driver_name'])) {

	$username = trim($_POST['driver_name']);
	$lati = trim($_POST['latitude']);
	$lng = trim($_POST['longitude']);

try
  {

   $stmt = $DB_con->prepare("SELECT * FROM `driver` WHERE username=:username");
   $stmt->execute(array(":username"=>$username));
   $count = $stmt->rowCount();

   if($count==1){
	$stmt = $DB_con->prepare("UPDATE `driver` SET lat=:lati, lng=:lng WHERE username=:username");
    $stmt->bindparam(":lati",$lati);
	$stmt->bindparam(":lng",$lng);
	$stmt->bindparam(":username",$username);


	//check if query executes
	if($stmt->execute()){

		echo 2;
	}
	else{

		echo "Query could not execute";
		}
   }//end of integrity check

   else {
	  echo "1"; // user email is taken
   }

 }// end of try block

 catch(PDOException $e){
       echo $e->getMessage();
  }

 }//end post
 else{

	 echo "Nothing has been posted"; // user email is taken
 }


 //echo json_encode($response);
