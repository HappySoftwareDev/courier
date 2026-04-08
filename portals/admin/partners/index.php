<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Partnership | Merchant Couriers</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

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

        function processPhase1() {
            businessName = _("businessName").value;
            businesslLocation = _("businesslLocation").value;
            email = _("email").value;
            phone = _("phone").value;
            estDeliver = _("estDeliver").value;
            businessType = _("businessType").value;
            if (businesslLocation == "" || businessName == "" || email == "" || phone == "" || estDeliver == "" || businessType == "") {
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
            PreferedType = _("PreferedType").value;
            devliveryTime = _("deliveryTime").value;
            if (drop_address == "" || pick_name == "" || drop_phone == "" || pass == "" || PreferedType == "" || deliveryTime == "") {
                alert("Please fill in the fields");
            } else {
                _("phase2").style.display = "block";
            }
            _("multiphase").method = "post";
            _("multiphase").action = "submit_parser.php";
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
            _("multiphase").action = "submit_parser.php";
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


                                <li><a href="booking.php">Parcel Delivery</a></li>
                                <li><a href="freight.booking.php">Send Freight</a></li>
                                <li><a href="furniture_go.php">Move Furniture</a></li>
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
                    <h1>Partner With Us</h1>
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
                        <div>Lets Do Business Together</div>
                    </h2>
                    <p class="lead">You can deliver all your parcels and goods with us.</p>
                    <ul class="tabs">
                        <li class="span3">
                            <a onclick="img1()"><span id="activ1">Please Fill This Form</span></a>
                        </li>

                    </ul>
                    <br /><br />
                    <div id="txt1">
                        <ul class="driving-req">
                            <li>Business Name</li>
                            <li>Type of Business</li>
                            <li>Deliveries Per Week (Estimate)</li>
                            <li>Proof of Company Registration (Upon meeting)</li>
                            <li>Website If Any</li>

                        </ul>
                    </div>

                    <p class="legal">*Standard across all Zimbabwe cities</p>

                    <div id="image1">
                        <p><img src="images/bsn2.png" width="100%" alt="" /></p>
                    </div>
                </div>
                <div class="span6">
                    <h3 id="status">Step 1 of 2...</h3>
                    <form method="POST" action="<?php echo $editFormAction; ?>" id="multiphase" onsubmit="return false" name="partnerform">
                        <div id="phase1">
                            <h2>Enter Your Business Details!</h2>
                            <input class="input-block-level" placeholder="Business Name" type="text" id="businessName" name="businessName" required>
                            <input type="email" class="input-block-level" placeholder="email address" id="email" name="email" required>
                            <input type="tel" class="input-block-level" placeholder="Phone Number" id="phone" name="phone" required>
                            <input type="text" class="input-block-level" placeholder="City" id="businesslLocation" name="businesslLocation" required>
                            <select name="businessType" id="businessType" class="input-block-level" required>
                                <option>Business Type</option>
                                <option>Retail & Shopping</option>
                                <option>Restaurent & Takeaway</option>
                                <option>Wholesale Trade</option>
                                <option>Manufacturing</option>
                                <option>Industrial</option>
                                <option>Other</option>
                            </select>
                            <span style="color:red"></span>
                            <select name="estDeliver" id="estDeliver" class="input-block-level" required>
                                <option>Estimated Weekly Deliveries</option>
                                <option>1-10</option>
                                <option>11-50</option>
                                <option>51-100</option>
                                <option>more..</option>
                            </select>

                            <button class="btn btn-success btn-large btn-block" onclick="processPhase1()">Next Step</button>

                        </div>

                        <div id="phase2">
                            <h2> Enter Pickup Details</h2>
                            <input type="text" class="input-block-level" placeholder="Address" id="drop_address" name="drop_address" required>
                            <select name="deliveryTime" id="deliveryTime" class="input-block-level" required>
                                <option> Delivery Time</option>
                                <option>Day</option>
                                <option>Night</option>
                                <option>Day & Night</option>
                            </select>
                            <select name="PreferedType" id="PreferedType" class="input-block-level" required>
                                <option>Prefered Type Of Vehicle</option>
                                <option>Car</option>
                                <option>Motor bike</option>
                                <option>Any..</option>
                            </select>
                            Name of Contact
                            <input type="text" class="input-block-level" placeholder="Full Name" id="pick_name" name="pick_name" required>
                            <input type="tel" class="input-block-level" placeholder="Phone Number" id="drop_phone" name="drop_phone" required>
                            <input type="password" class="input-block-level" placeholder="Create a password" id="pass" name="pass" required>

                            <div class="g-recaptcha" data-sitekey="6LfKFSoUAAAAAFX_hbTpahwAhZ43IJViUCsB6r7k"></div>
                            <button class="btn btn-success btn-large btn-block" onclick="processPhase2()">Create an account</button>
                        </div>
                        <input type="hidden" name="MM_insert" value="partnerform">
                    </form>


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
                            <strong>Email: </strong> admin@merchantcouriers.co.zw
                        </li>
                        <li>
                            <i class="icon-globe"></i>
                            <strong>Website:</strong> www.merchantcouriers.co.zw
                        </li>
                        <li>
                            <i class="icon-phone"></i>
                            <strong>Mobile No:</strong> +263772467352
                        </li>
                    </ul>
                </div>
                <!--End Contact Form-->

                <!--Important Links-->
                <div id="tweets" class="span3">
                    <h4>OUR COMPANY</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="about-us.php">About Us</a></li>
                            <li><a href="#">Support</a></li>
                            <li><a href="terms.php">Terms of Use</a></li>
                            <li><a href="privacy.php">Privacy Policy</a></li>
                            <li><a href="#">Copyright</a></li>
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
                            <li><a href="about-us.php">News & Updates</a></li>
                            <li><a href="#">We're Hiring</a></li>
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


