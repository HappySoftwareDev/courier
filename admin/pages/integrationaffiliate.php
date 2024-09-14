<?php require ("login-securityaffiliate.php"); ?>

<?php require ("get-sql-value.php");

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['email'])) {
  $name=$_POST['name'];
  $email=$_POST['email'];
  $phone=$_POST['phone'];
  $address=$_POST['address'];
  $affiate_no=$_POST['affiate_no'];
  $password=$_POST['password'];
  
   $insertSQL = sprintf("UPDATE `affilate_user` SET `name`=%s,`email`=%s,`phone`=%s,`password`=%s,`address`=%s WHERE `affialte_no`=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['affiliate_no'], "text"));
	
  mysql_select_db($database_Connect, $Connect);
  $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());
  
   $insertGoTo = "login.php";
  if($insertGoTo){
        echo "<script>alert('Info updated successful!')</script>";
		 echo "<script>window.open('integration.php','_self')</script>";
		}else{echo "<script>alert('error!')</script>";}
}
if (isset($_POST['bank_acc'])) {
  
  $coni=@mysqli_connect("localhost","merchant_admin","}{kTftfu1449", "merchant_db");
    $affialte_no = $_POST['affiliate_no'];

  $get = "SELECT * FROM `payment_methods` WHERE affiliate_no='$affialte_no' ";
     $run = mysqli_query($coni,$get);
     $count = mysqli_num_rows($run);
  if($count != 0){
  
   $insertSQL = sprintf("UPDATE `payment_methods` SET `company_name`=%s,`bank_acc`=%s,`bank_acc_name`=%s,`bank_name`=%s,`ecocash_num`=%s,`branch`=%s WHERE `affiliate_no`=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['bank_acc'], "text"),
                       GetSQLValueString($_POST['bank_acc_name'], "text"),
                       GetSQLValueString($_POST['bank_name'], "text"),
                       GetSQLValueString($_POST['ecocash_num'], "text"),
                       GetSQLValueString($_POST['branch'], "text"),
                       GetSQLValueString($_POST['affiliate_no'], "text"));
	
  mysql_select_db($database_Connect, $Connect);
  $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());
  }else{
     $insertSQL = sprintf("INSERT INTO `payment_methods`(`company_name`, `bank_acc`, `bank_acc_name`, `bank_name`, `ecocash_num`, `branch`, `affiliate_no`)VALUES(%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['bank_acc'], "text"),
                       GetSQLValueString($_POST['bank_acc_name'], "text"),
                       GetSQLValueString($_POST['bank_name'], "text"),
                       GetSQLValueString($_POST['ecocash_num'], "text"),
                       GetSQLValueString($_POST['branch'], "text"),
                       GetSQLValueString($_POST['affiliate_no'], "text"));
	
  mysql_select_db($database_Connect, $Connect);
  $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error()); 
  }
   $insertGoTo = "login.php";
  if($insertGoTo){
        echo "<script>alert('Info submitted successfully!')</script>";
		 echo "<script>window.open('integration.php','_self')</script>";
		}else{echo "<script>alert('error!')</script>";}
}
?>
<?php require("functionaffiliate.php");?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Merchant Couriers - Drivers</title>

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

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><img src="../../images/logo.png" width="200px" height="40px" alt=" Logo" /></a>
                <b class="navbar-brand"><?php getUsername(); ?></b>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        
                        <?php getChatAlert(); ?>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
        
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="integration.php"><i class="fa fa-user fa-fw"></i><?php getUsername(); ?></a>
                        </li>
                        <li><a href="integration.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $logoutAction ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
						<li>
                            <a href="users.php"><i class="fa fa-users fa-fw"></i> Users</a>
                        </li>
					
						<li>
                            <a href="integration.php"><i class="fa fa-gear fa-fw"></i> Integration</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
		
<?php

  $user = $_SESSION['affilate_Username'];
	 
	 $get = "SELECT * FROM `affilate_user` WHERE email='$user'";
	 
	 $run = mysqli_query($Connect,$get);
	 
	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['id'];
		 $Name = $row_type['name'];
		 $Email = $row_type['email'];
		 $phone = $row_type['phone'];
		 $address = $row_type['address'];
		 $password = $row_type['password'];
		 $affialte_no = $row_type['affialte_no'];
	 }
  
  $get = "SELECT * FROM `payment_methods` WHERE affiliate_no='$affialte_no'";
	 
	 $run = mysqli_query($Connect,$get);
	 
	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['id'];
		 $bank_acc = $row_type['bank_acc'];
		 $bank_acc_name = $row_type['bank_acc_name'];
		 $bank_name = $row_type['bank_name'];
		 $ecocash_num = $row_type['ecocash_num'];
		 $branch = $row_type['branch'];
		 $affiliate_no = $row_type['affialte_no'];
	 }

 ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Settings</h1>
						<div class="row">
               
                <!-- /.col-lg-6 -->
				<div class="col-lg-6">
				    <h3>My Details</h3>
				         <form ACTION="integration.php" METHOD="POST" role="form" name="adminlogin">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Name" name="name" value="<?php echo $Name; ?>" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" value="<?php echo $Email; ?>" type="email">
                                </div>
                                
                                <div class="form-group">
                                    <input class="form-control" placeholder="Phone" name="phone" value="<?php echo $phone; ?>" type="text">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Address" name="address" value="<?php echo $address; ?>" type="text">
                                </div>
                                <br/>
                                <div class="form-group">
                                    <h4>UPDATE PASSWORD</h4>
                                    <input class="form-control" placeholder="Password" name="password" value="<?php echo $password; ?>" type="password">
                                     <input class="form-control" name="affiliate_no" value="<?php echo $affialte_no; ?>" type="hidden">
                                </div>
                               
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Update Info">
                                <p/>
                            </fieldset>
                        </form>
                    </div>
                    
                    <!-- /.col-lg-6 -->
				<div class="col-lg-6">
				    <h3>Banking Details</h3>
				         <form ACTION="#" METHOD="POST" role="form" name="adminlogin">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Name" name="name" value="<?php echo $Name; ?>" type="hidden" autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Bank Account</label>
                                    <input class="form-control" placeholder="Bank Account" name="bank_acc" value="<?php echo $bank_acc; ?>" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Branch</label>
                                    <input class="form-control" placeholder="Branch" name="branch" value="<?php echo $branch; ?>" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Bank Account Name</label>
                                    <input class="form-control" placeholder="Bank acc name" name="bank_acc_name" value="<?php echo $bank_acc_name; ?>" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Bank Name</label>
                                    <input class="form-control" placeholder="Bank name" name="bank_name" value="<?php echo $bank_name; ?>" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Ecocash Number</label>
                                    <input class="form-control" placeholder="Ecocash Number" name="ecocash_num" value="<?php echo $ecocash_num; ?>" type="tel">
                                     <input class="form-control" name="affiliate_no" value="<?php echo $affialte_no; ?>" type="hidden">
                                </div>
                               
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Enter">
                                <p/>
                            </fieldset>
                        </form>
                    </div>
	
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
