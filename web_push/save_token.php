<?php 
require_once('../db.php');

if(isset($_POST["token"])){
$token = $_POST["token"];

try {
    $stmt = $Connect->prepare("SELECT * FROM push_tokens WHERE token=:token");
    $stmt->execute(array(":token" => $token));
    $count = $stmt->rowCount();
  
  if($count == 0){
     $stmt = $Connect->prepare("INSERT INTO push_tokens (token) VALUES (:token)"); 
     $stmt->bindparam(":token", $token);
     
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