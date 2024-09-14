<?php require ("login-security.php"); ?>

<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$sResponse = "";
if (isset($_POST["MM_insert"])) {
	$myFile = "website.json";
	$myLogoFile = "logo.json";
	
	$name_image = $_FILES['logo']['name'];
    $tmp_name_array = $_FILES['logo']['tmp_name'];
    move_uploaded_file($tmp_name_array, "custom_files/$name_image");
	
	if($_FILES['logo']['size'] != 0){
	$a_post = $_POST;
	$a_logo_post = $_FILES;
    file_put_contents($myFile, json_encode($a_post));
    file_put_contents($myLogoFile, json_encode($a_logo_post));
	//file_put_contents($myFile, json_encode($_FILES), FILE_APPEND);
    $srResponse = '<div class="alert alert-success">Record Updated Successfully</div>';
	}else{
	$a_post = $_POST;
    file_put_contents($myFile, json_encode($a_post));
    $srResponse = '<div class="alert alert-success">Record Updated Successfully</div>';
	}
}


?>
<?php require("function.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Web Management</title>

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

    <div id="wrapper">

       <?php include("nav-menu.php"); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Customize Website</h1>
                        <div class="row">
                            <?php echo $srResponse; ?>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-12">
                                <form role="form" method="POST" name="invite" action="site_management.php" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <p><span id="sent"></span></p>
                                        <p class="help-block"></p>

                                        <div class="panel panel-default">
                                            <!-- .panel-heading -->
                                            <div class="panel-body">
                                                <div class="panel-group" id="accordion">
                                                    <!----------Strip Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Logo</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseOne" class="panel-collapse collapse in">
                                                            <div class="panel-body">
                                                                <div class="row">
																    <div class="col-lg-6">
                                                                        <label>Current Logo</label>
                                                                        <img src='custom_files/<?php echo $logo; ?>' width="100px"/>
                                                                    </div>
																	<div class="col-lg-6">
                                                                        <label>Upload Logo Size(240x56)</label>
                                                                        <input type="file" class="form-control" name="logo" /> <br />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Website Name</label>
                                                                        <input type="text" class="form-control" value="<?php echo $site_name; ?>" name="site_name" placeholder="Enter website name" required /><br />
                                                                    </div>
                                                                    
																	<div class="col-lg-6">
                                                                        <label>Website URL (Don't include WWW)</label>
                                                                        <input type="text" class="form-control" name="url" placeholder="domain.com" value="<?php echo $web_url; ?>"/><br />
                                                                    </div>
																	
																	<div class="col-lg-6">
                                                                        <label>Address</label>
                                                                        <input type="text" class="form-control" name="bus_address" placeholder="Address" value="<?php echo $bus_address; ?>"/>
                                                                    </div>
																	<div class="col-lg-6">
                                                                        <label>Phone Number</label>
                                                                        <input type="text" class="form-control" name="bus_phone" placeholder="phone" value="<?php echo $bus_phone; ?>"/><br />
                                                                    </div>
																	<div class="col-lg-6">
                                                                        <label>E-mail</label>
                                                                        <input type="text" class="form-control" name="bus_email" placeholder="email@domain.com" value="<?php echo $bus_email; ?>"/>
                                                                    </div>
																	<div class="col-lg-6">
                                                                        <label>Google ReCapcha Key</label>
                                                                        <input type="text" class="form-control" name="recapcha_key" placeholder="recapcha key" value="<?php echo $recapcha_key; ?>"/><br />
                                                                    </div>
																	<div class="col-lg-6">
                                                                        <label>Facebook Pixel ID</label>
                                                                        <input type="text" class="form-control" name="facebook_pixel" placeholder="enter pixel id" value="<?php echo $facebook_pixel; ?>"/>
                                                                    </div>
																	<div class="col-lg-6">
                                                                        <label>Google Analytics Key</label>
                                                                        <input type="text" class="form-control" name="analytics_key" placeholder="analytics key" value="<?php echo $analytics_key; ?>"/><br />
                                                                    </div>
																	<div class="col-lg-12">
                                                                        <label>Firebase OTP</label>
                                                                        <textarea type="text" class="form-control" name="firebase_config" placeholder="Firebase Config" ><?php echo $firebase_config; ?></textarea><br />
                                                                    </div>
																	<div class="col-lg-12">
                                                                        <label>Firebase Push Notification Key</label>
																		<input type="text" class="form-control" name="firebase_push_key" placeholder="Firebase Push key" value="<?php echo $firebase_push_key; ?>"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Strip End --------->

                                                    
                                                   
                                                    <div class="col-lg-6 pull-right">
                                                        <br /><br />
                                                        <input type="submit" name="invite" class="btn btn-primary btn-lg btn-block" value="Submit">
                                                        <input type="hidden" name="MM_insert" value="invite">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </form>
                                <hr />

                            </div>

                            <!-- /.col-lg-6 -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

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
