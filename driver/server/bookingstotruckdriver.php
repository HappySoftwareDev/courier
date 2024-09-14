function getBookingsToTruckDrivers(){

$user = $_SESSION['MM_Username'];
global $Connect;

$get_driver = "SELECT * FROM driver WHERE username='$user' ";

$run_driver = mysqli_query($Connect,$get_driver);

while ($row_type = mysqli_fetch_array($run_driver)){
$ID = $row_type['driverID'];
$company_name = $row_type['company_name'];
$online = $row_type['online'];
$mode_of_transport = $row_type['mode_of_transport'];
$type_of_service = $row_type['type_of_service'];
$username = $row_type['username'];

$get = "SELECT * FROM `users` WHERE Name='$company_name'";

$run = mysqli_query($Connect,$get);

while ($row_type = mysqli_fetch_array($run)){
$ID = $row_type['ID'];
$Name = $row_type['Name'];
$Email = $row_type['email'];
$date = $row_type['date'];
$days = $row_type['days'];

$expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date))."+ $days day"));

if(date("Y-m-d") < $expire){ $get="SELECT * FROM bookings WHERE status ='new' AND vehicle_type='$type_of_service' AND company_name='$company_name' ORDER BY Date DESC LIMIT 8 " ; $run=mysqli_query($Connect,$get); while ($row_type=mysqli_fetch_array($run)){ $ID=$row_type['order_id']; $Date=$row_type['Date']; $email_fro=$row_type['email']; $address=$row_type['pick_up_address']; $drop_address=$row_type['drop_address']; $name=$row_type['Name']; $phone=$row_type['phone']; $pick_up_date=$row_type['pick_up_date']; $drop_date=$row_type['drop_date']; $Drop_name=$row_type['Drop_name']; $Total_price=$row_type['Total_price']; $drop_phone=$row_type['drop_phone']; $weight_of_package=$row_type['weight']; $package_quantity=$row_type['quantity']; $insurance=$row_type['insurance']; $value_of_package=$row_type['value']; $type_of_transport=$row_type['type_of_transport']; $note=$row_type['drivers_note']; $time=$row_type['pick_up_time']; $service=$row_type['vehicle_type']; $drop_time=$row_type['drop_time']; if($service=="Parcel Delivery" ){ $url="order_datails.php?orderD=$ID" ; $cost=70 / 100 * $Total_price; } else if($service=="Freight Delivery" ){ $url="freight_order_details.php?orderD=$ID" ; $cost=80 / 100 * $Total_price; } else if($service=="Test" ){ $url="freight_order_details.php?orderD=$ID" ; $cost=70 / 100 * $Total_price; } $cost1=number_format((float)$cost, 2, '.' , '' ); if ($online=="offline" ){ echo "
		  <ul class='list-group'>
                 <li class='list-group-item' ><a  style=' color:#ff8c00;' href='#'> Order From $name <button class='btn btn-info btn-sm pull-right'>new</button></a> <br> $$cost1 </li>

				</ul>
		 " ; } else { echo "
	       <tr>
		   <ul class='list-group'>
                 <li class='list-group-item' ><a  style=' color:#ff8c00;' href='freight_order_details.php?orderD=$ID'> Order From $name <button class='btn btn-info btn-sm pull-right'>new</button></a> <br> $$cost1 </li>

				</ul>
            </tr>
			" ; } } }else{ echo "<div style='color:red'><h2>Your account has expired please recharge!<h2></div>" ; } } } }
