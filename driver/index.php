<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width" />
    <!-- This is a wide open CSP declaration. To lock this down for production, see below. -->
    <!--<meta http-equiv="Content-Security-Policy" content="default-src * 'unsafe-inline'; style-src 'self' 'unsafe-inline'; media-src *" />-->
    
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fontawesome.css">
	<script type="text/javascript" src="validation.min.js"></script>
	<script type="text/javascript" src="index.js"></script>
	<link href="style.css" rel="stylesheet" media="screen">
	<script type="text/javascript" src="jquery-3.1.1.min.js" charset="UTF-8"></script>
    <title>Merchant Couriers -Driver</title>
    <style>
    body {font-family: Arial, Helvetica, sans-serif;}
    .form {padding-top: 80px;}
    
    input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }
    
    button {
        background-color: #193b50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }
    
    button:hover {
        opacity: 0.8;
    }
    
    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #ff8C00;
    }
    
    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }
    
    img.avatar {
        width: 50%;
    }
    
    .container {
        padding: 10px;
    }
    
    span.psw {
        float: right;
        padding-top: 16px;
    }
    
    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
        span.psw {
           display: block;
           float: none;
        }
        .cancelbtn {
           width: 100%;
        }
        .container {
        padding: 0px;
    }
    }
    </style>
    </head>
    
    <body>
        <div class="container">
    <form class="form">
      <div class="imgcontainer">
        <img src="../images/logo.png" alt="Avatar">
      </div>
      <div id="error"></div>
      <div class="container">
        <label for="uname"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="uname" id="uname" required>
    
        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
            
        <button type="submit" id="btn-login">Login</button>
        <label>
          <input type="checkbox" checked="checked" name="remember"> Remember me
        </label>
      </div>
    
      <div class="container" style="background-color:#f1f1f1">
        <a href="../driver_registration.php"><button type="button" class="cancelbtn">SignUp</button></a>
        <span class="psw">Forgot <a href="#">password?</a></span>
      </div>
       <center>
                <h3 class="form-title ">
                    <center>Invite Friends</center>
                </h3>
                <a href="invite-email.php" class="btn btn-small btn-default"><i class="fa fa-envelope"></i></a>
                <a href="invite-sms.php" class="btn btn-small btn-default"><i class="fa fa-comments"></i> </a>
                <a href="http://www.facebook.com/sharer.php?u=https://www.merchantcouriers.co.zw/driver_registration.php" class="btn btn-default btn-small">
				<i class="fa fa-facebook"></i></a>
				
                <a href="whatsapp://send?abid=&text=Hey there! You are being invited to try our delivery driver app.
				If you own a Motorbike, Small cars, Vans, Small trucks, 30t trucks and Box trucks. Go ahead and signup
				and start earning extra money. Visit our website www.merchantcouriers.co.zw and register your vehicle today." class="btn btn-default btn-small">
				<i class="fa fa-whatsapp"><img src="../images/whatsapp.png" width="15px" alt="" /></i></a>
            </center>
    </form>
        </div>
    	
    <script>
    $('document').ready(function(){
    $("body").delegate("#btn-login","click",function(event){
    event.preventDefault();
     var uname = $("#uname").val();
     var password = $("#psw").val();
     var data = "uname="+uname+"&password="+password;
     if( $.trim(uname).length == 0 || $.trim(password).length==0)
        {
    	$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; All fields must be completed!</div>');
         $("#error").fadeOut(5000);
         exit(); 
    	 }
        $.ajax({
        
        type : 'POST',
        url  : 'login_act.php',
        data : data,
        beforeSend: function()
        { 
    	
         $("#error").fadeOut();
         $("#btn-login").html('processing ...');
        },
        success :  function(data)
             {      
             if(data=="ok")
            {
             window.location='new_orders.php';
            }
    		 else if(data=="Invalid password"){
             $("#error").fadeIn(1000, function(){
               $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;Sorry wrong password please try again</div>');
               });
    		 }
            else{
             $("#error").fadeIn(1000, function(){
             $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');
             });
            }
        }
        
    	});
    })
    });
    	</script>
    	
        <script type="text/javascript" src="js/index.js"></script>
        <script type="text/javascript">
            app.initialize();
        </script>
    </body>
    
    </html>
