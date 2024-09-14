<?php
require_once('db.php');

if (isset($_POST["insertZone"])) {
   $zone=$_POST['zone'];
   $zoneprice=$_POST['zoneprice'];
   $weightprice=$_POST['weightprice'];
   $assigned_zone=$_POST['assigned_zone'];
   $country=$_POST['country'];

try
  {
   if($zone != ""){
   $stmt = $Connect->prepare("SELECT * FROM inter_zones WHERE zone=:id AND weight_price=$weightprice");
   $stmt->execute(array(":id"=>$zone));
   $count = $stmt->rowCount();
   if($count==0){$stmt = $Connect->prepare("INSERT INTO `inter_zones`(`zone`, `zone_price`, `weight`) VALUES(:zone, :zone_price, :weight_price)");
		$stmt->bindparam(":zone",$zone);
		$stmt->bindparam(":zone_price",$zoneprice);
		$stmt->bindparam(":weight_price",$weightprice);

	 if($stmt->execute()){
        	 echo "<script>alert('Zone uploaded.')</script>";
             echo "<script>window.open('integration.php','_self')</script>";
	 }
	 else{
		echo "Query could not execute";
		}
	 }

   else if($count!=0){
	  echo "Zone and Weight combination already exist"; // user email is taken
   }
   }
//  Country submition ----------------------------------------------------------------------
   if($country != ""){
	        $stmt = $Connect->prepare("SELECT * FROM countries WHERE country=:id");
            $stmt->execute(array(":id"=>$country));
            $count = $stmt->rowCount();
               if($count==0){$stmt = $Connect->prepare("INSERT INTO `countries`(`country`, `assigned_zone`) VALUES (:country, :assigned_zone)");
            		$stmt->bindparam(":country",$country);
            		$stmt->bindparam(":assigned_zone",$assigned_zone);

            		 if($stmt->execute()){
            		     echo "<script>alert('Country uploaded.')</script>";
                         echo "<script>window.open('integration.php','_self')</script>";
            		  }else{
                    		echo "Query could not execute";
                    		}
               } else {
                	  echo "Country already exist"; // user email is taken
                   }
	    }

 }// end of try block

 catch(PDOException $e){
       echo $e->getMessage();
  }

 }//end post