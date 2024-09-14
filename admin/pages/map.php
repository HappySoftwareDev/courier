<?php require ("login-security.php"); ?>

<?php require("function.php"); ?>

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

    <style>
        #map {
            height: 570px;
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
            top: 590px;
            left: 450px;
            Width: 600px;
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
    <script src="https://ajax.googleapis.com/libs/jquery/2.0.0/jquery.min.js"></script>
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
                <a class="navbar-brand" href="index.php">Merchant Couriers</a>
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
                            <a class="text-center" href="message.php">
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
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">

                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
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
                            <a href="invite.php"><i class="fa fa-users fa-fw"></i> Invite</a>
                        </li>
                        <li>
                            <a href="driver.php"><i class="fa fa-car fa-fw"></i> Drivers</a>
                        </li>
                        <li>
                            <a href="map.php"><i class="fa fa-map-marker fa-fw"></i> Map</a>
                        </li>
                        <li>
                            <a href="integration.php"><i class="fa fa-gear fa-fw"></i> Integration</a>
                        </li>
                        <li>
                            <a href="blog.php"><i class="fa fa-list fa-fw"></i> Blog</a>
                        </li>
                        <li>
                            <a href="affiliate.php"><i class="fa fa-bullhorn fa-fw"></i> Affiliate</a>
                        </li>
                        <li class="">
                            <a href="coupons.php"><i class="fa fa-gear fa-fw"></i> coupons</a>
                        </li>
                        <li class="">
                            <a href="usercoupon.php"><i class="fa fa-gear fa-fw"></i> All Users coupons</a>
                        </li>
                        <li class="">
                            <a href="commoncoupon.php"><i class="fa fa-gear fa-fw"></i> Common coupons</a>
                        </li>
                        <li>
                            <a href="affiliate.msg.php"><i class="glyphicon glyphicon-question-sign fa-fw"></i> Affiliate Help</a>
                        </li>
                        <li>
                            <a href="customer_alerts.php"><i class="fa fa-bell fa-fw"></i> Send Alerts</a>
                        </li>
                        <li>
                            <a href="api.php"><i class="fa fa-gear fa-fw"></i> API keys</a>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row"><br />
                    <div class="col-lg-15">
                        <div class="col-lg-15">
                            <div id="addDpanel">
                                <h5>No drivers are online ...</h5>

                                <button type="button" id="refresh" class="btn btn-outline btn-primary">ADD DRIVERS</button>

                                <a href="http://localhost/pages/map.php?driver=1">Other</a>
                            </div>
                            <div id="floating-panel">
                                <b>SELECT DRIVERS: </b>
                                <select id="start">
                                    <?php
                                    $get = "SELECT * FROM `markers`";

                                    $run = mysqli_query($Connect, $get);

                                    while ($row_type = mysqli_fetch_array($run)) {
                                        $ID = $row_type['id'];
                                        $Name = $row_type['name'];

                                        echo "<option value='$ID'><a href='map.php?driver=$ID' >$Name</a></option>";
                                    }

                                    ?>
                                </select>


                            </div>
                            <div id="detailz">
                                <span class="col-lg-2" style="text-align:center;">
                                    <h5>Delivered </h5>
                                    <h5> 0 </h5>
                                </span>

                                <span class="col-lg-2" style="text-align:center;">
                                    <h5> Canceled </h5>
                                    <h5> 0 </h5>
                                </span>

                                <span class="col-lg-2" style="text-align:center;">
                                    <h5> Late </h5>
                                    <h5> 0 </h5>
                                </span>

                                <span class="col-lg-3" style="text-align:center;">
                                    <h5> Orders </h5>
                                    <h5> 0 </h5>
                                </span>

                                <span class="col-lg-3" style="text-align:center;">
                                    <h5> Drivers Online </h5>
                                    <h5> 0 </h5>
                                </span>

                            </div>


                            <div id="map"></div>

                            <script>
                                var customLabel = {
                                    restaurant: {
                                        label: 'R'
                                    },
                                    bar: {
                                        label: 'B'
                                    }
                                };

                                function initMap() {
                                    var map = new google.maps.Map(document.getElementById('map'), {
                                        center: new google.maps.LatLng(-17.8251657, 31.03351),
                                        zoom: 12
                                    });
                                    var infoWindow = new google.maps.InfoWindow;

                                    // Change this depending on the name of your PHP or XML file
                                    downloadUrl('maps_xml.php', function(data) {
                                        var xml = data.responseXML;
                                        var markers = xml.documentElement.getElementsByTagName('marker');
                                        Array.prototype.forEach.call(markers, function(markerElem) {
                                            var id = markerElem.getAttribute('id');
                                            var name = markerElem.getAttribute('name');
                                            var address = markerElem.getAttribute('address');
                                            var type = markerElem.getAttribute('type');
                                            var point = new google.maps.LatLng(
                                                parseFloat(markerElem.getAttribute('lat')),
                                                parseFloat(markerElem.getAttribute('lng')));

                                            var infowincontent = document.createElement('div');
                                            var strong = document.createElement('strong');
                                            strong.textContent = name
                                            infowincontent.appendChild(strong);
                                            infowincontent.appendChild(document.createElement('br'));

                                            var text = document.createElement('text');
                                            text.textContent = address
                                            infowincontent.appendChild(text);
                                            var icon = customLabel[type] || {};
                                            var marker = new google.maps.Marker({
                                                map: map,
                                                position: point,
                                                label: icon.label
                                            });
                                            marker.addListener('click', function() {
                                                infoWindow.setContent(infowincontent);
                                                infoWindow.open(map, marker);
                                            });
                                        });
                                    });
                                }



                                function downloadUrl(url, callback) {
                                    var request = window.ActiveXObject ?
                                        new ActiveXObject('Microsoft.XMLHTTP') :
                                        new XMLHttpRequest;

                                    request.onreadystatechange = function() {
                                        if (request.readyState == 4) {
                                            request.onreadystatechange = doNothing;
                                            callback(request, request.status);
                                        }
                                    };

                                    request.open('GET', url, true);
                                    request.send(null);
                                }

                                function doNothing() {}
                            </script>
                            <?php
                            $aData = json_decode(file_get_contents("keys.json"));
                            $mapApi = !empty($aData->mapApi) ? $aData->mapApi : "";
                            ?>
                            <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $mapApi ?>&libraries=places&callback=initMap"></script>



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
