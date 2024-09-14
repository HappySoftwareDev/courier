(function() {

    //   var showStripe = <?php echo $showStripe; ?>;
    //   var showPaynow = <?php echo $showPaynow; ?>;
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
                  $("#paymentOpt option[value='paypal']").remove();
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
                      <?php

                      $aDatas = json_decode(file_get_contents("admin/keys.json"));
                      if ($aDatas->paypal_handle == "1") {
                      ?>
                          $("#paymentOpt").append('<option value="USD" selected="selected">Pay via Stripe (Online USD)</option><option value="paypal">Pay Through Paypal</option>');
                      <?php } else { ?>
                          $("#paymentOpt").append('<option value="USD" selected="selected">Pay via Stripe (Online USD)</option>');

                      <?php    } ?>
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
    }