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
    <title>Services | Merchant Couriers</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/bootstrap.min.css">
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
    <style>
        #map {
            height: 560px;
        }

        #floating-panel {
            position: absolute;
            top: 70px;
            left: 450px;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto', 'sans-serif';
            line-height: 10px;
            padding-left: 15px;
        }

        #addDpanel {
            position: absolute;
            top: 110px;
            left: 1123px;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto', 'sans-serif';
            line-height: 20px;
            padding-left: 15px;
        }

        #detailz {
            position: absolute;
            top: 500px;
            left: 0px;
            Width: 100%;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #FFF;
            text-align: left;
            float: right;
            font-family: 'Roboto', 'sans-serif';
            line-height: 20px;
            padding-left: 15px;
        }

        #az {
            float: left;
        }
    </style>
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Book Delivery<i class="icon-angle-down"></i></a>
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign-Up <i class="icon-angle-down"></i></a>
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
                    <h1>map</h1>
                </div>
                <div class="span6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                        <li class="active">Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- / .title -->


    <section Style="background-color:#193b50" id="services">
        <div class="container">
            <div class="span4">
                <b>Start: </b>
                <select id="start" class="form-control">
                    <?php
                    $user = $_SESSION['MM_Username'];
                    $get = "SELECT * FROM `bookings`  where status = '$user'";

                    $run = mysqli_query($Connect, $get);

                    while ($row_type = mysqli_fetch_array($run)) {
                        $address = $row_type['pick_up_address'];
                        $ID = $row_type['order_id'];

                        echo "<option value='$address'>$address</option>";
                    }

                    ?>
                </select>
            </div>
            <div class="span4">
                <b>End: </b>
                <select id="end" class="form-control">
                    <option></option>
                    <?php
                    $user = $_SESSION['MM_Username'];
                    $get = "SELECT * FROM `bookings` where status = '$user'";

                    $run = mysqli_query($Connect, $get);

                    while ($row_type = mysqli_fetch_array($run)) {
                        $drop_address = $row_type['drop_address'];
                        $ID = $row_type['order_id'];

                        echo "<option value='$drop_address'>$drop_address</option>";
                    }

                    ?>
                </select>


            </div>
        </div>
        </div>

        <div class="row">

        </div>
        <!--/.row-->


        <div class="row">

        </div>

        <div class="panel-group m-bot20" id="accordion">


        </div>


        <div class="row-fluid">
            <div class="span12">

                <div id="map"></div>



            </div>
        </div>

        <script>
            var service;
            var map;

            function initialise(location) {
                console.log(location);
                var currentLocation = new google.maps.LatLng(location.coords.latitude, location.coords.longitude);
                var directionsService = new google.maps.DirectionsService;
                var directionsDisplay = new google.maps.DirectionsRenderer;
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12,
                    center: currentLocation,
                });

                directionsDisplay.setMap(map);

                var beachMarker = new google.maps.Marker({
                    position: currentLocation,
                    map: map,
                });

                google.maps.event.addListenerOnce(map, 'bounds_changed', performSearch);

                $('#refresh').click(performSearch);

                var onChangeHandler = function() {
                    calculateAndDisplayRoute(directionsService, directionsDisplay);
                };
                document.getElementById('start').addEventListener('change', onChangeHandler);
                document.getElementById('end').addEventListener('change', onChangeHandler);
            }
            navigator.geolocation.getCurrentPosition(initialise);

            function handleSearchResults(results, status) {
                console.log(results);
                for (var i = 0; i < results.length; i++) {

                    var marker = new google.maps.Marker({
                        position: results[i].geometry.location,
                        map: map,
                    });
                }
            }

            function performSearch() {
                var request = {
                    bounds: map.getBounds(),
                    name: "schools"
                }
                service.nearbySearch(request, handleSearchResults);
            }

            service = new google.maps.places.PlacesService(map);

            function calculateAndDisplayRoute(directionsService, directionsDisplay) {
                directionsService.route({
                    origin: document.getElementById('start').value,
                    destination: document.getElementById('end').value,
                    travelMode: 'DRIVING'
                }, function(response, status) {
                    if (status === 'OK') {
                        directionsDisplay.setDirections(response);
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                });
            }
        </script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAASD--ei5pvGlTxWLBswb4z4q_4J2vQS4&libraries=places&callback=initMap"></script>



        <script src="https://www.gstatic.com/firebasejs/4.1.2/firebase.js"></script>
        <script>
            // Initialize Firebase
            var config = {
                apiKey: "AIzaSyCHyMgct5EYcxtr8DpVgeICWEHsaz0y6r8",
                authDomain: "mre-localhost-1494982496654.firebaseapp.com",
                databaseURL: "https://mre-localhost-1494982496654.firebaseio.com",
                projectId: "mre-localhost-1494982496654",
                storageBucket: "mre-localhost-1494982496654.appspot.com",
                messagingSenderId: "560569853708"
            };
            firebase.initializeApp(config);
        </script>
        </div>
    </section>

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
                            <li><a href="#">Terms of Use</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Copyright</a></li>
                            <li><a href="#">We are hiring</a></li>
                            <li><a href="#">News & Updates</a></li>
                        </ul>
                    </div>
                </div>
                <!--Important Links-->

                <!--Archives-->
                <div id="archives" class="span3">
                    <h4>SERVICED LOCATIONS</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="#">Harare, Zimbabwe</a></li>
                        </ul>
                    </div>
                </div>
                <!--End Archives-->

    </section>
    <!--/bottom-->

    <!--Footer-->
    <footer id="footer">
        <div class="container">
            <div class="row-fluid">
                <div class="span5 cp">
                    &copy; 2017 <a target="_blank" href="http://merchantcouriers.co.zw/" title="Free Twitter Bootstrap WordPress Themes and HTML templates">Merchant Couriers</a>. All Rights Reserved.
                </div>
                <!--/Copyright-->

                <div class="span6">
                    <ul class="social pull-right">
                        <li><a href="#"><i class="icon-facebook"></i></a></li>
                        <li><a href="#"><i class="icon-twitter"></i></a></li>
                        <li><a href="#"><i class="icon-linkedin"></i></a></li>
                        <li><a href="#"><i class="icon-google-plus"></i></a></li>
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
