<?php require ("login-securityaffiliate.php"); ?>

<?php
if (isset($_POST['email'])) {
  $email=$_POST['email'];
  $affiliate_no=$_POST['affiliate_no'];
  $type="email";
  $subject2 = "Join Merchant Couriers";
  $link = $_POST['link'];
 
 $insertSQL = "INSERT INTO `affilate_invites`(`type`, `affiliate_no`) VALUES ('$type', '$affiliate_no')";

  $Result1 = mysqli_query($Connect, $insertSQL);

	$htmlContent2 = '
    <html>
    <head>
        <title>Merchant Couriers</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">Merchant Couriers</h1>
        <h3>We Deliver With Speed!</h3>
		<p>
	     Hello 
	     </p>
	     <p>
	     Plan to ship your parcels, freight or move furniture the easy way? Try Merchant Couriers. Whether you are busy at work, can`t leave home or you`re out of town. Just book and we`l pick it up and deliver it for you! That`s why with our new, fast and convenient app, you can now book and have your delivery done at a good price. New clients are invited to signup for free and send your first delivery; Plus you`re Awarded a 10% Discount on your first delivery.
		</p>
        
       <h3> Click <a href="'.$link.'"><b>Join Now</b></a> to register.</h3>
         
		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.co.zw. Alternatively you can call/whatsapp on +263772467352 or +263779495409.
       </p>
		
		<h4 style="color:#FF8C00">Merchant Couriers</h4>
		<p>We Deliver With Speed.</p>
		</div>
		</footer>
		</div>
    </body>
    </html>';
	
	// Set content-type header for sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// Additional headers
$headers .= 'From: Merchant Couriers<registrations@merchantcouriers.co.zw>' . "\r\n";
$headers .= 'Bcc:'. $email ."\r\n";

// Send email
if(mail(null,$subject2,$htmlContent2,$headers)):
    $successMsg = 'Email has sent successfully.';
else:
    $errorMsg = 'Email sending fail.';
endif;
  
   $insertGoTo = "login.php";
  if($insertGoTo){
        echo "<script>alert('Invitation sent!')</script>";
		 echo "<script>window.open('index.php','_self')</script>";
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

    <title>Merchant Couriers - Admin Area</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">
    
    <!-- Social Buttons CSS -->
    <link href="../vendor/bootstrap-social/bootstrap-social.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
    function fb() {
    document.getElementById("multiphase").method = "post";
	document.getElementById("multiphase").action = "fb_sub.php";
	document.getElementById("multiphase").submit();
    return false;
    }
    function google() {
    document.getElementById("multiphase").method = "post";
	document.getElementById("multiphase").action = "google_sub.php";
	document.getElementById("multiphase").submit();
    return false;
    }
    function ln() {
    document.getElementById("multiphase").method = "post";
	document.getElementById("multiphase").action = "ln_sub.php";
	document.getElementById("multiphase").submit();
    return false;
    }
    function wt() {
    document.getElementById("multiphase").method = "post";
	document.getElementById("multiphase").action = "wt_sub.php";
	document.getElementById("multiphase").submit();
    return false;
    }
    function tw() {
    document.getElementById("multiphase").method = "post";
	document.getElementById("multiphase").action = "tw_sub.php";
	document.getElementById("multiphase").submit();
    return false;
    }
    function sms() {
    document.getElementById("multiphase").method = "post";
	document.getElementById("multiphase").action = "sms_sub.php";
	document.getElementById("multiphase").submit();
    return false;
    }
    function email_s() {
    document.getElementById("multiphase").method = "post";
	document.getElementById("multiphase").action = "email_sub.php";
	document.getElementById("multiphase").submit();
    return false;
    }
    </script>

</head>

<body>
 <?php
    $user = $_SESSION['affilate_Username'];
	 
	 $get = "SELECT * FROM `affilate_user` WHERE email='$user'";
	 
	 $run = mysqli_query($Connect,$get);
	 
	 while ($row_type = mysqli_fetch_array($run)){
		 $ID = $row_type['id'];
		 $Name = $row_type['name'];
		 $Email = $row_type['email'];
		 $phone = $row_type['phone'];
		 $affialte_no = $row_type['affialte_no'];
		 $balance = $row_type['balance'];
		 
		 if($balance >= 10){
		     $sho="<a href='payments.php' class='btn btn-default btn-sm' style='color: #FF8C00'>Payments</a>";
		 }else {
		    $sho="<button tabindex='0' class='btn btn-default btn-sm' style='color: #FF8C00' data-toggle='popover' data-trigger='focus' data-placement='bottom' title='Balance too low!' data-content='You cannot request payment when your balance is less than $10'>Payments</button>";
		 }
	
	 }
    ?>
    
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
                <a class="navbar-brand" href="index.php"><img src="../../images/logo.png" width="180px" height="40px" alt=" Logo" /></a>
                <span class="navbar-brand">Welcome <?php getUsername(); ?></span>
            </div>
            <!-- /.navbar-header -->
           
            <ul class="nav navbar-top-links navbar-right">
            <?php echo $sho; ?>
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
                        <li><a href="integration.php"><i class="fa fa-user fa-fw"></i> <?php getUsername(); ?></a>
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
                            <a href='index.php'><i class='fa fa-dashboard fa-fw'></i> Dashboard</a>
                        </li>
						<li>
                            <a href='users.php'><i class='fa fa-users fa-fw'></i> Users</a>
                        </li>
					
						<li>
                            <a href='integration.php'><i class='fa fa-gear fa-fw'></i> Integration</a>
                        </li>
                        <li>
                            <a href='help.php'><i class='glyphicon glyphicon-question-sign fa-fw'></i> Help</a>
                        </li>
                       
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Affiliate Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
                
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-usd fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php getCountTotalSales(); ?></div>
                                    <div>Commissions</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Total Earned</span>
                                <span class="pull-right"><i class="fa fa-usd"></i><?php getCountTotalEarned(); ?></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user-plus fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php  getCountCustomers(); ?></div>
                                    <div>Registered Customers</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cubes fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php  getCountNewOrders(); ?></div>
                                    <div>Total Orders</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                 <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-share-square-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php  getCountSharedAd(); ?></div>
                                    <div>Total Adverts Shared</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Order List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                   <th>ID</th>
                                                    <th>Date</th>
                                                    <th>Type</th>
                                                    <th>Name</th>
													<th>Invoice</th>
													<th>Status</th>
													
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php getBookings(); ?>
                                            </tbody>
                                        </table>
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
                </div>
                
                
                </div>
				
               
                
                 <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-envelope fa-fw"></i> Send Invitations here.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <form ACTION="<?php echo $editFormAction; ?>" METHOD="POST" role="form" id="multiphase" name="addDriver">
                            <fieldset>
                                <div class="form-group">
								<div class="form-group">
								 <p><a href="<?php getLink(); ?>"><?php getLink(); ?></a></p>
								 <label>Enter Email</label>
                                  <input class="form-control" name="email" placeholder="name@domain.com"  type="text" >
                                  <input class="form-control" name="link" value="<?php getLink_em(); ?>"  type="hidden" >
                                  <input class="form-control" name="affiliate_no" id="affiliate_no" value="<?php echo $affialte_no; ?>"  type="hidden" >
                                </div>
								
								<input type="hidden" name="ID" value="<?php echo $ID; ?>">
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Send Invitation">
                            </fieldset>
                            <input type="hidden" name="MM_insert" value="addDriver">
                            <input type="hidden" name="MM_update" value="addDriver">
                            
                        </form>
                        </div>
                        <!-- /.panel-body -->
                        
            
            <div class="text-center">  
            <a href="http://www.facebook.com/sharer.php?u=<?php getLink(); ?>" target="_blank" class="btn btn-social-icon btn-facebook" onclick="fb()" ><i class="fa fa-facebook"></i></a>
            <a href="https://plus.google.com/share?url=<?php getLink(); ?>" target="_blank" class="btn btn-social-icon btn-google-plus" onClick="google()"><i class="fa fa-google-plus"></i></a>
            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php getLink(); ?>" target="_blank" class="btn btn-social-icon btn-linkedin" onClick="ln()"><i class="fa fa-linkedin"></i></a>
            <a href="whatsapp://send?abid=&text=Plan to ship your parcels, freight or move furniture the easy way? Try Merchant Couriers. Whether you are busy at work, can't leave home or you're out of town. Just book and we'l pick it up and deliver it for you! That's why with our new, fast and convenient app, you can now book and have your delivery done at a good price. New clients are invited to signup for free and send your first delivery; Plus you're Awarded a 10% Discount on your first delivery. Visit <?php getLink();?> We Deliver With Speed!" class="btn btn-social-icon panel-green" onClick="wt()"><i class="fa fa-whatsapp"></i></a>
            <a onClick="tw()" href="https://twitter.com/share?url=<?php getLink(); ?>&amp;text=Plan%20to%20ship%20your%20parcels,%20freight%20or%20move%20furniture%20the%20easy%20way?%20Try%20Merchant%20Couriers.%20Whether%20you%20are%20busy%20at%20work,%20can't%20leave%20home%20or%20you're%20out%20of%20town.%20Just%20book%20and%20we'l%20pick%20it%20up%20and%20deliver%20it%20for%20you!%20That's%20why%20with%20our%20new,%20fast%20and%20convenient%20app,%20you%20can%20now%20book%20and%20have%20your%20delivery%20done%20at%20a%20good%20price.%20New%20clients%20are%20invited%20to%20signup%20for%20free%20and%20send%20your%20first%20delivery.%20Visit%20<?php getLink();?>;%20Plus%20you're%20Awarded%20a%20ten%20percent%20Discount%20on%20your%20first%20delivery.%20We%20Deliver%20With%20Speed.!&amp;hashtags=MerchantCouriers" target="_blank" class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
            <a onClick="sms()" href="sms:?body=Plan to ship your parcels, freight or move furniture the easy way? Try Merchant Couriers. Whether you are busy at work, can't leave home or you're out of town. Just book and we'l pick it up and deliver it for you! That's why with our new, fast and convenient app, you can now book and have your delivery done at a good price. New clients are invited to signup for free and send your first delivery; Plus you're Awarded a 10% Discount on your first delivery. Visit <?php getLink();?> We Deliver With Speed!" target="_blank" class="btn btn-social-icon btn-vk" title="Share by SMS"><i class="fa fa-comments"></i></a>
            <a onClick="email_s()" href="mailto:?subject=Deliver with Merchant Couriers&amp;body=Plan to ship your parcels, freight or move furniture the easy way? Try Merchant Couriers. Whether you are busy at work, can't leave home or you're out of town. Just book and we'l pick it up and deliver it for you! That's why with our new, fast and convenient app, you can now book and have your delivery done at a good price. New clients are invited to signup for free and send your first delivery; Plus you're Awarded a 10% Discount on your first delivery. Visit <?php getLink();?> We Deliver With Speed!
            
            	For any further inquiries please call/whatsapp on +263772467352 or +263775972428.
            "
                title="Share by Email" class="btn btn-social-icon btn-instagram"><i class="fa fa-envelope"></i>
            </a>
            <p/>
            </div>
            </div>	
            </div>
            </div>
            <!-- /.row -->
        <div class="row">
        <div class="col-lg-6">
       <p> <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fmerchantcouriers%2Fposts%2F360542281153865%3A0&width=500" width="500" height="593" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe></p>
       </div>
        <div class="col-lg-6">
        <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fmerchantcouriers%2Fposts%2F364453117429448%3A0&width=500" width="500" height="420" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
        </div>
        </div>
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

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
     <script>
    // tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })
    // popover demo
    $("[data-toggle=popover]")
        .popover()
    </script>
</body>

</html>
