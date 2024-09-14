<?php
// $Connect = @mysqli_connect("localhost", "iobagcmg_merchant_admin", "}{kTftfu1449", "iobagcmg_merchant_db");
$hostname_Connect = "localhost";
$database_Connect = "kundaita_mc_db";
$username_Connect = "kundaita_mc_user";
$password_Connect = "#;H}MXNXx(kB";
$Connect = @mysqli_connect($hostname_Connect, $username_Connect, $password_Connect, $database_Connect);
function getClients()
{
    global $Connect;

    $get = "SELECT * FROM `clients`";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
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

function getUsername()
{
    global $Connect;
    $user = $_SESSION['affilate_Username'];

    $get = "SELECT * FROM `affilate_user` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['id'];
        $Name = $row_type['name'];
        $Email = $row_type['email'];
        $phone = $row_type['phone'];

        echo "$Name";
    }
}

function make_bitly_url($url = 'https://www.merchantcouriers.co.zw/', $login = 'emmanuelb', $appkey = 'R_b98ac157a6784165876d73d8844d53fd', $format = 'xml', $history = 1, $version = '2.0.1')
{
    //create the URL
    $bitly = 'http://api.bit.ly/shorten';
    $param = 'version=' . $version . '&longUrl=' . urlencode($url) . '&login='
        . $login . '&apiKey=' . $appkey . '&format=' . $format . '&history=' . $history;

    //get the url
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $bitly . "?" . $param);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    //parse depending on desired format
    if (strtolower($format) == 'json') {
        $json = @json_decode($response, true);
        return $json['results'][$url]['shortUrl'];
    } else {
        $xml = simplexml_load_string($response);
        return 'http://bit.ly/' . $xml->results->nodeKeyVal->hash;
    }
}

function getLink()
{
    global $Connect;
    $user = $_SESSION['affilate_Username'];
    $get = "SELECT * FROM `affilate_user` WHERE email='$user'";
    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $affialte_no = $row_type['affialte_no'];

        $short = make_bitly_url("https://www.merchantcouriers.co.zw/signup_aff.php?joinnow=$affialte_no", "emmanuelb", "R_b98ac157a6784165876d73d8844d53fd", "xml", 1, "2.0.1");
        echo $short;
    }
}

function getLink_em()
{
    global $Connect;
    $user = $_SESSION['affilate_Username'];
    $get = "SELECT * FROM `affilate_user` WHERE email='$user'";
    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $affialte_no = $row_type['affialte_no'];

        echo "https://www.merchantcouriers.co.zw/signup_aff.php?joinnow=$affialte_no";
    }
}

function getUsers()
{
    global $Connect;
    $user = $_SESSION['affilate_Username'];

    $get = "SELECT * FROM `affilate_user` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['id'];
        $Name = $row_type['name'];
        $affialte_no = $row_type['affialte_no'];
        $phone = $row_type['phone'];

        $get = "SELECT * FROM `businesspartners` WHERE affiliate_no = '$affialte_no' ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {

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
                <td> $ID</td>
                <td>$Name</td>
                <td>$email_from</td>
                <td>$phone</td>
            </tr>";
        }
    }
}

function getDrivers()
{
    global $Connect;

    $user = $_SESSION['MM_Username'];

    $get = "SELECT * FROM `users` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $Name = $row_type['Name'];
        $Email = $row_type['email'];

        $get = "SELECT * FROM `driver` WHERE company_name='$Name'";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['driverID'];
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

            echo "<tr>
                <td> $ID</td>
                <td><b style='color:#FF8C00'>$Name</b><br/>$phone<br/><b style='color:#FF8C00'>$address</b></td>
                <td>$online</td>
                <td>$username</td>
				<td>$info</td>
				<td>
				<a href='delete.php?revokeDriver=$ID'><button type='button' class='btn btn-danger'>Block</button></a>
				<a href='delete.php?unblockDriver=$ID'><button type='button' class='btn btn-success'>Unblock</button></a>
				</td>
				<td><a href='driverDetail.php?detail=$email'><i class='fa-fw'>details...</i></a></td>
				<td><a href='delete.php?deleteDriver=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
            </tr>";
        }
    }
}

function getDriverDetails()
{
    if (isset($_GET['detail'])) {
        $MrE = $_GET['detail'];
        global $Connect;

        $get = "SELECT * FROM `driver` where email='$MrE' ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['driverID'];
            $Name = $row_type['name'];
            $phone = $row_type['phone'];
            $email = $row_type['email'];
            $address = $row_type['address'];
            $mode_of_transport = $row_type['mode_of_transport'];
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

            echo "#$ID <img src='../../images/driverProfile/$profileImage' class='pull-right' width='40px' height='40px'> <br><br>
	               <li class='list-group-item'><b>Status:</b> $username </li>
                   <li class='list-group-item'><h3>Details </h3></li>
			       <li class='list-group-item'><b>Name:</b> $Name<br></li>
			       <li class='list-group-item'><b>D.O.B:</b> $dob<br></li>
                   <li class='list-group-item'><b>Phone:</b> $phone<br/></li>
                   <li class='list-group-item'><b>Email:</b> $email  <br/></li>
                   <li class='list-group-item'><b>Address:</b> $address  <br/></li>

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

function getDriverDocs()
{
    if (isset($_GET['detail'])) {
        $MrE = $_GET['detail'];
        global $Connect;

        $get = "SELECT * FROM `driver_doc` where email='$MrE' ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
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

function getDoc()
{
    if (isset($_GET['doc'])) {
        $MrE = $_GET['doc'];
        global $Connect;

        $get = "SELECT * FROM `driver_doc` where ID='$MrE' ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['ID'];
            $Name = $row_type['DriverName'];
            $email = $row_type['email'];
            $doc = $row_type['documents'];

            echo "<embed type='application/pdf' src='../../driver_documents/$Name/$doc' width='100%' height='500px'>";
        }
    }
}

function getDriversOnMaps()
{
    global $Connect;

    $get = "SELECT * FROM `driver`";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
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

function getPrizelist()
{
    global $Connect;

    $get = "SELECT * FROM `prizelist`";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $Price_per_km = $row_type['Price_per_km'];

        echo "$Price_per_km";
    }
}

function getBusinessPartnerD()
{
    if (isset($_GET['partnerD'])) {
        $MrE = $_GET['partnerD'];
        global $Connect;

        $get = "SELECT * FROM `businesspartners` WHERE businessID = '$MrE' Limit 1 ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {

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
				<td><a href='delete.php?deleteBus=$ID'><i class='fa fa-trash fa-fw'></i></a></td>

            </tr>";
        }
    }
}



function getBusinessPartner()
{
    if (!isset($_GET['partnerD'])) {
        global $Connect;

        $get = "SELECT * FROM `businesspartners`";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {

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
				<td><a href='delete.php?deleteBus=$ID'><i class='fa fa-trash fa-fw'></i></a></td>
				<td><a href='BusinessPartnerDetails.php?partnerD=$ID'><i class='fa fa-list-alt fa-fw'></i></a></td>
            </tr>";
        }
    }
}

function getExDateToDriver()
{
    global $Connect;

    $user = $_SESSION['MM_Username'];

    $get = "SELECT * FROM `users` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $Name = $row_type['Name'];
        $Email = $row_type['email'];
        $date = $row_type['date'];
        $days = $row_type['days'];

        $expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . "+ $days day"));

        if (date("Y-m-d") < $expire) {
            $show = "";
        } else {
            $show = "<div style='color:red'><h2>Your account has expired please recharge!<h2></div>";
        }
        echo "$show";
    }
}

function getExDate()
{
    global $Connect;

    $user = $_SESSION['MM_Username'];

    $get = "SELECT * FROM `users` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $Name = $row_type['Name'];
        $Email = $row_type['email'];
        $date = $row_type['date'];
        $days = $row_type['days'];

        $expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . "+ $days day"));

        if (date("Y-m-d") < $expire) {
            $show = "";
        } else {
            $show = "<div style='color:red'><h2>Your account has expired please recharge!<h2></div>";
        }
        echo "$show";
    }
}

function getBookings()
{
    global $Connect;

    $user = $_SESSION['affilate_Username'];

    $get = "SELECT * FROM `affilate_user` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['id'];
        $Name = $row_type['name'];
        $Email = $row_type['email'];
        $phone = $row_type['phone'];
        $balance = $row_type['balance'];
        $affialte_no = $row_type['affialte_no'];

        $get = "SELECT * FROM `bookings` WHERE affiliate_no='$affialte_no' order by Date DESC";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['order_id'];
            $email_from = $row_type['email'];
            $address = $row_type['pick_up_address'];
            $drop_address = $row_type['drop_address'];
            $name = $row_type['Name'];;
            $date = $row_type['pick_up_date'];
            $drop_date = $row_type['drop_date'];
            $weight_of_package = $row_type['weight'];
            $package_quantity = $row_type['quantity'];
            $insurance = $row_type['insurance'];
            $value_of_package = $row_type['value'];
            $note = $row_type['drivers_note'];
            $time = $row_type['pick_up_time'];
            $status = $row_type['status'];
            $invoice = $row_type['invoice'];
            $price = $row_type['Total_price'];
            $vehicle_type = $row_type['vehicle_type'];
            $affiliate_com = $row_type['affiliate_com'];

            $cost1 = $affiliate_com;;
            $tot = number_format((float)$cost1, 2, '.', '');

            $show = "<tr>
                <td>$ID</td>
                <td>$date</td>
                <td>$vehicle_type</td>
                <td>$name</td>
				<td>
				<a href='#'  class='btn btn-outline btn-primary'><i class='fa fa-usd fa-fw'></i>$price</a>
				<p><button href='orderDetails.php?orderD=$ID' class='btn btn-outline btn-xs'>Earned:<i class='fa fa-usd fa-fw'></i>$tot</button>
				</td>
				<td>
				<a href='orderDetails.php?orderD=$ID' class='btn btn-outline btn-primary'><i class='fa fa-list-alt fa-fw'></i>$status</a>
				<p><button href='orderDetails.php?orderD=$ID' class='btn btn-outline btn-xs'>Order: $invoice</button></p>
				</td>
		   </tr>";


            echo "$show";
        }
    }
}

function getBookingsD()
{
    if (isset($_GET['orderD'])) {
        $MrE = $_GET['orderD'];
        global $Connect;

        $get = "SELECT * FROM `bookings` WHERE order_id = '$MrE' ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['order_id'];
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


            echo " Order#$ID
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

function getContacts()
{
    global $Connect;

    $get = "SELECT * FROM `contacts` order by Date DESC";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
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

function getChats()
{
    global $Connect;

    $user = $_SESSION['MM_Username'];

    $get = "SELECT * FROM `users` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $Name = $row_type['Name'];
        $Email = $row_type['email'];
        $date = $row_type['date'];
        $days = $row_type['days'];

        $expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . "+ $days day"));

        $get = "SELECT * FROM `chat_drivers` WHERE company_name='$Name' order by Date DESC ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['ID'];
            $Date = $row_type['Date'];
            $Name = $row_type['name'];
            $msg = $row_type['message'];


            if (date("Y-m-d") < $expire) {
                $show = "<a href='message.php?chatD=$ID' class='list-group-item'>
                                    <i class='fa  fa-envelope-o fa-fw'></i> $Name
                                    <span class='pull-right text-muted small'><em>$Date</em>
                                    </span>
                                </a>";
            } else {
                $show = "";
            }
            echo "$show";
        }
    }
}

function getChatAlert()
{
    global $Connect;

    $user = $_SESSION['MM_Username'];

    $get = "SELECT * FROM `users` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $Name = $row_type['Name'];
        $Email = $row_type['email'];
        $date = $row_type['date'];
        $days = $row_type['days'];

        $expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . "+ $days day"));

        $get = "SELECT * FROM `chat_drivers` WHERE company_name='$Name' order by Date DESC LIMIT 3 ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['ID'];
            $Date = $row_type['Date'];
            $Name = $row_type['name'];
            $msg = $row_type['message'];

            if (strlen($msg) > 100) {
                $trimstring = substr($msg, 0, 100);
            } else {
                $trimstring = $msg;
            }

            if (date("Y-m-d") < $expire) {
                $show = "<li class='divider'></li>
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
                        </li>";
            } else {
                $show = "";
            }
            echo "$show";
        }
    }
}

function getChatsFroDr()
{
    if (isset($_GET['chatD'])) {
        $MrE = $_GET['chatD'];
        global $Connect;

        $get = "SELECT * FROM `chat_drivers` where ID = '$MrE' order by Date DESC";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
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

function getReplyChatsFroDr()
{
    if (isset($_GET['chatD'])) {
        $MrE = $_GET['chatD'];
        global $Connect;

        $get = "SELECT * FROM `replychat_drivers` where chatID = '$MrE' ";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
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

function getBlog()
{
    global $Connect;

    $get = "SELECT * FROM `blog`";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
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
                                </a>
				  ";
    }
}

function getCountNewOrders()
{

    global $Connect;
    $count = 0;

    $user = $_SESSION['affilate_Username'];

    $get = "SELECT * FROM `affilate_user` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $affialte_no = $row_type['affialte_no'];
    }

    $get = "SELECT * FROM bookings WHERE affiliate_no='$affialte_no'";

    $run = mysqli_query($Connect, $get);

    $count = mysqli_num_rows($run);

    $show = $count;

    echo "$show";
}


function getCountCustomers()
{

    global $Connect;
    $count = 0;

    $user = $_SESSION['affilate_Username'];

    $get = "SELECT * FROM `affilate_user` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $affialte_no = $row_type['affialte_no'];
    }

    $get = "SELECT * FROM businesspartners WHERE affiliate_no='$affialte_no'";

    $run = mysqli_query($Connect, $get);

    $count = mysqli_num_rows($run);

    $show = $count;

    echo "$show";
}


function getCountTotalSales()
{
    global $Connect;
    $tot = 0;
    $cost = 0;

    $user = $_SESSION['affilate_Username'];

    $get = "SELECT * FROM `affilate_user` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $affialte_no = $row_type['affialte_no'];
        $order_id = $row_type['paid_orders'];
        $balance = $row_type['balance'];

        $cost = $balance;
        $tot = number_format((float)$cost, 2, '.', '');

        echo $tot;
    }
}

function getCountMonSales()
{
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
    $last_month_year = '';
    $run = mysqli_query($Connect, $get);
    while ($nt = mysqli_fetch_array($run)) {
        $price = array($row_price['Total_price']);
        $total = array_sum($price);

        $cost += $total;
        $tot = number_format((float)$cost, 2, '.', '');

        if ($last_month_year == '')
            $month_total = $nt['daily_total'];
        elseif ($last_month_year == $nt['month'] . $nt['year'])
            $month_total += $nt['daily_total'];
        else {
            $month_total = $nt['daily_total'];
            echo "Month total: " . $month_total . "<br>";
        }
        $cost = $nt['date'] . $nt['daily_total'] . "<br>";
        $last_month_year = $nt['month'] . $nt['year'];

        $tot = number_format((float)$cost, 2, '.', '');

        echo $tot;
    }
}

function getCountSharedAd()
{
    global $Connect;

    $user = $_SESSION['affilate_Username'];

    $get = "SELECT * FROM `affilate_user` WHERE email='$user'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $affialte_no = $row_type['affialte_no'];
    }

    $get = "SELECT * FROM `affilate_invites` WHERE affiliate_no='$affialte_no' ";

    $run = mysqli_query($Connect, $get);

    $count = mysqli_num_rows($run);

    echo $count;
}

function getCountTotalEarned()
{
    global $Connect;

    $user = $_SESSION['affilate_Username'];

    $geta = "SELECT * FROM `affilate_user` WHERE email='$user'";

    $runa = mysqli_query($Connect, $geta);

    while ($row_type = mysqli_fetch_array($runa)) {
        $affialte_no = $row_type['affialte_no'];
    }
    $cost;
    $get = "SELECT * FROM bookings WHERE affiliate_no='$affialte_no' AND status !='cancelled'";
    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $price = array($row_type['affiliate_com']);
        $total = array_sum($price);

        $cost += $total;
        $tot = number_format((float)$cost, 2, '.', '');
    }

    echo $tot;
}

function getChatsAffiliate()
{
    $MrE = $_SESSION['affilate_Username'];
    global $Connect;
    $m = "";
    $geta = "SELECT * FROM `affilate_user` WHERE email='$MrE'";
    $runa = mysqli_query($Connect, $geta);
    while ($row_type = mysqli_fetch_array($runa)) {
        $affialte_no = $row_type['affialte_no'];
    }
    $get = "SELECT * FROM `affiliate_msg` where affiliate_no = '$affialte_no' OR reply_no='$affialte_no' and name !='' order by date ASC";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['id'];
        $Date = $row_type['date'];
        $Name = $row_type['name'];
        $msg = $row_type['msg'];
        $affiliate_no2 = $row_type['affiliate_no'];
        $reply_no = $row_type['reply_no'];


        if ($reply_no == $affialte_no) {
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
                        <p>
                           $msg
						</p>
                    </div>
                </li>";
        } else if ($affiliate_no2 == $affialte_no) {
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
                        <p>
                          $msg
						</p>
                    </div>
                </li>";
        }

        echo $m;
    }
}
