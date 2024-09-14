<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

$Connect = @mysqli_connect("localhost", "iobagcmg_merchant_admin", "}{kTftfu1449", "iobagcmg_merchant_db");

if (isset($_GET['driva'])) {

    $MrE = $_GET['driva'];
    $get = "SELECT * FROM `driver` where username = '$MrE' ";

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
        $documents = $row_type['documents'];
        $status = $row_type['online'];
        $profileImage = $row_type['profileImage'];



        $MrE = " <div class='bio-row'>
              <p><span> Name </span>: $Name </p>
              </div>
              <div class='bio-row'>
                  <p><span>Address </span>: $address</p>
              </div>
              <div class='bio-row'>
                  <p><span>Birthday</span>: $dob</p>
              </div>
              <div class='bio-row'>
                  <p><span>Country </span>: Zimbabwe</p>
              </div>
              <div class='bio-row'>
                  <p><span>Occupation </span>: $occupation</p>
              </div>
              <div class='bio-row'>
                  <p><span>Mobile </span>: $phone</p>
              </div>
	  ";
    }
}



$date = date("Y-m-d");
$time = date("H:m");
$datetime = $date . "T" . $time;


echo "
    	   <div class='panel-body'>
                            <div class='col-lg-2 col-sm-2'>
                              <h4> $Name</h4>
                              <div class='follow-ava'>
                                   <img src='https://merchantcouriers.co.zw/images/driverProfile/$profileImage' alt=''>
                              </div>
                              <h6>Driver <b style='color:FF8C00; text-transform:uppercase;'>$status</b></h6>
                            </div>
                            <div class='col-lg-4 col-sm-4 follow-info'>
                                <p>Hello I’m $Name, a driver at Merchant Coureirs .</p>
                                <h6>
                                    <span><i class='icon_clock_alt'></i>$time</span>
                                    <span><i class='icon_calendar'></i>$date</span>
                                    <span><i class='icon_pin_alt'></i>Zimbabwe</span>
                                </h6>
                            </div>
                          </div>

	  ";
