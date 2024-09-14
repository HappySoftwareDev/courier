<?php

// var_dump('ssssss'); die;
// $Connect = @mysqli_connect("localhost","root","", "kundaita_mc_db");
$hostname_Connect = "localhost";
$database_Connect = "mcdb";
$username_Connect = "root";
$password_Connect = "";
$Connect = @mysqli_connect($hostname_Connect, $username_Connect, $password_Connect, $database_Connect);
// error_reporting(1);
function getApiUsers()
{
	global $Connect;
	$data = array();
	$q = "SELECT * FROM api_users";
	$run = mysqli_query($Connect, $q);
	while($row = mysqli_fetch_array($run))
	{
		$data[] = $row;
	}
	// var_dump($run);
	// var_dump($Connect);
	return $data;
}

function delete_API_user($id)
{
	global $Connect;
	$data = array();
	$q = "DELETE FROM api_users WHERE id=$id";
	$run = mysqli_query($Connect, $q);
	return true;

}
function getUserStores($id)
{
	global $Connect;
	// $data = array();
	$q = "SELECT count(id) as total FROM api_users_business WHERE api_user_id = $id";
	$run = mysqli_query($Connect, $q);
	$row = mysqli_fetch_array($run);
	return $row['total'];
}
function getUserorders($id)
{
	global $Connect;
	// $data = array();
	$q = "SELECT count(id) as total FROM booking JOIN api_users_business ON booking.store_id = api_users_business.id WHERE api_users_business.api_user_id = $id";
	$run = mysqli_query($Connect, $q);
	$row = mysqli_fetch_array($run);
	return $row['total'];
}

 function getClients(){
	 global $Connect;

	 $get = "SELECT * FROM `clients`";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['client_id'];
		 $Name = $row_type['Name'];
		 $Email = $row_type['Email'];
		 $Pass = $row_type['Password'];

      echo "<tr>
                <td> $ID</td>
                <td>$Name</td>
                <td>$Email</td>
                <td>$Pass</td>
				<td><a href='delete.php?delete=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";

		 }
	 }

	function getUsers(){
	 global $Connect;

	 $get = "SELECT * FROM `admin`";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['ID'];
		 $Name = $row_type['Name'];
		 $Email = $row_type['Email'];
		 $phone = $row_type['phone'];

      echo "<tr>
                <td> $ID</td>
                <td>$Name</td>
                <td>$Email</td>
                <td>$phone</td>
				<td><a href='delete.php?deleteAdUser=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";

		 }
	 }

	 function getInvited(){
	 global $Connect;

	 $get = "SELECT * FROM `invite`";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['id'];
		 $date = $row_type['date'];
		 $email = $row_type['email'];
		 $msg = $row_type['msg'];

      echo "<tr>
                <td> $ID</td>
                <td>$date</td>
                <td>$email</td>
                <td>$msg</td>
				<td><a href='delete.php?deleteInvitation=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";

		 }
	 }

	 function getAffAlerts(){
	 global $Connect;

	 $get = "SELECT * FROM `affiliate_msg` order by date DESC LIMIT 5";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['id'];
		 $date = $row_type['date'];
		 $sub = $row_type['subject'];
		 $msg = $row_type['msg'];

      echo "<tr>
                <td> $ID</td>
                <td>$date</td>
                <td>$sub</td>
                <td>$msg</td>
				<td><a href='affiliate.alerts.php?delete_affAlert=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";

		 }
	 }

	 function getDriverAlerts(){
	 global $Connect;

	 $get = "SELECT * FROM `driver_alerts`";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['id'];
		 $date = $row_type['date'];
		 $sub = $row_type['subject'];
		 $msg = $row_type['msg'];

      echo "<tr>
                <td> $ID</td>
                <td>$date</td>
                <td>$sub</td>
                <td>$msg</td>
				<td><a href='driver_alerts.php?delete_drAlert=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";

		 }
	 }

	 function getCustomerAlerts(){
	 global $Connect;

	 $get = "SELECT * FROM `customer_alerts`";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['id'];
		 $date = $row_type['date'];
		 $sub = $row_type['subject'];
		 $msg = $row_type['msg'];

      echo "<tr>
                <td> $ID</td>
                <td>$date</td>
                <td>$sub</td>
                <td>$msg</td>
				<td><a href='customer_alerts.php?delete_custAlert=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";

		 }
	 }

	 function getAffiliate(){
	 global $Connect;
	 $get = "SELECT * FROM `affilate_user` ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['id'];
		 $Name = $row_type['name'];
		 $Email = $row_type['email'];
		 $phone = $row_type['phone'];
		 $address = $row_type['address'];
		 $password = $row_type['password'];
		 $affialte_no = $row_type['affialte_no'];
		 $balance = $row_type['balance'];
	$p = "";
	$bl = "<p><a href='affiliate.php?block_aff=$affialte_no'><button type='button' class='btn btn-xs btn-danger btn-block'>Block</button></a></p>";
	if($password == "b10ck3d"){
	    $p="<h4>BLOCKED</h4>";
	    $bl = "<p><a href='affiliate.php?unblock_aff=$affialte_no'><button type='button' class='btn btn-xs btn-success btn-block'>Unblock</button></a></p>";
	}

        $cost1 = "0";
        $cost1 = $balance;
		$tot = number_format((float)$cost1, 2, '.', '');

	 $getr = "SELECT * FROM `affiliate_payouts` WHERE affiliate_no='$affialte_no'";
	 $status = "";
	 $runr = mysqli_query($Connect,$getr);
	  $toti = "0.00";
	 while ($row_type = mysqli_fetch_array($runr)){
		 $status = $row_type['status'];
		 $pric = array($row_type['amount_paid']);
	     $tota = array_sum($pric);

       $c += $tota;
	   $toti = number_format((float)$c, 2, '.', '');
	 }
	 $geto = "SELECT * FROM `payment_methods` WHERE affiliate_no='$affialte_no'";

	 $runo = mysqli_query($Connect,$geto);
	 $bank_acc = "";
	 $bank_acc_name ="";
	 $bank_name="";
	 $ecocash_num ="";
	 $branch="";
	 while ($row_type = mysqli_fetch_array($runo)){
		 $ID = $row_type['id'];
		 $bank_acc = $row_type['bank_acc'];
		 $bank_acc_name = $row_type['bank_acc_name'];
		 $bank_name = $row_type['bank_name'];
		 $ecocash_num = $row_type['ecocash_num'];
		 $branch = $row_type['branch'];
		 $affiliate_no = $row_type['affialte_no'];
	 }

	 $geta = "SELECT * FROM businesspartners WHERE affiliate_no='$affialte_no'";
	 $runa = mysqli_query($Connect,$geta);
	 $count_clients = mysqli_num_rows($runa);


	 $geti = "SELECT * FROM `affilate_invites` WHERE affiliate_no='$affialte_no' ";
     $runi = mysqli_query($Connect,$geti);
     $count_shares = mysqli_num_rows($runi);

     $gete = "SELECT * FROM bookings WHERE affiliate_no='$affialte_no'";
	 $rune = mysqli_query($Connect,$gete);
	 $count_orders = mysqli_num_rows($rune);
	 while ($row_type = mysqli_fetch_array($rune)){
	  $price = array($row_type['affiliate_com']);
	  $total = array_sum($price);

		$cost1 = $total;
		$tot_com = "0.00";
		$tot_com = number_format((float)$cost1, 2, '.', '');

	 }
	  echo "<tr>
                <td><b style='color:#FF8C00'>$Name</b><br/>$phone<br/><b style='color:#000'>$Email</b> <br/><b style='color:#FF8C00'>$address</b>$p</td>
                <td>$count_clients</td>
                <td>$count_orders</td>
				<td>$$tot</td>
				<td><b style='color:#000'>Account:</b> $bank_acc
				<br/><b style='color:#000'>Account Name:</b> $bank_acc_name
				<br/><b style='color:#000'>Bank Name:</b> $bank_name
				<br/><b style='color:#000'>Branch:</b> $branch
				<br/><b style='color:#000'>Ecocash:</b> $ecocash_num
				</td>
				<td>$count_shares</td>
                <td>$status
				<p><button class='btn btn-outline btn-xs'>Earned:<i class='fa fa-usd fa-fw'></i>$tot_com</button>
				</td>
				<td>
				<p>
				<!-- Button trigger modal -->
                            <button class='btn btn-xs btn-primary btn-block' data-toggle='modal' data-target='#myModal$affialte_no'>
                                Paid
                            </button>
                            <!-- Modal -->
                            <div class='modal fade' id='myModal$affialte_no' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                                            <h4 class='modal-title' id='myModalLabel'>Enter amount</h4>
                                        </div>
                                        <div class='modal-body'>
                                        <form action='affiliate.php' method='post' name='blogEditForm'>
                                         <div class='form-group input-group'>
                                            <span class='input-group-addon'>$</span>
                                            <input type='text' name='amount' required class='form-control'>
                                            <input type='hidden' name='affiliate_no' value='$affialte_no' class='form-control'>
                                            <input type='hidden' name='status' value='paid' class='form-control'>

                                        </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                            <input type='submit' class='btn btn-primary' value='paid'/>
                                            <input type='hidden' name='MM_update' value='blogEditForm'>
                                        </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->

				</p>
				$bl
				</td>
				<td><a href='#'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";
	 }
	 }

	 function getDrivers(){
	 global $Connect;

	 $get = "SELECT * FROM `driver`";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['driverID'];
		 $driver_number = $row_type['driver_number'];
		 $Name = $row_type['name'];
		 $phone = $row_type['phone'];
		 $email = $row_type['email'];
		 $address = $row_type['address'];
		 $vehicleMake = $row_type['vehicleMake'];
		 $model = $row_type['model'];
		 $year = $row_type['year'];
		 $engineCapacity = $row_type['engineCapacity'];
		 $dob = $row_type['DOB'];
		 $occupation = $row_type['occupation'];
		 $regNo = $row_type['RegNo'];
		 $username = $row_type['username'];
		 $online = $row_type['online'];
		 $info = $row_type['info'];
		 $type_of_service = $row_type['type_of_service'];

      echo "<tr>
                <td> $ID</td>
                <td><b style='color:#FF8C00'>$Name</b><br/>$phone<br/><b style='color:#000'>$type_of_service</b> <br/><b style='color:#FF8C00'>$address</b></td>
                <td>$online</td>
                <td>$username</td>
				<td>$info</td>
				<td>
				<a href='delete.php?revokeDriver=$ID'><button type='button' class='btn btn-danger'>Block</button></a>
				<a href='delete.php?unblockDriver=$ID'><button type='button' class='btn btn-success'>Unblock</button></a>
				</td>
				<td><a href='driverDetail.php?detail=$driver_number'><i class='fa-fw'>details...</i></a></td>
				<td><a href='delete.php?deleteDriver=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";

		 }
	 }

	 function getDriverDetails(){
	 if (isset ($_GET['detail'])){
	    $MrE = $_GET['detail'];
	 global $Connect;

	 $get = "SELECT * FROM `driver` where driver_number='$MrE' ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['driverID'];
		 $driver_number = $row_type['driver_number'];
		 $Name = $row_type['name'];
		 $phone = $row_type['phone'];
		 $email = $row_type['email'];
		 $address = $row_type['address'];
		 $mode_of_transport = $row_type['mode_of_transport'];
		 $type_of_service = $row_type['type_of_service'];
		 $vehicleMake = $row_type['vehicleMake'];
		 $model = $row_type['model'];
		 $year = $row_type['year'];
		 $engineCapacity = $row_type['engineCapacity'];
		 $dob = $row_type['DOB'];
		 $occupation = $row_type['occupation'];
		 $regNo = $row_type['RegNo'];
		 $username = $row_type['username'];
		 $online = $row_type['online'];
		 $profileImage = $row_type['profileImage'];

      echo "#$driver_number <img src='../../images/driverProfile/$profileImage' class='pull-right' width='40px' height='40px'> <br><br>
	               <li class='list-group-item'><b>Status:</b> $username </li>
                   <li class='list-group-item'><h3>Details </h3></li>
			       <li class='list-group-item'><b>Name:</b> $Name<br></li>
			       <li class='list-group-item'><b>D.O.B:</b> $dob<br></li>
                   <li class='list-group-item'><b>Phone:</b> $phone<br/></li>
                   <li class='list-group-item'><b>Email:</b> $email  <br/></li>
                   <li class='list-group-item'><b>Address:</b> $address  <br/></li>
				   <li class='list-group-item'><h3>Type Of Service</h3></li>
				   <li class='list-group-item'><b>Service:</b> $type_of_service  <br/></li>
				   <li class='list-group-item'><h3>Vehicle Details </h3></li>
			       <li class='list-group-item'><b>Mode Of Transport:</b> $mode_of_transport<br></li>
                   <li class='list-group-item'><b>Vehicle Make:</b> $vehicleMake<br/></li>
                   <li class='list-group-item'><b>Model:</b> $model  <br/></li>
                   <li class='list-group-item'><b>Year:</b> $year  <br/></li>
                   <li class='list-group-item'><b>Engine Capacity:</b> $engineCapacity  <br/></li>
                   <li class='list-group-item'><b>Registration Number:</b> $regNo  <br/></li>

				   <li class='list-group-item'><h3>More Details </h3></li>
			       <li class='list-group-item'><b>Occupation:</b> $occupation<br></li>
			      <li class='list-group-item'><h3>Documents </h3></li>
	               </li>
				";

		 }
	 }
	 }

	 function getDriverDocs(){
	  if (isset ($_GET['detail'])){
	    $MrE = $_GET['detail'];
	 global $Connect;

	 $get = "SELECT * FROM `driver` where driver_number='$MrE' ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['driverID'];
		 $driver_number = $row_type['driver_number'];
		 $email = $row_type['email'];
	 }

	 $get = "SELECT * FROM `driver_doc` where email='$email' ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['ID'];
		 $Name = $row_type['DriverName'];
		 $email = $row_type['email'];
		 $doc = $row_type['documents'];


		echo "
		<li class='list-group-item'><a href='fullDoc.php?doc=$ID'>$doc</a></li>
				  ";



	 }
	 }
	 }

	 function getDriverDocs1(){
	  if (isset ($_GET['detail'])){
	    $MrE = $_GET['detail'];
	 global $Connect;

	$get = "SELECT * FROM `driver` where driver_number='$MrE' ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['driverID'];
		 $driver_number = $row_type['driver_number'];
		 $email = $row_type['email'];
	 }

	 $get = "SELECT * FROM `driver_doc` where email='$email' ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['ID'];
		 $Name = $row_type['DriverName'];
		 $email = $row_type['email'];
		 $doc = $row_type['documents'];


		echo "
		<li class='list-group-item'><a href='fullDoc.php?doc=$ID'>$doc</a></li>
				  ";



	 }
	 }
	 }

	 function getDoc(){
	 if (isset ($_GET['doc'])){
	    $MrE = $_GET['doc'];
	 global $Connect;

	 $get = "SELECT * FROM `driver_doc` where ID='$MrE' ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['ID'];
		 $Name = $row_type['DriverName'];
		 $email = $row_type['email'];
		 $doc = $row_type['documents'];

		 $dr_doc = "";

		 $ext = end((explode(".", $doc)));
         if($ext == 'png' || $ext == 'jpeg'|| $ext == 'jpg' ) {

             $dr_doc = "<img src='../../driver_documents/$Name/$doc' width='100%' height='500px'>";
             if($dr_doc ==""){
                 $dr_doc = "<img src='../../driver_documents/$doc' width='100%' height='500px'>";
             }
         }

		 else if($ext == 'pdf'){

             $dr_doc = "<embed type='application/pdf' src='../../driver_documents/$Name/$doc' width='100%' height='500px'>";
             if($dr_doc ==""){
                 $dr_doc = "<embed type='application/pdf' src='../../driver_documents/$doc' width='100%' height='500px'>";
             }
         }

         else if($ext == 'doc' || $ext == 'docx'){

             $dr_doc = " <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=../../driver_documents/$Name/$doc' width='1366px' height='623px' frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
		        ";
		      if($dr_doc ==""){
                 $dr_doc = " <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=../../driver_documents/$doc' width='1366px' height='623px' frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>
		        ";
             }
         }


		 echo "$dr_doc";
	 }
	 }
	 }

	 function getDriversOnMaps(){
	 global $Connect;

	 $get = "SELECT * FROM `driver`";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['driverID'];
		 $Name = $row_type['name'];
		 $phone = $row_type['phone'];
		 $address = $row_type['address'];
		 $vehicleMake = $row_type['vehicleMake'];
		 $model = $row_type['model'];
		 $year = $row_type['year'];
		 $engineCapacity = $row_type['engineCapacity'];
		 $dob = $row_type['DOB'];
		 $occupation = $row_type['occupation'];
		 $documents = $row_type['documents'];

      echo "<div class='list-group'>
	  <button id='driver_id' class='list-group-item' style='color: #FF8C00'><i class='fa fa-car fa-fw'></i>$Name</button>
	  </div>
	  ";

		 }
	 }

	 function getPrizelist(){
	 global $Connect;

	 $get = "SELECT * FROM `prizelist`";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['ID'];
		$Price_per_km = $row_type['Price_per_km'];

		echo "$Price_per_km";
	 }
	 }

    function getBusinessPartnerD(){
    if (isset ($_GET['partnerD'])){
    $MrE = $_GET['partnerD'];
	 global $Connect;

	 $get = "SELECT * FROM `businesspartners` WHERE businessID = '$MrE' Limit 1 ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){

		$ID = $row_type['businessID'];
		$email_from = $row_type['email'];
	    $address = $row_type['pick_up_address'];
        $PersonPhone = $row_type['PersonPhone'];
		$NameOfContact = $row_type['NameOfContact'];
		$businessName = $row_type['businessName'];
		$phone = $row_type['phone'];
		$PreferedTransport = $row_type['PreferedTransport'];
		$businessType = $row_type['businessType'];
		$businessLocation = $row_type['businessLocation'];
		$password = $row_type['password'];
		$time = $row_type['deliveryTime'];
		$estimateDeliveries = $row_type['estimateDeliveries'];

      echo "<tr>
                <td>$ID</td>
                <td>
				<li class='list-group-item'><h4>Business Name</h4>$businessName</li>
				<li class='list-group-item'><h4>Business Type</h4>$businessType</li>
				<li class='list-group-item'><h4>Business Location</h4>$businessLocation</li>
				<li class='list-group-item'><h4>Business Phone</h4>$phone</li>

				</td>
				<td>
				<li class='list-group-item'><h4>Pick Up Address</h4>$address</li>
				<li class='list-group-item'><h4>Estimate Deliveries</h4>$estimateDeliveries</li>
				<li class='list-group-item'><h4>Prefered Transport</h4>$PreferedTransport</li>
				<li class='list-group-item'><h4>Delivery Time</h4>$time</li>

				</td>

                <td>
				<li class='list-group-item'><h4>Name</h4>$NameOfContact</li>
				<li class='list-group-item'><h4>Phone</h4>$PersonPhone</li>
				<li class='list-group-item'><h4>E-mail</h4>$email_from</li>
				</td>
				<td>
				<li class='list-group-item'><a href='delete.php?block_sub=$businessName' class='btn btn-danger btn-block'>block</a></li>
				<li class='list-group-item'><a href='delete.php?unblock_sub=$businessName' class='btn btn-info btn-block'> Unblock </a></li>

				</td>
				<td><a href='delete.php?deleteBus=$ID'><i class='fa fa-trash fa-fw'></i></a></td>



            </tr>";

		 }
		 }
	 }



	 function getBusinessPartner(){
		if (!isset ($_GET['partnerD'])){
	 global $Connect;

	 $get = "SELECT * FROM `businesspartners`";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){

		$ID = $row_type['businessID'];
		$email_from = $row_type['email'];
	    $address = $row_type['pick_up_address'];
        $PersonPhone = $row_type['PersonPhone'];
		$NameOfContact = $row_type['NameOfContact'];
		$businessName = $row_type['businessName'];
		$phone = $row_type['phone'];
		$PreferedTransport = $row_type['PreferedTransport'];
		$businessType = $row_type['businessType'];
		$businessLocation = $row_type['businessLocation'];
		$password = $row_type['password'];
		$time = $row_type['deliveryTime'];
		$estimateDeliveries = $row_type['estimateDeliveries'];

      echo "<tr>
                <td>$ID</td>
                <td>$businessName</td>
				<td>$businessType</td>
				<td>$businessLocation</td>
                <td>$NameOfContact</td>
				<td><a href='BusinessPartnerDetails.php?partnerD=$ID'><i class='fa fa-list-alt fa-fw'></i></a></td>
            </tr>";

		 }
		 }

	 }

	 function getBookings(){
	 global $Connect;

	 $get = "SELECT * FROM `bookings` order by Date DESC";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['order_id'];
		$ID2 = $row_type['order_id'];
		$email_from = $row_type['email'];
	    $address = $row_type['pick_up_address'];
        $drop_address = $row_type['drop_address'];
		$name = $row_type['Name'];;
		$date = $row_type['pick_up_date'];
		$drop_date = $row_type['drop_date'];
		$weight_of_package = $row_type['weight'];
		$package_quantity = $row_type['quantity'];
		$insurance = $row_type['insurance'];
		$value_of_package =$row_type['value'];
		$note = $row_type['drivers_note'];
		$time = $row_type['pick_up_time'];
		$status = $row_type['status'];
		$invoice = $row_type['invoice'];

      echo "<tr>
                <td>$ID</td>
                <td>$date</td>
                <td>$name</td>
				<td>$email_from</td>
				<td><a href='invo.php?invoice=$ID'  class='btn btn-outline btn-primary'><i class='fa fa-envelope fa-fw'></i>$invoice</a></td>
				<td><a href='orderDetails.php?orderD=$ID' class='btn btn-outline btn-primary'><i class='fa fa-list-alt fa-fw'></i>$status</a></td>

				<td><a href='delete.php?deleteOrder=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
		   </tr>";

		 }
	 }


function getBookingsD(){
      if (isset ($_GET['orderD'])){
	    $MrE = $_GET['orderD'];
	    $renew_btn;
	    $act_btn;
	  global $Connect;

	 $get = "SELECT * FROM `bookings` WHERE order_id = '$MrE' ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['order_id'];
		$ID2 = $row_type['order_id'];
		$Date = $row_type['Date'];
		$email_fro = $row_type['email'];
	    $address = $row_type['pick_up_address'];
        $drop_address = $row_type['drop_address'];
		$name = $row_type['Name'];
		$phone = $row_type['phone'];
		$pick_up_date = $row_type['pick_up_date'];
		$drop_date = $row_type['drop_date'];
		$Drop_name = $row_type['Drop_name'];
		$Total_price = $row_type['Total_price'];
		$drop_phone = $row_type['drop_phone'];
		$weight_of_package = $row_type['weight'];
		$package_quantity = $row_type['quantity'];
		$insurance = $row_type['insurance'];
		$value_of_package = $row_type['value'];
		$type_of_transport = $row_type['type_of_transport'];
		$note = $row_type['drivers_note'];
		$time = $row_type['pick_up_time'];
		$drop_time = $row_type['drop_time'];
		$status = $row_type['status'];
		$status_update_date = $row_type['status_update_date'];
		$invoice = $row_type['invoice'];
		$reciepientName = $row_type['ReciepientName'];
		$ReciepientSignature = $row_type['ReciepientSignature'];
		$driver_username = $row_type['username'];


		if($driver_username != "" && $status != "accepted" && $status != "on the way" && $status != "at pick" && $status != "deliverd"){
		     $act_btn = "<a href='orderDetails.php?AcceptOrder=$ID2' class='btn btn-outline btn-sm  btn-info pull-right'>
	      <i class='fa fa-check-square'></i> Accept</a>";
		 }else if($status == "at pick"){
		     $act_btn ="<a href='orderDetails.php?OnWay=$ID2' class='btn btn-outline btn-sm  btn-primary pull-right'>
		   <i class='fa fa-share-square'></i> On the Way </a>";
		 }else if($status == "accepted"){
		     $act_btn ="<a href='orderDetails.php?AtPick=$ID2' class='btn btn-outline btn-sm  btn-primary pull-right'>
		   <i class='fa fa-map-marker'></i> At Pick</a>";
		 }else if($status == "on the way"){
		     $act_btn ="<a href='orderDetails.php?Deliverd=$ID2' class='btn btn-outline btn-sm  btn-primary pull-right'>
	        <i class='fa fa-taxi'></i> Delivered </a>
	        ";
		 }else if($status == "delivered" || $order_status == "cancelled"){
		     $act_btn ="";
		 }


		 if($status != "new"){
		     $renew_btn = "<a href='orderDetails.php?RenewOrder=$ID2' class='btn btn-outline btn-sm  btn-primary pull-right'><i class='fa fa-refresh fa-fw'></i>Renew</a>";

		 }


			echo " Order#$ID
			        <span class=' margin-left'>$act_btn</span>
			        <span class='margin-left'>
			       	<a href='orderDetails.php?CancelOrder=$ID' class='btn btn-outline btn-sm btn-danger pull-right'><i class='fa fa-times fa-fw'></i>Cancel</a>
			       	</span>
			       	<span class='margin-left'>$renew_btn</span>
				    <br/><br/>
                   <li class='list-group-item'><b>Status:</b> $status </li>
                   <li class='list-group-item'><h3>From </h3></li>
			       <li class='list-group-item'><b>Name:</b> $name<br></li>
                   <li class='list-group-item'><b>Phone:</b> $phone<br/></li>
                   <li class='list-group-item'><b>Email:</b> $email_fro <br/></li>

				   <li class='list-group-item'><h3>Deliver To</h3></li>
				   <li class='list-group-item'><b>Name:</b> $Drop_name<br></li>
                   <li class='list-group-item'><b>Phone:</b> $drop_phone<br/></li>

				  <li class='list-group-item'> <h3>Pick Up Address</h3></li>
                   <li class='list-group-item'><b>Address:</b> $address <br/></li>
                   <li class='list-group-item'><b>Pick Up Date:</b> $pick_up_date <br/></li>
                   <li class='list-group-item'><b>Pick Up Time:</b> $time <br/><br/></li>

				   <li class='list-group-item'><h3>Delivery Address</h3></li>
                   <li class='list-group-item'><b>Address:</b> $drop_address <br/></li>
                   <li class='list-group-item'><b>Delivery Date:</b> $drop_date <br/></li>
                   <li class='list-group-item'><b>Delivery Time:</b> $drop_time <br/><br/></li>

				   <li class='list-group-item'><h3>Package Details</h3></li>
				  <li class='list-group-item'> <b>Weight:</b> $weight_of_package<br></li>
                   <li class='list-group-item'><b>Quantity:</b> $package_quantity<br/></li>
                   <li class='list-group-item'><b>Prefered Type Of Transport:</b> $type_of_transport <br/><br/></li>
                  <li class='list-group-item'> <b>Note:</b> $note <br/>
                  <li class='list-group-item'> <b>Total Cost:</b> $$Total_price $invoice <br/>

				  <li class='list-group-item'><h3>Reciepient Details</h3></li>
				   <li class='list-group-item'> <b>Name:</b> $reciepientName <br/>
				   <li class='list-group-item'> <b>Date:</b> $status_update_date <br/>

				   ";

		 }
		 }
		 }

	 function getContacts(){
	 global $Connect;

	 $get = "SELECT * FROM `contacts` order by Date DESC";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['ID'];
		$Date = $row_type['Date'];
		$Name = $row_type['Name'];
		$Surname = $row_type['Subject'];
		$Email = $row_type['Email'];
		$msg = $row_type['message'];

		echo "<li class='left clearfix'>
                                    <span class='chat-img pull-left'>
                                        <img src='http://placehold.it/50/55C1E7/fff' alt='User Avatar' class='img-circle' />
                                    </span>
                                    <div class='chat-body clearfix'>
                                        <div class='header'>
                                            <strong class='primary-font'>$Name </strong>
                                            <small class='pull-right text-muted'>
                                                <i class='fa fa-clock-o fa-fw'></i> $Date
                                            </small>
											<h4>$Surname<h4>
                                        </div>
                                        <p>
                                           $msg
										 <br><br>
										</p>

										<p>
                                           <b>E-mail:</b> <a href='$Email' target='_blank'>$Email</a>
										</p>
										<a href='reply_message.php?chatD=$ID' class='btn btn-info btn-block'>reply</a>
                                    </div>
                                </li>";
	 }
	}

function getChats(){
	 global $Connect;

	 $get = "SELECT * FROM `chat_drivers` order by Date DESC ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['ID'];
		$Date = $row_type['Date'];
		$Name = $row_type['name'];
		$msg = $row_type['message'];

		echo "
		<a href='message.php?chatD=$ID' class='list-group-item'>
                                    <i class='fa  fa-envelope-o fa-fw'></i> $Name
                                    <span class='pull-right text-muted small'><em>$Date</em>
                                    </span>
                                </a>
		";
	 }
	}

	function getAffiliatesChats(){
	 global $Connect;

	 $get = "SELECT * FROM `affiliate_msg` where affiliate_no !='' GROUP BY affiliate_no order by date DESC ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['id'];
		$Date = $row_type['date'];
		$Name = $row_type['name'];
		$msg = $row_type['msg'];
		$affiliate_no = $row_type['affiliate_no'];

		echo "
		<a href='affiliate.msg.php?chatD=$affiliate_no' class='list-group-item'>
                                    <i class='fa  fa-envelope-o fa-fw'></i> $Name
                                    <span class='pull-right text-muted small'><em>$Date</em>
                                    </span>
                                </a>
		";
	 }
	}

	function getChatAlert(){
	 global $Connect;

	 $get = "SELECT * FROM `chat_drivers` order by Date DESC LIMIT 3 ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['ID'];
		$Date = $row_type['Date'];
		$Name = $row_type['name'];
		$msg = $row_type['message'];

		if (strlen($msg) > 100) {
        $trimstring = substr($msg, 0, 100);
        } else {
        $trimstring = $msg;
       }

		echo " <li class='divider'></li>
		<li>
                            <a href='message.php?chatD=$ID'>
                                <div>
                                    <strong>$Name</strong>
                                    <span class='pull-right text-muted'>
                                        <em>$Date</em>
                                    </span>
                                </div>
                                <div>$trimstring...</div>
                            </a>
                        </li>
		";
	 }
	}

	function getChatsFroDr(){
		 if (isset ($_GET['chatD'])){
	    $MrE = $_GET['chatD'];
	 global $Connect;

	 $get = "SELECT * FROM `chat_drivers` where ID = '$MrE' order by Date DESC";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['ID'];
		$Date = $row_type['Date'];
		$Name = $row_type['name'];
		$msg = $row_type['message'];

		echo " <li class='left clearfix'>
                                    <span class='chat-img pull-left'>
                                        <img src='http://placehold.it/50/55C1E7/fff' alt='User Avatar' class='img-circle' />
                                    </span>
                                    <div class='chat-body clearfix'>
                                        <div class='header'>
                                            <strong class='primary-font'>$Name </strong>
                                            <small class='pull-right text-muted'>
                                                <i class='fa fa-clock-o fa-fw'></i> $Date
                                            </small>
                                        </div>
                                        <p>
                                           $msg
										</p>
                                    </div>
                                </li>
				";
	 }
	}
	}

	function getChatsAffiliate(){
	 if (isset ($_GET['chatD'])){
    $MrE = $_GET['chatD'];
	 global $Connect;
	 $m = "";
	 $geta = "SELECT * FROM `affilate_user` WHERE affialte_no='$MrE'";
	 $runa = mysqli_query($Connect,$geta);
	 while ($row_type = mysqli_fetch_array($runa)){
		 $affialte_no = $row_type['affialte_no'];
	 }
	 $get = "SELECT * FROM `affiliate_msg` where affiliate_no = '$affialte_no' OR reply_no='$affialte_no' order by date ASC";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['id'];
		$Date = $row_type['date'];
		$Name = $row_type['name'];
		$msg = $row_type['msg'];
		$sub = $row_type['subject'];
		$affiliate_no2 = $row_type['affiliate_no'];
		$reply_no = $row_type['reply_no'];


		if($affiliate_no2 == $affialte_no){
		    $m = " <li class='left clearfix'>
                    <span class='chat-img pull-left'>
                        <img src='http://placehold.it/50/55C1E7/fff' alt='User Avatar' class='img-circle' />
                    </span>
                    <div class='chat-body clearfix'>
                        <div class='header'>
                            <strong class='primary-font'>$Name </strong>
                            <small class='pull-right text-muted'>
                                <i class='fa fa-clock-o fa-fw'></i> $Date
                            </small>
                        </div>
                        <h4>$sub</h4>
                        <p>
                           $msg
						</p>
                    </div>
                </li>";
		}elseif($reply_no == $affialte_no){
		    $m = "<li class='right clearfix'>
                    <span class='chat-img pull-right'>
                        <img src='http://placehold.it/50/FA6F57/fff' alt='User Avatar' class='img-circle' />
                    </span>
                    <div class='chat-body clearfix'>
                        <div class='header'>
                            <small class=' text-muted'>
                                <i class='fa fa-clock-o fa-fw'></i>$Date</small>
                            <strong class='pull-right primary-font'>$Name</strong>
                        </div>
                        <h4>$sub</h4>
                        <p>
                          $msg
						</p>
                    </div>
                </li>";
		}

		echo $m;
	 }
	}
	}

	function getReplyChatsFroDr(){
		 if (isset ($_GET['chatD'])){
	    $MrE = $_GET['chatD'];
	 global $Connect;

	 $get = "SELECT * FROM `replychat_drivers` where chatID = '$MrE' ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['ID'];
		$Date = $row_type['Date'];
		$Name = $row_type['name'];
		$msg = $row_type['message'];

		echo " <li class='right clearfix'>
                                    <span class='chat-img pull-right'>
                                        <img src='http://placehold.it/50/FA6F57/fff' alt='User Avatar' class='img-circle' />
                                    </span>
                                    <div class='chat-body clearfix'>
                                        <div class='header'>
                                            <small class=' text-muted'>
                                                <i class='fa fa-clock-o fa-fw'></i>$Date</small>
                                            <strong class='pull-right primary-font'>$Name</strong>
                                        </div>
                                        <p>
                                          $msg
										</p>
                                    </div>
                                </li>
				";
	 }
	}
	}

	function getBlog(){
	 global $Connect;

	 $get = "SELECT * FROM `blog`";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['ID'];
		$name = $row_type['Name'];
		$Date = $row_type['date'];
		$heading = $row_type['heading'];
		$category = $row_type['category'];
		$msg = $row_type['message'];
		$image = $row_type['image'];

		 echo "  <a href='blog_edit.php?blogEdit=$ID' class='list-group-item'>
                                    <i class='fa fa-comment fa-fw'></i> $heading
                                    <span class='pull-right text-muted small'><em>$Date</em>
                                    </span>
                                    <a href='delete.php?delete_blog=$ID' class='btn btn-danger btn-sm '>DELETE <i class='fa fa-trash'></i></a>
                                    </span>
                                </a>
				  ";
	 }
	}

 function getCountDownloadsb(){

	 global $Connect;
	 $count = 0;

	 $get = "SELECT * FROM app_download WHERE app ='booking_app' ";


	 $run = mysqli_query($Connect,$get);

	 $count = mysqli_num_rows($run);

		echo $count;

	  }

	 function getCountDownloadsd(){

	 global $Connect;
	 $count = 0;

	 $get = "SELECT * FROM app_download WHERE app ='driver_app' ";


	 $run = mysqli_query($Connect,$get);

	 $count = mysqli_num_rows($run);

		echo $count;

	  }

	 function getCountNewOrders(){

	 global $Connect;
	 $count = 0;

	 $get = "SELECT * FROM bookings WHERE status ='new' ";


	 $run = mysqli_query($Connect,$get);

	 $count = mysqli_num_rows($run);

		echo $count;

	  }

	 function getCountAllOrders(){

	 global $Connect;
	 $count = 0;

	 $get = "SELECT * FROM bookings WHERE status !='cancelled' ";


	 $run = mysqli_query($Connect,$get);

	 $count = mysqli_num_rows($run);

		echo $count;

	  }

	  function getCountCancelledOrders(){

	 global $Connect;
	 $count = 0;

	 $get = "SELECT * FROM bookings WHERE status ='cancelled' ";


	 $run = mysqli_query($Connect,$get);

	 $count = mysqli_num_rows($run);

		echo $count;

	  }

	 function getCountTotalSales(){
	 global $Connect;
	 $tot = 0;
	 $cost = 0;
	 $get = "SELECT * FROM `bookings` WHERE status !='cancelled' AND currency !='RTGS' ";

	 $run = mysqli_query($Connect,$get);
	 while ($row_price = mysqli_fetch_array($run)){
		 $price = array($row_price['Total_price']);
		 $total = array_sum($price);

	    $cost += $total;
		$tot = number_format((float)$cost, 2, '.', '');


	 }
	 echo $tot;
	 }
	 function getCountTotalRTGSSales(){
	 global $Connect;
	 $tot = 0;
	 $cost = 0;
	 $get = "SELECT * FROM `bookings` WHERE status !='cancelled' AND currency ='RTGS'";

	 $run = mysqli_query($Connect,$get);
	 while ($row_price = mysqli_fetch_array($run)){
		 $price = array($row_price['Total_price']);
		 $total = array_sum($price);

	    $cost += $total;
		$tot = number_format((float)$cost, 2, '.', '');


	 }
	 echo $tot;
	 }
	 function getCountTotalCashSales(){
	 global $Connect;
	 $tot = 0;
	 $cost = 0;
	 $get = "SELECT * FROM `bookings` WHERE status !='cancelled'";

	 $run = mysqli_query($Connect,$get);
	 while ($row_price = mysqli_fetch_array($run)){
		 $price = array($row_price['Total_price']);
		 $total = array_sum($price);

	    $cost += $total;
		$tot = number_format((float)$cost, 2, '.', '');


	 }
	 echo $tot;
	 }

	 function getCountMonSales(){
	 global $Connect;
	 $tot = 0;
	 $cost = 0;
	 $a_date = "2017-10-01";
     $date = new DateTime($a_date);
     $date->modify('last day of this month');
     $last = $date->format('Y-m-d');
      $now = new \DateTime('now');
      $month = $now->format('m');
      $year = $now->format('Y');
	 $get = "SELECT YEAR(Date) AS year, MONTH(Date) AS month, COUNT(order_id) AS orders_made, SUM(Total_price) AS daily_total FROM bookings WHERE Date BETWEEN ('$year-$month-01') AND ('$last') GROUP BY YEAR(Date), MONTH(Date)";
	 $last_month_year='';
	 $run = mysqli_query($Connect,$get);
	 while ($nt = mysqli_fetch_array($run)){
		 $price = array($row_price['Total_price']);
		 $total = array_sum($price);

	    $cost += $total;
		$tot = number_format((float)$cost, 2, '.', '');

	if($last_month_year=='')
    $month_total=$nt['daily_total'];
    elseif($last_month_year==$nt['month'].$nt['year'])
        $month_total+=$nt['daily_total'];
    else
    {
        $month_total=$nt['daily_total'];
        echo "Month total: ".$month_total."<br>";
    }
	$cost = $nt['date'].$nt['daily_total']."<br>";
    $last_month_year=$nt['month'].$nt['year'];

	$tot = number_format((float)$cost, 2, '.', '');

	echo $tot;

	 }
	 }

 function getCountAllDrivers(){
     global $Connect;

     $get = "SELECT * FROM `driver` ";


     $run = mysqli_query($Connect,$get);

     $count = mysqli_num_rows($run);

    	echo $count;

     }

     function getCountAllSellers(){
     global $Connect;

     $get = "SELECT * FROM `businesspartners` ";


     $run = mysqli_query($Connect,$get);

     $count = mysqli_num_rows($run);

    	echo $count;

     }

     function getCountCommission(){
	 global $Connect;
	 $tot = 0;
	  $get = "SELECT * FROM `affilate_user`";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
         $price = array($row_type['balance']);
		 $total = array_sum($price);

        $cost += $total;
		$tot = number_format((float)$cost, 2, '.', '');

		 $show = $tot;
	 }
	 echo $tot;

	  }

	 function getCountAPIUsers(){
     global $Connect;

     $get = "SELECT * FROM `api_users` ";


     $run = mysqli_query($Connect,$get);

     $count = mysqli_num_rows($run);

    	echo $count;

     }
	 function getCountAffilates(){
     global $Connect;

     $get = "SELECT * FROM `affilate_user` ";


     $run = mysqli_query($Connect,$get);

     $count = mysqli_num_rows($run);

    	echo $count;

     }

     function getCountAPIUserOrders(){

	 global $Connect;
	 $count = 0;

	 $get = "SELECT * FROM bookings WHERE business_user_id !='' ";


	 $run = mysqli_query($Connect,$get);

	 $count = mysqli_num_rows($run);

		echo $count;

	  }
     function getCountAffilateOrders(){

	 global $Connect;
	 $count = 0;

	 $get = "SELECT * FROM bookings WHERE affiliate_no !='' ";


	 $run = mysqli_query($Connect,$get);

	 $count = mysqli_num_rows($run);

		echo $count;

	  }

	 function getCountAffilateClients(){

	 global $Connect;
	 $count = 0;

	 $get = "SELECT * FROM businesspartners WHERE affiliate_no !='' ";


	 $run = mysqli_query($Connect,$get);

	 $count = mysqli_num_rows($run);

		echo $count;

	  }

	 function getCountAffilateShares(){

	 global $Connect;
	 $count = 0;

	 $get = "SELECT * FROM affilate_invites";


	 $run = mysqli_query($Connect,$get);

	 $count = mysqli_num_rows($run);

		echo $count;

	  }

	 function getCountTotalEarned(){
     global $Connect;

	 $get = "SELECT * FROM bookings WHERE affiliate_no !='' AND status !='cancelled'";
     $run = mysqli_query($Connect,$get);

    while ($row_type = mysqli_fetch_array($run)){
    	 $price = array($row_type['affiliate_com']);
		 $total = array_sum($price);

	    $cost += $total;
		$tot = number_format((float)$cost, 2, '.', '');

		 $show = $tot;
		   }

    	echo $show;

     }

    function update_API_user($id, $status)
    {
        global $Connect;
    	$q = "UPDATE api_users SET status = '$status' WHERE id=$id";
    	$run = mysqli_query($Connect, $q);
    	return true;

    }
	 function getCountTotalAPIEarned(){
     global $Connect;

	 $get = "SELECT * FROM bookings WHERE business_user_id !='' AND status !='cancelled'";
     $run = mysqli_query($Connect,$get);
     $cost=0;
    while ($row_type = mysqli_fetch_array($run)){
    	 $price = array($row_type['affiliate_com']);
		 $total = array_sum($price);

	    $cost += $total;
		$tot = number_format((float)$cost, 2, '.', '');

		 $show = $tot;
		   }

    	echo ($show?$show:0);

     }
     function getAllUserss()
     {
     	global $Connect;
	 $data = array();
	 $get = "SELECT * FROM `users`";

	 $run = mysqli_query($Connect,$get);
	 while($data1 = mysqli_fetch_assoc($run))
		{
			$data[] = $data1;
		}
		return $data ;

     }
     function generateAndSubmitCoupon()
     {
     	global $Connect;

     	$limit = $_POST['limit'];
     	$type = $_POST['type'];
     	$expiry_date = $_POST['expiry_date'];
     	$amount = $_POST['amount'];
     	$txn = strtotime('now');
        $fourDigit = rand(1000,9999);
        $snip = substr($txn, 6);
        $txnid = $snip.$fourDigit;

     	$get = "SELECT * FROM `users`";

	 $run = mysqli_query($Connect,$get);
	 while($data1 = mysqli_fetch_assoc($run))
		{
			$userid = $data1['Userid'];
			$txn = strtotime('now');
            $fourDigit = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
            $snip = substr($txn, 6);
            $txnid = $snip.$fourDigit;
            $coupon = $txnid.$userid;

          $sql = "INSERT INTO user_coupons (`user_id` ,`coupon`, `limit_used` , `used` ,`expiry_date` , `type` , `amount`) VALUES ('$userid' ,'$coupon',  '$limit' , '0' ,'$expiry_date' , '$type' , '$amount') ";


          $result = mysqli_query($Connect,$sql);

		}


     }
     function getCommonCoupon()
     {
     	global $Connect;
     	$id = $_GET['editid'];
	 $data = array();
	 $get = "SELECT * FROM `common_coupon` WHERE id = '$id'";

	 $run = mysqli_query($Connect,$get);
	 $data1 = mysqli_fetch_assoc($run);

		return $data1 ;

     }
     function getSingleUserCoupon()
     {
     	global $Connect;
     	$id = $_GET['editid'];
	 $data = array();
	 $get = "SELECT * FROM `user_coupons` Where user_coupon_id = '$id'";

	 $run = mysqli_query($Connect,$get);
	 $data1 = mysqli_fetch_assoc($run);

		return $data1 ;

     }
     function updateCommonCoupon()
     {
     	global $Connect;
     	$id = $_POST['id'];
     	$coupon = $_POST['coupon'];
     	$limit = $_POST['limit'];
     	$expiry = $_POST['expiry_date'];
     	$type = $_POST['type'];
     	$amount = $_POST['amount'];

     	$get = "UPDATE common_coupon SET coupon = '$coupon' , limit_used = '$limit' , expiry_date = '$expiry' , type = '$type' , amount = '$amount' WHERE id = '$id'";


	    $run = mysqli_query($Connect,$get);


     }
     function updateUserCoupon()
     {
     	global $Connect;
     	$id = $_POST['id'];
     	$coupon = $_POST['coupon'];
     	$limit = $_POST['limit'];
     	$expiry = $_POST['expiry_date'];
     	$type = $_POST['type'];
     	$amount = $_POST['amount'];

     	$get = "UPDATE user_coupons SET coupon = '$coupon' , limit_used = '$limit' , expiry_date = '$expiry' , type = '$type' , amount = '$amount' WHERE user_coupon_id = '$id'";


	    $run = mysqli_query($Connect,$get);


     }
     function storeCommonCoupon()
     {
     	global $Connect;
     	$coupon = $_POST['coupon'];
     	$limit = $_POST['limit'];
     	$expiry = $_POST['expiry_date'];
     	$type = $_POST['type'];
     	$amount = $_POST['amount'];

     	$get ="INSERT INTO common_coupon (`coupon`, `limit_used` , `used` ,`expiry_date` , `type` , `amount`) VALUES ('$coupon',  '$limit' , '0' ,'$expiry' , '$type' , '$amount')";


	    $run = mysqli_query($Connect,$get);

     }
     function getAllCommonCoupon()
     {
     	global $Connect;
	 $data = array();
	 $get = "SELECT * FROM `common_coupon`";

	 $run = mysqli_query($Connect,$get);
	 while($data1 = mysqli_fetch_assoc($run))
		{
			$data[] = $data1;
		}
		return $data ;
	}
	function getAllUniqueCoupon()
     {
     	global $Connect;
	 $data = array();
	 $get = "SELECT * FROM `user_coupons` INNER JOIN users ON user_coupons.user_id=users.Userid";

	 $run = mysqli_query($Connect,$get);
	 while($data1 = mysqli_fetch_assoc($run))
		{
			$data[] = $data1;
		}
		return $data ;
	}

	function deleteCommonCoupon()
	{
	  global $Connect;
	  $id = $_GET['delid'];

	  $sql = "DELETE FROM common_coupon WHERE id = '$id'";

	  $run = mysqli_query($Connect,$sql);
	}
	function deleteUserCoupon()
	{
	  global $Connect;
	  $id = $_GET['delid'];

	  $sql = "DELETE FROM user_coupons WHERE user_coupon_id = '$id'";

	  $run = mysqli_query($Connect,$sql);
	}
	function sendCommonCouponMail()
	{
		global $Connect;
     	$id = $_GET['mailid'];

	 $get = "SELECT * FROM `common_coupon` WHERE id = '$id'";

	 $run = mysqli_query($Connect,$get);
	 $data1 = mysqli_fetch_assoc($run);
      $data = array();
	 $sql = "SELECT * FROM `users`";

	 $query = mysqli_query($Connect,$sql);
	 while($result = mysqli_fetch_assoc($query))
		{
			 $data[] = $result['email'];
		}



			$usermail = $result['email'];
			$username = $result['Name'];
			 require 'PHPMailerAutoload.php';

            $mail = new PHPMailer;


           // $mail->isSMTP();
            $mail->Host = 'mail.payingtrusted.com';
            $mail->SMTPAuth = true;
			$mail->Username = 'info@payingtrusted.com';
			$mail->Password = 'info@payingtrusted.com';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;

			$mail->setFrom('admin@merchantcouriers.com');
             foreach ($data as $value) {
             	$mail->AddBCC($value);
             }

			$mail->isHTML(true);

			$mail->Subject = 'Welcome';
			$mail->Body    = 'Hi your coupon For MERCHANT COURIERS is' .$data1['coupon'];
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if (!$mail->send()) {
				echo "<script>alert('Mail not send!');
  				window.location.href='commoncoupon.php';</script>";

			}
			else
			{
				echo "<script>alert('Mail has been Send Successfuly!');
  				window.location.href='commoncoupon.php';</script>";

			}




	}
	function sendUserMail()

	{
		 global $Connect;
		$users = $_POST['check'];

		for ($i=0; $i <count($users) ; $i++)
      {

      $userid = $users[$i];

	 $get = "SELECT * FROM `user_coupons` INNER JOIN users ON user_coupons.user_id=users.Userid WHERE user_coupon_id = $userid";

	 $run = mysqli_query($Connect,$get);
	 $data1 = mysqli_fetch_assoc($run);


	        $usermail = $data1['email'];
			$username = $data1['Name'];
			$coupon = $data1['coupon'];
			 require 'PHPMailerAutoload.php';

            $mail = new PHPMailer;


           // $mail->isSMTP();
            $mail->Host = 'mail.payingtrusted.com';
            $mail->SMTPAuth = true;
			$mail->Username = 'info@payingtrusted.com';
			$mail->Password = 'info@payingtrusted.com';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;

			$mail->setFrom('admin@merchantcouriers.com');

             	$mail->AddAddress($usermail);




			$mail->isHTML(true);

			$mail->Subject = 'Welcome';
			$mail->Body    = 'Hi Your coupon For MERCHANT COURIERS is' .$coupon;
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if (!$mail->send()) {


				echo "<script>alert('Mail not send!');
  				window.location.href='usercoupon.php';</script>";

			}
			else
			{
				echo "<script>alert('Mail has been Send Successfuly!');
  				window.location.href='usercoupon.php';</script>";

			}


      }

	}
	function getusersPhone()
	{
		global $Connect;
     	$coupon = $_GET['coupon'];
      $data = array();
	 $sql = "SELECT phone FROM `users`";

	 $query = mysqli_query($Connect,$sql);
	 while($result = mysqli_fetch_assoc($query))
		{
			 $data[] = $result['phone'];
		}


	   return $data;
	}


// 	Get zones --------------------------

	function getZones(){
	 global $Connect;

	 $get = "SELECT * FROM inter_zones  Group BY zone ";

	 $run = mysqli_query($Connect,$get);

	 while ($row_type = mysqli_fetch_array($run)){
		$ID = $row_type['id'];
		$zone = $row_type['zone'];
		$zone_price = $row_type['zone_price'];
	    $weight = $row_type['weight'];

	 $get_c = "SELECT * FROM countries WHERE assigned_zone = '$zone'  Group BY assigned_zone";
	 $run_c = mysqli_query($Connect,$get_c);
	 $country ="";
	 while ($row_type = mysqli_fetch_array($run_c)){
		//$ID = $row_type['id'];
		$assigned_zone = $row_type['assigned_zone'];
	    $country = $row_type['country'];

	    foreach ( $country as $key => $value ) {
            $country = $value;
        }
	 }
      echo "<tr>
                <td>$ID</td>
                <td>$zone</td>
                <td>$zone_price</td>
				<td>$weight</td>
				<td>$country</td>
				<td><a href='#'  class='btn btn-outline btn-primary'><i class='fa fa-edit fa-fw'></i> Update</a></td>
				<td><a href='delete.php?deleteOrder=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
		   </tr>";


	 }
	 }
