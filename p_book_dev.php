<?php require ("login-security.php"); ?>

<?php require ("get-sql-value.php"); 

$aData = json_decode(file_get_contents("admin/pages/keys.json"));
// echo "<pre>" . print_r($aData, true) . "</pre>";
$showStripe = isset($aData->stripe_handle) ? $aData->stripe_handle : "";
$showPaynow = isset($aData->paynow_handle) ? $aData->paynow_handle : "";

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117550135-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-117550135-1');
    </script>

    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '656929728593166');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=656929728593166&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->


    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Inner city parcel delivery booking for Zimbabwe | Merchant Couriers</title>
    <meta name="Book a service of your choice in Zimbabwe through Merchant Couriers. YOu can book on the internet, on your phone or call us." content="motorbike messenger, van delivery, parcel delivery, in Zimbabwe">
    <meta name="viewport" content="width=device-width">

    <link re="canonical" href="https://www.merchantcouriers.com/booking.php" />


    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/sl-slide.css">

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script src="js/vendor/jquery-1.9.1.min.js"></script>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <style>
        form#multiphase>#phase2,
        #phase3,
        #sho_fo {
            display: none;
        }
    </style>


    <script type="text/javascript">
        var showStripe = <?php echo $showStripe; ?>;
        var showPaynow = <?php echo $showPaynow; ?>;
        window.onload = function() {
            calculateTotal(1);
        }
        var address, name, email, phone, date, time, drop_address, drop_name, drop_phone, drop_date, drop_time, note, transport,
            weight_of_package, package_quantity, insurance, harm, value_of_package;

        var map;
        var geocoder;
        var bounds = new google.maps.LatLngBounds();
        var markersArray = [];

        //var origin1 = new google.maps.LatLng(55.930, -3.118);
        var origin;
        var destination;
        //var destinationB = new google.maps.LatLng(50.087, 14.421);

        var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';
        var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';

        function _(x) {
            return document.getElementById(x);
        }

        function initialize() {
            var opts = {
                center: new google.maps.LatLng(-17.824858, 31.053028),
                zoom: 10
            };
            map = new google.maps.Map(document.getElementById('map-canvas'), opts);
            geocoder = new google.maps.Geocoder();
        }

        function processPhase1() {
            address = _("autocomplete").value;
            drop_address = _("drop_address").value;
            name = _("name").value;
            email = _("email").value;
            phone = _("phone").value;
            if (address == "" || drop_address == "") {
                alert("Please fill in the fields");
            } else if (address.length < 2) {
                _("addstatus").innerHTML = "Please enter a valid address!";
            } else {

                _("phase1").style.display = "none";
                _("phase2").style.display = "block";
                _("display_address").innerHTML = address;
                _("display_pickuptime").innerHTML = time;
                _("display_pickupdate").innerHTML = date;
                _("progressBar").value = 50;
                _("status").innerHTML = "Step 2 of 3...";
                _("startAdd").innerHTML = address;
            }
        }

        function shoPricePhase1() {
            address = _("autocomplete").value;
            drop_address = _("drop_address").value;
            drop_name = _("drop_name").value;
            drop_phone = _("drop_phone").value;
            drop_date = _("drop_date").value;
            drop_time = _("drop_time").value;

            var service = new google.maps.DistanceMatrixService(); //initialize the distance service
            service.getDistanceMatrix({
                origins: [address], //set origin, you can specify multiple sources here
                destinations: [drop_address], //set destination, you can specify multiple destinations here
                travelMode: google.maps.TravelMode.DRIVING, //set the travelmode
                unitSystem: google.maps.UnitSystem.METRIC, //The unit system to use when displaying distance
                avoidHighways: false,
                avoidTolls: false
            }, calcDistance); // here calcDistance is the call back function
        }

        function processPhase2() {
            drop_address = _("drop_address").value;
            drop_name = _("drop_name").value;
            drop_phone = _("drop_phone").value;
            drop_date = _("drop_date").value;
            drop_time = _("drop_time").value;
            date = _("date").value;
            time = _("time").value;

            var service = new google.maps.DistanceMatrixService(); //initialize the distance service
            service.getDistanceMatrix({
                origins: [address], //set origin, you can specify multiple sources here
                destinations: [drop_address], //set destination, you can specify multiple destinations here
                travelMode: google.maps.TravelMode.DRIVING, //set the travelmode
                unitSystem: google.maps.UnitSystem.METRIC, //The unit system to use when displaying distance
                avoidHighways: false,
                avoidTolls: false
            }, calcDistance); // here calcDistance is the call back function

            if (drop_name == "" || drop_phone == "" || drop_date == "" || drop_time == "" || date == "" || time == "") {
                alert("Please fill in the fields");
            } else if (drop_name.length < 2) {
                _("namestatus2").innerHTML = "Please fill the name field!";
            } else if (date.length < 2) {
                _("datestatus2").innerHTML = "A date is required!";
            } else if (phone.length < 2) {
                _("phonestatus2").innerHTML = "Phone number is required!";
            } else if (time.length < 2) {
                _("timestatus2").innerHTML = "pick up time is required!";
            } else {
                _("phase2").style.display = "none";
                _("phase3").style.display = "block";
                _("progressBar").value = 100;
                _("status").innerHTML = "Last Step...";
                _("display_address2").innerHTML = address;
                _("display_pickuptime2").innerHTML = time;
                _("display_pickupdate2").innerHTML = date;
                _("display_drop_address").innerHTML = drop_address;
                _("display_droptime").innerHTML = drop_time;
                _("display_dropdate").innerHTML = drop_date;
                _("endAdd").innerHTML = drop_address;

            }

        }

        function getWeightPrice() {
            var totalWeightPrice = parseFloat(_("totalW").value);
            var selectedWeight = parseFloat(_("weight_of_package").value);
            var packageWeightPrice = selectedWeight;

            return packageWeightPrice;
        }

        function getWeightRange() {
            var packageWeightRange = 0;
            var selectedValue = _("weight_of_package").value;
            if (selectedValue == "0-1 KG") {
                packageWeightRange = parseFloat(_("weight_range").value);
            } else if (selectedValue == "1.1-2 KG") {
                packageWeightRange = parseFloat(_("weight_range1").value);
            } else if (selectedValue == "2.1-3 KG") {
                packageWeightRange = parseFloat(_("weight_range2").value);
            } else if (selectedValue == "3.1-4 KG") {
                packageWeightRange = parseFloat(_("weight_range3").value);
            } else if (selectedValue == "4.1-5 KG") {
                packageWeightRange = parseFloat(_("weight_range4").value);
            } else if (selectedValue == "5.1-6 KG") {
                packageWeightRange = parseFloat(_("weight_range5").value);
            } else if (selectedValue == "6.1-7 KG") {
                packageWeightRange = parseFloat(_("weight_range6").value);
            } else if (selectedValue == "7.1-8 KG") {
                packageWeightRange = parseFloat(_("weight_range7").value);
            } else if (selectedValue == "8.1-9 KG") {
                packageWeightRange = parseFloat(_("weight_range8").value);
            } else if (selectedValue == "9.1-10 KG") {
                packageWeightRange = parseFloat(_("weight_range9").value);
            } else if (selectedValue == "10.1-11 KG") {
                packageWeightRange = parseFloat(_("weight_range10").value);
            } else if (selectedValue == "11.1-12 KG") {
                packageWeightRange = parseFloat(_("weight_range11").value);
            } else if (selectedValue == "12.1-13 KG") {
                packageWeightRange = parseFloat(_("weight_range12").value);
            } else if (selectedValue == "13.1-14 KG") {
                packageWeightRange = parseFloat(_("weight_range13").value);
            } else if (selectedValue == "14.1-15 KG") {
                packageWeightRange = parseFloat(_("weight_range14").value);
            } else if (selectedValue == "15.1-16 KG") {
                packageWeightRange = parseFloat(_("weight_range15").value);
            } else if (selectedValue == "16.1-17 KG") {
                packageWeightRange = parseFloat(_("weight_range16").value);
            } else if (selectedValue == "17.1-18 KG") {
                packageWeightRange = parseFloat(_("weight_range17").value);
            } else if (selectedValue == "18.1-19 KG") {
                packageWeightRange = parseFloat(_("weight_range18").value);
            } else if (selectedValue == "19.1-20 KG") {
                packageWeightRange = parseFloat(_("weight_range19").value);
            } else if (selectedValue == "20 KG-above") {
                packageWeightRange = parseFloat(_("weight_range20").value);
            } else if (selectedValue == "more") {
                _("sho_more").style.display = "block";
                var weight_of_package_more = _("more_weight_of_package").value;
                var w20_more = parseFloat(_("weight_range20").value);
                var weight2019 = parseFloat(_("weight_range19").value);
                var above_weight_p = w20_more * weight_of_package_more - weight2019;
                packageWeightRange = weight2019 + above_weight_p;
            } else if (selectedValue != "more") {
                _("sho_more").style.display = "none";
            }
            return packageWeightRange;
        }

        function getValuePrice() {
            var packageValuePrice = 0;
            var selectedValue = _("value_of_package").value;
            if (selectedValue == "$1,00 - $50,00") {
                packageValuePrice = parseFloat(_("value_L1").value);
            } else if (selectedValue == "$50,00 - $100,00") {
                packageValuePrice = parseFloat(_("value_L2").value);
            } else if (selectedValue == "$100,00 - $500,00") {
                packageValuePrice = parseFloat(_("value_L3").value);
            } else if (selectedValue == "$500,00 - $1000,00") {
                packageValuePrice = parseFloat(_("value_L4").value);
            } else if (selectedValue == "$1000,00 - Above") {
                packageValuePrice = parseFloat(_("value_L5").value);
            }
            return packageValuePrice;
        }


        function getQuantityPrice() {
            var packageQuantityPrice = 0;
            var totalQuantity = parseFloat(_("totalT").value);
            var selectedQuantity = parseFloat(_("package_quantity").value);
            packageQuantityPrice = totalQuantity * selectedQuantity;

            return packageQuantityPrice;
        }

        function getCarPrice() {
            var CarPrice = 0;
            var selectedCar = _("transport").value;
            if (selectedCar == "Car") {
                CarPrice = parseFloat(_("totalC").value);
            } else if (selectedCar == "Motorbike") {
                CarPrice = parseFloat(_("totalBike").value);
            } else if (selectedCar == "Van") {
                CarPrice = parseFloat(_("totalVan").value);
            }
            return CarPrice;
        }

        function getInsurancePrice() {
            var InsurancePrice = 0;
            var rate_price_in = _('price_in').value;
            var zim_rtgs_rate = _('zim_dollar_rate').value;
            var totPricett = parseFloat(_('tpp').value);
            var InsurancePercentage = parseFloat(_("totalIn").value);
            var selectedInsurance = _("insurance").value;
            if (selectedInsurance == "yes") {
                if (rate_price_in == "RTGS") {
                    totPricett = parseFloat(totPricett / zim_rtgs_rate);
                }
                InsurancePrice = (InsurancePercentage / 100) * totPricett;
            } else if (selectedInsurance == "no") {
                InsurancePrice = 0;
            }
            return InsurancePrice;
        }

        function getInterCityPrice() {
            var InterCityPrice = 0;
            var area_deliva = _("area_d").value;

            if (area_deliva == "Harare") {
                InterCityPrice = parseFloat(_("harare").value);
            } else if (area_deliva == "Bulawayo") {
                InterCityPrice = parseFloat(_("bulawayo").value);
            } else if (area_deliva == "Banket") {
                InterCityPrice = parseFloat(_("banket").value);
            } else if (area_deliva == "Karoi") {
                InterCityPrice = parseFloat(_("karoi").value);
            } else if (area_deliva == "Chinhoyi") {
                InterCityPrice = parseFloat(_("chinhoyi").value);
            } else if (area_deliva == "Chegutu") {
                InterCityPrice = parseFloat(_("chegutu").value);
            } else if (area_deliva == "Gweru") {
                InterCityPrice = parseFloat(_("gweru").value);
            } else if (area_deliva == "Kwekwe") {
                InterCityPrice = parseFloat(_("kwekwe").value);
            } else if (area_deliva == "Kadoma") {
                InterCityPrice = parseFloat(_("kadoma").value);
            } else if (area_deliva == "Mutare") {
                InterCityPrice = parseFloat(_("mutare").value);
            } else if (area_deliva == "Kariba") {
                InterCityPrice = parseFloat(_("kariba").value);
            } else if (area_deliva == "Plumtree") {
                InterCityPrice = parseFloat(_("plumtree").value);
            } else if (area_deliva == "Gwanda") {
                InterCityPrice = parseFloat(_("gwanda").value);
            } else if (area_deliva == "Zvishavane") {
                InterCityPrice = parseFloat(_("zvishavane").value);
            } else if (area_deliva == "Masvingo") {
                InterCityPrice = parseFloat(_("masvingo").value);
            } else if (area_deliva == "Beitbridge") {
                InterCityPrice = parseFloat(_("beitbridge").value);
            } else if (area_deliva == "Mvuma") {
                InterCityPrice = parseFloat(_("mvuma").value);
            } else if (area_deliva == "Chivhu") {
                InterCityPrice = parseFloat(_("chivhu").value);
            } else if (area_deliva == "Bubi") {
                InterCityPrice = parseFloat(_("bubi").value);
            } else if (area_deliva == "Chiredzi") {
                InterCityPrice = parseFloat(_("chiredzi").value);
            } else if (area_deliva == "Hwange") {
                InterCityPrice = parseFloat(_("hwange").value);
            } else if (area_deliva == "Rusape") {
                InterCityPrice = parseFloat(_("rusape").value);
            } else if (area_deliva == "Bindura") {
                InterCityPrice = parseFloat(_("bindura").value);
            } else if (area_deliva == "Mt Darwin") {
                InterCityPrice = parseFloat(_("mtDarwin").value);
            } else if (area_deliva == "Mvurwi") {
                InterCityPrice = parseFloat(_("mvurwi").value);
            } else if (area_deliva == "Victoria Falls") {
                InterCityPrice = parseFloat(_("victoriaFalls").value);
            } else if (area_deliva == "Binga") {
                InterCityPrice = parseFloat(_("binga").value);
            } else if (area_deliva == "Other") {
                InterCityPrice = parseFloat(_("other").value);
            }
            return InterCityPrice;
        }

        function inprecise_round(value, decPlaces) {
            return Math.round(value * Math.pow(10, decPlaces)) / Math.pow(10, decPlaces);
        }

        function precise_round(value, decPlaces) {
            var val = value * Math.pow(10, decPlaces);
            var fraction = (Math.round((val - parseInt(val)) * 10) / 10);

            //this line is for consistency with .NET Decimal.Round behavior
            // -342.055 => -342.06
            if (fraction == -0.5) fraction = -0.6;

            val = Math.round(parseInt(val) + fraction) / Math.pow(10, decPlaces);
            return val;
        }

        function calculateTotal(chk = 0) {

            var price_in = _('price_in').value;
            var zim_dollar_rate = _('zim_dollar_rate').value;
            var area_pick = _('area_pick').value;
            var area_d = _('area_d').value;
            var intaCityP = getInterCityPrice()
            var WeightRangeP = getWeightRange();
            var InsPrice = getInsurancePrice();
            var actaulPrice = getValuePrice() + getCarPrice() + getQuantityPrice() + getInsurancePrice();
            var totDist = parseFloat(_('outputDiv').value);
            var outputDistt = parseFloat(_('outputDist').value);
            if (area_pick != area_d) {
                var roundTp = parseFloat(WeightRangeP + intaCityP + InsPrice);
                var roundTpp = parseFloat(WeightRangeP + intaCityP + InsPrice);
                var min = parseFloat(_("min_parcel").value);

                if (roundTpp < min) {
                    roundTpp = min;
                }
                if (roundTp < min) {
                    roundTp = min;
                }
            } else if (area_pick == area_d) {
                var roundTp = totDist + actaulPrice;
                var roundTpp = totDist + actaulPrice;
                var min = parseFloat(_("min_parcel").value);
                if (roundTpp < min) {
                    roundTpp = min;
                }
                if (roundTp < min) {
                    roundTp = min;
                }
            }
            var dis = _('c_disc').value;

            if (dis == '') {
                dis = 0;
            }
            // alert(dis);


            if (price_in == "RTGS") {
                if (chk > 0) {
                    $("#paymentOpt option[value='USD']").remove();
                    $("#paymentOpt option[value='RTGS']").remove();
                    if (showPaynow == 1) {
                        $("#paymentOpt").append('<option value="RTGS" selected="selected">Pay Online in Local CURRENCY (RTGS)</option>');
                    }
                }
                dis1 = dis * zim_dollar_rate;
                // alert(dis1);
                roundTp = roundTp * zim_dollar_rate;
                roundTpp = roundTpp * zim_dollar_rate;
                // alert(roundTpp);
                // alert(roundTp);
                // alert(dis);
                roundTp = roundTp - dis1;
                roundTpp = roundTpp - dis1;

            } else if (price_in == "USD") {
                if (chk > 0) {
                    $("#paymentOpt option[value='USD']").remove();
                    $("#paymentOpt option[value='RTGS']").remove();
                    if (showStripe == 1) {
                        $("#paymentOpt").append('<option value="USD" selected="selected">Pay via Stripe (Online USD)</option>');
                    }
                    if (showPaynow == 1) {
                        $("#paymentOpt").append('<option value="RTGS">Pay Online in Local CURRENCY (RTGS)</option>');
                    }
                }



                roundTp = roundTp;
                roundTpp = roundTpp;
                // alert(roundTpp);
                //   alert(roundTp);
                // alert(dis);
                roundTp = roundTp - dis;
                roundTpp = roundTpp - dis;
            }

            _('tp_phase1').innerHTML = roundTp.toFixed(2);
            _('tp_phase2').innerHTML = roundTp.toFixed(2);
            _('tp').innerHTML = roundTp.toFixed(2);
            _('tpp').value = roundTpp.toFixed(2);

        }

        function getCouponDiscount() {
            var coupon = _("coupon").value;
            var userid = <?php echo $_SESSION['Userid']; ?>;
            var c_totaAmount = document.getElementById('tp_phase1').innerHTML;
            $.ajax({
                url: 'booking.php',
                type: 'POST',
                data: 'userid=' + userid + '&coupon=' + coupon,
                success: function(result) {

                    if (result != '') {
                        var obj = JSON.parse(result);
                        var c_type = obj['coupontype'];
                        var c_amount = obj['coupondiscount'];

                        if (c_type == 1) {
                            var c_rate = c_amount / 100 * c_totaAmount;
                            var afterDisc = parseFloat(c_totaAmount - c_rate);
                            var c_afterDisc = afterDisc.toFixed(2);
                            _('tp_phase1').innerHTML = c_afterDisc;
                            _('tp_phase2').innerHTML = c_afterDisc;
                            _('tp').innerHTML = c_afterDisc;
                            _('c_disc').value = c_rate;

                            $("#coupon").prop("disabled", true);

                        } else {

                            var afterDisc = parseFloat(c_totaAmount - c_amount);
                            var c_afterDisc = afterDisc.toFixed(2);
                            _('tp_phase1').innerHTML = c_afterDisc;
                            _('tp_phase2').innerHTML = c_afterDisc;
                            _('tp').innerHTML = c_afterDisc;
                            _('c_disc').value = c_amount;
                            $("#coupon").prop("disabled", true);





                        }
                    } else {

                        _('tp_phase1').innerHTML = c_totaAmount;
                        _('tp_phase2').innerHTML = c_totaAmount;

                    }
                }
            });
        }



        function calcDistance(response, status) {
            var totalp = _("totalp").value;
            var totalW = parseFloat(_("totalW").value);
            var totalC = parseFloat(_("totalC").value);
            var totalT = parseFloat(_("totalT").value);
            var totalIn = parseFloat(_("totalIn").value);
            var totalB = parseFloat(_("totalB").value);
            if (status != google.maps.DistanceMatrixStatus.OK) {
                alert('Error was: ' + status);
            } else {
                var origins = response.originAddresses;
                var destinations = response.destinationAddresses;
                deleteOverlays();

                for (var i = 0; i < origins.length; i++) {
                    var results = response.rows[i].elements;
                    addMarker(origins[i], false);
                    for (var j = 0; j < results.length; j++) {
                        addMarker(destinations[j], true);

                        var str = (results[j].distance.text);

                        _('outputDiv').value = parseFloat(str.replace(/[^\d\.]*/g, '')) * totalp;
                        _('outputDist').value = (results[j].distance.text);
                    }
                }
            }
        }

        function addMarker(location, isDestination) {
            var icon;
            if (isDestination) {
                icon = destinationIcon;
            } else {
                icon = originIcon;
            }
            geocoder.geocode({
                'address': location
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    bounds.extend(results[0].geometry.location);
                    map.fitBounds(bounds);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        icon: icon
                    });
                    markersArray.push(marker);
                } else {
                    alert('Geocode was not successful for the following reason: ' +
                        status);
                }
            });
        }

        function deleteOverlays() {
            for (var i = 0; i < markersArray.length; i++) {
                markersArray[i].setMap(null);
            }
            markersArray = [];
        }

        google.maps.event.addDomListener(window, 'load', initialize);

        function submitForm() {
            transport = _("transport").value;
            note = _("note").value;
            weight_of_package = _("weight_of_package").value;
            value_of_package = _("value_of_package").value;
            insurance = _("insurance").value;
            package_quantity = _("package_quantity").value;
            harm = _("harm").value;

            if (transport.length < 3 && weight_of_package.length < 4 && value_of_package.length < 4 && insurance.length < 4 && package_quantity.length < 4) {
                alert("Please fill in the fields");
                exit;
            } else if (harm.checked == false) {
                _("harmstatus").innerHTML = "Please check the box to agree with our terms!";
                die;
            } else {
                _("phase3").style.display = "block";
                _("multiphase").method = "post";
                _("multiphase").action = "submit_parser1.php";
                _("multiphase").submit();
            }
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
            _("progressBar").value = 50;
        }
    </script>

    <script type="text/javascript">
        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */
                (document.getElementById('autocomplete')), {
                    types: ['geocode']
                });

            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();

        }

        function sho_email() {
            _("sho_fo").style.display = "block";
        }

        function SendQuote() {
            var address_e = _("autocomplete").value;
            var drop_address_e = _("drop_address").value;
            var email_e = _("email_quote").value;
            var name_e = _("name").value;
            var Total_price = _('tpp').value;
            var distance_e = _("outputDist").value;
            var transport_e = _("transport").value;
            var value_e = _("value_of_package").value;
            var weight_e = _("weight_of_package").value;
            var quantity_e = _("package_quantity").value;
            var insure_e = _("insurance").value;
            var delivery_type_e = "Taxi";
            //var acc_id_e = $('#acc_id');
            var data = "address=" + address_e + "&drop_address=" + drop_address_e + "&email=" + email_e + "&value=" + value_e +
                "&Total_price=" + Total_price + "&distance=" + distance_e + "&transport=" + transport_e + "&delivery_type=" + delivery_type_e + "&weight=" + weight_e + "&quantity=" + quantity_e + "&insurance=" + insure_e;

            if ($.trim(address_e).length == 0 || $.trim(drop_address_e).length == 0) {
                _("error").innerhtml('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; All fields must be completed!</div>');
                _("error").fadeOut(5000);
                exit();
            }
            $.ajax({

                type: 'POST',
                url: 'email_quote.php',
                data: data,
                beforeSend: function() {
                    $("#error").fadeOut();
                    $("#confirm_btn").html('processing ...');
                    //alert(data);
                },
                success: function(data) {
                    alert(data);
                    if (data == "OK") {
                        alert("Quote sent!");
                    } else if (data == "error") {
                        alert("Error");
                    } else if (data == "1") {

                        _("error").fadeIn(500, function() {
                            _("error").innerHTML('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error quote was not sent please try again!</div>');

                            $("#acc_btn").html('Create Program3');

                        });

                    }

                }

            });
            alert("sent!");
            _("sho_fo").style.display = "none";
        }
    </script>

</head>

<body>

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
                    <h1>Book A Delivery</h1>
                </div>
                <div class="span6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                        <li><a href="#">Pages</a> <span class="divider">/</span></li>
                        <li class="active">Registration</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- / .title -->

    <?php
    $get = "SELECT * FROM `prizelist` WHERE company_name='merchant'";

    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $ID = $row_type['ID'];
        $zim_dollar_rate = $row_type['zim_dollar_rate'];
        $Price_per_km = $row_type['Price_per_km'];
        $Car_per_km = $row_type['Car_per_km'];
        $weight = $row_type['Weight'];
        $Insurance = $row_type['Insurance'];
        $Base_price = $row_type['Base_price'];
        $Cost_per_item = $row_type['Cost_per_item'];
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
        $Chinhoyi = $row_type['Chinhoyi'];
        $VictoriaFalls = $row_type['VictoriaFalls'];
    }


    ?>
    <?php
    // var_dump($Connect);
    // die;
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
    }
    ?>
    <?php
    $user = $_SESSION['MM_Username'];
    $name = "";
    $get = "SELECT * FROM `businesspartners` WHERE email='$user'";
    $run = mysqli_query($Connect, $get);

    while ($row_type = mysqli_fetch_array($run)) {
        $name = $row_type['businessName'];
        $affiliate_no = $row_type['affiliate_no'];
        $email = $row_type['email'];
        $phone = $row_type['phone'];
    }
    if ($name == "") {
        $get_user = "SELECT * FROM `users` WHERE email='$user'";
        $run_user = mysqli_query($Connect, $get_user);

        while ($row_type = mysqli_fetch_array($run_user)) {
            $name = $row_type['Name'];
            $affiliate_no = $row_type['affiliate_no'];
            $email = $row_type['email'];
            $phone = $row_type['phone'];
        }
    }
    ?>

    <section class="container">
        <!--- <div id="error"></div> --->
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <fieldset class="registration-form col-md-12">
                    <h3 id="status">Step 1 of 3...</h3>
                    <progress id="progressBar" class="progress-bar-warning" value="0" max="100" style="width:100%;"></progress>


                    <form action="<?php echo $editFormAction; ?>" method="POST" id="multiphase" onsubmit="showLocation();calcRoute(); return false" name="bookingform">
                        <!--------------------------------------------- Phase 1 -------------------------------------------------->
                        <div id="phase1">
                            <input id="totalp" value="<?php echo $Price_per_km; ?>" type="hidden">
                            <input id="totalBike" value="<?php echo $bike; ?>" type="hidden">
                            <input id="totalVan" value="<?php echo $van; ?>" type="hidden">
                            <input id="totalW" value="<?php echo $weight; ?>" type="hidden">
                            <input id="totalC" value="<?php echo $Car_per_km; ?>" type="hidden">
                            <input id="totalT" value="<?php echo $Cost_per_item; ?>" type="hidden">
                            <input id="totalIn" value="<?php echo $Insurance; ?>" type="hidden">
                            <input id="totalB" value="<?php echo $Base_price; ?>" type="hidden">
                            <input id="min_parcel" value="<?php echo $min_parcel; ?>" type="hidden">
                            <input id="min_freight" value="<?php echo $min_freight; ?>" type="hidden">
                            <input id="value_L1" value="<?php echo $value_L1; ?>" type="hidden">
                            <input id="value_L2" value="<?php echo $value_L2; ?>" type="hidden">
                            <input id="value_L3" value="<?php echo $value_L3; ?>" type="hidden">
                            <input id="value_L4" value="<?php echo $value_L4; ?>" type="hidden">
                            <input id="value_L5" value="<?php echo $value_L5; ?>" type="hidden">
                            <input id="zim_dollar_rate" value="<?php echo $zim_dollar_rate; ?>" type="hidden">
                            <!--------------------------City Prices----------------------->
                            <input id="harare" value="<?php echo $Harare; ?>" type="hidden">
                            <input id="bulawayo" value="<?php echo $Bulawayo; ?>" type="hidden">
                            <input id="banket" value="<?php echo $Banket; ?>" type="hidden">
                            <input id="chinhoyi" value="<?php echo $Chinhoyi; ?>" type="hidden">
                            <input id="karoi" value="<?php echo $Karoi; ?>" type="hidden">
                            <input id="mutare" value="<?php echo $Mutare; ?>" type="hidden">
                            <input id="kariba" value="<?php echo $Kariba; ?>" type="hidden">
                            <input id="kwekwe" value="<?php echo $Kwekwe; ?>" type="hidden">
                            <input id="kadoma" value="<?php echo $Kadoma; ?>" type="hidden">
                            <input id="chegutu" value="<?php echo $Chegutu; ?>" type="hidden">
                            <input id="gweru" value="<?php echo $Gweru; ?>" type="hidden">
                            <input id="plumtree" value="<?php echo $Plumtree; ?>" type="hidden">
                            <input id="gwanda" value="<?php echo $Gwanda; ?>" type="hidden">
                            <input id="zvishavane" value="<?php echo $Zvishavane; ?>" type="hidden">
                            <input id="masvingo" value="<?php echo $Masvingo; ?>" type="hidden">
                            <input id="beitbridge" value="<?php echo $Beitbridge; ?>" type="hidden">
                            <input id="mvuma" value="<?php echo $Mvuma; ?>" type="hidden">
                            <input id="vhivhu" value="<?php echo $Chivhu; ?>" type="hidden">
                            <input id="bubi" value="<?php echo $Bubi; ?>" type="hidden">
                            <input id="chiredzi" value="<?php echo $Chiredzi; ?>" type="hidden">
                            <input id="hwange" value="<?php echo $Hwange; ?>" type="hidden">
                            <input id="rusape" value="<?php echo $Rusape; ?>" type="hidden">
                            <input id="bindura" value="<?php echo $Bindura; ?>" type="hidden">
                            <input id="mtDarwin" value="<?php echo $MtDarwin; ?>" type="hidden">
                            <input id="mvurwi" value="<?php echo $Mvurwi; ?>" type="hidden">
                            <input id="victoriaFalls" value="<?php echo $VictoriaFalls; ?>" type="hidden">
                            <input id="binga" value="<?php echo $Binga; ?>" type="hidden">
                            <input id="other" value="<?php echo $other; ?>" type="hidden">
                            <!--------------------------Weight Prices----------------------->
                            <input id="weight_range" value="<?php echo $weight_range; ?>" type="hidden">
                            <input id="weight_range1" value="<?php echo $weight_range1; ?>" type="hidden">
                            <input id="weight_range2" value="<?php echo $weight_range2; ?>" type="hidden">
                            <input id="weight_range3" value="<?php echo $weight_range3; ?>" type="hidden">
                            <input id="weight_range4" value="<?php echo $weight_range4; ?>" type="hidden">
                            <input id="weight_range5" value="<?php echo $weight_range5; ?>" type="hidden">
                            <input id="weight_range6" value="<?php echo $weight_range6; ?>" type="hidden">
                            <input id="weight_range7" value="<?php echo $weight_range7; ?>" type="hidden">
                            <input id="weight_range8" value="<?php echo $weight_range8; ?>" type="hidden">
                            <input id="weight_range9" value="<?php echo $weight_range9; ?>" type="hidden">
                            <input id="weight_range10" value="<?php echo $weight_range10; ?>" type="hidden">
                            <input id="weight_range11" value="<?php echo $weight_range11; ?>" type="hidden">
                            <input id="weight_range12" value="<?php echo $weight_range12; ?>" type="hidden">
                            <input id="weight_range13" value="<?php echo $weight_range13; ?>" type="hidden">
                            <input id="weight_range14" value="<?php echo $weight_range14; ?>" type="hidden">
                            <input id="weight_range15" value="<?php echo $weight_range15; ?>" type="hidden">
                            <input id="weight_range16" value="<?php echo $weight_range16; ?>" type="hidden">
                            <input id="weight_range17" value="<?php echo $weight_range17; ?>" type="hidden">
                            <input id="weight_range18" value="<?php echo $weight_range18; ?>" type="hidden">
                            <input id="weight_range19" value="<?php echo $weight_range19; ?>" type="hidden">
                            <input id="weight_range20" value="<?php echo $weight_range20; ?>" type="hidden">

                            <input type="hidden" name="affiliate_no" class="form-control" value="<?php echo $affiliate_no; ?>" required />
                            <h2>Enter Pick Up Details!</h2>
                            <input type="hidden" class="input-block-level" placeholder="Full Name" value="<?php echo $name; ?>" id="name" name="name">
                            <span style="color:red" id="namestatus"></span>
                            <input type="hidden" class="input-block-level" placeholder="email address" value="<?php echo $email; ?>" id="email" name="email">
                            <span style="color:red" id="emailstatus"></span>
                            <input type="hidden" class="input-block-level" placeholder="Phone Number" value="<?php echo $phone; ?>" id="phone" name="phone">
                            <span style="color:red" id="phonestatus"></span>
                            <label>Area of Pick-Up</label>
                            <select name="city" id="area_pick" class="input-block-level" required>
                                <option></option>
                                <option>Harare</option>
                                <option>Bulawayo</option>
                                <option>Chinhoyi</option>
                                <option>Mutare</option>
                                <option>Kariba</option>
                                <option>Kwekwe</option>
                                <option>Kadoma</option>
                                <option>Chegutu</option>
                                <option>Gweru</option>
                                <option>Plumtree</option>
                                <option>Gwanda</option>
                                <option>Zvishavane</option>
                                <option>Masvingo</option>
                                <option>Beitbridge</option>
                                <option>Chivhu</option>
                                <option>Chiredzi</option>
                                <option>Bindura</option>
                                <option>Victoria Falls</option>
                                <option>Other</option>
                            </select>

                            <label>Pick Address</label>
                            <input id="autocomplete" class="input-block-level" placeholder="Enter your address" type="text" name="address" onFocus="geolocate()">
                            <span style="color:red" id="addstatus"></span>

                            <!----------------------Delivery-------------------------->
                            <label>Area of delivery</label>
                            <select name="area_delivery" id="area_d" class="input-block-level">
                                <option></option>
                                <option>Harare</option>
                                <option>Bulawayo</option>
                                <option>Chinhoyi</option>
                                <option>Mutare</option>
                                <option>Kariba</option>
                                <option>Kwekwe</option>
                                <option>Kadoma</option>
                                <option>Chegutu</option>
                                <option>Gweru</option>
                                <option>Plumtree</option>
                                <option>Gwanda</option>
                                <option>Zvishavane</option>
                                <option>Masvingo</option>
                                <option>Beitbridge</option>
                                <option>Chivhu</option>
                                <option>Chiredzi</option>
                                <option>Bindura</option>
                                <option>Victoria Falls</option>
                                <option>Other</option>
                            </select>
                            <label>Delivery Address</label>
                            <input type="text" class="input-block-level" placeholder="Delivery Address" id="drop_address" name="drop_address" onFocus="geolocate()">
                            <span style="color:red" id="addstatus2"></span>
                            <!----------------------End Delivery-------------------------->

                            <label>Weight of Package</label>
                            <select class="input-block-level" name="weight_of_package" id="weight_of_package" onchange="calculateTotal();" onFocus="shoPricePhase1()">
                                <option></option>
                                <option value="0-1 KG">0-1 KG</option>
                                <option value="1.1-2 KG">1.1-2 KG</option>
                                <option value="2.1-3 KG">2.1-3 KG</option>
                                <option value="3.1-4 KG">3.1-4 KG</option>
                                <option value="4.1-5 KG">4.1-5 KG</option>
                                <option value="5.1-6 KG">5.1-6 KG</option>
                                <option value="6.1-7 KG">6.1-7 KG</option>
                                <option value="7.1-8 KG">7.1-8 KG</option>
                                <option value="8.1-9 KG">8.1-9 KG</option>
                                <option value="9.1-10 KG">9.1-10 KG</option>
                                <option value="10.1-11 KG">10.1-11 KG</option>
                                <option value="11.1-12 KG">11.1-12 KG</option>
                                <option value="12.1-13 KG">12.1-13 KG</option>
                                <option value="13.1-14 KG">13.1-14 KG</option>
                                <option value="14.1-15 KG">14.1-15 KG</option>
                                <option value="15.1-16 KG">15.1-16 KG</option>
                                <option value="16.1-17 KG">16.1-17 KG</option>
                                <option value="17.1-18 KG">17.1-18 KG</option>
                                <option value="18.1-19 KG">18.1-19 KG</option>
                                <option value="19.1-20 KG">19.1-20 KG</option>
                                <option value="more">more</option>
                            </select>
                            <div id="sho_more" style="display:none">
                                <input class="input-block-level" placeholder="Enter package weight" type="text" name="more_weight_of_package" id="more_weight_of_package" onChange="calculateTotal();">
                            </div>
                            <span style="color:red" id="weight"></span>
                            <label>Value of Package</label>
                            <select class="input-block-level" name="value_of_package" id="value_of_package" onchange="calculateTotal(); ">
                                <option></option>
                                <option value="$1,00 - $50,00">$1,00 - $50,00</option>
                                <option value="$50,00 - $100,00">$50,00 - $100,00</option>
                                <option value="$100,00 - $500,00">$100,00 - $500,00</option>
                                <option value="$500,00 - $1000,00">$500,00 - $1000,00</option>
                                <option value="$1000,00 - Above">$1000,00 - Above</option>
                            </select>
                            <span style="color:red" id="valueofpackage"></span>

                            <label>Quantity of Package</label>
                            <select class="input-block-level" name="package_quantity" id="package_quantity" onchange="calculateTotal()">
                                <option></option>
                                <option value="1">1 Package</option>
                                <option value="2">2 Packages</option>
                                <option value="3">3 Packages</option>
                                <option value="4">4 Packages</option>
                                <option value="5">5 Packages</option>
                                <option value="6">6 Packages</option>
                                <option value="7">7 Packages</option>
                                <option value="8">8 Packages</option>
                                <option value="9">9 Packages</option>
                                <option value="10">10 Packages</option>
                                <option value="11">11 Packages</option>
                                <option value="12">12 Packages</option>
                                <option value="13">13 Packages</option>
                                <option value="14">14 Packages</option>
                                <option value="15">15 Packages</option>
                                <option value="16">16 Packages</option>
                                <option value="17">17 Packages</option>
                                <option value="18">18 Packages</option>
                                <option value="19">19 Packages</option>
                                <option value="15">15 Packages</option>
                                <option value="16">16 Packages</option>
                                <option value="17">17 Packages</option>
                                <option value="18">18 Packages</option>
                                <option value="19">19 Packages</option>
                                <option value="15">15 Packages</option>
                                <option value="16">16 Packages</option>
                                <option value="17">17 Packages</option>
                                <option value="18">18 Packages</option>
                                <option value="19">19 Packages</option>
                                <option value="20">20 Packages</option>
                                <option value="21">21 Packages</option>
                                <option value="22">22 Packages</option>
                                <option value="23">23 Packages</option>
                                <option value="24">24 Packages</option>
                                <option value="25">25 Packages</option>
                            </select>
                            <span style="color:red" id="quantity"></span>
                            <label>Transport</label>
                            <select name="transport" id="transport" required="required" class="input-block-level" onchange="calculateTotal()">
                                <option></option>
                                <option value="Car">Car </option>
                                <option value="Motorbike">Motorbike</option>
                                <option value="Van">Van</option>
                            </select>
                            <span style="color:red" id="transport"></span>

                            <label>Buy Insurance(optional)</label>
                            <select name="insurance" id="insurance" class="input-block-level" onchange="calculateTotal()">
                                <option></option>
                                <option value="yes">Yes</option>
                                <option value="no">no</option>
                            </select>
                            <input type="hidden" name="c_disc" id="c_disc">
                            <label>Coupon</label>
                            <input class="input-block-level" placeholder="Enter your Coupon" type="text" name="coupon" id="coupon" onkeyup="getCouponDiscount()" onFocus="geolocate()">
                            <span style="color:red" id=""></span>

                            <b style="font-size:18px;" class="btn-default btn-large btn-block col-md-12">Total price:$<span id="tp_phase1" style="font-size:18px;"></span>
                                <select id="price_in" class="btn btn-small" onchange="calculateTotal(1);" style="width:75px;">
                                    <option value="USD">USD</option>
                                    <option value="RTGS">RTGS</option>
                                </select>
                            </b>
                            <a class="btn btn-info btn-large btn-block col-md-5 " onclick="sho_email();">Email Quote </a>
                            <button class="btn btn-success btn-large btn-block col-md-5 pull-right" onclick="processPhase1()">Next Step</button>

                            <span id="sho_fo">
                                <div class="span4">
                                    <label>Email</label>
                                    <input type="text" id="email_quote" class="input-block-level" placeholder="name@domain.com" name="email_invo2">
                                    <button class="btn btn-info btn-small btn-block" onClick="SendQuote()">send</button>

                                </div>
                            </span>

                        </div>
                        <!--------------------------------------------- Phase 2 -------------------------------------------------->
                        <div id="phase2">
                            <div align="center">
                                <h4>Pick Up Details</h4>
                                Address:<span class="glyphicon glyphicon-map-marker"></span><span id="display_address" style="text-transform: uppercase"></span><br>
                                <span style=" font-size: medium;"> Date: </span> <span class="icon-calendar"></span> <span id="display_pickupdate" style="text-transform: uppercase;"></span>
                                <span style=" font-size: medium;"> Time: </span> <span class="icon-time"></span> <span id="display_pickuptime" style="text-transform: uppercase;"></span>
                                <span><a href="#" onclick="change_phase1()" style="color:orange;">Change</a></span><br /><br />
                            </div>
                            <h2> Enter drop off details</h2>

                            Enter Pick Up Date
                            <input type="date" class="input-block-level" id="date" name="date">
                            <span style="color:red" id="datestatus"></span>
                            <select name="time" id="time" class="input-block-level">
                                <option>Pick Up Time</option>
                                <option>6:00 am - to - 7:00 am</option>
                                <option>7:00 am - to - 8:00 am</option>
                                <option>8:00 am - to - 9:00 am</option>
                                <option>9:00 am - to - 10:00 am</option>
                                <option>10:00 am to - 11:00 am</option>
                                <option>11:00 am - to - 12:00 pm</option>
                                <option>12:00 pm - to - 1:00 pm</option>
                                <option>1:00 pm - to - 2:00 pm</option>
                                <option>2:00 pm - to - 3:00 pm</option>
                                <option>3:00 pm - to - 4:00 pm</option>
                                <option>4:00 pm - to - 5:00 pm</option>
                                <option>5:00 pm - to - 6:00 pm</option>
                                <option>6:00 pm - to - 7:00 pm</option>
                            </select>
                            <span style="color:red"></span>
                            Drop Off Date.
                            <input type="date" class="input-block-level" name="drop_date" id="drop_date">
                            <span style="color:red" id="datestatus2"></span>

                            <select name="drop_time" id="drop_time" class="input-block-level">
                                <option>Drop off Time</option>
                                <option>6:00 am - to - 7:00 am</option>
                                <option>7:00 am - to - 8:00 am</option>
                                <option>8:00 am - to - 9:00 am</option>
                                <option>9:00 am - to - 10:00 am</option>
                                <option>10:00 am to - 11:00 am</option>
                                <option>11:00 am - to - 12:00 pm</option>
                                <option>12:00 pm - to - 1:00 pm</option>
                                <option>1:00 pm - to - 2:00 pm</option>
                                <option>2:00 pm - to - 3:00 pm</option>
                                <option>3:00 pm - to - 4:00 pm</option>
                                <option>4:00 pm - to - 5:00 pm</option>
                                <option>5:00 pm - to - 6:00 pm</option>
                                <option>6:00 pm - to - 7:00 pm</option>
                            </select>
                            <span style="color:red" id="timestatus2"></span>

                            <label>Full Name (receiver)</label>
                            <input type="text" class="input-block-level" placeholder="Full Name" id="drop_name" name="drop_name">
                            <span style="color:red" id="namestatus2"></span>
                            <label>Phone Number (receiver)</label>
                            <input type="tel" class="input-block-level" placeholder="Phone Number" value="+263" id="drop_phone" name="drop_phone">
                            <span style="color:red" id="phonestatus2"></span>
                            <label>Note for the driver/Package Description</label>
                            <textarea rows="6" class="input-block-level" placeholder="Add a note for the driver" id="note" name="note">please be on time</textarea>
                            <span style="color:red" id="msg"></span>

                            <b style="font-size:18px;">Total price:$</b><span id="tp_phase2" style="font-size:18px;"></span>
                            <button class="btn btn-success btn-large btn-block" onclick="processPhase2()" name="calc">Next Step</button>
                        </div>
                        <!--------------------------------------------- Phase 3 -------------------------------------------------->
                        <div id="phase3">
                            <div align="center">
                                <h4>Pick Up Details</h4>
                                Address: <span class="glyphicon glyphicon-map-marker"></span> <span id="display_address2" style="text-transform: uppercase"></span><br />
                                <span style=" font-size: medium;"> Date: </span> <span class="icon-calendar"></span> <span id="display_pickupdate2" style="text-transform: uppercase;"></span>
                                <span style=" font-size: medium;"> Time: </span> <span class="icon-time"></span> <span id="display_pickuptime2" style="text-transform: uppercase;"></span>
                                <span><a href="#" onclick="change_phase1()" style="color:orange;">change</a></span><br><br>
                                <h4>Drop Off Details</h4>
                                Address: <span class="glyphicon glyphicon-map-marker"></span> <span id="display_drop_address" style="text-transform: uppercase"></span> <br />
                                <span style=" font-size: medium;"> Date: </span> <span class="icon-calendar"></span> <span id="display_dropdate" style="text-transform: uppercase;"></span>
                                <span style=" font-size: medium;"> Time: </span> <span class="icon-time"></span> <span id="display_droptime" style="text-transform: uppercase;"></span>
                                <span><a href="#" onclick="change_phase2()" style="color:orange;">change</a></span><br /><br />
                                <strong>Select Payment Method</strong>
                                <select name="paymentOpt" id="paymentOpt" required="required" class="input-block-level" style="width: 50%;">
                                    <option value="">Select one</option>
                                    <option value="USD" selected="selected">Pay via Stripe (Online USD)</option>
                                    <option value="RTGS">Pay Online in Local CURRENCY (RTGS)</option>
                                    <option value="cash">Pay Cash at Pickup</option>
                                </select>
                            </div>
                            <br>


                            <input type="hidden" placeholder="Order Number" name="order_number" class="form-control" value="<?php echo $a = rand(10000, 99999); ?>" required />
                            <input type="hidden" name="vehicle_type" class="form-control" value="Parcel Delivery" required />
                            <input type="hidden" id="outputDiv">
                            <input type="hidden" id="outputDist" name="distance">
                            <input type="hidden" id="tpp" name="Total_price">
                            <b style="font-size:18px;">Total price:$</b><span id="tp" style="font-size:18px;"></span>
                            <div style="background-color:#193b50; color:#fff;" class="btn btn-default btn-file">
                                <input type="checkbox" class="input-checkbox" name="harm" id="harm" value="nothing harmful" required="required"> I hereby declare that the goods I am sending are not illegal contents or anything that will cause harm to the health, life and welfare of people, such as illegal drugs, contraband, explosives etc.
                            </div><br /><br />
                            <span id="harmstatus" style="color:red"></span>
                            <input type="submit" class="btn btn-success btn-large btn-block" onclick="submitForm()" value="Book Delivery">

                            Save your addresses by clicking this link <a href="#" style="color:orange;">Save</a>

                        </div>
                        <input type="hidden" name="MM_insert" value="bookingform">
                    </form>


                </fieldset>
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
            administrative_area_level_3: 'short_name',
            country: 'long_name',
            componentRestrictions: GeocoderComponentRestrictions,
            postal_code: 'short_name'
        };
        var op = {
            componentRestrictions: {
                country: "zw"
            }
        };

        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                (document.getElementById('autocomplete')), {
                    types: ['establishment' | 'address'],
                    componentRestrictions: {
                        country: "zw"
                    }
                });
            drop_address = new google.maps.places.Autocomplete(
                (document.getElementById('drop_address')), {
                    types: ['establishment' | 'address'],
                    componentRestrictions: {
                        country: "zw"
                    }
                });
            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);
            drop_address.addListener('place_changed', fillInAddress);
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
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyAASD--ei5pvGlTxWLBswb4z4q_4J2vQS4&sensor=false&libraries=places&callback=initAutocomplete" type="text/javascript"></script>

    <div id="map-canvas"></div>
    <script src="http://static.jsbin.com/js/render/edit.js?4.0.4"></script>
    <script>
        jsbinShowEdit && jsbinShowEdit({
            "static": "http://static.jsbin.com",
            "root": "http://jsbin.com"
        });
    </script>
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-1656750-34', 'auto');
        ga('require', 'linkid', 'linkid.js');
        ga('require', 'displayfeatures');
        ga('send', 'pageview');
    </script>
    <!-- /#registration-page -->

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
                            <strong>Email: </strong> admin@merchantcouriers.com
                        </li>
                        <li>
                            <i class="icon-globe"></i>
                            <strong>Website:</strong> www.merchantcouriers.com
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
                            <li><a href="blog.php">News & Updates</a></li>
                            <li><a href="#">We're Hiring</a></li>
                            <li><a href="affiliate.user/index.php">Join Affiliate Program</a></li>
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
                    &copy; <?php echo date("Y"); ?> <a target="_blank" href="https://merchantcouriers.com/" title="Merchant Courers">Merchant Couriers</a>. All Rights Reserved.
                </div>
                <!--/Copyright-->

                <div class="span6">
                    <ul class="social pull-right">
                        <li><a href="https://www.facebook.com/sharer.php?u=https://merchantcouriers.com" target="_blank"><i class="icon-facebook"></i></a></li>
                        <li><a href="https://twitter.com/share?url=https://merchantcouriers.com&amp;text=merchant%20couriers&amp;hashtags=merchantcouriers" target="_blank"><i class="icon-twitter"></i></a></li>
                        <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=https://merchantcouriers.com" target="_blank"><i class="icon-linkedin"></i></a></li>
                        <li><a href="https://plus.google.com/share?url=https://merchantcouriers.com" target="_blank"><i class="icon-google-plus"></i></a></li>
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

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5abf88e04b401e45400e3b3b/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>
