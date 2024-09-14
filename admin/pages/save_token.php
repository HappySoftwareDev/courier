<?php 
if (!isset($_SESSION)) {
    session_start();
}
require_once('../../db.php');

if(isset($_POST["token"])){
$token = $_POST["token"];
$username = $_SESSION['MM_Username'];

try {
    $stmt = $Connect->prepare("SELECT * FROM admin WHERE push_token=:token && email='$username'");
    $stmt->execute(array(":token" => $token));
    $count = $stmt->rowCount();
  
  if($count == 0){
     $stmt = $Connect->prepare("UPDATE admin SET  push_token=:token WHERE email=:username"); 
     $stmt->bindparam(":token", $token);
     $stmt->bindparam(":username", $username);
     
     if ($stmt->execute()) {
        echo "OK";
     }
  } else{
         echo "exist"; //token already exist
     }
    
}catch (PDOException $e) {
        echo $e->getMessage();
    }
    
}
?>