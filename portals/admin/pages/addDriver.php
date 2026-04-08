<?php include("function.php") ?>

<?php include ('site_settings.php'); ?>

<?php
require_once('../../config/bootstrap.php');

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "addDriver")) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $driverID = intval($_POST['driverID']);
    try {
        // Check if username already exists
        $stmt = $DB->prepare("SELECT COUNT(*) as count FROM driver WHERE username = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];
        
        if ($count == 0) {
            // Username doesn't exist, update driver record
            $stmt = $DB->prepare("UPDATE driver SET username = ?, password = ? WHERE driverID = ?");
            
            if ($stmt->execute([$username, $password, $driverID])) {
                echo "<script>alert('You are now a registered driver at ' . $site_name . ' .')</script>";
                echo "<script>window.open('../../driver/index.php','_self')</script>";
            } else {
                echo "<script>alert('Error updating driver information')</script>";
            }
        } else {
            echo "<script>alert('Username is already taken, please try a different name')</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} //end post
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Driver Registration</title>

</head>

<body>

    <?php
    if (isset($_GET['approvedDriver'])) {

        $MrE = $_GET['approvedDriver'];
        global $DB;

        $get = "SELECT * FROM `driver` where driver_number='$MrE'";

        $stmt = $DB->prepare( $get);

        foreach ($results as $1) {
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
            $regNo = $row_type['RegNo'];
            $username = $row_type['username'];
            $Email = $row_type['email'];
        }
    }

    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Register to drive with <?php echo $site_name ?></h3>
                    </div>
                    <div class="panel-body">
                        <form ACTION="addDriver.php" METHOD="POST" role="form" name="addDriver">
                            <fieldset>
                                <div class="form-group">
                                    <label>
                                        <h4>Contact Info</h4>
                                    </label>
                                    <br />
                                    <label>Full name</label>
                                    <input class="form-control" name="driverName" id="disabledInput" type="text" value="<?php echo $Name; ?>" required disabled>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" name="email" type="email" id="disabledInput" value="<?php echo $Email; ?>" required disabled>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control" name="phone" type="tel" value="<?php echo $phone; ?>" required disabled>
                                    <input class="form-control" name="driverID" type="hidden" value="<?php echo $ID; ?>" required>

                                </div>
                                <br />
                                <div class="form-group">
                                    <label>
                                        <h4>Create an Account</h4>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="form-control" name="username" type="text" autofocus required>
                                    <span id="error"> </span>
                                </div>
                                <div class="form-group">
                                    <label>password</label>
                                    <input class="form-control" name="password" type="password" required>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Register">
                            </fieldset>
                            <input type="hidden" name="MM_update" value="addDriver">
                            <input type="hidden" name="MM_insert" value="addDriver">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Include footer template scripts -->
<?php include 'footer-template-scripts.php'; ?>

</body>

</html>


