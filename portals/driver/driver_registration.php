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
