<?php
// Load centralized bootstrap
require_once('../../config/bootstrap.php');
require_once('../../function.php');

// Admin auth check
if (!isset($_SESSION['admin_email'])) {
    header('Location: login.php');
    exit;
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "driverUploadDoc")) {
    // Get form data
    $fullname = $_POST['fullname'];
    $email_2 = $_POST['email_2'];
    $driver_number = $_POST['driver_number'];
    $name_array = $_FILES['documents']['name'];
    $tmp_name_array = $_FILES['documents']['tmp_name'];
    $type_array = $_FILES['documents']['type'];
    $size_array = $_FILES['documents']['size'];
    $userNa = $_POST['fullname'];
    $desired_dir = "../../driver_documents/" . $userNa;

    // Ensure the directory exists
    if (!is_dir($desired_dir)) {
        mkdir($desired_dir, 0755); // Change to 0755 if needed
    }

    $upload_success = true; // Flag for upload success

    // Move uploaded files
    foreach ($name_array as $index => $name) {
        if (!move_uploaded_file($tmp_name_array[$index], "$desired_dir/" . $name)) {
            $upload_success = false; // Set flag to false if any file upload fails
            echo "<script>alert('Error uploading file: $name');</script>";
        }
    }

    // Check if the email exists in the driver table
    $stmt = $Connect->prepare("SELECT * FROM driver WHERE email = ?");
    $stmt->bind_param("s", $email_2);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Prepare to insert documents into the database
        $stmt = $Connect->prepare("INSERT INTO driver_doc (DriverName, email, documents) VALUES (?, ?, ?)");
        $documents = implode(",", $name_array); // Store filenames as a comma-separated string

        $stmt->bind_param("sss", $fullname, $email_2, $documents);

        if ($upload_success && $stmt->execute()) {
            echo "<script>alert('Upload Successful.')</script>";
            echo "<script>window.open('driverDetail.php?detail=$driver_number','_self')</script>";
        } else {
            echo "<script>alert('Error: Could not save documents.')</script>";
        }
    } else {
        echo "<script>alert('Upload failed. Error: User email not found.');</script>";
    }

    $stmt->close();
}

if (isset($_POST['email'])) {
    $driverID = $_POST['driverID'];
    $note = $_POST['note'];
    $to = $_POST['email'];
    $driver_phone = $_POST['phone'];
    $driver_name = $_POST['name'];

    // Prepare the email subject and HTML content
    $subject2 = "Invitation To Drive With " . $site_name;

    $htmlContent2 = '
    <html>
    <head>
        <title>' . $site_name . '</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px;">
        <h1 style="color:#FF8C00">' . $site_name . '</h1>
        <p>Hello ' . $driver_name . ', thank you for registering to become a driver at ' . $site_name . '.</p>
        <p>' . $note . '</p>
        <h3>Your registration was approved. Click <a href="https://' . $web_url . '/admin/pages/addDriver.php?approvedDriver=' . $driverID . '"><b>this link</b></a> to complete your registration account details.</h3>
        <p>If you didn’t sign up to become a driver, please ignore this email.</p>
        <footer>
            <div style="background-color:#CCC; padding:10px;">
                <p>For any further inquiries, please contact us via the contact page on our website <a href="http://' . $web_url . '">' . $web_url . '</a>. Alternatively, you can call/WhatsApp on <b>' . $bus_phone . '</b>.</p>
                <h4 style="color:#FF8C00">' . $site_name . '</h4>
            </div>
        </footer>
    </div>
    </body>
    </html>';

    // Set email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: ' . $site_name . ' <registrations@' . $web_url . '>' . "\r\n";

    // Send the email
    if (mail($to, $subject2, $htmlContent2, $headers)) {
        echo "<script>alert('Invitation sent!')</script>";
    } else {
        echo "<script>alert('Email sending failed.')</script>";
    }

    // SMS Functionality
    // $sms_phone = $driver_phone;
    // $sms_msg = "Hello $driver_name, thank you for registering to become a driver at $site_name. Your registration was approved. Check your email to complete your registration.";

    // $sms_data = http_build_query([
    //     'u' => 'Business', // Your SMS portal username
    //     'h' => '5cb7afb730f8fefe60780e67871c117f', // Your SMS portal hash ID
    //     'op' => 'pv',
    //     'to' => $sms_phone,
    //     'msg' => $sms_msg
    // ]);

    // $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
    // curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $sms_data);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // $sms_result = curl_exec($ch);
    // curl_close($ch);

    if ($sms_result) {
        echo "<script>alert('SMS sent successfully.');</script>";
    } else {
        echo "<script>alert('SMS sending failed.');</script>";
    }

    echo "<script>window.open('driver.php','_self')</script>";
}
?>



<!-- HTML Structure Continues... -->


<?php require("function.php"); ?>



<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Driver Details</title>

    
</head>

<body>

    <div id="wrapper">

        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Driver Details</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <div class="list-group">
                                            <?php getDriverDetails(); ?>
                                            <?php getDriverDocs(); ?>
                                        </div>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>

                    <div>
                        <!-- /.panel -->

                    </div>

                    <!-- /.col-lg-8 -->

                    <!-- /.col-lg-4 -->

                </div>

                <?php
                if (isset($_GET['detail'])) {
                    $MrE = $_GET['detail'];
                    global $DB;

                    $get = "SELECT * FROM `driver` where driver_number='$MrE' ";

                    $stmt = $DB->prepare( $get);

                    foreach ($results as $1) {
                        $ID = $row_type['driverID'];
                        $driver_number = $row_type['driver_number'];
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

                        $display = "none";
                        if ($username == "pending") {
                            $display = "block";
                        }
                    }
                }

                ?>

                <div class="col-lg-4" style="display:<?php echo $display; ?>">
                    <form role="form" method="POST" action="driverDetail.php" name="driverinv">
                        <div class="form-group">
                            <p><span id="sent"></span></p>
                            <h4 class="help-block">Invite a new driver.</h4> <br />
                            <label>Email</label>
                            <input class="form-control" type="text" name="email" value="<?php echo $email; ?>" placeholder="Email" required><br />
                            <textarea class="form-control" rows="3" type="text" name="note" placeholder="invitation note" required></textarea><br />
                            <input class="form-control" type="hidden" name="driverID" value="<?php echo $driver_number; ?>" placeholder="Driver ID" required>
                            <input class="form-control" type="hidden" name="phone" value="<?php echo $phone; ?>" placeholder="Driver ID" required>
                            <input class="form-control" type="hidden" name="name" value="<?php echo $Name; ?>" placeholder="Driver ID" required>
                            <input type="submit" name="sendinv" class="btn btn-primary btn-lg btn-block" value="Invite Drivers">
                            <p class="help-block">Only approved drivers are to be sent a message from here.</p>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <form method="POST" action="driverDetail.php" enctype="multipart/form-data" name="driverUploadDoc">
                        <div class="form-group">
                            <p><span id="sent"></span></p>
                            <h4 class="help-block">Add driver documents.</h4> <br />
                            <label>Upload Driver Doc</label>
                            <input class="form-control" type="file" name="documents" multiple="multiple" required><br />
                            <input class="form-control" type="hidden" name="email_2" value="<?php echo $email; ?>" placeholder="Email" required>
                            <input type="hidden" name="fullname" value="<?php echo $Name; ?>">
                            <input type="hidden" name="driver_number" value="<?php echo $driver_number; ?>">

                            <button type="submit" class="btn btn-primary btn-lg btn-block">Upload Documents</button>
                            <input type="hidden" name="MM_insert" value="driverUploadDoc">
                            <p class="help-block">Upload driver documents here.</p>
                        </div>
                    </form>
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->


        <!-- Include footer template scripts -->
        <?php include 'footer-template-scripts.php'; ?>


</body>

</html>


