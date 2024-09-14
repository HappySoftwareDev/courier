<?php require_once('db.php'); ?>

<?php

// error_reporting(1);
//initialize the session
if (!isset($_SESSION)) {
    session_start();
}
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
    $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_GET['doLogout'])) {
    //to fully log out a visitor we need to clear the session varialbles
    $_SESSION['MM_Username'] = NULL;
    $_SESSION['MM_UserGroup'] = NULL;
    $_SESSION['PrevUrl'] = NULL;
    unset($_SESSION['MM_Username']);
    unset($_SESSION['MM_UserGroup']);
    unset($_SESSION['PrevUrl']);

    $logoutGoTo = "login.php";
    if ($logoutGoTo) {
        header("Location: $logoutGoTo");
        exit;
    }
}
?>
<?php
if (!isset($_SESSION)) {
    session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup)
{
    // For security, start by assuming the visitor is NOT authorized.
    $isValid = False;

    // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
    // Therefore, we know that a user is NOT logged in if that Session variable is blank.
    if (!empty($UserName)) {
        // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
        // Parse the strings into arrays.
        $arrUsers = Explode(",", $strUsers);
        $arrGroups = Explode(",", $strGroups);
        if (in_array($UserName, $arrUsers)) {
            $isValid = true;
        }
        // Or, you may restrict access to only certain users based on their username.
        if (in_array($UserGroup, $arrGroups)) {
            $isValid = true;
        }
        if (($strUsers == "") && true) {
            $isValid = true;
        }
    }
    return $isValid;
}

$MM_restrictGoTo = "login.php";
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "addDriver")) {
    $carprice = $_POST['carprice'];
    $truckprice = $_POST['truckprice'];
    $taxiprice = $_POST['taxiprice'];
    $towtruckprice = $_POST['towtruckprice'];
    $weightprice = $_POST['weightprice'];
    $itemprice = $_POST['itemprice'];
    $insuranceprice = $_POST['insuranceprice'];
    $baseRate = $_POST['baseRate'];
    $quoteKm = $_POST['quoteKm'];
    $min_parcel = $_POST['min_parcel'];
    $min_freight = $_POST['min_freight'];
    $ID = $_POST['ID'];
    $bike = $_POST['bike'];
    $van = $_POST['van'];
    $value_L1 = $_POST['value_L1'];
    $value_L2 = $_POST['value_L2'];
    $value_L3 = $_POST['value_L3'];
    $value_L4 = $_POST['value_L4'];
    $value_L5 = $_POST['value_L5'];
    $Harare = $_POST['Harare'];
    $Bulawayo = $_POST['Bulawayo'];
    $Chinhoyi = $_POST['Chinhoyi'];
    $Banket = $_POST['Banket'];
    $Karoyi = $_POST['Karoyi'];
    $Kariba = $_POST['Kariba'];
    $Kwekwe = $_POST['Kwekwe'];
    $Mutare = $_POST['Mutare'];
    $Kadoma = $_POST['Kadoma'];
    $Gweru = $_POST['Gweru'];
    $Chegutu = $_POST['Chegutu'];
    $Plumtree = $_POST['Plumtree'];
    $Bindura = $_POST['Bindura'];
    $other = $_POST['other'];
    $Gwanda = $_POST['Gwanda'];
    $Zvishavane = $_POST['Zvishavane'];
    $MtDarwin = $_POST['MtDarwin'];
    $Hwange = $_POST['Hwange'];
    $Beitbridge = $_POST['Beitbridge'];
    $Masvingo = $_POST['Masvingo'];
    $Bupi = $_POST['Bupi'];
    $Chiredzi = $_POST['Chiredzi'];
    $Rusape = $_POST['Rusape'];
    $Chivhu = $_POST['Chivhu'];
    $Binga = $_POST['Binga'];
    $Mvurwi = $_POST['Mvurwi'];
    $VictoriaFalls = $_POST['VictoriaFalls'];
    $loaderPrice = $_POST['loader_price'];
    $freight_driver_commission = $_POST['freight_driver_commission'];
    $parcel_driver_commission = $_POST['parcel_driver_commission'];
    $furniture_driver_commission = $_POST['furniture_driver_commission'];

    $weight_range = $_POST['weight_range'];
    $weight_range1 = $_POST['weight_range1'];
    $weight_range2 = $_POST['weight_range2'];
    $weight_range3 = $_POST['weight_range3'];
    $weight_range4 = $_POST['weight_range4'];
    $weight_range5 = $_POST['weight_range5'];
    $weight_range6 = $_POST['weight_range6'];
    $weight_range7 = $_POST['weight_range7'];
    $weight_range8 = $_POST['weight_range8'];
    $weight_range9 = $_POST['weight_range9'];
    $weight_range10 = $_POST['weight_range10'];
    $weight_range11 = $_POST['weight_range11'];
    $weight_range12 = $_POST['weight_range12'];
    $weight_range13 = $_POST['weight_range13'];
    $weight_range14 = $_POST['weight_range14'];
    $weight_range15 = $_POST['weight_range15'];
    $weight_range16 = $_POST['weight_range16'];
    $weight_range17 = $_POST['weight_range17'];
    $weight_range18 = $_POST['weight_range18'];
    $weight_range19 = $_POST['weight_range19'];
    $weight_range20 = $_POST['weight_range20'];
    $zim_dollar_rate = $_POST['zim_dollar_rate'];

    $tonne_1 = $_POST['tonne_1'];
    $tonne_2 = $_POST['tonne_2'];
    $tonne_3 = $_POST['tonne_3'];
    $tonne_4 = $_POST['tonne_4'];
    $tonne_5 = $_POST['tonne_5'];
    $tonne_6 = $_POST['tonne_6'];
    $tonne_7 = $_POST['tonne_7'];
    $tonne_8 = $_POST['tonne_8'];
    $tonne_9 = $_POST['tonne_9'];
    $tonne_10 = $_POST['tonne_10'];
    $tonne_11 = $_POST['tonne_11'];
    $tonne_12 = $_POST['tonne_12'];
    $tonne_13 = $_POST['tonne_13'];
    $tonne_14 = $_POST['tonne_14'];
    $tonne_15 = $_POST['tonne_15'];
    $tonne_16 = $_POST['tonne_16'];
    $tonne_17 = $_POST['tonne_17'];
    $tonne_18 = $_POST['tonne_18'];
    $tonne_19 = $_POST['tonne_19'];
    $tonne_20 = $_POST['tonne_20'];
    $tonne_21 = $_POST['tonne_21'];
    $tonne_22 = $_POST['tonne_22'];
    $tonne_23 = $_POST['tonne_23'];
    $tonne_24 = $_POST['tonne_24'];
    $tonne_25 = $_POST['tonne_25'];
    $tonne_26 = $_POST['tonne_26'];
    $tonne_27 = $_POST['tonne_27'];
    $tonne_28 = $_POST['tonne_28'];
    $tonne_29 = $_POST['tonne_29'];
    $tonne_30 = $_POST['tonne_30'];
    $tonne_31 = $_POST['tonne_31'];
    $tonne_32 = $_POST['tonne_32'];
    $tonne_33 = $_POST['tonne_33'];
    $tonne_34 = $_POST['tonne_34'];
    $inter_charge = $_POST['inter_charge'];



    try {

        $stmt = $Connect->prepare("SELECT * FROM prizelist WHERE ID=:id");
        $stmt->execute(array(":id" => $ID));
        $count = $stmt->rowCount();
        $count2 = $stmt->rowCount();
        if ($count2 == 1) {
            $stmt = $Connect->prepare("UPDATE `weight_price` SET `weight_range0`=:weight_range,`weight_range1`=:weight_range1,`weight_range2`=:weight_range2,`weight_range3`=:weight_range3,`weight_range4`=:weight_range4,`weight_range5`=:weight_range5,`weight_range6`=:weight_range6,`weight_range7`=:weight_range7,`weight_range8`=:weight_range8,`weight_range9`=:weight_range9,`weight_range10`=:weight_range10,`weight_range11`=:weight_range11,`weight_range12`=:weight_range12,`weight_range13`=:weight_range13,`weight_range14`=:weight_range14,`weight_range15`=:weight_range15,`weight_range16`=:weight_range16,`weight_range17`=:weight_range17,`weight_range18`=:weight_range18,`weight_range19`=:weight_range19,`weight_range20`=:weight_range20, tonne_1=:tonne_1, tonne_2=:tonne_2, tonne_3=:tonne_3, tonne_4=:tonne_4, tonne_5=:tonne_5, tonne_6=:tonne_6, tonne_6=:tonne_6, tonne_7=:tonne_7, tonne_8=:tonne_8, tonne_9=:tonne_9, tonne_10=:tonne_10, tonne_11=:tonne_11, tonne_12=:tonne_12, tonne_13=:tonne_13, tonne_14=:tonne_14, tonne_15=:tonne_15, tonne_16=:tonne_16, tonne_17=:tonne_17, tonne_18=:tonne_18, tonne_19=:tonne_19, tonne_20=:tonne_20, tonne_21=:tonne_21, tonne_22=:tonne_22, tonne_23=:tonne_23, tonne_24=:tonne_24, tonne_25=:tonne_25, tonne_26=:tonne_26, tonne_27=:tonne_27, tonne_28=:tonne_28, tonne_29=:tonne_29, tonne_30=:tonne_30, tonne_31=:tonne_31, tonne_32=:tonne_32, tonne_33=:tonne_33, tonne_34=:tonne_34  WHERE id='1'");
            $stmt->bindparam(":weight_range", $weight_range);
            $stmt->bindparam(":weight_range1", $weight_range1);
            $stmt->bindparam(":weight_range2", $weight_range2);
            $stmt->bindparam(":weight_range3", $weight_range3);
            $stmt->bindparam(":weight_range4", $weight_range4);
            $stmt->bindparam(":weight_range5", $weight_range5);
            $stmt->bindparam(":weight_range6", $weight_range6);
            $stmt->bindparam(":weight_range7", $weight_range7);
            $stmt->bindparam(":weight_range8", $weight_range8);
            $stmt->bindparam(":weight_range9", $weight_range9);
            $stmt->bindparam(":weight_range10", $weight_range10);
            $stmt->bindparam(":weight_range11", $weight_range11);
            $stmt->bindparam(":weight_range12", $weight_range12);
            $stmt->bindparam(":weight_range13", $weight_range13);
            $stmt->bindparam(":weight_range14", $weight_range14);
            $stmt->bindparam(":weight_range15", $weight_range15);
            $stmt->bindparam(":weight_range16", $weight_range16);
            $stmt->bindparam(":weight_range17", $weight_range17);
            $stmt->bindparam(":weight_range18", $weight_range18);
            $stmt->bindparam(":weight_range19", $weight_range19);
            $stmt->bindparam(":weight_range20", $weight_range20);

            $stmt->bindparam(":tonne_1", $tonne_1);
            $stmt->bindparam(":tonne_2", $tonne_2);
            $stmt->bindparam(":tonne_3", $tonne_3);
            $stmt->bindparam(":tonne_4", $tonne_4);
            $stmt->bindparam(":tonne_5", $tonne_5);
            $stmt->bindparam(":tonne_6", $tonne_6);
            $stmt->bindparam(":tonne_7", $tonne_7);
            $stmt->bindparam(":tonne_8", $tonne_8);
            $stmt->bindparam(":tonne_9", $tonne_9);
            $stmt->bindparam(":tonne_10", $tonne_10);
            $stmt->bindparam(":tonne_11", $tonne_11);
            $stmt->bindparam(":tonne_12", $tonne_12);
            $stmt->bindparam(":tonne_13", $tonne_13);
            $stmt->bindparam(":tonne_14", $tonne_14);
            $stmt->bindparam(":tonne_15", $tonne_15);
            $stmt->bindparam(":tonne_16", $tonne_16);
            $stmt->bindparam(":tonne_17", $tonne_17);
            $stmt->bindparam(":tonne_18", $tonne_18);
            $stmt->bindparam(":tonne_19", $tonne_19);
            $stmt->bindparam(":tonne_20", $tonne_20);
            $stmt->bindparam(":tonne_21", $tonne_21);
            $stmt->bindparam(":tonne_22", $tonne_22);
            $stmt->bindparam(":tonne_23", $tonne_23);
            $stmt->bindparam(":tonne_24", $tonne_24);
            $stmt->bindparam(":tonne_25", $tonne_25);
            $stmt->bindparam(":tonne_26", $tonne_26);
            $stmt->bindparam(":tonne_27", $tonne_27);
            $stmt->bindparam(":tonne_28", $tonne_28);
            $stmt->bindparam(":tonne_29", $tonne_29);
            $stmt->bindparam(":tonne_30", $tonne_30);
            $stmt->bindparam(":tonne_31", $tonne_31);
            $stmt->bindparam(":tonne_32", $tonne_32);
            $stmt->bindparam(":tonne_33", $tonne_33);
            $stmt->bindparam(":tonne_34", $tonne_34);
            if ($stmt->execute()) {
                $df = '1';
            }
        }
        if ($count == 1) {
            $stmt = $Connect->prepare("UPDATE prizelist SET Car_per_km=:carprice, truck_price_km=:truckprice, taxi_price_km=:taxiprice, towtruck_price_km=:towtruckprice, Weight=:weightprice, Cost_per_item=:itemprice, Insurance=:insuranceprice, Base_price=:baseRate, Price_per_km=:quoteKm, min_parcel=:min_parcel, min_freight=:min_freight, bike=:bike, van=:van, value_L1=:value_L1, value_L2=:value_L2, value_L3=:value_L3, value_L4=:value_L4, value_L5=:value_L5, Harare=:Harare, Bulawayo=:Bulawayo, Banket=:Banket, Chinhoyi=:Chinhoyi, Karoyi=:Karoyi, Mutare=:Mutare, Kariba=:Kariba, Kwekwe=:Kwekwe, Kadoma=:Kadoma, Chegutu=:Chegutu, Gweru=:Gweru, Plumtree=:Plumtree, Bindura=:Bindura, Gwanda=:Gwanda, Zvishavane=:Zvishavane, MtDarwin=:MtDarwin, Hwange=:Hwange, Beitbridge=:Beitbridge, Masvingo=:Masvingo, Bupi=:Bupi, Chiredzi=:Chiredzi, Chivhu=:Chivhu, Rusape=:Rusape, other=:other, Binga=:Binga, Mvurwi=:Mvurwi, VictoriaFalls=:VictoriaFalls, zim_dollar_rate=:zim_dollar_rate, loader_price=:loaderPrice, parcel_driver_commission=:parcel_driver_commission, freight_driver_commission=:freight_driver_commission, furniture_driver_commission=:furniture_driver_commission, inter_charge=:inter_charge WHERE ID=:ID");

            $stmt->bindparam(":carprice", $carprice);
            $stmt->bindparam(":taxiprice", $taxiprice);
            $stmt->bindparam(":truckprice", $truckprice);
            $stmt->bindparam(":towtruckprice", $towtruckprice);
            $stmt->bindparam(":weightprice", $weightprice);
            $stmt->bindparam(":itemprice", $itemprice);
            $stmt->bindparam(":insuranceprice", $insuranceprice);
            $stmt->bindparam(":baseRate", $baseRate);
            $stmt->bindparam(":quoteKm", $quoteKm);
            $stmt->bindparam(":min_parcel", $min_parcel);
            $stmt->bindparam(":min_freight", $min_freight);
            $stmt->bindparam(":bike", $bike);
            $stmt->bindparam(":van", $van);
            $stmt->bindparam(":value_L1", $value_L1);
            $stmt->bindparam(":value_L2", $value_L2);
            $stmt->bindparam(":value_L3", $value_L3);
            $stmt->bindparam(":value_L4", $value_L4);
            $stmt->bindparam(":value_L5", $value_L5);
            $stmt->bindparam(":Harare", $Harare);
            $stmt->bindparam(":Bulawayo", $Bulawayo);
            $stmt->bindparam(":Banket", $Banket);
            $stmt->bindparam(":Karoyi", $Karoyi);
            $stmt->bindparam(":Kariba", $Kariba);
            $stmt->bindparam(":Kwekwe", $Kwekwe);
            $stmt->bindparam(":Mutare", $Mutare);
            $stmt->bindparam(":Kadoma", $Kadoma);
            $stmt->bindparam(":Gweru", $Gweru);
            $stmt->bindparam(":Chegutu", $Chegutu);
            $stmt->bindparam(":Plumtree", $Plumtree);
            $stmt->bindparam(":Bindura", $Bindura);
            $stmt->bindparam(":other", $other);
            $stmt->bindparam(":Gwanda", $Gwanda);
            $stmt->bindparam(":Zvishavane", $Zvishavane);
            $stmt->bindparam(":MtDarwin", $MtDarwin);
            $stmt->bindparam(":Hwange", $Hwange);
            $stmt->bindparam(":Beitbridge", $Beitbridge);
            $stmt->bindparam(":Masvingo", $Masvingo);
            $stmt->bindparam(":Bupi", $Bupi);
            $stmt->bindparam(":Chiredzi", $Chiredzi);
            $stmt->bindparam(":Rusape", $Rusape);
            $stmt->bindparam(":Chivhu", $Chivhu);
            $stmt->bindparam(":Binga", $Binga);
            $stmt->bindparam(":Mvurwi", $Mvurwi);
            $stmt->bindparam(":VictoriaFalls", $VictoriaFalls);
            $stmt->bindparam(":Chinhoyi", $Chinhoyi);
            $stmt->bindparam(":zim_dollar_rate", $zim_dollar_rate);
            $stmt->bindparam(":loaderPrice", $loaderPrice);
            $stmt->bindparam(":parcel_driver_commission", $parcel_driver_commission);
            $stmt->bindparam(":freight_driver_commission", $freight_driver_commission);
            $stmt->bindparam(":furniture_driver_commission", $furniture_driver_commission);
            $stmt->bindparam(":inter_charge", $inter_charge);
            $stmt->bindparam(":ID", $ID);


            //check if query executes
            if ($stmt->execute()) {
                echo "<script>alert('Update successful check the result.')</script>";
                echo "<script>window.open('integration.php','_self')</script>";
            } else {

                echo "Query could not execute";
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
<?php require("function.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Merchant Couriers - Prices</title>

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
                        <li><a href="integration.php?doLogout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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

        <?php
        $get = "SELECT * FROM `prizelist` WHERE company_name='merchant'";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['ID'];
            $zim_dollar_rate = $row_type['zim_dollar_rate'];
            $Car_per_km = $row_type['Car_per_km'];
            $truck_per_km = $row_type['truck_price_km'];
            $taxi_per_km = $row_type['taxi_price_km'];
            $towtruck_per_km = $row_type['towtruck_price_km'];
            $Weight = $row_type['Weight'];
            $Cost_per_item = $row_type['Cost_per_item'];
            $Insurance = $row_type['Insurance'];
            $Base_price = $row_type['Base_price'];
            $Price_per_km = $row_type['Price_per_km'];
            $min_parcel = $row_type['min_parcel'];
            $min_freight = $row_type['min_freight'];
            $bike = $row_type['bike'];
            $van = $row_type['van'];
            $value_L1 = $row_type['value_L1'];
            $value_L2 = $row_type['value_L2'];
            $value_L3 = $row_type['value_L3'];
            $value_L4 = $row_type['value_L4'];
            $value_L5 = $row_type['value_L5'];
            $Harare = $row_type['Harare'];
            $Bulawayo = $row_type['Bulawayo'];
            $Banket = $row_type['Banket'];
            $Chinhoyi = $row_type['Chinhoyi'];
            $Karoyi = $row_type['Karoyi'];
            $Kariba = $row_type['Kariba'];
            $Kwekwe = $row_type['Kwekwe'];
            $Mutare = $row_type['Mutare'];
            $Kadoma = $row_type['Kadoma'];
            $Gweru = $row_type['Gweru'];
            $Chegutu = $row_type['Chegutu'];
            $Plumtree = $row_type['Plumtree'];
            $Bindura = $row_type['Bindura'];
            $other = $row_type['other'];
            $Gwanda = $row_type['Gwanda'];
            $Zvishavane = $row_type['Zvishavane'];
            $MtDarwin = $row_type['MtDarwin'];
            $Hwange = $row_type['Hwange'];
            $Beitbridge = $row_type['Beitbridge'];
            $Masvingo = $row_type['Masvingo'];
            $Bupi = $row_type['Bupi'];
            $Chiredzi = $row_type['Chiredzi'];
            $Rusape = $row_type['Rusape'];
            $Chivhu = $row_type['Chivhu'];
            $Binga = $row_type['Binga'];
            $Mvurwi = $row_type['Mvurwi'];
            $VictoriaFalls = $row_type['VictoriaFalls'];
            $loader_price = $row_type['loader_price'];
            $parcel_driver_commission = $row_type['parcel_driver_commission'];
            $freight_driver_commission = $row_type['freight_driver_commission'];
            $furniture_driver_commission = $row_type['furniture_driver_commission'];
            $inter_charge = $row_type['inter_charge'];
        }

        ?>
        <?php
        $get_w = "SELECT * FROM `weight_price` ";

        $run = mysqli_query($Connect, $get_w);

        while ($row_type = mysqli_fetch_array($run)) {
            $id = $row_type['id'];
            $weight_range = $row_type['weight_range0'];
            $weight_range1 = $row_type['weight_range1'];
            $weight_range2 = $row_type['weight_range2'];
            $weight_range3 = $row_type['weight_range3'];
            $weight_range4 = $row_type['weight_range4'];
            $weight_range5 = $row_type['weight_range5'];
            $weight_range6 = $row_type['weight_range6'];
            $weight_range7 = $row_type['weight_range7'];
            $weight_range8 = $row_type['weight_range8'];
            $weight_range9 = $row_type['weight_range9'];
            $weight_range10 = $row_type['weight_range10'];
            $weight_range11 = $row_type['weight_range11'];
            $weight_range12 = $row_type['weight_range12'];
            $weight_range13 = $row_type['weight_range13'];
            $weight_range14 = $row_type['weight_range14'];
            $weight_range15 = $row_type['weight_range15'];
            $weight_range16 = $row_type['weight_range16'];
            $weight_range17 = $row_type['weight_range17'];
            $weight_range18 = $row_type['weight_range18'];
            $weight_range19 = $row_type['weight_range19'];
            $weight_range20 = $row_type['weight_range20'];

            $tonne_1 = $row_type['tonne_1'];
            $tonne_2 = $row_type['tonne_2'];
            $tonne_3 = $row_type['tonne_3'];
            $tonne_4 = $row_type['tonne_4'];
            $tonne_5 = $row_type['tonne_5'];
            $tonne_6 = $row_type['tonne_6'];
            $tonne_7 = $row_type['tonne_7'];
            $tonne_8 = $row_type['tonne_8'];
            $tonne_9 = $row_type['tonne_9'];
            $tonne_10 = $row_type['tonne_10'];
            $tonne_11 = $row_type['tonne_11'];
            $tonne_12 = $row_type['tonne_12'];
            $tonne_13 = $row_type['tonne_13'];
            $tonne_14 = $row_type['tonne_14'];
            $tonne_15 = $row_type['tonne_15'];
            $tonne_16 = $row_type['tonne_16'];
            $tonne_17 = $row_type['tonne_17'];
            $tonne_18 = $row_type['tonne_18'];
            $tonne_19 = $row_type['tonne_19'];
            $tonne_20 = $row_type['tonne_20'];
            $tonne_21 = $row_type['tonne_21'];
            $tonne_22 = $row_type['tonne_22'];
            $tonne_23 = $row_type['tonne_23'];
            $tonne_24 = $row_type['tonne_24'];
            $tonne_25 = $row_type['tonne_25'];
            $tonne_26 = $row_type['tonne_26'];
            $tonne_27 = $row_type['tonne_27'];
            $tonne_28 = $row_type['tonne_28'];
            $tonne_29 = $row_type['tonne_29'];
            $tonne_30 = $row_type['tonne_30'];
            $tonne_31 = $row_type['tonne_31'];
            $tonne_32 = $row_type['tonne_32'];
            $tonne_33 = $row_type['tonne_33'];
            $tonne_34 = $row_type['tonne_34'];
        }
        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Prices</h1>
                        <div class="row">

                            <!-- /.col-lg-6 -->
                            <div class="col-lg-12">
                                <form ACTION="integration.php" METHOD="POST" role="form" name="addDriver">
                                    <fieldset>
                                        <!-- /.row -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Collapsible Accordion Panel Group
                                                    </div>
                                                    <!-- .panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="panel-group" id="accordion">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Main Delivery Prices</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseOne" class="panel-collapse collapse in">
                                                                    <div class="panel-body">
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Base rate</label>
                                                                            <input class="form-control" name="baseRate" value="<?php echo $Base_price; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Price perKM</label>
                                                                            <input class="form-control" name="quoteKm" value="<?php echo  $Price_per_km; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Car Price</label>
                                                                            <input class="form-control" name="carprice" value="<?php echo $Car_per_km; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Truck Price</label>
                                                                            <input class="form-control" name="truckprice" value="<?php echo $truck_per_km; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Taxi Price</label>
                                                                            <input class="form-control" name="taxiprice" value="<?php echo $taxi_per_km; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Tow Truck Price</label>
                                                                            <input class="form-control" name="towtruckprice" value="<?php echo $towtruck_per_km; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Weight</label>
                                                                            <input class="form-control" name="weightprice" value="<?php echo $Weight; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Insurance (%)</label>
                                                                            <input class="form-control" name="insuranceprice" value="<?php echo $Insurance; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Package Cost</label>
                                                                            <input class="form-control" name="itemprice" value="<?php echo $Cost_per_item; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Min Price</label>
                                                                            <input class="form-control" name="min_parcel" value="<?php echo $min_parcel; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Bike Price</label>
                                                                            <input class="form-control" name="bike" value="<?php echo $bike; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Van Price</label>
                                                                            <input class="form-control" name="van" value="<?php echo $van; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Min Price Freight</label>
                                                                            <input class="form-control" name="min_freight" value="<?php echo $min_freight; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Zim Dollar Rate</label>
                                                                            <input class="form-control" name="zim_dollar_rate" value="<?php echo $zim_dollar_rate; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Loader Price</label>
                                                                            <input class="form-control" name="loader_price" value="<?php echo $loader_price; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Inter Charges (1.3)</label>
                                                                            <input class="form-control" name="inter_charge" value="<?php echo $inter_charge; ?>" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!------------------------------ value tab------------------------------>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Package Value Price</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseTwo" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Value Level 1</label>
                                                                            <input class="form-control" name="value_L1" value="<?php echo $value_L1; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Value Level 2</label>
                                                                            <input class="form-control" name="value_L2" value="<?php echo $value_L2; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Value Level 3</label>
                                                                            <input class="form-control" name="value_L3" value="<?php echo $value_L3; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Value Level 4</label>
                                                                            <input class="form-control" name="value_L4" value="<?php echo $value_L4; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Value Level 5</label>
                                                                            <input class="form-control" name="value_L5" value="<?php echo $value_L5; ?>" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!------------------------------ weight tab------------------------------>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Package Weight Price</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapse3" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <div class="form-group col-lg-2">
                                                                            <label>0-1KG</label>
                                                                            <input class="form-control" name="weight_range" value="<?php echo  $weight_range; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>1.1-2KG</label>
                                                                            <input class="form-control" name="weight_range1" value="<?php echo $weight_range1; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>2.1-3KG</label>
                                                                            <input class="form-control" name="weight_range2" value="<?php echo $weight_range2; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>3.1-4KG</label>
                                                                            <input class="form-control" name="weight_range3" value="<?php echo $weight_range3; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>4.1-5KG</label>
                                                                            <input class="form-control" name="weight_range4" value="<?php echo $weight_range4; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>5.1-6KG</label>
                                                                            <input class="form-control" name="weight_range5" value="<?php echo $weight_range5; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>6.1-7KG</label>
                                                                            <input class="form-control" name="weight_range6" value="<?php echo $weight_range6; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>7.1-8KG</label>
                                                                            <input class="form-control" name="weight_range7" value="<?php echo $weight_range7; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>8.1-9KG</label>
                                                                            <input class="form-control" name="weight_range8" value="<?php echo $weight_range8; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>9.1-10KG</label>
                                                                            <input class="form-control" name="weight_range9" value="<?php echo $weight_range9; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>10.1-11KG</label>
                                                                            <input class="form-control" name="weight_range10" value="<?php echo $weight_range10; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>11.1-12KG</label>
                                                                            <input class="form-control" name="weight_range11" value="<?php echo $weight_range11; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>12.1-13KG</label>
                                                                            <input class="form-control" name="weight_range12" value="<?php echo $weight_range12; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>13.1-14KG</label>
                                                                            <input class="form-control" name="weight_range13" value="<?php echo $weight_range13; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>14.1-15KG</label>
                                                                            <input class="form-control" name="weight_range14" value="<?php echo $weight_range14; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>15.1-16KG</label>
                                                                            <input class="form-control" name="weight_range15" value="<?php echo $weight_range15; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>16.1-17KG</label>
                                                                            <input class="form-control" name="weight_range16" value="<?php echo $weight_range16; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>17.1-18KG</label>
                                                                            <input class="form-control" name="weight_range17" value="<?php echo $weight_range17; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>18.1-19KG</label>
                                                                            <input class="form-control" name="weight_range18" value="<?php echo $weight_range18; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>19.1-20KG</label>
                                                                            <input class="form-control" name="weight_range19" value="<?php echo $weight_range19; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>20.1-more KG</label>
                                                                            <input class="form-control" name="weight_range20" value="<?php echo $weight_range20; ?>" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!------------------------------ cities tab------------------------------>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Cities</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseThree" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Harare</label>
                                                                            <input class="form-control" name="Harare" value="<?php echo $Harare; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Bulawayo</label>
                                                                            <input class="form-control" name="Bulawayo" value="<?php echo $Bulawayo; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Banket</label>
                                                                            <input class="form-control" name="Banket" value="<?php echo $Banket; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Karoyi</label>
                                                                            <input class="form-control" name="Karoyi" value="<?php echo $Karoyi; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Kariba</label>
                                                                            <input class="form-control" name="Kariba" value="<?php echo $Kariba; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Kwekwe</label>
                                                                            <input class="form-control" name="Kwekwe" value="<?php echo $Kwekwe; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Mutare</label>
                                                                            <input class="form-control" name="Mutare" value="<?php echo $Mutare; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Kadoma</label>
                                                                            <input class="form-control" name="Kadoma" value="<?php echo $Kadoma; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Chegutu</label>
                                                                            <input class="form-control" name="Chegutu" value="<?php echo $Chegutu; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Gweru</label>
                                                                            <input class="form-control" name="Gweru" value="<?php echo $Gweru; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Plumtree</label>
                                                                            <input class="form-control" name="Plumtree" value="<?php echo $Plumtree; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Bindura</label>
                                                                            <input class="form-control" name="Bindura" value="<?php echo $Bindura; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Gwanda</label>
                                                                            <input class="form-control" name="Gwanda" value="<?php echo $Gwanda; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Zvishavane</label>
                                                                            <input class="form-control" name="Zvishavane" value="<?php echo $Zvishavane; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>MtDarwin</label>
                                                                            <input class="form-control" name="MtDarwin" value="<?php echo $MtDarwin; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Hwange</label>
                                                                            <input class="form-control" name="Hwange" value="<?php echo $Hwange; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Beitbridge</label>
                                                                            <input class="form-control" name="Beitbridge" value="<?php echo $Beitbridge; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Masvingo</label>
                                                                            <input class="form-control" name="Masvingo" value="<?php echo $Masvingo; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Bupi</label>
                                                                            <input class="form-control" name="Bupi" value="<?php echo $Bupi; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Chiredzi</label>
                                                                            <input class="form-control" name="Chiredzi" value="<?php echo $Chiredzi; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>Rusape</label>
                                                                            <input class="form-control" name="Rusape" value="<?php echo $Rusape; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Chivhu</label>
                                                                            <input class="form-control" name="Chivhu" value="<?php echo $Chivhu; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Binga</label>
                                                                            <input class="form-control" name="Binga" value="<?php echo $Binga; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Mvurwi</label>
                                                                            <input class="form-control" name="Mvurwi" value="<?php echo $Mvurwi; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>VictoriaFalls</label>
                                                                            <input class="form-control" name="VictoriaFalls" value="<?php echo $VictoriaFalls; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Chinhoyi</label>
                                                                            <input class="form-control" name="Chinhoyi" value="<?php echo $Chinhoyi; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>Other</label>
                                                                            <input class="form-control" name="other" value="<?php echo $other; ?>" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!------------------------------ Freight Tonne------------------------------>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTonne">Freight Tonnage Prices</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseTonne" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <div class="form-group col-lg-2">
                                                                            <label>1 Tonne</label>
                                                                            <input class="form-control" name="tonne_1" value="<?php echo $tonne_1; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>2 Tonnes</label>
                                                                            <input class="form-control" name="tonne_2" value="<?php echo $tonne_2; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>3 Tonnes</label>
                                                                            <input class="form-control" name="tonne_3" value="<?php echo $tonne_3; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>4 Tonnes</label>
                                                                            <input class="form-control" name="tonne_4" value="<?php echo $tonne_4; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>5 Tonne</label>
                                                                            <input class="form-control" name="tonne_5" value="<?php echo $tonne_5; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>6 Tonnes</label>
                                                                            <input class="form-control" name="tonne_6" value="<?php echo $tonne_6; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>7 Tonnes</label>
                                                                            <input class="form-control" name="tonne_7" value="<?php echo $tonne_7; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>8 Tonnes</label>
                                                                            <input class="form-control" name="tonne_8" value="<?php echo $tonne_8; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>9 Tonnes</label>
                                                                            <input class="form-control" name="tonne_9" value="<?php echo $tonne_9; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>10 Tonnes</label>
                                                                            <input class="form-control" name="tonne_10" value="<?php echo $tonne_10; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>11 Tonnes</label>
                                                                            <input class="form-control" name="tonne_11" value="<?php echo $tonne_11; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>12 Tonnes</label>
                                                                            <input class="form-control" name="tonne_12" value="<?php echo $tonne_12; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>13 Tonnes</label>
                                                                            <input class="form-control" name="tonne_13" value="<?php echo $tonne_13; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>14 Tonnes</label>
                                                                            <input class="form-control" name="tonne_14" value="<?php echo $tonne_14; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>15 Tonnes</label>
                                                                            <input class="form-control" name="tonne_15" value="<?php echo $tonne_15; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>16 Tonnes</label>
                                                                            <input class="form-control" name="tonne_16" value="<?php echo $tonne_16; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>17 Tonnes</label>
                                                                            <input class="form-control" name="tonne_17" value="<?php echo $tonne_17; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>18 Tonnes</label>
                                                                            <input class="form-control" name="tonne_18" value="<?php echo $tonne_18; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>19 Tonnes</label>
                                                                            <input class="form-control" name="tonne_19" value="<?php echo $tonne_19; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>20 Tonnes</label>
                                                                            <input class="form-control" name="tonne_20" value="<?php echo $tonne_20; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>21 Tonnes</label>
                                                                            <input class="form-control" name="tonne_21" value="<?php echo $tonne_21; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>22 Tonnes</label>
                                                                            <input class="form-control" name="tonne_22" value="<?php echo $tonne_22; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>23 Tonnes</label>
                                                                            <input class="form-control" name="tonne_23" value="<?php echo $tonne_23; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>24 Tonnes</label>
                                                                            <input class="form-control" name="tonne_24" value="<?php echo $tonne_24; ?>" type="text">
                                                                        </div>

                                                                        <div class="form-group col-lg-2">
                                                                            <label>25 Tonnes</label>
                                                                            <input class="form-control" name="tonne_25" value="<?php echo $tonne_25; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>26 Tonnes</label>
                                                                            <input class="form-control" name="tonne_26" value="<?php echo $tonne_26; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>27 Tonnes</label>
                                                                            <input class="form-control" name="tonne_27" value="<?php echo $tonne_27; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>28 Tonnes</label>
                                                                            <input class="form-control" name="tonne_28" value="<?php echo $tonne_28; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>29 Tonnes</label>
                                                                            <input class="form-control" name="tonne_29" value="<?php echo $tonne_29; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>30 Tonnes</label>
                                                                            <input class="form-control" name="tonne_30" value="<?php echo $tonne_30; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>31 Tonnes</label>
                                                                            <input class="form-control" name="tonne_31" value="<?php echo $tonne_31; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>32 Tonnes</label>
                                                                            <input class="form-control" name="tonne_32" value="<?php echo $tonne_32; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>33 Tonnes</label>
                                                                            <input class="form-control" name="tonne_33" value="<?php echo $tonne_33; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label>34 Tonnes</label>
                                                                            <input class="form-control" name="tonne_34" value="<?php echo $tonne_34; ?>" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!------------------------------ Driver Commissions------------------------------>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseCommission">Driver Commissions</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseCommission" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <div class="form-group col-lg-4">
                                                                            <label>Driver Commission (Parcel %)</label>
                                                                            <input class="form-control" name="parcel_driver_commission" value="<?php echo $parcel_driver_commission; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-4">
                                                                            <label>Driver Commission (Freight %)</label>
                                                                            <input class="form-control" name="freight_driver_commission" value="<?php echo $freight_driver_commission; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-4">
                                                                            <label>Driver Commission (Furniture %)</label>
                                                                            <input class="form-control" name="furniture_driver_commission" value="<?php echo $furniture_driver_commission; ?>" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <br /><br />
                                                            <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                                                            <div class="col-lg-12"> <input type="submit" class="btn btn-lg btn-success btn-block" value="Update Prices"></div>

                                                        </div>
                                                    </div>
                                                    <!-- .panel-body -->
                                                </div>
                                                <!-- /.panel -->
                                            </div>
                                            <!-- /.col-lg-12 -->
                                        </div>
                                        <!-- /.row -->


                                    </fieldset>
                                    <input type="hidden" name="MM_insert" value="addDriver">
                                    <input type="hidden" name="MM_update" value="addDriver">

                                </form>
                                <br /><br /><br />
                            </div>

                            <!-- international zone area -->
                            <div class="col-lg-12">
                                <form ACTION="submit_zones.php" METHOD="POST" role="form" name="interZone">
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        International Zone Prices
                                                    </div>
                                                    <!-- .panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="panelDriver Commission (Parcel %)-group" id="accordion2">

                                                            <!------------------------------ Adding zones------------------------------>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion2" href="#zone">Add Zone</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="zone" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <div class="form-group col-lg-4">
                                                                            <label>Zone</label>
                                                                            <input class="form-control" name="zone" value="" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-4">
                                                                            <label>Zone Price</label>
                                                                            <input class="form-control" name="zoneprice" value="" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-4">
                                                                            <label>Weight (KG)</label>
                                                                            <input class="form-control" name="weightprice" value="" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!------------------------------ //Adding zones------------------------------>

                                                            <!------------------------------ Adding Country------------------------------>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion2" href="#country-zone">Add Country</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="country-zone" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <div class="form-group col-lg-6">
                                                                            <label>Country</label>
                                                                            <select class="form-control" id="country" name="country">
                                                                                <option value=""></option>
                                                                                <option value="Afganistan">Afghanistan</option>
                                                                                <option value="Albania">Albania</option>
                                                                                <option value="Algeria">Algeria</option>
                                                                                <option value="American Samoa">American Samoa</option>
                                                                                <option value="Andorra">Andorra</option>
                                                                                <option value="Angola">Angola</option>
                                                                                <option value="Anguilla">Anguilla</option>
                                                                                <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                                                                <option value="Argentina">Argentina</option>
                                                                                <option value="Armenia">Armenia</option>
                                                                                <option value="Aruba">Aruba</option>
                                                                                <option value="Australia">Australia</option>
                                                                                <option value="Austria">Austria</option>
                                                                                <option value="Azerbaijan">Azerbaijan</option>
                                                                                <option value="Bahamas">Bahamas</option>
                                                                                <option value="Bahrain">Bahrain</option>
                                                                                <option value="Bangladesh">Bangladesh</option>
                                                                                <option value="Barbados">Barbados</option>
                                                                                <option value="Belarus">Belarus</option>
                                                                                <option value="Belgium">Belgium</option>
                                                                                <option value="Belize">Belize</option>
                                                                                <option value="Benin">Benin</option>
                                                                                <option value="Bermuda">Bermuda</option>
                                                                                <option value="Bhutan">Bhutan</option>
                                                                                <option value="Bolivia">Bolivia</option>
                                                                                <option value="Bonaire">Bonaire</option>
                                                                                <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                                                                <option value="Botswana">Botswana</option>
                                                                                <option value="Brazil">Brazil</option>
                                                                                <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                                                <option value="Brunei">Brunei</option>
                                                                                <option value="Bulgaria">Bulgaria</option>
                                                                                <option value="Burkina Faso">Burkina Faso</option>
                                                                                <option value="Burundi">Burundi</option>
                                                                                <option value="Cambodia">Cambodia</option>
                                                                                <option value="Cameroon">Cameroon</option>
                                                                                <option value="Canada">Canada</option>
                                                                                <option value="Canary Islands">Canary Islands</option>
                                                                                <option value="Cape Verde">Cape Verde</option>
                                                                                <option value="Cayman Islands">Cayman Islands</option>
                                                                                <option value="Central African Republic">Central African Republic</option>
                                                                                <option value="Chad">Chad</option>
                                                                                <option value="Channel Islands">Channel Islands</option>
                                                                                <option value="Chile">Chile</option>
                                                                                <option value="China">China</option>
                                                                                <option value="Christmas Island">Christmas Island</option>
                                                                                <option value="Cocos Island">Cocos Island</option>
                                                                                <option value="Colombia">Colombia</option>
                                                                                <option value="Comoros">Comoros</option>
                                                                                <option value="Congo">Congo</option>
                                                                                <option value="Cook Islands">Cook Islands</option>
                                                                                <option value="Costa Rica">Costa Rica</option>
                                                                                <option value="Cote DIvoire">Cote DIvoire</option>
                                                                                <option value="Croatia">Croatia</option>
                                                                                <option value="Cuba">Cuba</option>
                                                                                <option value="Curaco">Curacao</option>
                                                                                <option value="Cyprus">Cyprus</option>
                                                                                <option value="Czech Republic">Czech Republic</option>
                                                                                <option value="Denmark">Denmark</option>
                                                                                <option value="Djibouti">Djibouti</option>
                                                                                <option value="Dominica">Dominica</option>
                                                                                <option value="Dominican Republic">Dominican Republic</option>
                                                                                <option value="East Timor">East Timor</option>
                                                                                <option value="Ecuador">Ecuador</option>
                                                                                <option value="Egypt">Egypt</option>
                                                                                <option value="El Salvador">El Salvador</option>
                                                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                                                <option value="Eritrea">Eritrea</option>
                                                                                <option value="Estonia">Estonia</option>
                                                                                <option value="Ethiopia">Ethiopia</option>
                                                                                <option value="Falkland Islands">Falkland Islands</option>
                                                                                <option value="Faroe Islands">Faroe Islands</option>
                                                                                <option value="Fiji">Fiji</option>
                                                                                <option value="Finland">Finland</option>
                                                                                <option value="France">France</option>
                                                                                <option value="French Guiana">French Guiana</option>
                                                                                <option value="French Polynesia">French Polynesia</option>
                                                                                <option value="French Southern Ter">French Southern Ter</option>
                                                                                <option value="Gabon">Gabon</option>
                                                                                <option value="Gambia">Gambia</option>
                                                                                <option value="Georgia">Georgia</option>
                                                                                <option value="Germany">Germany</option>
                                                                                <option value="Ghana">Ghana</option>
                                                                                <option value="Gibraltar">Gibraltar</option>
                                                                                <option value="Great Britain">Great Britain</option>
                                                                                <option value="Greece">Greece</option>
                                                                                <option value="Greenland">Greenland</option>
                                                                                <option value="Grenada">Grenada</option>
                                                                                <option value="Guadeloupe">Guadeloupe</option>
                                                                                <option value="Guam">Guam</option>
                                                                                <option value="Guatemala">Guatemala</option>
                                                                                <option value="Guinea">Guinea</option>
                                                                                <option value="Guyana">Guyana</option>
                                                                                <option value="Haiti">Haiti</option>
                                                                                <option value="Hawaii">Hawaii</option>
                                                                                <option value="Honduras">Honduras</option>
                                                                                <option value="Hong Kong">Hong Kong</option>
                                                                                <option value="Hungary">Hungary</option>
                                                                                <option value="Iceland">Iceland</option>
                                                                                <option value="Indonesia">Indonesia</option>
                                                                                <option value="India">India</option>
                                                                                <option value="Iran">Iran</option>
                                                                                <option value="Iraq">Iraq</option>
                                                                                <option value="Ireland">Ireland</option>
                                                                                <option value="Isle of Man">Isle of Man</option>
                                                                                <option value="Israel">Israel</option>
                                                                                <option value="Italy">Italy</option>
                                                                                <option value="Jamaica">Jamaica</option>
                                                                                <option value="Japan">Japan</option>
                                                                                <option value="Jordan">Jordan</option>
                                                                                <option value="Kazakhstan">Kazakhstan</option>
                                                                                <option value="Kenya">Kenya</option>
                                                                                <option value="Kiribati">Kiribati</option>
                                                                                <option value="Korea North">Korea North</option>
                                                                                <option value="Korea Sout">Korea South</option>
                                                                                <option value="Kuwait">Kuwait</option>
                                                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                                                <option value="Laos">Laos</option>
                                                                                <option value="Latvia">Latvia</option>
                                                                                <option value="Lebanon">Lebanon</option>
                                                                                <option value="Lesotho">Lesotho</option>
                                                                                <option value="Liberia">Liberia</option>
                                                                                <option value="Libya">Libya</option>
                                                                                <option value="Liechtenstein">Liechtenstein</option>
                                                                                <option value="Lithuania">Lithuania</option>
                                                                                <option value="Luxembourg">Luxembourg</option>
                                                                                <option value="Macau">Macau</option>
                                                                                <option value="Macedonia">Macedonia</option>
                                                                                <option value="Madagascar">Madagascar</option>
                                                                                <option value="Malaysia">Malaysia</option>
                                                                                <option value="Malawi">Malawi</option>
                                                                                <option value="Maldives">Maldives</option>
                                                                                <option value="Mali">Mali</option>
                                                                                <option value="Malta">Malta</option>
                                                                                <option value="Marshall Islands">Marshall Islands</option>
                                                                                <option value="Martinique">Martinique</option>
                                                                                <option value="Mauritania">Mauritania</option>
                                                                                <option value="Mauritius">Mauritius</option>
                                                                                <option value="Mayotte">Mayotte</option>
                                                                                <option value="Mexico">Mexico</option>
                                                                                <option value="Midway Islands">Midway Islands</option>
                                                                                <option value="Moldova">Moldova</option>
                                                                                <option value="Monaco">Monaco</option>
                                                                                <option value="Mongolia">Mongolia</option>
                                                                                <option value="Montserrat">Montserrat</option>
                                                                                <option value="Morocco">Morocco</option>
                                                                                <option value="Mozambique">Mozambique</option>
                                                                                <option value="Myanmar">Myanmar</option>
                                                                                <option value="Nambia">Nambia</option>
                                                                                <option value="Nauru">Nauru</option>
                                                                                <option value="Nepal">Nepal</option>
                                                                                <option value="Netherland Antilles">Netherland Antilles</option>
                                                                                <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                                                <option value="Nevis">Nevis</option>
                                                                                <option value="New Caledonia">New Caledonia</option>
                                                                                <option value="New Zealand">New Zealand</option>
                                                                                <option value="Nicaragua">Nicaragua</option>
                                                                                <option value="Niger">Niger</option>
                                                                                <option value="Nigeria">Nigeria</option>
                                                                                <option value="Niue">Niue</option>
                                                                                <option value="Norfolk Island">Norfolk Island</option>
                                                                                <option value="Norway">Norway</option>
                                                                                <option value="Oman">Oman</option>
                                                                                <option value="Pakistan">Pakistan</option>
                                                                                <option value="Palau Island">Palau Island</option>
                                                                                <option value="Palestine">Palestine</option>
                                                                                <option value="Panama">Panama</option>
                                                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                                                <option value="Paraguay">Paraguay</option>
                                                                                <option value="Peru">Peru</option>
                                                                                <option value="Phillipines">Philippines</option>
                                                                                <option value="Pitcairn Island">Pitcairn Island</option>
                                                                                <option value="Poland">Poland</option>
                                                                                <option value="Portugal">Portugal</option>
                                                                                <option value="Puerto Rico">Puerto Rico</option>
                                                                                <option value="Qatar">Qatar</option>
                                                                                <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                                                <option value="Republic of Serbia">Republic of Serbia</option>
                                                                                <option value="Reunion">Reunion</option>
                                                                                <option value="Romania">Romania</option>
                                                                                <option value="Russia">Russia</option>
                                                                                <option value="Rwanda">Rwanda</option>
                                                                                <option value="St Barthelemy">St Barthelemy</option>
                                                                                <option value="St Eustatius">St Eustatius</option>
                                                                                <option value="St Helena">St Helena</option>
                                                                                <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                                                <option value="St Lucia">St Lucia</option>
                                                                                <option value="St Maarten">St Maarten</option>
                                                                                <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                                                                <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                                                                <option value="Saipan">Saipan</option>
                                                                                <option value="Samoa">Samoa</option>
                                                                                <option value="Samoa American">Samoa American</option>
                                                                                <option value="San Marino">San Marino</option>
                                                                                <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                                                <option value="Senegal">Senegal</option>
                                                                                <option value="Seychelles">Seychelles</option>
                                                                                <option value="Sierra Leone">Sierra Leone</option>
                                                                                <option value="Singapore">Singapore</option>
                                                                                <option value="Slovakia">Slovakia</option>
                                                                                <option value="Slovenia">Slovenia</option>
                                                                                <option value="Solomon Islands">Solomon Islands</option>
                                                                                <option value="Somalia">Somalia</option>
                                                                                <option value="South Africa">South Africa</option>
                                                                                <option value="Spain">Spain</option>
                                                                                <option value="Sri Lanka">Sri Lanka</option>
                                                                                <option value="Sudan">Sudan</option>
                                                                                <option value="Suriname">Suriname</option>
                                                                                <option value="Swaziland">Swaziland</option>
                                                                                <option value="Sweden">Sweden</option>
                                                                                <option value="Switzerland">Switzerland</option>
                                                                                <option value="Syria">Syria</option>
                                                                                <option value="Tahiti">Tahiti</option>
                                                                                <option value="Taiwan">Taiwan</option>
                                                                                <option value="Tajikistan">Tajikistan</option>
                                                                                <option value="Tanzania">Tanzania</option>
                                                                                <option value="Thailand">Thailand</option>
                                                                                <option value="Togo">Togo</option>
                                                                                <option value="Tokelau">Tokelau</option>
                                                                                <option value="Tonga">Tonga</option>
                                                                                <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                                                                <option value="Tunisia">Tunisia</option>
                                                                                <option value="Turkey">Turkey</option>
                                                                                <option value="Turkmenistan">Turkmenistan</option>
                                                                                <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                                                                <option value="Tuvalu">Tuvalu</option>
                                                                                <option value="Uganda">Uganda</option>
                                                                                <option value="United Kingdom">United Kingdom</option>
                                                                                <option value="Ukraine">Ukraine</option>
                                                                                <option value="United Arab Erimates">United Arab Emirates</option>
                                                                                <option value="United States of America">United States of America</option>
                                                                                <option value="Uraguay">Uruguay</option>
                                                                                <option value="Uzbekistan">Uzbekistan</option>
                                                                                <option value="Vanuatu">Vanuatu</option>
                                                                                <option value="Vatican City State">Vatican City State</option>
                                                                                <option value="Venezuela">Venezuela</option>
                                                                                <option value="Vietnam">Vietnam</option>
                                                                                <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                                                <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                                                <option value="Wake Island">Wake Island</option>
                                                                                <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                                                                <option value="Yemen">Yemen</option>
                                                                                <option value="Zaire">Zaire</option>
                                                                                <option value="Zambia">Zambia</option>
                                                                                <option value="Zimbabwe">Zimbabwe</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-lg-6">
                                                                            <label>Assign to a Zone</label>
                                                                            <select class="form-control" id="assigned_zone" name="assigned_zone">
                                                                                <option value=""></option>
                                                                                <?php
                                                                                $get_w = "SELECT * FROM `inter_zones` GROUP BY zone ";
                                                                                $run = mysqli_query($Connect, $get_w);
                                                                                while ($row_type = mysqli_fetch_array($run)) {
                                                                                    $zone = $row_type['zone'];

                                                                                    echo "<option value='$zone'>$zone</option>";
                                                                                };
                                                                                ?>
                                                                            </select>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-------------------- //Adding Country --------------------->

                                                            <!------------------------------ Update Zones------------------------------>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion2" href="#update-zone">Update Zone</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="update-zone" class="panel-collapse collapse">
                                                                    <div class="panel-body">

                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <div class="table-responsive">
                                                                                    <table id="clients_Ac" class="table table-bordered table-hover table-striped">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>ID</th>
                                                                                                <th>Zones</th>
                                                                                                <th>Weight</th>
                                                                                                <th>Price</th>
                                                                                                <th>Country</th>
                                                                                                <th>Action</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php getZones(); ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <!-- /.table-responsive -->
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-------------------- //Adding Country --------------------->

                                                                <br /><br />
                                                                <input type="hidden" name="insertZone" value="interZone">
                                                                <div class="col-lg-12"> <input type="submit" class="btn btn-lg btn-success btn-block" value="Submit"></div>
                                                            </div>
                                                        </div>

                                                        <!-- .panel-body -->
                                                    </div>
                                                    <!-- /.panel -->
                                                </div>
                                                <!-- /.col-lg-12 -->
                                            </div>


                                    </fieldset>

                                </form>
                                <br /><br /><br /><br /><br /><br />
                            </div>
                            <?php

                            if (isset($_POST['email'])) {

                                $email = $_POST['email'];

                                $email_from = 'admin@merchantcouriers.co.zw';
                                $email_to = $email;
                                $subject = '<img src="//images/logo.png" alt="logo">';
                                $message = 'Hi!\n Merchant Couriers has invited you to signup to become an admin.\n\n <a href="adminUsers.php">Click here</a> to enter your details.';

                                $body = 'Email: ' . $email . "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;

                                $success = @mail($email_to, $subject, $body, 'From: <' . $email_from . '>');
                                echo '<script>document.getElementById("sent").innerHTML="Invitation sent successfully!"</script>';
                            }

                            ?>
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
