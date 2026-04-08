<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Max-Age: 1000');

require_once '../../config/bootstrap.php';
require_once '../../function.php';

if (isset($_GET['driva'])) {

    $MrE = $_GET['driva'];
    $get = "SELECT * FROM `driver` where username = ?";
    $stmt = $DB->prepare($get);
    $stmt->execute([$MrE]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row_type) {
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
    	 <form method='POST' action='$editFormAction' class='form-horizontal' role='form' name='driverUpdate'>
          <div class='form-group'>
              <label class='col-lg-2 control-label'>Full Name</label>
              <div class='col-lg-6'>
                  <input type='text' class='form-control' id='f-name' name='name' value='$Name'>
              </div>
          </div>
          <div class='form-group'>
              <label class='col-lg-2 control-label'>Phone</label>
              <div class='col-lg-6'>
                  <input type='tel' class='form-control' id='l-name' name='phone' value='$phone'>
              </div>
          </div>
		  <div class='form-group'>
              <label class='col-lg-2 control-label'>E-mail</label>
              <div class='col-lg-6'>
                  <input type='tel' class='form-control' id='l-name' name='email' value='$email'>
              </div>
          </div>
          <div class='form-group'>
              <label class='col-lg-2 control-label'>Address</label>
              <div class='col-lg-6'>
                  <input type='text' class='form-control' id='c-name' name='address' value='$address'>
              </div>
          </div>
          <div class='form-group'>
              <label class='col-lg-2 control-label'>Birthday</label>
              <div class='col-lg-6'>
                  <input type='text' class='form-control' id='b-day' name='dob' value='$dob'>
              </div>
          </div>
          <div class='form-group'>
              <label class='col-lg-2 control-label'>Occupation</label>
              <div class='col-lg-6'>
                  <input type='text' class='form-control' id='occupation' name='occupation' value='$occupation'>
              </div>
          </div>
          <div class='form-group'>
              <label class='col-lg-2 control-label'>Vehicle Make</label>
              <div class='col-lg-6'>
                  <input type='text' class='form-control' id='email' name='vehicleMake' value='$vehicleMake'>
              </div>
          </div>
          <div class='form-group'>
              <label class='col-lg-2 control-label'>Model</label>
              <div class='col-lg-6'>
                  <input type='text' class='form-control' id='mobile' name='model' value='$model'>
              </div>
          </div>
		   <div class='form-group'>
              <label class='col-lg-2 control-label'>Year</label>
              <div class='col-lg-6'>
                  <input type='text' class='form-control' id='mobile' name='year' value='$year'>
              </div>
          </div>

		   <div class='form-group'>
              <label class='col-lg-2 control-label'>Engine Capacity</label>
              <div class='col-lg-6'>
                  <input type='text' class='form-control' id='mobile' name='engineCapacity' value='$engineCapacity'>
                   <input type='hidden' class='form-control'  name='id' value='$ID'>
              </div>
          </div>



          <div class='form-group'>
              <div class='col-lg-offset-2 col-lg-10'>
                  <button type='submit' class='btn btn-primary'>Save</button>
                  <a href='profile.php'><button type='button' class='btn btn-danger'>Cancel</button></a>
              </div>
          </div>
          <input type='hidden' name='MM_update' value='driverUpdate'>
      </form>

	  ";


