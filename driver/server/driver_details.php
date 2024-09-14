<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

$Connect = @mysqli_connect("localhost","iobagcmg_merchant_admin","}{kTftfu1449", "iobagcmg_merchant_db");

 $date= date("Y-m-d");
 $time=date("H:m");
 $datetime=$date."T".$time;

 if(isset($_GET["driva"])){
  $user = $_GET['driva'];

  $get = "SELECT * FROM `driver` where username='$user' ";

  $run = mysqli_query($Connect,$get);

  while ($row_type = mysqli_fetch_array($run)){
  $driverID = $row_type['driverID'];
  $username = $row_type['username'];
  $email = $row_type['email'];
  $drivername = $row_type['name'];
  $vehicleMake = $row_type['vehicleMake'];
  $RegNo = $row_type['RegNo'];

  echo "<input type='hidden' id='username' value=' $username'>
        <input type='hidden' id='email' value=' $email'>
        <input type='hidden' id='drivername' value='$drivername'>
        <input type='hidden' id='vehicleMake' value='$vehicleMake'>
        <input type='hidden' id='RegNo' value='$RegNo'>
      ";
  }
 }
