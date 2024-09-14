<?php
require_once('db.php');

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "addDriver")) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $driverID = $_POST['driverID'];
    try {

        $stmt = $Connect->prepare("SELECT * FROM driver WHERE username=:username");
        $stmt->execute(array(":username" => $username));
        $count = $stmt->rowCount();
        if ($count == "") {
            $stmt = $Connect->prepare("UPDATE driver SET  username=:username, password=:password WHERE driverID=:driverID");

            $stmt->bindparam(":username", $username);
            $stmt->bindparam(":password", $password);
            $stmt->bindparam(":driverID", $driverID);


            //check if query executes
            if ($stmt->execute()) {
                echo "<script>alert('You are now a registered driver at Merchant Couriers.')</script>";
                echo "<script>window.open('../../driver/index.php','_self')</script>";
            } else {

                echo "<script>alert('username is taken go back and try a different name')</script>";
            }
        } //end of integrity check

        else {
            echo "1"; // user email is taken
        }
    } // end of try block

    catch (PDOException $e) {
        echo $e->getMessage();
    }
} //end post
?>
<?php include("function.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Merchant Couriers - Driver Registration</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



</head>

<body>

    <?php
    if (isset($_GET['approvedDriver'])) {

        $MrE = $_GET['approvedDriver'];
        global $Connect;

        $get = "SELECT * FROM `driver` where driver_number='$MrE'";

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
                        <h3 class="panel-title">Register to drive with Merchant Couriers</h3>
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


    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
