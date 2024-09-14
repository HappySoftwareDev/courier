<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "partnerform")) {

    $insertSQL = sprintf(
        "INSERT INTO businesspartners (businessName, email, phone, businessLocation, businessType, software_packages, estimateDeliveries, pick_up_address, deliveryTime, PreferedTransport, company_logo, NameOfContact, PersonPhone, password, affiliate_no) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['businessName'], "text"),
        GetSQLValueString($_POST['email'], "text"),
        GetSQLValueString($_POST['phone'], "int"),
        GetSQLValueString($_POST['businesslLocation'], "text"),
        GetSQLValueString($_POST['businessType'], "text"),
        GetSQLValueString($_POST['software_package'], "text"),
        GetSQLValueString($_POST['estDeliver'], "text"),
        GetSQLValueString($_POST['drop_address'], "text"),
        GetSQLValueString($_POST['deliveryTime'], "text"),
        GetSQLValueString($_POST['PreferedType'], "text"),
        GetSQLValueString($_POST['company_logo'], "text"),
        GetSQLValueString($_POST['pick_name'], "text"),
        GetSQLValueString($_POST['drop_phone'], "int"),
        GetSQLValueString($_POST['pass'], "text"),
        GetSQLValueString($_POST['affiliate_no'], "text")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());


    $subject2 = "New Customer Signup";
    $businessName = $_POST['businessName'];
    $affiliate_name = $_POST['affiliate_name'];
    $affiliate_email = $_POST['affiliate_email'];

    $htmlContent2 = '
    <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Merchant Couriers</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">Merchant Couriers</h1>
        <h3>We Deliver With Speed!</h3>
		<p>
	     Hello ' . $affiliate_name . '
	     </p>
	     <p>
	     A new customer ' . $businessName . ' has just sign up using your invite link.
		</p>

       <h3> Click <a href="https://www.merchantcouriers.co.zw/affiliate.user/"><b>View details</b></a> to see more details about this client.</h3>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.co.zw. Alternatively you can call/whatsapp on +263772467352 or +263779495409. <br/>
        PLEASE DO NOT REPLY TO THIS EMAIL.
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
    $headers .= 'Bcc: bamhara1@gmail.com' . "\r\n";

    // Send email
    if (mail($affiliate_email, $subject2, $htmlContent2, $headers)) :
        $successMsg = 'Email has sent successfully.';
    else :
        $errorMsg = 'Email sending fail.';
    endif;
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "partnerform")) {
    $insertSQL = sprintf(
        "INSERT INTO `users`(`Name`, `email`, phone, `password`, affiliate_no) VALUES (%s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['businessName'], "text"),
        GetSQLValueString($_POST['email'], "text"),
        GetSQLValueString($_POST['phone'], "text"),
        GetSQLValueString($_POST['pass'], "text"),
        GetSQLValueString($_POST['affiliate_no'], "text")
    );
    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "partnerform")) {
    $insertSQL = sprintf(
        "INSERT INTO `clients`(`Name`, `email`, `password`, affiliate_no) VALUES (%s, %s, %s, %s)",
        GetSQLValueString($_POST['businessName'], "text"),
        GetSQLValueString($_POST['email'], "text"),
        GetSQLValueString($_POST['pass'], "text"),
        GetSQLValueString($_POST['affiliate_no'], "text")
    );
    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());


    $subject = "Confirmation";
    $email_to = $_POST['email'];

    $htmlContent = '
    <html>
    <head>
        <title>Merchant Couriers</title>
    </head>
    <body>
    <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; text-align:centre;">
        <h1 style="color:#FF8C00">Merchant Couriers</h1>
        <h3>We Deliver With Speed!</h3>
		<p>
	     Welcome to Merchant Couriers thanks for signing up.
		</p>

       <h3> Download our booking app <a href="https://www.merchantcouriers.co.zw/mobile_apps/MerchantCouriersBooking.apk">here</a> to book a delivery at anytime using your phone. </h3>
        <p>You can also book on our website <a href="https://www.merchantcouriers.co.zw/">click here</a></p>

		<footer>
		<div style="background-color:#CCC; padding:10px;">
		<p>
		For any further inquiries please contact us via the contact page on our website www.merchantcouriers.co.zw. Alternatively you can call/whatsapp on +263772467352 or +263779495409. <br/>
        PLEASE DO NOT REPLY TO THIS EMAIL.
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

    // Send email
    if (mail($email_to, $subject, $htmlContent, $headers)) :
        $successMsg = 'Email has sent successfully.';
    else :
        $errorMsg = 'Email sending fail.';
    endif;

    $insertGoTo = "partner.php";
    if ($insertGoTo) {
        echo "<script>alert('Account Created successful!')</script>";
        echo "<script>window.open('signup_aff.php','_self')</script>";
    } else {
        echo "<script>alert('error!')</script>";
    }
}
?>
<?php require("function.php"); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <title>New customer registration for transport services in Zimbabwe| Merchant Couriers</title>
    <meta name="author" content="Merchant Couriers">
    <meta name="keywords" content="register online,book online, transport service, zimbabwe ">
    <meta name="description" content="Visit merchant couriers, to book your transportation service. We have heavy trucks, freigth truks, taxi, tow trucks, parcel deliveries.">

    <meta property="og:title" content="Become a Merchant Couriers driver">
    <meta property="og:image" content="https://www.merchantcouriers.co.zw/images/01.png">
    <meta property="og:description" content="Hey there! You are being invited to try our delivery driver app. If you own a Motorbike, Small cars, Vans, Small trucks, 30t trucks and Box trucks. Go ahead and signup and start earning extra money. Visit our website www.merchantcouriers.co.zw and register your vehicle today.">

    <link re="canonical" href="https://www.merchantcouriers.co.zw/freight.reg.php" />


    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/sl-slide.css">

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
        form#multiphase>#phase2 {
            display: none;
        }
    </style>


    <script>
        var businesslLocation, businessName, email, phone, deliveryTime, businessType, estDeliver, drop_phone, pick_name, pass,
            drop_address, PreferedType;

        function _(x) {
            return document.getElementById(x);
        }

        function showfield(name) {
            if (name == 'Other') document.getElementById('sho_it').innerHTML = 'Other: <input type="text" class="input-block-level" placeholder="Enter Business Type" name="businessType" id="businessType" />';
            else document.getElementById('sho_it').innerHTML = '';
        }

        function showfield2(name) {
            if (name == 'Individual') document.getElementById('sho_ind').innerHTML = 'Individual <input  class="input-block-level" placeholder="Enter Your Full Name" type="text" id="businessName" name="businessName" required>';
            else document.getElementById('sho_ind').innerHTML = '';
            if (name == 'Company') document.getElementById('sho_bus').innerHTML = 'Company <input  class="input-block-level" placeholder="Enter Business Name" type="text" id="businessName" name="businessName" required>';
            else document.getElementById('sho_bus').innerHTML = '';
        }

        function processPhase1() {
            businessName = _("businessName").value;
            businesslLocation = _("businesslLocation").value;
            email = _("email").value;
            phone = _("phone").value;
            estDeliver = _("estDeliver").value;
            businessType = _("businessType").value;
            if (businesslLocation == "" || businessName == "" || email == "" || phone == "" || businessType == "") {
                alert("Please fill in the fields");
            } else {

                _("phase1").style.display = "none";
                _("phase2").style.display = "block";
                _("progressBar").value = 100;
                _("status").innerHTML = "Last Step";
            }
        }

        function processPhase2() {
            drop_address = _("drop_address").value;
            pick_name = _("pick_name").value;
            drop_phone = _("drop_phone").value;
            pass = _("pass").value;
            if (pick_name == "" || drop_phone == "" || pass == "") {
                alert("Please fill in the fields");
            } else {
                _("phase2").style.display = "block";
            }
            _("multiphase").method = "post";
            _("multiphase").action = "signup_aff.php";
            _("multiphase").submit();
        }

        function submitForm() {
            transport = _("transport").value;
            note = _("note").value;
            weight_of_package = _("weight_of_package").value;
            value_of_package = _("value_of_package").value;
            insurance = _("insurance").value;
            package_quantity = _("package_quantity").value;

            if (transport.length > 0 && note.length > 2 && weight_of_package.length > 0 && value_of_package.length > 0 && insurance.length > 0 && package_quantity.length > 0) {
                _("phase3").style.display = "block";

            } else {
                alert("Please fill in the fields");
            }

            _("multiphase").method = "post";
            _("multiphase").action = "submit_parser_aff.php";
            _("multiphase").submit();

        }

        function change_phase1() {
            _("phase1").style.display = "block";
            _("phase2").style.display = "none";
            _("phase3").style.display = "none";
            _("progressBar").value = 0;
        }

        function change_phase2() {
            _("phase1").style.display = "none";
            _("phase2").style.display = "block";
            _("phase3").style.display = "none";
            _("progressBar").value = 100;
        }
    </script>

</head>

<body>

    <!--Header-->
    <header class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a id="logo" class="pull-left" href="index.php"></a>
                <div class="nav-collapse collapse pull-right">
                    <ul class="nav">

                        <li class="active"><a href="index.php">Home</a></li>



                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Book Delivery <i class="icon-angle-down"></i></a>
                            <ul class="dropdown-menu">


                                <li><a href="book/parcel_delivery.php">Parcel Delivery</a></li>
                                <li><a href="book/freight.booking.php">Send Freight</a></li>
                                <li><a href="book/furniture_go.php">Move Furniture</a></li>
                                <li><a href="freight.reg.php">New Customer? Register.</a></li>
                                <li class="divider"></li>
                                <li><a href="privacy.php">Privacy Policy</a></li>
                                <li><a href="terms.php">Terms of Use</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign-UP <i class="icon-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="driver_registration.php">Driver Sign-Up</a></li>
                                <li><a href="freight.reg.php">Customer Sign-Up</a></li>
                                <li class="divider"></li>
                                <li><a href="privacy.php">Privacy Policy</a></li>
                                <li><a href="terms.php">Terms of Use</a></li>
                            </ul>
                        </li>
                        <li class="login"><a href="driver/index.php"><i class="icon-taxi">Driver Login</i></a></li>
                        <li><a href="invite-email.php"><i class="icon-share"></i> Share</a></li>


                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </header>
    <!-- /header -->


    <section class="title">
        <div class="container">
            <div class="row-fluid">
                <div class="span6">
                    <h1>Customer Registration</h1>
                </div>
                <div class="span6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                        <li><a href="#">Pages</a> <span class="divider">/</span></li>
                        <li class="active">Partnership</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- / .title -->


    <section Style="background-color:#193b50" id="recent-works">
        <div class="container">
            <div class="row-fluid">
                <div class="span6">
                    <h2 class="push--bottom">
                        <div class="primary-font"></div>
                        <div>Please fill in the form below.</div>
                    </h2>
                    <p class="lead">Register yourself and gain access to our rich booking services page.</p>
                    <ul class="tabs">
                        <li class="span3">
                        </li>
                    </ul>


                    <div id="image1">
                        <p><img src="images/fb.jpeg" alt="" /></p>
                    </div>
                </div>
                <div class="span6">
                    <?php
                    if (isset($_GET['joinnow'])) {
                        $affiliate_no = $_GET['joinnow'];
                        $get = "SELECT * FROM `affilate_user` WHERE affialte_no='$affiliate_no'";

                        $run = mysqli_query($Connect, $get);

                        while ($row_type = mysqli_fetch_array($run)) {
                            $affialte_no = $row_type['affialte_no'];
                            $affialte_name = $row_type['name'];
                            $affialte_email = $row_type['email'];
                            $phone = $row_type['phone'];
                        }
                    }
                    ?>
                    <form method="POST" action="signup_aff.php" name="partnerform" enctype="multipart/form-data">
                        <div id="phase1">
                            <h2>Enter Your Details!</h2>
                            <label>Individual/Company</label>
                            <select id="businessName" name="businessName" class="input-block-level" onchange="showfield2(this.options[this.selectedIndex].value)" required>
                                <option></option>
                                <option>Individual</option>
                                <option>Company</option>
                            </select>
                            <div id=sho_ind></div>
                            <div id=sho_bus></div>
                            <label>E-mail</label>
                            <input type="email" class="input-block-level" placeholder="Email Address" id="email" name="email" required>
                            <label>Phone Number</label>
                            <input type="tel" class="input-block-level" placeholder="Phone Number" id="phone" name="phone" required>
                            <label>Location</label>
                            <input type="text" class="input-block-level" placeholder="eg Harare Zimbabwe" id="businesslLocation" name="businesslLocation" required>
                            <label>Type of Trade/Business </label>
                            <select name="businessType" id="businessType" class="input-block-level" onchange="showfield(this.options[this.selectedIndex].value)" required>
                                <option></option>
                                <option>Retail Trade</option>
                                <option>Hospitality</option>
                                <option>Wholesale Trade</option>
                                <option>Manufacturing</option>
                                <option>Industrial</option>
                                <option>Farming</option>
                                <option>Mining</option>
                                <option>Other</option>
                            </select>
                            <div id="sho_it"></div>
                            <span style="color:red"></span>

                            <label><br /> </label> <br />
                            <input type="hidden" class="input-block-level" placeholder="Address" id="img_logo" name="company_logo">

                            <label>CREATE YOUR ACCOUNT LOGIN AND PASSWORD </label><br />
                            <label>Name of Contact</label>
                            <input type="text" class="input-block-level" placeholder="Full Name" id="pick_name" name="pick_name" required>
                            <label>Phone Number</label>
                            <input type="tel" class="input-block-level" placeholder="Phone Number" id="drop_phone" name="drop_phone" required>
                            <label>Create a password</label>
                            <input type="password" class="input-block-level" placeholder="Create a password" id="pass" name="pass" required>
                            <input type="hidden" value="<?php echo $affialte_no; ?>" id="affiliate_no" name="affiliate_no">
                            <input type="hidden" value="<?php echo $affialte_name; ?>" id="affiliate_name" name="affiliate_name">
                            <input type="hidden" value="<?php echo $affialte_email; ?>" id="affiliate_email" name="affiliate_email">
                            <br /><br />

                            <div class="g-recaptcha" data-sitekey="6LfKFSoUAAAAAFX_hbTpahwAhZ43IJViUCsB6r7k"></div>
                            <br />

                            <input type="checkbox" class="input-checkbox" required> By ticking the box you declare that you agree to abide by our terms and conditions to use Merchant Couriers Technology and Mobile Apps to send LEGAL FREIGHT shipment requests only.<a href="terms.php" target='_blank'> Terms of Use</a> <br /><br />
                            <button type="submit" class="btn btn-success btn-large btn-block">Create an account</button>
                        </div>
                        <input type="hidden" name="MM_insert" value="partnerform">
                    </form>

                    <p>Already Registered <a href="freight.login.php">Login Here</a></p>
                </div>
            </div>
        </div>
    </section>
    <script>
        // This example displays an address form, using the autocomplete feature
        // of the Google Places API to help users fill in the information.

        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

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
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */
                (document.getElementById('autocomplete')), {
                    types: ['geocode']
                });

            drop_address = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */
                (document.getElementById('drop_address')), {
                    types: ['geocode']
                });

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);
        }


        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();
            var place = drop_address.getPlace();

            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

            // Get each component of the address from the place details
            // and fill the corresponding field on the form.
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
        }

        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
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
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChENbCfj7LOv-pCCTUwwlHlmSAeY64B8I&libraries=places&callback=initAutocomplete" async defer></script>
    <!-- /#registration-page -->

    <!--Bottom-->
    <section id="bottom" class="main">
        <!--Container-->
        <div class="container">

            <!--row-fluids-->
            <div class="row-fluid">

                <!--Contact Form-->
                <div class="span3">
                    <h4>ADDRESS</h4>
                    <ul class="unstyled address">
                        <li>
                            <i class="icon-home"></i><strong>Address:</strong> Harare <br>Zimbabwe
                        </li>
                        <li>
                            <i class="icon-envelope"></i>
                            <strong>Email: </strong> merchantcouriers1@gmail.com
                        </li>
                        <li>
                            <i class="icon-globe"></i>
                            <strong>Website:</strong> www.merchantcouriers.co.zw
                        </li>
                        <li>
                            <i class="icon-phone"></i>
                            <strong>Mobile No:</strong> +263779495409
                        </li>
                    </ul>
                </div>
                <!--End Contact Form-->

                <!--Important Links-->
                <div id="tweets" class="span3">
                    <h4>OUR COMPANY</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="index.php">About Us</a></li>
                            <li><a href="contact-us.php">Support</a></li>
                            <li><a href="terms.php">Terms of Use</a></li>
                            <li><a href="privacy.php">Privacy Policy</a></li>
                            <li><a href="terms.php">Copyright</a></li>
                    </div>
                </div>
                <!--Important Links-->

                <!--Archives-->
                <div id="archives" class="span3">
                    <h4>SERVICES LOCATIONS</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="#">Harare, Zimbabwe</a></li>
                        </ul>
                    </div>
                </div>
                <!--End Archives-->

                <!--Important Links-->
                <div id="tweets" class="span3">
                    <h4>Other Pages</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="blog.php">News & Updates</a></li>
                            <li><a href="driver_registration.php">We're Hiring</a></li>
                        </ul>
                    </div>
                </div>
                <!--Important Links-->
    </section>
    <!--/bottom-->

    <!--Footer-->
    <footer id="footer">
        <div class="container">
            <div class="row-fluid">
                <div class="span5 cp">
                    &copy; 2017 <a target="_blank" href="http://merchantcouriers.co.zw/">Merchant Couriers</a>. All Rights Reserved.
                </div>
                <!--/Copyright-->

                <div class="span6">
                    <ul class="social pull-right">
                        <li><a href="http://www.facebook.com/sharer.php?u=https://merchantcouriers.co.zw" target="_blank"><i class="icon-facebook"></i></a></li>
                        <li><a href="https://twitter.com/share?url=https://merchantcouriers.co.zw&amp;text=merchant%20couriers&amp;hashtags=merchantcouriers" target="_blank"><i class="icon-twitter"></i></a></li>
                        <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=https://merchantcouriers.co.zw" target="_blank"><i class="icon-linkedin"></i></a></li>
                        <li><a href="https://plus.google.com/share?url=https://merchantcouriers.co.zw" target="_blank"><i class="icon-google-plus"></i></a></li>
                        <li><a href="#"><i class="icon-instagram"></i></a></li>
                        <li><a href="whatsapp://send?abid=username&text=HeyThere!"><img src="images/whatsapp.png" width="28px" alt="" /></a></li>
                    </ul>
                </div>

                <div class="span1">
                    <a id="gototop" class="gototop pull-right" href="#"><i class="icon-angle-up"></i></a>
                </div>
                <!--/Goto Top-->
            </div>
        </div>
    </footer>
    <!--/Footer-->

    <!--  Login form -->
    <div class="modal hide fade in" id="loginForm" aria-hidden="false">
        <div class="modal-header">
            <i class="icon-remove" data-dismiss="modal" aria-hidden="true"></i>
            <h4>Login Form</h4>
        </div>
        <!--Modal Body-->
        <div class="modal-body">
            <form class="form-inline" action="<?php echo $loginFormAction; ?>" method="POST" id="form-login">
                <input type="text" class="input-small" name="email" placeholder="Email">
                <input type="password" class="input-small" name="password" placeholder="Password">
                <label class="checkbox">
                    <input type="checkbox"> Remember me
                </label>
                <button type="submit" class="btn btn-primary">Sign in</button>
            </form>
            <a href="#">Forgot your password?</a>
            <p>Don't have an account? <a href="registration.php">register</a> </p>
        </div>
        <!--/Modal Body-->
    </div>
    <!--  /Login form -->

    <script src="js/vendor/jquery-1.9.1.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
