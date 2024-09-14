var address, name, email, phone, date, time, drop_address, drop_name, drop_phone, drop_date, drop_time, note, transport,
weight_of_package, package_quantity, insurance, harm, value_of_package;

//var origin1 = new google.maps.LatLng(55.930, -3.118);
var origin;
var destination;
//var destinationB = new google.maps.LatLng(50.087, 14.421);

function _(x){
	return document.getElementById(x);
}

function processPhase2(){
    _("bk2").style.display = "block";
	_("bkform2").style.display = "block";
  origin = document.getElementById('autocomplete2').value;
  destination = document.getElementById('drop_address2').value;
  var service = new google.maps.DistanceMatrixService();
  service.getDistanceMatrix(
    {
      origins: [origin],
      destinations: [destination],
      travelMode: google.maps.TravelMode.DRIVING,
      unitSystem: google.maps.UnitSystem.METRIC,
      avoidHighways: false,
      avoidTolls: false
    }, calcDistanc);

}

var insur= new Array();
insur["Yes"]=0.1;
insur["No"]="";

var weight_prices= new Array();
weight_prices["n"]=0;
weight_prices["0 KG - 5 KG"]=0.11;
weight_prices["5 KG - 10 KG"]=0.21;
weight_prices["11 KG - 15 KG"]=0.41;
weight_prices["20 KG - above"]=0.81;

var quantity_price= new Array();
quantity_price["0"]=0;
quantity_price["1"]=1;
quantity_price["2"]=2;
quantity_price["3"]=3;
quantity_price["4"]=4;
quantity_price["5"]=5;
quantity_price["6"]=6;
quantity_price["7"]=7;
quantity_price["8"]=8;
quantity_price["9"]=9;
quantity_price["10"]=10;
quantity_price["11"]=11;
quantity_price["12"]=12;
quantity_price["13"]=13;
quantity_price["14"]=14;
quantity_price["15"]=15;
quantity_price["16"]=16;
quantity_price["17"]=17;
quantity_price["18"]=18;
quantity_price["19"]=19;
quantity_price["20"]=20;
quantity_price["21"]=19;
quantity_price["22"]=22;

var car_price= new Array();
car_price["0"]=0;
car_price["Back Tipper"]=0.5;
car_price["Closed Panel Van"]=0.5;
car_price["30 tonne Flat Bed Truck"]=0.5;
car_price["Fuel Tanker"]=0.5;
car_price["Recovery Truck"]=0.5;
car_price["Refrigerated Truck"]=1;
car_price["Rigid Flatbed Truck"]=0.6;
car_price["Box Truck"]=0.6;
car_price["Crane Lorry"]=0.8;
car_price["Side Tipper"]=4;
car_price["Low Loader"]=1;
car_price["3 tonne open truck"]=0.25;
car_price["Water Bowser"]=0.25;


function getTruckNum()
{
    var packageQuantityPrice=0;
    var theForm = document.forms["multiphase2"];
    var selectedQuantity = theForm.elements["trucks_num"];

    packageQuantityPrice = quantity_price[selectedQuantity .value];

    return packageQuantityPrice;
}

function getCarPrice()
{
    var CarPrice=0;
    var theForm = document.forms["multiphase2"];
    var selectedCar = theForm.elements["transport"];

    CarPrice = car_price[selectedCar.value];

    return CarPrice;
}

function getInsure()
{
    var Insu=0;
    var theForm = document.forms["multiphase2"];
    var selectedInsu = theForm.elements["insure"];

    Insu = insur[selectedInsu.value];

    return Insu;
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

function calculateTotal1()
{
    var weight_of_package = parseFloat(_("weight_of_package1").value);
    var CarPrice = getCarPrice();
    var actaulPrice = getTruckNum();
    var Ins = getInsure();

    var totDist = parseFloat(_('outputDiv1').value) + weight_of_package;
    var f = totDist * Ins;
	var roundTp = totDist * actaulPrice + f;
	var roundTpp = totDist * actaulPrice + f;
	var min = parseFloat(_("min_freight").value);
	if (roundTpp < min) {
     roundTpp = min;
     }
     if (roundTp < min) {
     roundTp = min;
     }
    _('tp').innerHTML = roundTp.toFixed(2);
    _('tpp').value = roundTpp.toFixed(2);
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
		var dist = origins[i] + ' to ' + destinations[j] + ':' + ' $' + '';
		var str=(results[j].distance.text);
		var allAdded = parseFloat(str.replace( /[^\d\.]*/g, '')) * totalp + totalW + totalC + totalT + totalB + totalIn;
        output.value = allAdded.toFixed(2);
      }
    }
  }
}
