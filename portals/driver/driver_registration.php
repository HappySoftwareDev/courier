<?php
require_once '../../config/bootstrap.php';
require_once '../../function.php';

error_reporting(0);

// Get site name
$site_name = defined('SITE_NAME') ? SITE_NAME : 'WG ROOS Courier';


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "driverForm")) {
    $name_array = $_FILES['documents']['name'];
    $tmp_name_array = $_FILES['documents']['tmp_name'];
    $type_array = $_FILES['documents']['type'];
    $size_array = $_FILES['documents']['size'];
    $userNa = $_POST['fullname'];
    $desired_dir = "driver_documents";
    move_uploaded_file($tmp_name_array, "driver_documents/$name_array");
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $insertSQL = $Connect->prepare("INSERT INTO driver_doc (DriverName, email, documents)VALUES ($fullname, $email, '$name_array')");
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "driverForm")) {
    try {
        $name_image = $_FILES['profileImage']['name'];
        $tmp_name_array = $_FILES['profileImage']['tmp_name'];
        $type_array = $_FILES['profileImage']['type'];
        $size_array = $_FILES['profileImage']['size'];
        move_uploaded_file($tmp_name_array, "images/driverProfile/$name_image");

        $driver_num = $_POST['driver_num'];
        $fullname = $_POST['fullname'];
        $phone = $_POST['countryCode'] + $_POST['phone'];
        $address = $_POST['address'];
        $vehicleMake = $_POST['vehicleMake'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $engineCapacity = $_POST['engineCapacity'];
        $RegNo = $_POST['RegNo'];
        $dob = $_POST['dob'];
        $occupation = $_POST['occupation'];
        $email = $_POST['email'];
        $mode_of_transport = $_POST['mode_of_transport'];
        $type_of_service = $_POST['type_of_service'];
        $city = $_POST['city'];

        $insertSQL = $Connect->prepare("INSERT INTO driver (driver_number, name, phone, address, city, vehicleMake, model, `year`, engineCapacity, RegNo, DOB, occupation, email, mode_of_transport, type_of_service, profileImage) VALUES (:driver_num, :fullname, :phone, :address, :city, :vehicleMake, :model, :year, :engineCapacity, :RegNo, :dob, :occupation, :email, :mode_of_transport, :type_of_service, :name_image)");
        $insertSQL->bindparam(":driver_num", $driver_num);
        $insertSQL->bindparam(":fullname", $fullname);
        $insertSQL->bindparam(":email", $email);
        $insertSQL->bindparam(":phone", $phone);
        $insertSQL->bindparam(":address", $address);
        $insertSQL->bindparam(":city", $city);
        $insertSQL->bindparam(":vehicleMake", $vehicleMake);
        $insertSQL->bindparam(":model", $model);
        $insertSQL->bindparam(":year", $year);
        $insertSQL->bindparam(":engineCapacity", $engineCapacity);
        $insertSQL->bindparam(":RegNo", $RegNo);
        $insertSQL->bindparam(":dob", $dob);
        $insertSQL->bindparam(":occupation", $occupation);
        $insertSQL->bindparam(":mode_of_transport", $mode_of_transport);
        $insertSQL->bindparam(":type_of_service", $type_of_service);
        $insertSQL->bindparam(":name_image", $name_image);


        $subject2 = "New Driver Registration";
        $email_to = "admin@" . $web_url;
        $name = $_POST['fullname'];

        $htmlContent2 = '
    <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>' . $site_name . '</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">' . $site_name . '</h1>
        <h3>Freight.Courier.Transportation</h3>
		<p>
	    ' . $name . ' has just registered to become a driver.
		</p>

       <h3> Click <a href="http://' . $web_url . '/admin"><b>More Info</b></a> to see more details about this registration.</h3>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>For inquiries, visit <a href="http://' . $web_url . '">' . $web_url . '</a>. Call/WhatsApp <b>' . $bus_phone . '</b>.</p>
        <p>PLEASE DO NOT REPLY TO THIS EMAIL.</p>
		<h4 style="color:#FF8C00">' . $site_name . '</h4>
		<p>Freight.Courier.Transportation</p>
		</div>
		</footer>
		</div>
    </body>
    </html>';

        // Set content-type header for sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // Additional headers
        $headers .= 'From: ' . $site_name . ' <registrations@' . $web_url . '>' . "\r\n";
        

        // Send email
        if (mail($email_to, $subject2, $htmlContent2, $headers)) :
            $successMsg = 'Email has sent successfully.';
        else :
            $errorMsg = 'Email sending failed.';
        endif;

        $subject = "Driver Registration";
        $client_to = $_POST['email'];
        $name = $_POST['fullname'];

        $htmlContent = '
    <html>
    <head>
        <title>' . $site_name . '</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">' . $site_name . '</h1>
        <h3>Freight.Courier.Transportation</h3>
		<p>
	    Hey ' . $name . ' <br/>
	    You just registered to become a driver for ' . $site_name . '. <br/>
	    When your registration is approved you will receive an email with a link for you to create your login details. Good luck!
		</p>

       <h3> Click <a href="http://' . $web_url . '/admin/"><b>More Info</b></a> to see more details about this registration.</h3>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>For inquiries, visit <a href="http://' . $web_url . '">' . $web_url . '</a>. Call/WhatsApp <b>' . $bus_phone . '</b>.</p>
        <p>PLEASE DO NOT REPLY TO THIS EMAIL.</p>

		<h4 style="color:#FF8C00">' . $site_name . '</h4>
		<p>Freight.Courier.Transportation</p>
		</div>
		</footer>
		</div>
    </body>
    </html>';

        // Set content-type header for sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // Additional headers
        $headers .= 'From: ' . $site_name . ' <registrations@' . $web_url . '>' . "\r\n";

        // Send email
        if (mail($client_to, $subject, $htmlContent, $headers)) :
            $successMsg = 'Email has sent successfully.';
        else :
            $errorMsg = 'Email sending failed.';
        endif;

        $insertGoTo = "driver_registration.php";
        if ($insertSQL->execute()) {
            echo "<script>alert('Registration was successful we will be in touch with you after review')</script>";
            echo "<script>window.open('driver_registration.php','_self')</script>";
        } else {
            echo "<script>alert('error!')</script>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $site_name ?> - Driver Registration</title>
    
    <!-- Include head.php for Bootstrap 5 CDN -->
    <?php include 'head.php'; ?>
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        
        .registration-wrapper {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
            padding: 40px;
        }
        
        .registration-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .registration-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        .registration-header p {
            font-size: 14px;
            color: #6b7280;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #374151;
        }
        
        input[type=text],
        input[type=email],
        input[type=password],
        input[type=tel],
        input[type=date],
        select,
        textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            font-size: 13px;
            font-family: inherit;
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        
        input[type=text]:focus,
        input[type=email]:focus,
        input[type=password]:focus,
        input[type=tel]:focus,
        input[type=date]:focus,
        select:focus,
        textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
        
        .btn-register {
            width: 100%;
            padding: 12px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            margin-top: 20px;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .signin-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #6b7280;
        }
        
        .signin-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <!-- Home Navigation -->
    <div style="position: absolute; top: 20px; left: 20px; z-index: 100;">
        <a href="../../" class="btn" style="background: white; color: #667eea; border: 1px solid #e5e7eb; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-weight: 600; font-size: 13px; display: inline-block; transition: all 0.3s ease;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='white'">← Back to Home</a>
    </div>
    
    <div class="registration-wrapper">
        <div class="registration-header">
            <h2>Driver Registration</h2>
            <p>Join our driver network and start earning</p>
        </div>
        
        <?php if (!empty($successMsg)): ?>
            <div class="alert alert-success">✓ <?php echo htmlspecialchars($successMsg); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-error">✗ <?php echo htmlspecialchars($errorMsg); ?></div>
        <?php endif; ?>
        
        <form action="driver_registration.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="MM_insert" value="driverForm">
            
            <!-- Personal Information -->
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="fullname" placeholder="Enter your full name" required>
            </div>
            
            <div class="form-group">
                <label>Email Address *</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Phone Number *</label>
                    <input type="tel" name="phone" placeholder="Phone number" required>
                </div>
                <div class="form-group">
                    <label>Date of Birth *</label>
                    <input type="date" name="dob" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Address *</label>
                <input type="text" name="address" placeholder="Street address" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>City *</label>
                    <input type="text" name="city" placeholder="City" required>
                </div>
                <div class="form-group">
                    <label>Occupation *</label>
                    <input type="text" name="occupation" placeholder="Your occupation" required>
                </div>
            </div>
            
            <!-- Vehicle Information -->
            <div class="form-group">
                <label>Driver Number *</label>
                <input type="text" name="driver_num" placeholder="Driver ID number" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Vehicle Make *</label>
                    <input type="text" name="vehicleMake" placeholder="e.g., Toyota" required>
                </div>
                <div class="form-group">
                    <label>Model *</label>
                    <input type="text" name="model" placeholder="e.g., Hiace" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Year *</label>
                    <input type="text" name="year" placeholder="2020" required>
                </div>
                <div class="form-group">
                    <label>Registration Number *</label>
                    <input type="text" name="RegNo" placeholder="Reg. No." required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Engine Capacity *</label>
                <input type="text" name="engineCapacity" placeholder="Engine capacity in cc" required>
            </div>
            
            <!-- Service Selection -->
            <div class="form-row">
                <div class="form-group">
                    <label>Mode of Transport *</label>
                    <select name="mode_of_transport" required>
                        <option value="">Select transport mode</option>
                        <option value="Motorbike">Motorbike</option>
                        <option value="Car">Car</option>
                        <option value="Van">Van</option>
                        <option value="Truck">Truck</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Type of Service *</label>
                    <select name="type_of_service" required>
                        <option value="">Select service type</option>
                        <option value="Parcel Delivery">Parcel Delivery</option>
                        <option value="Freight Delivery">Freight Delivery</option>
                        <option value="Taxi">Taxi</option>
                        <option value="Tow Truck">Tow Truck</option>
                    </select>
                </div>
            </div>
            
            <!-- File Uploads -->
            <div class="form-group">
                <label>Profile Picture</label>
                <input type="file" name="profileImage" accept="image/*">
            </div>
            
            <div class="form-group">
                <label>Documents</label>
                <input type="file" name="documents" multiple>
            </div>
            
            <button type="submit" class="btn-register">Register as Driver</button>
        </form>
        
        <div class="signin-link">
            Already have an account? <a href="index.php">Sign in here</a>
        </div>
    </div>
    
    <?php include 'footer_scripts.php'; ?>
</body>
</html>
                                <option data-countryCode="AW" value="297">Aruba (+297)</option>
                                <option data-countryCode="AU" value="61">Australia (+61)</option>
                                <option data-countryCode="AT" value="43">Austria (+43)</option>
                                <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
                                <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
                                <option data-countryCode="BH" value="973">Bahrain (+973)</option>
                                <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
                                <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
                                <option data-countryCode="BY" value="375">Belarus (+375)</option>
                                <option data-countryCode="BE" value="32">Belgium (+32)</option>
                                <option data-countryCode="BZ" value="501">Belize (+501)</option>
                                <option data-countryCode="BJ" value="229">Benin (+229)</option>
                                <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
                                <option data-countryCode="BT" value="975">Bhutan (+975)</option>
                                <option data-countryCode="BO" value="591">Bolivia (+591)</option>
                                <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
                                <option data-countryCode="BW" value="267">Botswana (+267)</option>
                                <option data-countryCode="BR" value="55">Brazil (+55)</option>
                                <option data-countryCode="BN" value="673">Brunei (+673)</option>
                                <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
                                <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
                                <option data-countryCode="BI" value="257">Burundi (+257)</option>
                                <option data-countryCode="KH" value="855">Cambodia (+855)</option>
                                <option data-countryCode="CM" value="237">Cameroon (+237)</option>
                                <option data-countryCode="CA" value="1">Canada (+1)</option>
                                <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
                                <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
                                <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
                                <option data-countryCode="CL" value="56">Chile (+56)</option>
                                <option data-countryCode="CN" value="86">China (+86)</option>
                                <option data-countryCode="CO" value="57">Colombia (+57)</option>
                                <option data-countryCode="KM" value="269">Comoros (+269)</option>
                                <option data-countryCode="CG" value="242">Congo (+242)</option>
                                <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
                                <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
                                <option data-countryCode="HR" value="385">Croatia (+385)</option>
                                <option data-countryCode="CU" value="53">Cuba (+53)</option>
                                <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
                                <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
                                <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
                                <option data-countryCode="DK" value="45">Denmark (+45)</option>
                                <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
                                <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                                <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
                                <option data-countryCode="EC" value="593">Ecuador (+593)</option>
                                <option data-countryCode="EG" value="20">Egypt (+20)</option>
                                <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                                <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
                                <option data-countryCode="ER" value="291">Eritrea (+291)</option>
                                <option data-countryCode="EE" value="372">Estonia (+372)</option>
                                <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
                                <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
                                <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
                                <option data-countryCode="FJ" value="679">Fiji (+679)</option>
                                <option data-countryCode="FI" value="358">Finland (+358)</option>
                                <option data-countryCode="FR" value="33">France (+33)</option>
                                <option data-countryCode="GF" value="594">French Guiana (+594)</option>
                                <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
                                <option data-countryCode="GA" value="241">Gabon (+241)</option>
                                <option data-countryCode="GM" value="220">Gambia (+220)</option>
                                <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
                                <option data-countryCode="DE" value="49">Germany (+49)</option>
                                <option data-countryCode="GH" value="233">Ghana (+233)</option>
                                <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
                                <option data-countryCode="GR" value="30">Greece (+30)</option>
                                <option data-countryCode="GL" value="299">Greenland (+299)</option>
                                <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
                                <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
                                <option data-countryCode="GU" value="671">Guam (+671)</option>
                                <option data-countryCode="GT" value="502">Guatemala (+502)</option>
                                <option data-countryCode="GN" value="224">Guinea (+224)</option>
                                <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
                                <option data-countryCode="GY" value="592">Guyana (+592)</option>
                                <option data-countryCode="HT" value="509">Haiti (+509)</option>
                                <option data-countryCode="HN" value="504">Honduras (+504)</option>
                                <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
                                <option data-countryCode="HU" value="36">Hungary (+36)</option>
                                <option data-countryCode="IS" value="354">Iceland (+354)</option>
                                <option data-countryCode="IN" value="91">India (+91)</option>
                                <option data-countryCode="ID" value="62">Indonesia (+62)</option>
                                <option data-countryCode="IR" value="98">Iran (+98)</option>
                                <option data-countryCode="IQ" value="964">Iraq (+964)</option>
                                <option data-countryCode="IE" value="353">Ireland (+353)</option>
                                <option data-countryCode="IL" value="972">Israel (+972)</option>
                                <option data-countryCode="IT" value="39">Italy (+39)</option>
                                <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
                                <option data-countryCode="JP" value="81">Japan (+81)</option>
                                <option data-countryCode="JO" value="962">Jordan (+962)</option>
                                <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
                                <option data-countryCode="KE" value="254">Kenya (+254)</option>
                                <option data-countryCode="KI" value="686">Kiribati (+686)</option>
                                <option data-countryCode="KP" value="850">Korea North (+850)</option>
                                <option data-countryCode="KR" value="82">Korea South (+82)</option>
                                <option data-countryCode="KW" value="965">Kuwait (+965)</option>
                                <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
                                <option data-countryCode="LA" value="856">Laos (+856)</option>
                                <option data-countryCode="LV" value="371">Latvia (+371)</option>
                                <option data-countryCode="LB" value="961">Lebanon (+961)</option>
                                <option data-countryCode="LS" value="266">Lesotho (+266)</option>
                                <option data-countryCode="LR" value="231">Liberia (+231)</option>
                                <option data-countryCode="LY" value="218">Libya (+218)</option>
                                <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
                                <option data-countryCode="LT" value="370">Lithuania (+370)</option>
                                <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
                                <option data-countryCode="MO" value="853">Macao (+853)</option>
                                <option data-countryCode="MK" value="389">Macedonia (+389)</option>
                                <option data-countryCode="MG" value="261">Madagascar (+261)</option>
                                <option data-countryCode="MW" value="265">Malawi (+265)</option>
                                <option data-countryCode="MY" value="60">Malaysia (+60)</option>
                                <option data-countryCode="MV" value="960">Maldives (+960)</option>
                                <option data-countryCode="ML" value="223">Mali (+223)</option>
                                <option data-countryCode="MT" value="356">Malta (+356)</option>
                                <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
                                <option data-countryCode="MQ" value="596">Martinique (+596)</option>
                                <option data-countryCode="MR" value="222">Mauritania (+222)</option>
                                <option data-countryCode="YT" value="269">Mayotte (+269)</option>
                                <option data-countryCode="MX" value="52">Mexico (+52)</option>
                                <option data-countryCode="FM" value="691">Micronesia (+691)</option>
                                <option data-countryCode="MD" value="373">Moldova (+373)</option>
                                <option data-countryCode="MC" value="377">Monaco (+377)</option>
                                <option data-countryCode="MN" value="976">Mongolia (+976)</option>
                                <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
                                <option data-countryCode="MA" value="212">Morocco (+212)</option>
                                <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
                                <option data-countryCode="MN" value="95">Myanmar (+95)</option>
                                <option data-countryCode="NA" value="264">Namibia (+264)</option>
                                <option data-countryCode="NR" value="674">Nauru (+674)</option>
                                <option data-countryCode="NP" value="977">Nepal (+977)</option>
                                <option data-countryCode="NL" value="31">Netherlands (+31)</option>
                                <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
                                <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
                                <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
                                <option data-countryCode="NE" value="227">Niger (+227)</option>
                                <option data-countryCode="NG" value="234">Nigeria (+234)</option>
                                <option data-countryCode="NU" value="683">Niue (+683)</option>
                                <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
                                <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
                                <option data-countryCode="NO" value="47">Norway (+47)</option>
                                <option data-countryCode="OM" value="968">Oman (+968)</option>
                                <option data-countryCode="PW" value="680">Palau (+680)</option>
                                <option data-countryCode="PA" value="507">Panama (+507)</option>
                                <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
                                <option data-countryCode="PY" value="595">Paraguay (+595)</option>
                                <option data-countryCode="PE" value="51">Peru (+51)</option>
                                <option data-countryCode="PH" value="63">Philippines (+63)</option>
                                <option data-countryCode="PL" value="48">Poland (+48)</option>
                                <option data-countryCode="PT" value="351">Portugal (+351)</option>
                                <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
                                <option data-countryCode="QA" value="974">Qatar (+974)</option>
                                <option data-countryCode="RE" value="262">Reunion (+262)</option>
                                <option data-countryCode="RO" value="40">Romania (+40)</option>
                                <option data-countryCode="RU" value="7">Russia (+7)</option>
                                <option data-countryCode="RW" value="250">Rwanda (+250)</option>
                                <option data-countryCode="SM" value="378">San Marino (+378)</option>
                                <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
                                <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                                <option data-countryCode="SN" value="221">Senegal (+221)</option>
                                <option data-countryCode="CS" value="381">Serbia (+381)</option>
                                <option data-countryCode="SC" value="248">Seychelles (+248)</option>
                                <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
                                <option data-countryCode="SG" value="65">Singapore (+65)</option>
                                <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
                                <option data-countryCode="SI" value="386">Slovenia (+386)</option>
                                <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
                                <option data-countryCode="SO" value="252">Somalia (+252)</option>
                                <option data-countryCode="ZA" value="27">South Africa (+27)</option>
                                <option data-countryCode="ES" value="34">Spain (+34)</option>
                                <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
                                <option data-countryCode="SH" value="290">St. Helena (+290)</option>
                                <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
                                <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
                                <option data-countryCode="SD" value="249">Sudan (+249)</option>
                                <option data-countryCode="SR" value="597">Suriname (+597)</option>
                                <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
                                <option data-countryCode="SE" value="46">Sweden (+46)</option>
                                <option data-countryCode="CH" value="41">Switzerland (+41)</option>
                                <option data-countryCode="SI" value="963">Syria (+963)</option>
                                <option data-countryCode="TW" value="886">Taiwan (+886)</option>
                                <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
                                <option data-countryCode="TH" value="66">Thailand (+66)</option>
                                <option data-countryCode="TG" value="228">Togo (+228)</option>
                                <option data-countryCode="TO" value="676">Tonga (+676)</option>
                                <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                                <option data-countryCode="TN" value="216">Tunisia (+216)</option>
                                <option data-countryCode="TR" value="90">Turkey (+90)</option>
                                <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
                                <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
                                <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
                                <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
                                <option data-countryCode="UG" value="256">Uganda (+256)</option>
                                <option data-countryCode="GB" value="44">UK (+44)</option>
                                <option data-countryCode="UA" value="380">Ukraine (+380)</option>
                                <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
                                <option data-countryCode="UY" value="598">Uruguay (+598)</option>
                                <option data-countryCode="US" value="1">USA (+1)</option>
                                <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
                                <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
                                <option data-countryCode="VA" value="379">Vatican City (+379)</option>
                                <option data-countryCode="VE" value="58">Venezuela (+58)</option>
                                <option data-countryCode="VN" value="84">Vietnam (+84)</option>
                                <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
                                <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
                                <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                                <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
                                <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
                                <option data-countryCode="ZM" value="260">Zambia (+260)</option>
                                <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                </optgroup>
            </select>
            
            <input type="text" name="phone" id="number" placeholder="Phone Number" class="input-block-level form-field" required>

            <!-- Firebase Recaptcha Container -->
            <div id="recaptcha-container"></div>

            <!-- Verify Button for Phone Number -->
            <button type="button" id="verify-phone" class="btn btn-primary">Verify</button>

            <!-- Verification Step in Step 1 -->
            <div id="verify_stepp" style="display: none;">
                <label>Enter Verification Code</label>
                <input type="tel" class="input-block-level form-field" placeholder="Enter Verification Code" id="verificationCode" required>
                <button type="button" id="verify-code" class="btn btn-success btn-large btn-block">Verify Code</button>
            </div>

            <!-- Next button to move to Step 2 after successful verification -->
            <div id="auth_stepp" style="display: none;">
                <button type="button" id="next-step1" class="btn btn-success btn-large btn-block">Next</button>
            </div>
        </div>

        <!-- Second Step (Additional Information) -->
        <div id="step2" style="display: none;">
            <input type="text" name="address" placeholder="Address" class="input-block-level form-field" id="address" required>
            <label>Date of Birth</label>
            <input type="date" id="dob" name="dob" placeholder="Date of Birth" class="input-block-level form-field" required>
            <input type="text" name="occupation" placeholder="Other occupation" class="input-block-level form-field" required>

            <label>What mode of transport will you be using?</label>
            <select class="input-block-level form-field" name="mode_of_transport" onchange="showfield2(this.options[this.selectedIndex].value)" required>
                <option></option>
                <option>Car</option>
                <option>Van</option>
                <option>Truck</option>
                <option>Motorbike</option>
                <option>Scooter</option>
            </select>
            <div id="sho_truck"></div>

            <label>Enter Car Details</label>
            <input type="text" name="vehicleMake" placeholder="Vehicle make (Type of Vehicle)" class="input-block-level form-field" required>
            <input type="text" name="model" placeholder="Model" class="input-block-level form-field" required>
            <input type="text" name="year" placeholder="Year" class="input-block-level form-field" required>
            <input type="text" name="engineCapacity" placeholder="Engine Capacity" class="input-block-level form-field" required>
            <input type="text" name="RegNo" placeholder="Registration Number" class="input-block-level form-field" required>

            <input type="hidden" name="driver_num" value="<?php echo rand(10000, 99999); ?>" class="input-block-level" required>
            <label>Upload Profile Picture</label>
            <input type="file" name="profileImage" class="input-block-level form-field" required>

            <span>
                <h4>Combine your documents into one PDF document (certified copies) or upload grouped photos</h4>
                <input id="input-1" type="file" class="file form-field" name="documents" required>
            </span>
            <br /><br />
            <input type="submit" class="btn btn-success btn-large btn-block" value="Sign-up">
        </div>

        <div class="container" type="section">
            <a href="index.php">
                <button type="button" class="cancelbtn">Visit Login</button>
            </a>
            <span class="psw">Contact<a href="app.wgroos.com/contact-us"> Support</a>
            </span>
        </div>

        <input type="hidden" name="MM_insert" value="driverForm">
    </form>
</div>

<!-- Add Firebase SDK -->
<script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-auth.js"></script>

<script>
   <?php echo $firebase_config; ?>

    // Initialize Firebase
    const app = firebase.initializeApp(firebaseConfig);
    const auth = firebase.auth(app); // Initialize Firebase Authentication

    // Render the reCAPTCHA widget
    window.onload = function() {
        renderRecaptcha();
    };

    function renderRecaptcha() {
        // Initialize reCAPTCHA
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
            size: 'invisible', 
            callback: function(response) {
                console.log('Recaptcha verified');
            }
        }, auth);
        window.recaptchaVerifier.render();
    }

    // Phone verification button click
    document.getElementById('verify-phone').onclick = function() {
        var countryCode = document.getElementById('countryCode').value;
        var number = "+" + countryCode + document.getElementById('number').value;

        if (number.trim() == "") {
            alert('Please enter your phone number.');
            return;
        }

        auth.signInWithPhoneNumber(number, window.recaptchaVerifier)
            .then(function(confirmationResult) {
                window.confirmationResult = confirmationResult;
                document.getElementById('verify_stepp').style.display = "block";
                document.getElementById('recaptcha-container').style.display = "none";
                alert("Verification code sent, check your phone.");
            })
            .catch(function(error) {
                alert(error.message);
            });
    };

    // Verify code
    document.getElementById('verify-code').onclick = function() {
        var verificationCode = document.getElementById('verificationCode').value;

        if (verificationCode.trim() == "") {
            alert('Please enter a verification code.');
            return;
        }

        window.confirmationResult.confirm(verificationCode)
            .then(function(result) {
                document.getElementById('verify_stepp').style.display = "none";
                document.getElementById('auth_stepp').style.display = "block";
            })
            .catch(function(error) {
                alert(error.message);
            });
    };
</script>



<?php
    $keysFile = "../../config/keys.json";
    $aData = null;
    if (file_exists($keysFile)) {
        $content = @file_get_contents($keysFile);
        if ($content) $aData = json_decode($content);
    }
    if (!$aData) $aData = (object)[];
    $mapApi = !empty($aData->mapApi) ? $aData->mapApi : "";
?>

<!-- Include the Google Maps API -->
<script src="https://maps.google.com/maps/api/js?key=<?php echo $mapApi ?>&sensor=false&libraries=places&callback=initAutocomplete" type="text/javascript"></script>

<script>
    var placeSearch, autocomplete, drop_address;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        // Create the autocomplete object for the 'businessLocation' input field
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById('businessLocation'), {
                types: ['geocode']  // Restrict search to geographic locations
            });

        // Create autocomplete for the 'drop_address' input field if needed
        drop_address = new google.maps.places.Autocomplete(
            document.getElementById('drop_address'), {
                types: ['geocode']
            });

        // Add event listener for when a user selects an address
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object
        var place = autocomplete.getPlace();

        // Clear the address components form before filling
        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Fill the fields with the address components
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }

    // Geolocate function to bias the autocomplete based on the user's location
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());  // Bias the autocomplete results to the user's location
            });
        }
    }

    // Optional: Automatically call geolocate when the page loads to set the location
    window.onload = function() {
        initAutocomplete(); // Initialize Autocomplete
        geolocate(); // Optionally bias autocomplete results based on user location
    };
</script>

    <!-- /#registration-page -->
    
    

    


    </body>
    
    </html>


