<?php
// Start the session before any output (including includes)
session_start();

// Load centralized bootstrap (handles database, config, auth)
require_once('../../config/bootstrap.php');
require_once('../../function.php');

// Admin auth check
if (!isset($_SESSION['admin_email'])) {
    header('Location: login.php');
    exit;
}

// *** Logout the current user ***
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
    $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_GET['doLogout'])) {
    // To fully log out a visitor, we need to clear the session variables
    $_SESSION['_Username'] = NULL;
    $_SESSION['_UserGroup'] = NULL;
    $_SESSION['PrevUrl'] = NULL;
    unset($_SESSION['_Username']);
    unset($_SESSION['_UserGroup']);
    unset($_SESSION['PrevUrl']);

    // Redirect to login page after logout
    $logoutGoTo = "login.php";
    if ($logoutGoTo) {
        header("Location: $logoutGoTo");
        exit;
    }
}

// ** Restrict Access To Page: Grant or deny access based on user roles **

// Define the authorization function
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// Function to check if the user is authorized
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup)
{
    // For security, start by assuming the visitor is NOT authorized
    $isValid = False;

    // Check if the user is logged in by verifying the session variable MM_Username
    if (!empty($UserName)) {
        // Restrict access to certain users/groups
        $arrUsers = Explode(",", $strUsers);
        $arrGroups = Explode(",", $strGroups);
        
        // Check if the username is in the list of authorized users
        if (in_array($UserName, $arrUsers)) {
            $isValid = true;
        }
        // Check if the user belongs to an authorized group
        if (in_array($UserGroup, $arrGroups)) {
            $isValid = true;
        }
        // If no specific users or groups are provided, allow access by default
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
    // $taxiprice = $_POST['taxiprice'];
    // $towtruckprice = $_POST['towtruckprice'];
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
    $Chadiza = $_POST['Chadiza'];
    $Chama = $_POST['Chama'];
    $Chambeshi = $_POST['Chambeshi'];
    $Chavuma = $_POST['Chavuma'];
    $Chembe = $_POST['Chembe'];
    $Chibombo = $_POST['Chibombo'];
    $Chiengi = $_POST['Chiengi'];
    $Chiliabombwe = $_POST['Chiliabombwe'];
    $Chilubi = $_POST['Chilubi'];
    $Chingola = $_POST['Chingola'];
    $Chinsali = $_POST['Chinsali'];
    $Chinyingi = $_POST['Chinyingi'];
    $Chipata = $_POST['Chipata'];
    $Chirundu = $_POST['Chirundu'];
    $Chisamba = $_POST['Chisamba'];
    $Choma = $_POST['Choma'];
    $Chongwe = $_POST['Chongwe'];
    $Gwembe = $_POST['Gwembe'];
    $Isoka = $_POST['Isoka'];
    $Kabompo = $_POST['Kabompo'];
    $Kabwe = $_POST['Kabwe'];
    $Kafue = $_POST['Kafue'];
    $Kafulwe = $_POST['Kafulwe'];
    $Kalabo = $_POST['Kalabo'];
    $Kalene_Hill = $_POST['Kalene_Hill'];
    $Kalomo = $_POST['Kalomo'];
    $Kalulushi = $_POST['Kalulushi'];
    $Kalumbila = $_POST['Kalumbila'];
    $Kansanshi = $_POST['Kansanshi'];
    $Kanyembo = $_POST['Kanyembo'];
    $Kaoma = $_POST['Kaoma'];
    $Kapiri_Mposhi = $_POST['Kapiri_Mposhi'];
    $Kasempa = $_POST['Kasempa'];
    $Kashikishi = $_POST['Kashikishi'];
    $Kataba = $_POST['Kataba'];
    $Katete = $_POST['Katete'];
    $Kawambwa = $_POST['Kawambwa'];
    $Kazembe_Mwansabombwe = $_POST['Kazembe_Mwansabombwe'];
    $Kazungula = $_POST['Kazungula'];
    $Kibombomene = $_POST['Kibombomene'];
    $Kitwe = $_POST['Kitwe'];
    $Luangwa = $_POST['Luangwa'];
    $Luanshya = $_POST['Luanshya'];
    $Lufwanyama = $_POST['Lufwanyama'];
    $Lukulu = $_POST['Lukulu'];
    $Lumwana = $_POST['Lumwana'];
    $Lundazi = $_POST['Lundazi'];
    $Lusaka = $_POST['Lusaka'];
    $Macha_Mission = $_POST['Macha_Mission'];
    $Makeni = $_POST['Makeni'];
    $Mansa = $_POST['Mansa'];
    $Mazabuka = $_POST['Mazabuka'];
    $Mbala = $_POST['Mbala'];
    $Mbereshi = $_POST['Mbereshi'];
    $Mfuwe = $_POST['Mfuwe'];
    $Milenge = $_POST['Milenge'];
    $Misisi = $_POST['Misisi'];
    $Mkushi = $_POST['Mkushi'];
    $Mongu = $_POST['Mongu'];
    $Monze = $_POST['Monze'];
    $Mpika = $_POST['Mpika'];
    $Mporokoso = $_POST['Mporokoso'];
    $Mpulungu = $_POST['Mpulungu'];
    $Mufulira = $_POST['Mufulira'];
    $Mumbwa = $_POST['Mumbwa'];
    $Muyombe = $_POST['Muyombe'];
    $Mwinilunga = $_POST['Mwinilunga'];
    $Nchelenge = $_POST['Nchelenge'];
    $Ndola = $_POST['Ndola'];
    $Ngoma = $_POST['Ngoma'];
    $Nkana = $_POST['Nkana'];
    $Nseluka = $_POST['Nseluka'];
    $Pemba = $_POST['Pemba'];
    $Petauke = $_POST['Petauke'];
    $Samfya = $_POST['Samfya'];
    $Senanga = $_POST['Senanga'];
    $Serenje = $_POST['Serenje'];
    $Sesheke = $_POST['Sesheke'];
    $Shiwa_Ngandu = $_POST['Shiwa_Ngandu'];
    $Siavonga = $_POST['Siavonga'];
    $Sikalongo = $_POST['Sikalongo'];
    $Sinazongwe = $_POST['Sinazongwe'];
    $Solwezi = $_POST['Solwezi'];
    $Zambezi = $_POST['Zambezi'];
    $Zimba = $_POST['Zimba'];
    $Other = $_POST['Other'];
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
    $exchange_rate = $_POST['exchange_rate'];
    $primary_currency = $_POST['primary_currency'];
    $secondary_currency = $_POST['secondary_currency'];

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
	
    $city1 = $_POST['city1'];
    $city2 = $_POST['city2'];
    $city3 = $_POST['city3'];
    $city4 = $_POST['city4'];
    $city5 = $_POST['city5'];
    $city6 = $_POST['city6'];
    $city7 = $_POST['city7'];
    $city8 = $_POST['city8'];
    $city9 = $_POST['city9'];
    $city10 = $_POST['city10'];
    $city11 = $_POST['city11'];
    $city12 = $_POST['city12'];
    $city13 = $_POST['city13'];
    $city14 = $_POST['city14'];
    $city15 = $_POST['city15'];
    $city16 = $_POST['city16'];
    $city17 = $_POST['city17'];
    $city18 = $_POST['city18'];
    $city19 = $_POST['city19'];
    $city20 = $_POST['city20'];
    $city21 = $_POST['city21'];
    $city22 = $_POST['city22'];
    $city23 = $_POST['city23'];
    $city24 = $_POST['city24'];
    $city25 = $_POST['city25'];
    $city26 = $_POST['city26'];
    $city27 = $_POST['city27'];
    $city28 = $_POST['city28'];
    $city29 = $_POST['city29'];
    $city30 = $_POST['city30'];
    $city31 = $_POST['city31'];
    $city32 = $_POST['city32'];
    $city33 = $_POST['city33'];
    $city34 = $_POST['city34'];
    $city35 = $_POST['city35'];
    $city36 = $_POST['city36'];
    $city37 = $_POST['city37'];
    $city38 = $_POST['city38'];
    $city39 = $_POST['city39'];
    $city40 = $_POST['city40'];
    $city41 = $_POST['city41'];
    $city42 = $_POST['city42'];
    $city43 = $_POST['city43'];
    $city44 = $_POST['city44'];
    $city45 = $_POST['city45'];
    $city46 = $_POST['city46'];
    $city47 = $_POST['city47'];
    $city48 = $_POST['city48'];
    $city49 = $_POST['city49'];
    $city50 = $_POST['city50'];
    $city51 = $_POST['city51'];
    $city52 = $_POST['city52'];
    $city53 = $_POST['city53'];
    $city54 = $_POST['city54'];
    $city55 = $_POST['city55'];
    $city56 = $_POST['city56'];
    $city57 = $_POST['city57'];
    $city58 = $_POST['city58'];
    $city59 = $_POST['city59'];
    $city60 = $_POST['city60'];
    $city61 = $_POST['city61'];
    $city62 = $_POST['city62'];
    $city63 = $_POST['city63'];
    $city64 = $_POST['city64'];
    $city65 = $_POST['city65'];
    $city66 = $_POST['city66'];
    $city67 = $_POST['city67'];
    $city68 = $_POST['city68'];
    $city69 = $_POST['city69'];
    $city70 = $_POST['city70'];
    $city71 = $_POST['city71'];
    $city72 = $_POST['city72'];
    $city73 = $_POST['city73'];
    $city74 = $_POST['city74'];
    $city75 = $_POST['city75'];
    $city76 = $_POST['city76'];
    $city77 = $_POST['city77'];
    $city78 = $_POST['city78'];
    $city79 = $_POST['city79'];
    $city80 = $_POST['city80'];
    $city81 = $_POST['city81'];
    $city82 = $_POST['city82'];
    $city83 = $_POST['city83'];
    $city84 = $_POST['city84'];
    $city85 = $_POST['city85'];
    $city86 = $_POST['city86'];
    // $city_ID = $_POST['city_ID'];


   
    try {

        $stmt = $Connect->prepare("SELECT * FROM prizelist WHERE ID=:id");
        $stmt->execute(array(":id" => $ID));
        $count = $stmt->rowCount();
        $count2 = $stmt->rowCount();
        $count3 = $stmt->rowCount();

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
            $stmt = $Connect->prepare("UPDATE prizelist SET Car_per_km=:carprice, truck_price_km=:truckprice, Weight=:weightprice, Cost_per_item=:itemprice, Insurance=:insuranceprice, Base_price=:baseRate, Price_per_km=:quoteKm, min_parcel=:min_parcel, min_freight=:min_freight, bike=:bike, van=:van, value_L1=:value_L1, value_L2=:value_L2, value_L3=:value_L3, value_L4=:value_L4, value_L5=:value_L5, 
            Chadiza=:Chadiza, Chama=:Chama, Chambeshi=:Chambeshi, Chavuma=:Chavuma, Chembe=:Chembe, Chibombo=:Chibombo, Chiengi=:Chiengi, Chiliabombwe=:Chiliabombwe, Chilubi=:Chilubi, Chingola=:Chingola, Chinsali=:Chinsali, Chinyingi=:Chinyingi, Chipata=:Chipata, Chirundu=:Chirundu, Chisamba=:Chisamba, Choma=:Choma, Chongwe=:Chongwe, Gwembe=:Gwembe, Isoka=:Isoka, Kabompo=:Kabompo, Kabwe=:Kabwe, 
            Kafue=:Kafue, Kafulwe=:Kafulwe, Kalabo=:Kalabo, Kalene_Hill=:Kalene_Hill, Kalomo=:Kalomo, Kalulushi=:Kalulushi, Kalumbila=:Kalumbila, Kansanshi=:Kansanshi, Kanyembo=:Kanyembo, Kaoma=:Kaoma, Kapiri_Mposhi=:Kapiri_Mposhi, Kasempa=:Kasempa, Kashikishi=:Kashikishi, Kataba=:Kataba, Katete=:Katete, Kawambwa=:Kawambwa, Kazembe_Mwansabombwe=:Kazembe_Mwansabombwe, Kazungula=:Kazungula, Kibombomene=:Kibombomene, 
            Kitwe=:Kitwe, Luangwa=:Luangwa, Luanshya=:Luanshya, Lufwanyama=:Lufwanyama, Lukulu=:Lukulu, Lumwana=:Lumwana, Lundazi=:Lundazi, Lusaka=:Lusaka, Macha_Mission=:Macha_Mission, Makeni=:Makeni, Mansa=:Mansa, Mazabuka=:Mazabuka, Mbala=:Mbala, Mbereshi=:Mbereshi, Mfuwe=:Mfuwe, Milenge=:Milenge, Misisi=:Misisi, Mkushi=:Mkushi, Mongu=:Mongu, Monze=:Monze, Mpika=:Mpika, Mporokoso=:Mporokoso, Mpulungu=:Mpulungu, 
            Mufulira=:Mufulira, Mumbwa=:Mumbwa, Muyombe=:Muyombe, Mwinilunga=:Mwinilunga, Nchelenge=:Nchelenge, Ndola=:Ndola, Ngoma=:Ngoma, Nkana=:Nkana, Nseluka=:Nseluka, Pemba=:Pemba, Petauke=:Petauke, Samfya=:Samfya, Senanga=:Senanga, Serenje=:Serenje, Sesheke=:Sesheke, Shiwa_Ngandu=:Shiwa_Ngandu, Siavonga=:Siavonga, Sikalongo=:Sikalongo, Sinazongwe=:Sinazongwe, Solwezi=:Solwezi, Zambezi=:Zambezi, Zimba=:Zimba, 
            Other=:Other , exchange_rate=:exchange_rate, primary_currency=:primary_currency, secondary_currency=:secondary_currency, loader_price=:loaderPrice, parcel_driver_commission=:parcel_driver_commission, freight_driver_commission=:freight_driver_commission, furniture_driver_commission=:furniture_driver_commission, inter_charge=:inter_charge WHERE ID=:ID");

            $stmt->bindparam(":carprice", $carprice);
            $stmt->bindparam(":truckprice", $truckprice);
            // $stmt->bindparam(":taxiprice", $taxiprice);
            // $stmt->bindparam(":towtruckprice", $towtruckprice);
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
            $stmt->bindparam(":Chadiza", $Chadiza);
            $stmt->bindparam(":Chama", $Chama);
            $stmt->bindparam(":Chambeshi", $Chambeshi);
            $stmt->bindparam(":Chavuma", $Chavuma);
            $stmt->bindparam(":Chembe", $Chembe);
            $stmt->bindparam(":Chibombo", $Chibombo);
            $stmt->bindparam(":Chiengi", $Chiengi);
            $stmt->bindparam(":Chiliabombwe", $Chiliabombwe);
            $stmt->bindparam(":Chilubi", $Chilubi);
            $stmt->bindparam(":Chingola", $Chingola);
            $stmt->bindparam(":Chinsali", $Chinsali);
            $stmt->bindparam(":Chinyingi", $Chinyingi);
            $stmt->bindparam(":Chipata", $Chipata);
            $stmt->bindparam(":Chirundu", $Chirundu);
            $stmt->bindparam(":Chisamba", $Chisamba);
            $stmt->bindparam(":Choma", $Choma);
            $stmt->bindparam(":Chongwe", $Chongwe);
            $stmt->bindparam(":Gwembe", $Gwembe);
            $stmt->bindparam(":Isoka", $Isoka);
            $stmt->bindparam(":Kabompo", $Kabompo);
            $stmt->bindparam(":Kabwe", $Kabwe);
            $stmt->bindparam(":Kafue", $Kafue);
            $stmt->bindparam(":Kafulwe", $Kafulwe);
            $stmt->bindparam(":Kalabo", $Kalabo);
            $stmt->bindparam(":Kalene_Hill", $Kalene_Hill);
            $stmt->bindparam(":Kalomo", $Kalomo);
            $stmt->bindparam(":Kalulushi", $Kalulushi);
            $stmt->bindparam(":Kalumbila", $Kalumbila);
            $stmt->bindparam(":Kansanshi", $Kansanshi);
            $stmt->bindparam(":Kanyembo", $Kanyembo);
            $stmt->bindparam(":Kaoma", $Kaoma);
            $stmt->bindparam(":Kapiri_Mposhi", $Kapiri_Mposhi);
            $stmt->bindparam(":Kasempa", $Kasempa);
            $stmt->bindparam(":Kashikishi", $Kashikishi);
            $stmt->bindparam(":Kataba", $Kataba);
            $stmt->bindparam(":Katete", $Katete);
            $stmt->bindparam(":Kawambwa", $Kawambwa);
            $stmt->bindparam(":Kazembe_Mwansabombwe", $Kazembe_Mwansabombwe);
            $stmt->bindparam(":Kazungula", $Kazungula);
            $stmt->bindparam(":Kibombomene", $Kibombomene);
            $stmt->bindparam(":Kitwe", $Kitwe);
            $stmt->bindparam(":Luangwa", $Luangwa);
            $stmt->bindparam(":Luanshya", $Luanshya);
            $stmt->bindparam(":Lufwanyama", $Lufwanyama);
            $stmt->bindparam(":Lukulu", $Lukulu);
            $stmt->bindparam(":Lumwana", $Lumwana);
            $stmt->bindparam(":Lundazi", $Lundazi);
            $stmt->bindparam(":Lusaka", $Lusaka);
            $stmt->bindparam(":Macha_Mission", $Macha_Mission);
            $stmt->bindparam(":Makeni", $Makeni);
            $stmt->bindparam(":Mansa", $Mansa);
            $stmt->bindparam(":Mazabuka", $Mazabuka);
            $stmt->bindparam(":Mbala", $Mbala);
            $stmt->bindparam(":Mbereshi", $Mbereshi);
            $stmt->bindparam(":Mfuwe", $Mfuwe);
            $stmt->bindparam(":Milenge", $Milenge);
            $stmt->bindparam(":Misisi", $Misisi);
            $stmt->bindparam(":Mkushi", $Mkushi);
            $stmt->bindparam(":Mongu", $Mongu);
            $stmt->bindparam(":Monze", $Monze);
            $stmt->bindparam(":Mpika", $Mpika);
            $stmt->bindparam(":Mporokoso", $Mporokoso);
            $stmt->bindparam(":Mpulungu", $Mpulungu);
            $stmt->bindparam(":Mufulira", $Mufulira);
            $stmt->bindparam(":Mumbwa", $Mumbwa);
            $stmt->bindparam(":Muyombe", $Muyombe);
            $stmt->bindparam(":Mwinilunga", $Mwinilunga);
            $stmt->bindparam(":Nchelenge", $Nchelenge);
            $stmt->bindparam(":Ndola", $Ndola);
            $stmt->bindparam(":Ngoma", $Ngoma);
            $stmt->bindparam(":Nkana", $Nkana);
            $stmt->bindparam(":Nseluka", $Nseluka);
            $stmt->bindparam(":Pemba", $Pemba);
            $stmt->bindparam(":Petauke", $Petauke);
            $stmt->bindparam(":Samfya", $Samfya);
            $stmt->bindparam(":Senanga", $Senanga);
            $stmt->bindparam(":Serenje", $Serenje);
            $stmt->bindparam(":Sesheke", $Sesheke);
            $stmt->bindparam(":Shiwa_Ngandu", $Shiwa_Ngandu);
            $stmt->bindparam(":Siavonga", $Siavonga);
            $stmt->bindparam(":Sikalongo", $Sikalongo);
            $stmt->bindparam(":Sinazongwe", $Sinazongwe);
            $stmt->bindparam(":Solwezi", $Solwezi);
            $stmt->bindparam(":Zambezi", $Zambezi);
            $stmt->bindparam(":Zimba", $Zimba);
            $stmt->bindparam(":Other", $Other);
            $stmt->bindparam(":exchange_rate", $exchange_rate);
            $stmt->bindparam(":primary_currency", $primary_currency);
            $stmt->bindparam(":secondary_currency", $secondary_currency);
            $stmt->bindparam(":loaderPrice", $loaderPrice);
            $stmt->bindparam(":parcel_driver_commission", $parcel_driver_commission);
            $stmt->bindparam(":freight_driver_commission", $freight_driver_commission);
            $stmt->bindparam(":furniture_driver_commission", $furniture_driver_commission);
            $stmt->bindparam(":inter_charge", $inter_charge);
            $stmt->bindparam(":ID", $ID);

            $stmt->execute();
            
			
            
			if ($count3 == 1) {
            $stmt = $Connect->prepare("UPDATE cities SET 
            Chadiza=:city1, 
            Chama=:city2, 
            Chambeshi=:city3, 
            Chavuma=:city4, 
            Chembe=:city5, 
            Chibombo=:city6, 
            Chiengi=:city7, 
            Chiliabombwe=:city8, 
            Chilubi=:city9, 
            Chingola=:city10, 
            Chinsali=:city11, 
            Chinyingi=:city12, 
            Chipata=:city13, 
            Chirundu=:city14, 
            Chisamba=:city15, 
            Choma=:city16, 
            Chongwe=:city17, 
            Gwembe=:city18, 
            Isoka=:city19, 
            Kabompo=:city20, 
            Kabwe=:city21, 
            Kafue=:city22, 
            Kafulwe=:city23, 
            Kalabo=:city24, 
            Kalene_Hill=:city25, 
            Kalomo=:city26, 
            Kalulushi=:city27, 
            Kalumbila=:city28, 
            Kansanshi=:city29, 
            Kanyembo=:city30, 
            Kaoma=:city31, 
            Kapiri_Mposhi=:city32, 
            Kasempa=:city33, 
            Kashikishi=:city34, 
            Kataba=:city35, 
            Katete=:city36, 
            Kawambwa=:city37, 
            Kazembe_Mwansabombwe=:city38, 
            Kazungula=:city39, 
            Kibombomene=:city40, 
            Kitwe=:city41, 
            Luangwa=:city42, 
            Luanshya=:city43, 
            Lufwanyama=:city44, 
            Lukulu=:city45, 
            Lumwana=:city46, 
            Lundazi=:city47, 
            Lusaka=:city48, 
            Macha_Mission=:city49, 
            Makeni=:city50, 
            Mansa=:city51, 
            Mazabuka=:city52, 
            Mbala=:city53, 
            Mbereshi=:city54, 
            Mfuwe=:city55, 
            Milenge=:city56, 
            Misisi=:city57, 
            Mkushi=:city58, 
            Mongu=:city59, 
            Monze=:city60, 
            Mpika=:city61, 
            Mporokoso=:city62, 
            Mpulungu=:city63, 
            Mufulira=:city64, 
            Mumbwa=:city65, 
            Muyombe=:city66, 
            Mwinilunga=:city67, 
            Nchelenge=:city68, 
            Ndola=:city69, 
            Ngoma=:city70, 
            Nkana=:city71, 
            Nseluka=:city72, 
            Pemba=:city73, 
            Petauke=:city74, 
            Samfya=:city75, 
            Senanga=:city76, 
            Serenje=:city77, 
            Sesheke=:city78, 
            Shiwa_Ngandu=:city79, 
            Siavonga=:city80, 
            Sikalongo=:city81, 
            Sinazongwe=:city82, 
            Solwezi=:city83, 
            Zambezi=:city84, 
            Zimba=:city85,
            Other=:city86 
            WHERE id=:city_ID");
            
            $stmt->bindparam(":city1", $city1);
            $stmt->bindparam(":city2", $city2);
            $stmt->bindparam(":city3", $city3);
            $stmt->bindparam(":city4", $city4);
            $stmt->bindparam(":city5", $city5);
            $stmt->bindparam(":city6", $city6);
            $stmt->bindparam(":city7", $city7);
            $stmt->bindparam(":city8", $city8);
            $stmt->bindparam(":city9", $city9);
            $stmt->bindparam(":city10", $city10);
            $stmt->bindparam(":city11", $city11);
            $stmt->bindparam(":city12", $city12);
            $stmt->bindparam(":city13", $city13);
            $stmt->bindparam(":city14", $city14);
            $stmt->bindparam(":city15", $city15);
            $stmt->bindparam(":city16", $city16);
            $stmt->bindparam(":city17", $city17);
            $stmt->bindparam(":city18", $city18);
            $stmt->bindparam(":city19", $city19);
            $stmt->bindparam(":city20", $city20);
            $stmt->bindparam(":city21", $city21);
            $stmt->bindparam(":city22", $city22);
            $stmt->bindparam(":city23", $city23);
            $stmt->bindparam(":city24", $city24);
            $stmt->bindparam(":city25", $city25);
            $stmt->bindparam(":city26", $city26);
            $stmt->bindparam(":city27", $city27);
            $stmt->bindparam(":city28", $city28);
            $stmt->bindparam(":city29", $city29);
            $stmt->bindparam(":city30", $city30);
            $stmt->bindparam(":city31", $city31);
            $stmt->bindparam(":city32", $city32);
            $stmt->bindparam(":city33", $city33);
            $stmt->bindparam(":city34", $city34);
            $stmt->bindparam(":city35", $city35);
            $stmt->bindparam(":city36", $city36);
            $stmt->bindparam(":city37", $city37);
            $stmt->bindparam(":city38", $city38);
            $stmt->bindparam(":city39", $city39);
            $stmt->bindparam(":city40", $city40);
            $stmt->bindparam(":city41", $city41);
            $stmt->bindparam(":city42", $city42);
            $stmt->bindparam(":city43", $city43);
            $stmt->bindparam(":city44", $city44);
            $stmt->bindparam(":city45", $city45);
            $stmt->bindparam(":city46", $city46);
            $stmt->bindparam(":city47", $city47);
            $stmt->bindparam(":city48", $city48);
            $stmt->bindparam(":city49", $city49);
            $stmt->bindparam(":city50", $city50);
            $stmt->bindparam(":city51", $city51);
            $stmt->bindparam(":city52", $city52);
            $stmt->bindparam(":city53", $city53);
            $stmt->bindparam(":city54", $city54);
            $stmt->bindparam(":city55", $city55);
            $stmt->bindparam(":city56", $city56);
            $stmt->bindparam(":city57", $city57);
            $stmt->bindparam(":city58", $city58);
            $stmt->bindparam(":city59", $city59);
            $stmt->bindparam(":city60", $city60);
            $stmt->bindparam(":city61", $city61);
            $stmt->bindparam(":city62", $city62);
            $stmt->bindparam(":city63", $city63);
            $stmt->bindparam(":city64", $city64);
            $stmt->bindparam(":city65", $city65);
            $stmt->bindparam(":city66", $city66);
            $stmt->bindparam(":city67", $city67);
            $stmt->bindparam(":city68", $city68);
            $stmt->bindparam(":city69", $city69);
            $stmt->bindparam(":city70", $city70);
            $stmt->bindparam(":city71", $city71);
            $stmt->bindparam(":city72", $city72);
            $stmt->bindparam(":city73", $city73);
            $stmt->bindparam(":city74", $city74);
            $stmt->bindparam(":city75", $city75);
            $stmt->bindparam(":city76", $city76);
            $stmt->bindparam(":city77", $city77);
            $stmt->bindparam(":city78", $city78);
            $stmt->bindparam(":city79", $city79);
            $stmt->bindparam(":city80", $city80);
            $stmt->bindparam(":city81", $city81);
            $stmt->bindparam(":city82", $city82);
            $stmt->bindparam(":city83", $city83);
            $stmt->bindparam(":city84", $city84);
            $stmt->bindparam(":city85", $city85);
            $stmt->bindparam(":city86", $city86);
            $stmt->bindparam(":city_ID", $city_ID);
			
             $stmt->execute();
			

            //check if query executes
                if ($stmt->execute()) {
                    echo "<script>alert('Prices Update Successful please check the results.')</script>";
                    echo "<script>window.open('integration.php','_self')</script>";
                } else {
    
                    echo "Query could not execute";
                }
            } //end of integrity check

        } else {
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
    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Prices</title>

</head>

<body>

    <div id="wrapper">

        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

        <?php
        $get = "SELECT * FROM `prizelist` WHERE company_name='merchant'";

        $stmt = $DB->prepare( $get);

        foreach ($results as $1) {
            $ID = $row_type['ID'];
            $exchange_rate = $row_type['exchange_rate'];
            $primary_currency = $row_type['primary_currency'];
            $secondary_currency = $row_type['secondary_currency'];
            $Car_per_km = $row_type['Car_per_km'];
            $truck_per_km = $row_type['truck_price_km'];
            // $taxi_per_km = $row_type['taxi_price_km'];
            // $towtruck_per_km = $row_type['towtruck_price_km'];
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
            $Chadiza = $row_type['Chadiza'];
            $Chama = $row_type['Chama'];
            $Chambeshi = $row_type['Chambeshi'];
            $Chavuma = $row_type['Chavuma'];
            $Chembe = $row_type['Chembe'];
            $Chibombo = $row_type['Chibombo'];
            $Chiengi = $row_type['Chiengi'];
            $Chiliabombwe = $row_type['Chiliabombwe'];
            $Chilubi = $row_type['Chilubi'];
            $Chingola = $row_type['Chingola'];
            $Chinsali = $row_type['Chinsali'];
            $Chinyingi = $row_type['Chinyingi'];
            $Chipata = $row_type['Chipata'];
            $Chirundu = $row_type['Chirundu'];
            $Chisamba = $row_type['Chisamba'];
            $Choma = $row_type['Choma'];
            $Chongwe = $row_type['Chongwe'];
            $Gwembe = $row_type['Gwembe'];
            $Isoka = $row_type['Isoka'];
            $Kabompo = $row_type['Kabompo'];
            $Kabwe = $row_type['Kabwe'];
            $Kafue = $row_type['Kafue'];
            $Kafulwe = $row_type['Kafulwe'];
            $Kalabo = $row_type['Kalabo'];
            $Kalene_Hill = $row_type['Kalene_Hill'];
            $Kalomo = $row_type['Kalomo'];
            $Kalulushi = $row_type['Kalulushi'];
            $Kalumbila = $row_type['Kalumbila'];
            $Kansanshi = $row_type['Kansanshi'];
            $Kanyembo = $row_type['Kanyembo'];
            $Kaoma = $row_type['Kaoma'];
            $Kapiri_Mposhi = $row_type['Kapiri_Mposhi'];
            $Kasempa = $row_type['Kasempa'];
            $Kashikishi = $row_type['Kashikishi'];
            $Kataba = $row_type['Kataba'];
            $Katete = $row_type['Katete'];
            $Kawambwa = $row_type['Kawambwa'];
            $Kazembe_Mwansabombwe = $row_type['Kazembe_Mwansabombwe'];
            $Kazungula = $row_type['Kazungula'];
            $Kibombomene = $row_type['Kibombomene'];
            $Kitwe = $row_type['Kitwe'];
            $Luangwa = $row_type['Luangwa'];
            $Luanshya = $row_type['Luanshya'];
            $Lufwanyama = $row_type['Lufwanyama'];
            $Lukulu = $row_type['Lukulu'];
            $Lumwana = $row_type['Lumwana'];
            $Lundazi = $row_type['Lundazi'];
            $Lusaka = $row_type['Lusaka'];
            $Macha_Mission = $row_type['Macha_Mission'];
            $Makeni = $row_type['Makeni'];
            $Mansa = $row_type['Mansa'];
            $Mazabuka = $row_type['Mazabuka'];
            $Mbala = $row_type['Mbala'];
            $Mbereshi = $row_type['Mbereshi'];
            $Mfuwe = $row_type['Mfuwe'];
            $Milenge = $row_type['Milenge'];
            $Misisi = $row_type['Misisi'];
            $Mkushi = $row_type['Mkushi'];
            $Mongu = $row_type['Mongu'];
            $Monze = $row_type['Monze'];
            $Mpika = $row_type['Mpika'];
            $Mporokoso = $row_type['Mporokoso'];
            $Mpulungu = $row_type['Mpulungu'];
            $Mufulira = $row_type['Mufulira'];
            $Mumbwa = $row_type['Mumbwa'];
            $Muyombe = $row_type['Muyombe'];
            $Mwinilunga = $row_type['Mwinilunga'];
            $Nchelenge = $row_type['Nchelenge'];
            $Ndola = $row_type['Ndola'];
            $Ngoma = $row_type['Ngoma'];
            $Nkana = $row_type['Nkana'];
            $Nseluka = $row_type['Nseluka'];
            $Pemba = $row_type['Pemba'];
            $Petauke = $row_type['Petauke'];
            $Samfya = $row_type['Samfya'];
            $Senanga = $row_type['Senanga'];
            $Serenje = $row_type['Serenje'];
            $Sesheke = $row_type['Sesheke'];
            $Shiwa_Ngandu = $row_type['Shiwa_Ngandu'];
            $Siavonga = $row_type['Siavonga'];
            $Sikalongo = $row_type['Sikalongo'];
            $Sinazongwe = $row_type['Sinazongwe'];
            $Solwezi = $row_type['Solwezi'];
            $Zambezi = $row_type['Zambezi'];
            $Zimba = $row_type['Zimba'];
            $Other = $row_type['Other'];
            $loader_price = $row_type['loader_price'];
            $parcel_driver_commission = $row_type['parcel_driver_commission'];
            $freight_driver_commission = $row_type['freight_driver_commission'];
            $furniture_driver_commission = $row_type['furniture_driver_commission'];
            $inter_charge = $row_type['inter_charge'];
        }
		
		$get_city = "SELECT * FROM `cities`";

        $stmt = $DB->prepare( $get_city);

        foreach ($results as $1) {
			$city_ID=$row_type['id'];
			$city1 = $row_type['Chadiza'];
            $city2 = $row_type['Chama'];
            $city3 = $row_type['Chambeshi'];
            $city4 = $row_type['Chavuma'];
            $city5 = $row_type['Chembe'];
            $city6 = $row_type['Chibombo'];
            $city7 = $row_type['Chiengi'];
            $city8 = $row_type['Chiliabombwe'];
            $city9 = $row_type['Chilubi'];
            $city10 = $row_type['Chingola'];
            $city11 = $row_type['Chinsali'];
            $city12 = $row_type['Chinyingi'];
            $city13 = $row_type['Chipata'];
            $city14 = $row_type['Chirundu'];
            $city15 = $row_type['Chisamba'];
            $city16 = $row_type['Choma'];
            $city17 = $row_type['Chongwe'];
            $city18 = $row_type['Gwembe'];
            $city19 = $row_type['Isoka'];
            $city20 = $row_type['Kabompo'];
            $city21 = $row_type['Kabwe'];
            $city22 = $row_type['Kafue'];
            $city23 = $row_type['Kafulwe'];
            $city24 = $row_type['Kalabo'];
            $city25 = $row_type['Kalene_Hill'];
            $city26 = $row_type['Kalomo'];
            $city27 = $row_type['Kalulushi'];
            $city28 = $row_type['Kalumbila'];
            $city29 = $row_type['Kansanshi'];
            $city30 = $row_type['Kanyembo'];
            $city31 = $row_type['Kaoma'];
            $city32 = $row_type['Kapiri_Mposhi'];
            $city33 = $row_type['Kasempa'];
            $city34 = $row_type['Kashikishi'];
            $city35 = $row_type['Kataba'];
            $city36 = $row_type['Katete'];
            $city37 = $row_type['Kawambwa'];
            $city38 = $row_type['Kazembe_Mwansabombwe'];
            $city39 = $row_type['Kazungula'];
            $city40 = $row_type['Kibombomene'];
            $city41 = $row_type['Kitwe'];
            $city42 = $row_type['Luangwa'];
            $city43 = $row_type['Luanshya'];
            $city44 = $row_type['Lufwanyama'];
            $city45 = $row_type['Lukulu'];
            $city46 = $row_type['Lumwana'];
            $city47 = $row_type['Lundazi'];
            $city48 = $row_type['Lusaka'];
            $city49 = $row_type['Macha_Mission'];
            $city50 = $row_type['Makeni'];
            $city51 = $row_type['Mansa'];
            $city52 = $row_type['Mazabuka'];
            $city53 = $row_type['Mbala'];
            $city54 = $row_type['Mbereshi'];
            $city55 = $row_type['Mfuwe'];
            $city56 = $row_type['Milenge'];
            $city57 = $row_type['Misisi'];
            $city58 = $row_type['Mkushi'];
            $city59 = $row_type['Mongu'];
            $city60 = $row_type['Monze'];
            $city61 = $row_type['Mpika'];
            $city62 = $row_type['Mporokoso'];
            $city63 = $row_type['Mpulungu'];
            $city64 = $row_type['Mufulira'];
            $city65 = $row_type['Mumbwa'];
            $city66 = $row_type['Muyombe'];
            $city67 = $row_type['Mwinilunga'];
            $city68 = $row_type['Nchelenge'];
            $city69 = $row_type['Ndola'];
            $city70 = $row_type['Ngoma'];
            $city71 = $row_type['Nkana'];
            $city72 = $row_type['Nseluka'];
            $city73 = $row_type['Pemba'];
            $city74 = $row_type['Petauke'];
            $city75 = $row_type['Samfya'];
            $city76 = $row_type['Senanga'];
            $city77 = $row_type['Serenje'];
            $city78 = $row_type['Sesheke'];
            $city79 = $row_type['Shiwa_Ngandu'];
            $city80 = $row_type['Siavonga'];
            $city81 = $row_type['Sikalongo'];
            $city82 = $row_type['Sinazongwe'];
            $city83 = $row_type['Solwezi'];
            $city84 = $row_type['Zambezi'];
            $city85 = $row_type['Zimba'];
            $city86=$row_type['Other'];
		}

        ?>
        <?php
        $get_w = "SELECT * FROM `weight_price` ";

        $stmt = $DB->prepare( $get_w);

        foreach ($results as $1) {
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
        
        <?php
// Assuming a database connection is already established
$query = "SELECT primary_currency, secondary_currency FROM prizelist LIMIT 1"; // Adjust as needed
$stmt = $DB->prepare( $query);

$savedPrimaryCurrency = '';
$savedSecondaryCurrency = '';

if (!empty($results) && ($row = $results[0])) {
    $savedPrimaryCurrency = $row['primary_currency'];
    $savedSecondaryCurrency = $row['secondary_currency'];
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
                                                        Enter Your Prices in the Primary Currency
                                                    </div>
                                                    <!-- .panel-heading -->
                                                    <div class="panel-body">
                                                        <div class="panel-group" id="accordion">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">InnerCity (Local) Rates</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseOne" class="panel-collapse collapse in">
                                                                <div class="panel-body">
                                                                    <div class="form-group col-lg-3">
                                                                <label for="primaryCurrency">Primary Currency</label>
                                                                <select id="primaryCurrency" class="form-control" name="primary_currency" data-saved-value="<?php echo $savedPrimaryCurrency; ?>">
                                                                    <option value="" disabled selected>Loading...</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-lg-3">
                                                                <label for="secondaryCurrency">Secondary Currency</label>
                                                                <select id="secondaryCurrency" class="form-control" name="secondary_currency" data-saved-value="<?php echo $savedSecondaryCurrency; ?>">
                                                                    <option value="" disabled selected>Loading...</option>
                                                                </select>
                                                            </div>
                                                            
                                                                    <div class="form-group col-lg-3">
                                                                        <label>Exchange Rate</label>
                                                                        <div class="input-group">
                                                                            <input class="form-control" name="exchange_rate" id="ExchangeRate" value="<?php echo $exchange_rate; ?>" type="text" readonly>
                                                                            <div class="input-group-addon">
                                                                                <input type="checkbox" id="editExchangeRate"> Edit
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            
                                                                    <div class="form-group col-lg-2">
                                                                        <label>Base rate</label>
                                                                        <input class="form-control" name="baseRate" value="<?php echo $Base_price; ?>" type="text">
                                                                    </div>
                                                                    <div class="form-group col-lg-2">
                                                                        <label>Price perKM</label>
                                                                        <input class="form-control" name="quoteKm" value="<?php echo $Price_per_km; ?>" type="text">
                                                                    </div>
                                                                    <div class="form-group col-lg-2">
                                                                        <label>Car Price</label>
                                                                        <input class="form-control" name="carprice" value="<?php echo $Car_per_km; ?>" type="text">
                                                                    </div>
                                                                    <div class="form-group col-lg-2">
                                                                        <label>Truck Price</label>
                                                                        <input class="form-control" name="truckprice" value="<?php echo $truck_per_km; ?>" type="text">
                                                                    </div>
                                                                    <!--<div class="form-group col-lg-2">-->
                                                                    <!--    <label>Taxi Price</label>-->
                                                                    <!--    <input class="form-control" name="taxiprice" value="<?php echo $taxi_per_km; ?>" type="text">-->
                                                                    <!--</div>-->
                                                                    <!--<div class="form-group col-lg-2">-->
                                                                    <!--    <label>Tow Truck Price</label>-->
                                                                    <!--    <input class="form-control" name="towtruckprice" value="<?php echo $towtruck_per_km; ?>" type="text">-->
                                                                    <!--</div>-->
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
                                                                        <label>Loader Price</label>
                                                                        <input class="form-control" name="loader_price" value="<?php echo $loader_price; ?>" type="text">
                                                                    </div>
                                                                    <div class="form-group col-lg-2">
                                                                        <label>Inter Charges (1.3)</label>
                                                                        <input class="form-control" name="inter_charge" value="<?php echo $inter_charge; ?>" type="text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            

                                                            <!------------------------------ value tab------------------------------>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Package Value Rates</a>
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
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">InterCity (Overnight Express) Rates</a>
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
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Delivery Area Rates</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseThree" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city1; ?></label>
                                                                            <input class="form-control" name="Chadiza" value="<?php echo $Chadiza; ?>" type="text">
                                                                            <input class="form-control" name="city1" value="<?php echo $city1; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city2; ?></label>
                                                                            <input class="form-control" name="Chama" value="<?php echo $Chama; ?>" type="text">
                                                                            <input class="form-control" name="city2" value="<?php echo $city2; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city3; ?></label>
                                                                            <input class="form-control" name="Chambeshi" value="<?php echo $Chambeshi; ?>" type="text">
                                                                            <input class="form-control" name="city3" value="<?php echo $city3; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city4; ?></label>
                                                                            <input class="form-control" name="Chavuma" value="<?php echo $Chavuma; ?>" type="text">
                                                                            <input class="form-control" name="city4" value="<?php echo $city4; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city5; ?></label>
                                                                            <input class="form-control" name="Chembe" value="<?php echo $Chembe; ?>" type="text">
                                                                            <input class="form-control" name="city5" value="<?php echo $city5; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city6; ?></label>
                                                                            <input class="form-control" name="Chibombo" value="<?php echo $Chibombo; ?>" type="text">
                                                                            <input class="form-control" name="city6" value="<?php echo $city6; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city7; ?></label>
                                                                            <input class="form-control" name="Chiengi" value="<?php echo $Chiengi; ?>" type="text">
                                                                            <input class="form-control" name="city7" value="<?php echo $city7; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city8; ?></label>
                                                                            <input class="form-control" name="Chiliabombwe" value="<?php echo $Chiliabombwe; ?>" type="text">
                                                                            <input class="form-control" name="city8" value="<?php echo $city8; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city9; ?></label>
                                                                            <input class="form-control" name="Chilubi" value="<?php echo $Chilubi; ?>" type="text">
                                                                            <input class="form-control" name="city9" value="<?php echo $city9; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city10; ?></label>
                                                                            <input class="form-control" name="Chingola" value="<?php echo $Chingola; ?>" type="text">
                                                                            <input class="form-control" name="city10" value="<?php echo $city10; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city11; ?></label>
                                                                            <input class="form-control" name="Chinsali" value="<?php echo $Chinsali; ?>" type="text">
                                                                            <input class="form-control" name="city11" value="<?php echo $city11; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city12; ?></label>
                                                                            <input class="form-control" name="Chinyingi" value="<?php echo $Chinyingi; ?>" type="text">
                                                                            <input class="form-control" name="city12" value="<?php echo $city12; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city13; ?></label>
                                                                            <input class="form-control" name="Chipata" value="<?php echo $Chipata; ?>" type="text">
                                                                            <input class="form-control" name="city13" value="<?php echo $city13; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city14; ?></label>
                                                                            <input class="form-control" name="Chirundu" value="<?php echo $Chirundu; ?>" type="text">
                                                                            <input class="form-control" name="city14" value="<?php echo $city14; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city15; ?></label>
                                                                            <input class="form-control" name="Chisamba" value="<?php echo $Chisamba; ?>" type="text">
                                                                            <input class="form-control" name="city15" value="<?php echo $city15; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city16; ?></label>
                                                                            <input class="form-control" name="Choma" value="<?php echo $Choma; ?>" type="text">
                                                                            <input class="form-control" name="city16" value="<?php echo $city16; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city17; ?></label>
                                                                            <input class="form-control" name="Chongwe" value="<?php echo $Chongwe; ?>" type="text">
                                                                            <input class="form-control" name="city17" value="<?php echo $city17; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city18; ?></label>
                                                                            <input class="form-control" name="Gwembe" value="<?php echo $Gwembe; ?>" type="text">
                                                                            <input class="form-control" name="city18" value="<?php echo $city18; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city19; ?></label>
                                                                            <input class="form-control" name="Isoka" value="<?php echo $Isoka; ?>" type="text">
                                                                            <input class="form-control" name="city19" value="<?php echo $city19; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city20; ?></label>
                                                                            <input class="form-control" name="Kabompo" value="<?php echo $Kabompo; ?>" type="text">
                                                                            <input class="form-control" name="city20" value="<?php echo $city20; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city21; ?></label>
                                                                            <input class="form-control" name="Kabwe" value="<?php echo $Kabwe; ?>" type="text">
                                                                            <input class="form-control" name="city21" value="<?php echo $city21; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city22; ?></label>
                                                                            <input class="form-control" name="Kafue" value="<?php echo $Kafue; ?>" type="text">
                                                                            <input class="form-control" name="city22" value="<?php echo $city22; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city23; ?></label>
                                                                            <input class="form-control" name="Kafulwe" value="<?php echo $Kafulwe; ?>" type="text">
                                                                            <input class="form-control" name="city23" value="<?php echo $city23; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city24; ?></label>
                                                                            <input class="form-control" name="Kalabo" value="<?php echo $Kalabo; ?>" type="text">
                                                                            <input class="form-control" name="city24" value="<?php echo $city24; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city25; ?></label>
                                                                            <input class="form-control" name="Kalene_Hill" value="<?php echo $Kalene_Hill; ?>" type="text">
                                                                            <input class="form-control" name="city25" value="<?php echo $city25; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city26; ?></label>
                                                                            <input class="form-control" name="Kalomo" value="<?php echo $Kalomo; ?>" type="text">
                                                                            <input class="form-control" name="city26" value="<?php echo $city26; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city27; ?></label>
                                                                            <input class="form-control" name="Kalulushi" value="<?php echo $Kalulushi; ?>" type="text">
                                                                            <input class="form-control" name="city27" value="<?php echo $city27; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city28; ?></label>
                                                                            <input class="form-control" name="Kalumbila" value="<?php echo $Kalumbila; ?>" type="text">
                                                                            <input class="form-control" name="city28" value="<?php echo $city28; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city29; ?></label>
                                                                            <input class="form-control" name="Kansanshi" value="<?php echo $Kansanshi; ?>" type="text">
                                                                            <input class="form-control" name="city29" value="<?php echo $city29; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city30; ?></label>
                                                                            <input class="form-control" name="Kanyembo" value="<?php echo $Kanyembo; ?>" type="text">
                                                                            <input class="form-control" name="city30" value="<?php echo $city30; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city31; ?></label>
                                                                            <input class="form-control" name="Kaoma" value="<?php echo $Kaoma; ?>" type="text">
                                                                            <input class="form-control" name="city31" value="<?php echo $city31; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city32; ?></label>
                                                                            <input class="form-control" name="Kapiri_Mposhi" value="<?php echo $Kapiri_Mposhi; ?>" type="text">
                                                                            <input class="form-control" name="city32" value="<?php echo $city32; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city33; ?></label>
                                                                            <input class="form-control" name="Kasempa" value="<?php echo $Kasempa; ?>" type="text">
                                                                            <input class="form-control" name="city33" value="<?php echo $city33; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city34; ?></label>
                                                                            <input class="form-control" name="Kashikishi" value="<?php echo $Kashikishi; ?>" type="text">
                                                                            <input class="form-control" name="city34" value="<?php echo $city34; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city35; ?></label>
                                                                            <input class="form-control" name="Kataba" value="<?php echo $Kataba; ?>" type="text">
                                                                            <input class="form-control" name="city35" value="<?php echo $city35; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city36; ?></label>
                                                                            <input class="form-control" name="Katete" value="<?php echo $Katete; ?>" type="text">
                                                                            <input class="form-control" name="city36" value="<?php echo $city36; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city37; ?></label>
                                                                            <input class="form-control" name="Kawambwa" value="<?php echo $Kawambwa; ?>" type="text">
                                                                            <input class="form-control" name="city37" value="<?php echo $city37; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city38; ?></label>
                                                                            <input class="form-control" name="Kazembe_Mwansabombwe" value="<?php echo $Kazembe_Mwansabombwe; ?>" type="text">
                                                                            <input class="form-control" name="city38" value="<?php echo $city38; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city39; ?></label>
                                                                            <input class="form-control" name="Kazungula" value="<?php echo $Kazungula; ?>" type="text">
                                                                            <input class="form-control" name="city39" value="<?php echo $city39; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city40; ?></label>
                                                                            <input class="form-control" name="Kibombomene" value="<?php echo $Kibombomene; ?>" type="text">
                                                                            <input class="form-control" name="city40" value="<?php echo $city40; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city41; ?></label>
                                                                            <input class="form-control" name="Kitwe" value="<?php echo $Kitwe; ?>" type="text">
                                                                            <input class="form-control" name="city41" value="<?php echo $city41; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city42; ?></label>
                                                                            <input class="form-control" name="Luangwa" value="<?php echo $Luangwa; ?>" type="text">
                                                                            <input class="form-control" name="city42" value="<?php echo $city42; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city43; ?></label>
                                                                            <input class="form-control" name="Luanshya" value="<?php echo $Luanshya; ?>" type="text">
                                                                            <input class="form-control" name="city43" value="<?php echo $city43; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city44; ?></label>
                                                                            <input class="form-control" name="Lufwanyama" value="<?php echo $Lufwanyama; ?>" type="text">
                                                                            <input class="form-control" name="city44" value="<?php echo $city44; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city45; ?></label>
                                                                            <input class="form-control" name="Lukulu" value="<?php echo $Lukulu; ?>" type="text">
                                                                            <input class="form-control" name="city45" value="<?php echo $city45; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city46; ?></label>
                                                                            <input class="form-control" name="Lumwana" value="<?php echo $Lumwana; ?>" type="text">
                                                                            <input class="form-control" name="city46" value="<?php echo $city46; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city47; ?></label>
                                                                            <input class="form-control" name="Lundazi" value="<?php echo $Lundazi; ?>" type="text">
                                                                            <input class="form-control" name="city47" value="<?php echo $city47; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city48; ?></label>
                                                                            <input class="form-control" name="Lusaka" value="<?php echo $Lusaka; ?>" type="text">
                                                                            <input class="form-control" name="city48" value="<?php echo $city48; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city49; ?></label>
                                                                            <input class="form-control" name="Macha_Mission" value="<?php echo $Macha_Mission; ?>" type="text">
                                                                            <input class="form-control" name="city49" value="<?php echo $city49; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city50; ?></label>
                                                                            <input class="form-control" name="Makeni" value="<?php echo $Makeni; ?>" type="text">
                                                                            <input class="form-control" name="city50" value="<?php echo $city50; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city51; ?></label>
                                                                            <input class="form-control" name="Mansa" value="<?php echo $Mansa; ?>" type="text">
                                                                            <input class="form-control" name="city51" value="<?php echo $city51; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city52; ?></label>
                                                                            <input class="form-control" name="Mazabuka" value="<?php echo $Mazabuka; ?>" type="text">
                                                                            <input class="form-control" name="city52" value="<?php echo $city52; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city53; ?></label>
                                                                            <input class="form-control" name="Mbala" value="<?php echo $Mbala; ?>" type="text">
                                                                            <input class="form-control" name="city53" value="<?php echo $city53; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city54; ?></label>
                                                                            <input class="form-control" name="Mbereshi" value="<?php echo $Mbereshi; ?>" type="text">
                                                                            <input class="form-control" name="city54" value="<?php echo $city54; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city55; ?></label>
                                                                            <input class="form-control" name="Mfuwe" value="<?php echo $Mfuwe; ?>" type="text">
                                                                            <input class="form-control" name="city55" value="<?php echo $city55; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city56; ?></label>
                                                                            <input class="form-control" name="Milenge" value="<?php echo $Milenge; ?>" type="text">
                                                                            <input class="form-control" name="city56" value="<?php echo $city56; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city57; ?></label>
                                                                            <input class="form-control" name="Misisi" value="<?php echo $Misisi; ?>" type="text">
                                                                            <input class="form-control" name="city57" value="<?php echo $city57; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city58; ?></label>
                                                                            <input class="form-control" name="Mkushi" value="<?php echo $Mkushi; ?>" type="text">
                                                                            <input class="form-control" name="city58" value="<?php echo $city58; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city59; ?></label>
                                                                            <input class="form-control" name="Mongu" value="<?php echo $Mongu; ?>" type="text">
                                                                            <input class="form-control" name="city59" value="<?php echo $city59; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city60; ?></label>
                                                                            <input class="form-control" name="Monze" value="<?php echo $Monze; ?>" type="text">
                                                                            <input class="form-control" name="city60" value="<?php echo $city60; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city61; ?></label>
                                                                            <input class="form-control" name="Mpika" value="<?php echo $Mpika; ?>" type="text">
                                                                            <input class="form-control" name="city61" value="<?php echo $city61; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city62; ?></label>
                                                                            <input class="form-control" name="Mporokoso" value="<?php echo $Mporokoso; ?>" type="text">
                                                                            <input class="form-control" name="city62" value="<?php echo $city62; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city63; ?></label>
                                                                            <input class="form-control" name="Mpulungu" value="<?php echo $Mpulungu; ?>" type="text">
                                                                            <input class="form-control" name="city63" value="<?php echo $city63; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city64; ?></label>
                                                                            <input class="form-control" name="Mufulira" value="<?php echo $Mufulira; ?>" type="text">
                                                                            <input class="form-control" name="city64" value="<?php echo $city64; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city65; ?></label>
                                                                            <input class="form-control" name="Mumbwa" value="<?php echo $Mumbwa; ?>" type="text">
                                                                            <input class="form-control" name="city65" value="<?php echo $city65; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city66; ?></label>
                                                                            <input class="form-control" name="Muyombe" value="<?php echo $Muyombe; ?>" type="text">
                                                                            <input class="form-control" name="city66" value="<?php echo $city66; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city67; ?></label>
                                                                            <input class="form-control" name="Mwinilunga" value="<?php echo $Mwinilunga; ?>" type="text">
                                                                            <input class="form-control" name="city67" value="<?php echo $city67; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city68; ?></label>
                                                                            <input class="form-control" name="Nchelenge" value="<?php echo $Nchelenge; ?>" type="text">
                                                                            <input class="form-control" name="city68" value="<?php echo $city68; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city69; ?></label>
                                                                            <input class="form-control" name="Ndola" value="<?php echo $Ndola; ?>" type="text">
                                                                            <input class="form-control" name="city69" value="<?php echo $city69; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city70; ?></label>
                                                                            <input class="form-control" name="Ngoma" value="<?php echo $Ngoma; ?>" type="text">
                                                                            <input class="form-control" name="city70" value="<?php echo $city70; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city71; ?></label>
                                                                            <input class="form-control" name="Nkana" value="<?php echo $Nkana; ?>" type="text">
                                                                            <input class="form-control" name="city71" value="<?php echo $city71; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city72; ?></label>
                                                                            <input class="form-control" name="Nseluka" value="<?php echo $Nseluka; ?>" type="text">
                                                                            <input class="form-control" name="city72" value="<?php echo $city72; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city73; ?></label>
                                                                            <input class="form-control" name="Pemba" value="<?php echo $Pemba; ?>" type="text">
                                                                            <input class="form-control" name="city73" value="<?php echo $city73; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city74; ?></label>
                                                                            <input class="form-control" name="Petauke" value="<?php echo $Petauke; ?>" type="text">
                                                                            <input class="form-control" name="city74" value="<?php echo $city74; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city75; ?></label>
                                                                            <input class="form-control" name="Samfya" value="<?php echo $Samfya; ?>" type="text">
                                                                            <input class="form-control" name="city75" value="<?php echo $city75; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city76; ?></label>
                                                                            <input class="form-control" name="Senanga" value="<?php echo $Senanga; ?>" type="text">
                                                                            <input class="form-control" name="city76" value="<?php echo $city76; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city77; ?></label>
                                                                            <input class="form-control" name="Serenje" value="<?php echo $Serenje; ?>" type="text">
                                                                            <input class="form-control" name="city77" value="<?php echo $city77; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city78; ?></label>
                                                                            <input class="form-control" name="Sesheke" value="<?php echo $Sesheke; ?>" type="text">
                                                                            <input class="form-control" name="city78" value="<?php echo $city78; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city79; ?></label>
                                                                            <input class="form-control" name="Shiwa_Ngandu" value="<?php echo $Shiwa_Ngandu; ?>" type="text">
                                                                            <input class="form-control" name="city79" value="<?php echo $city79; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city80; ?></label>
                                                                            <input class="form-control" name="Siavonga" value="<?php echo $Siavonga; ?>" type="text">
                                                                            <input class="form-control" name="city80" value="<?php echo $city80; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city81; ?></label>
                                                                            <input class="form-control" name="Sikalongo" value="<?php echo $Sikalongo; ?>" type="text">
                                                                            <input class="form-control" name="city81" value="<?php echo $city81; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city82; ?></label>
                                                                            <input class="form-control" name="Sinazongwe" value="<?php echo $Sinazongwe; ?>" type="text">
                                                                            <input class="form-control" name="city82" value="<?php echo $city82; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city83; ?></label>
                                                                            <input class="form-control" name="Solwezi" value="<?php echo $Solwezi; ?>" type="text">
                                                                            <input class="form-control" name="city83" value="<?php echo $city83; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city84; ?></label>
                                                                            <input class="form-control" name="Zambezi" value="<?php echo $Zambezi; ?>" type="text">
                                                                            <input class="form-control" name="city84" value="<?php echo $city84; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city85; ?></label>
                                                                            <input class="form-control" name="Zimba" value="<?php echo $Zimba; ?>" type="text">
                                                                            <input class="form-control" name="city85" value="<?php echo $city85; ?>" type="text">
                                                                        </div>
                                                                        <div class="form-group col-lg-2">
                                                                            <label><?php echo $city86; ?></label>
                                                                            <input class="form-control" name="Other" value="<?php echo $Other; ?>" type="text">
                                                                            <input class="form-control" name="city86" value="<?php echo $city86; ?>" type="text">
                                                                        </div>
                                                                      
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!------------------------------ Freight Tonne------------------------------>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTonne">Freight Tonnage Rates</a>
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
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseCommission">Commission % Rates</a>
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

                                $email_from = "admin@" . $web_url;
                                $email_to = $email;
                                $subject = '<img src="//images/logo.png" alt="logo">';
                                $message = 'Hi!\n ' . $site_name . ' has invited you to signup to become an admin.\n\n <a href="adminUsers.php">Click here</a> to enter your details.';

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
        
    
    
    <script>
    document.addEventListener("DOMContentLoaded", async function () {
        const primaryCurrency = document.getElementById("primaryCurrency");
        const secondaryCurrency = document.getElementById("secondaryCurrency");
        const ExchangeRateInput = document.getElementById("ExchangeRate");
        const editExchangeRate = document.getElementById("editExchangeRate");

        // Static currency symbol mapping
        const currencySymbols = {
            USD: "$", // United States Dollar
            EUR: "€", // Euro
            GBP: "£", // British Pound Sterling
            JPY: "¥", // Japanese Yen
            AUD: "A$", // Australian Dollar
            CAD: "C$", // Canadian Dollar
            CHF: "CHF", // Swiss Franc
            CNY: "¥", // Chinese Yuan Renminbi
            INR: "₹", // Indian Rupee
            ZAR: "R", // South African Rand
            MXN: "$", // Mexican Peso
            NZD: "$", // New Zealand Dollar
            SGD: "S$", // Singapore Dollar
            HKD: "HK$", // Hong Kong Dollar
            NOK: "kr", // Norwegian Krone
            SEK: "kr", // Swedish Krona
            DKK: "kr", // Danish Krone
            PLN: "zł", // Polish Zloty
            RUB: "₽", // Russian Ruble
            BRL: "R$", // Brazilian Real
            THB: "฿", // Thai Baht
            IDR: "Rp", // Indonesian Rupiah
            TRY: "₺", // Turkish Lira
            MYR: "RM", // Malaysian Ringgit
            KRW: "₩", // South Korean Won
            TWD: "NT$", // Taiwan Dollar
            PHP: "₱", // Philippine Peso
            VND: "₫", // Vietnamese Dong
            ARS: "$", // Argentine Peso
            CLP: "$", // Chilean Peso
            COP: "$", // Colombian Peso
            PEN: "S/", // Peruvian Sol
            PKR: "₨", // Pakistani Rupee
            NGN: "₦", // Nigerian Naira
            EGP: "£", // Egyptian Pound
            ZWL: "ZW$", // Zimbabwean Dollar
            ZMW: "ZK", // Zambian Kwacha
            CZK: "Kč", // Czech Koruna
            HUF: "Ft", // Hungarian Forint
            ISK: "kr", // Icelandic Króna
            ILS: "₪", // Israeli Shekel
            KZT: "₸", // Kazakhstani Tenge
            SAR: "﷼", // Saudi Riyal
            AED: "د.إ", // UAE Dirham
            BHD: "ب.د", // Bahraini Dinar
            OMR: "﷼", // Omani Rial
            KWD: "د.ك", // Kuwaiti Dinar
            QAR: "﷼", // Qatari Riyal
            JOD: "د.ا", // Jordanian Dinar
            LBP: "ل.ل", // Lebanese Pound
            LYD: "ل.د", // Libyan Dinar
            MAD: "د.م.", // Moroccan Dirham
            TND: "د.ت", // Tunisian Dinar
            SDG: "ج.س.", // Sudanese Pound
            UZS: "лв", // Uzbekistani Som
            GEL: "₾", // Georgian Lari
            MDL: "L", // Moldovan Leu
            RON: "lei", // Romanian Leu
            BGN: "лв", // Bulgarian Lev
            BAM: "KM", // Bosnian Convertible Marka
            BYN: "Br", // Belarusian Ruble
            ALL: "Lek", // Albanian Lek
            MKD: "ден", // Macedonian Denar
            AMD: "֏", // Armenian Dram
            AZN: "₼", // Azerbaijani Manat
            MNT: "₮", // Mongolian Tugrik
            KHR: "៛", // Cambodian Riel
            MMK: "K", // Myanmar Kyat
            LAK: "₭", // Lao Kip
            BDT: "৳", // Bangladeshi Taka
            NPR: "₨", // Nepalese Rupee
            LKR: "₨", // Sri Lankan Rupee
            UGX: "USh", // Ugandan Shilling
            KES: "KSh", // Kenyan Shilling
            TZS: "TSh", // Tanzanian Shilling
            GHS: "₵", // Ghanaian Cedi
            BWP: "P", // Botswana Pula
            MUR: "₨", // Mauritian Rupee
            SCR: "₨", // Seychellois Rupee
            MZN: "MT", // Mozambican Metical
            ANG: "ƒ", // Netherlands Antillean Guilder
            AWG: "ƒ", // Aruban Florin
            HNL: "L", // Honduran Lempira
            CRC: "₡", // Costa Rican Colón
            DOP: "RD$", // Dominican Peso
            JMD: "J$", // Jamaican Dollar
            BBD: "Bds$", // Barbadian Dollar
            TTD: "TT$", // Trinidad and Tobago Dollar
            XCD: "EC$", // East Caribbean Dollar
            BSD: "B$", // Bahamian Dollar
            KYD: "CI$", // Cayman Islands Dollar
            FJD: "FJ$", // Fijian Dollar
            WST: "WS$", // Samoan Tala
            VUV: "VT", // Vanuatu Vatu
            TOP: "T$", // Tongan Paʻanga
            PGK: "K", // Papua New Guinean Kina
            SBD: "SI$", // Solomon Islands Dollar
            BTN: "Nu.", // Bhutanese Ngultrum
            MGA: "Ar", // Malagasy Ariary
            AOA: "Kz", 
            MWK: "MK",// Angolan Kwanza // Example for custom local currency
                // Add more symbols as needed
        };

        const apiBaseUrl = "https://api.exchangerate-api.com/v4/latest/";

        async function fetchCurrencies() {
            try {
                const response = await fetch(`${apiBaseUrl}USD`);
                const data = await response.json();
                const currencyCodes = Object.keys(data.rates);
                populateDropdowns(currencyCodes);
            } catch (error) {
                console.error("Error fetching currencies:", error);
            }
        }

        function populateDropdowns(currencies) {
            const options = currencies.map(code => 
                `<option value="${code}">${currencySymbols[code] || code} (${code})</option>`
            ).join("");
            primaryCurrency.innerHTML = options;
            secondaryCurrency.innerHTML = options;

            // Restore saved values if available
            if (primaryCurrency.dataset.savedValue) {
                primaryCurrency.value = primaryCurrency.dataset.savedValue;
            }
            if (secondaryCurrency.dataset.savedValue) {
                secondaryCurrency.value = secondaryCurrency.dataset.savedValue;
            }
        }

        async function fetchExchangeRate(base, target) {
            try {
                const response = await fetch(`${apiBaseUrl}${base}`);
                const data = await response.json();
                return data.rates[target];
            } catch (error) {
                console.error(`Error fetching exchange rate from ${base} to ${target}:`, error);
                return null;
            }
        }

        async function updateExchangeRate() {
            const baseCurrency = primaryCurrency.value;
            const targetCurrency = secondaryCurrency.value;

            if (!editExchangeRate.checked) {
                const rate = await fetchExchangeRate(baseCurrency, targetCurrency);
                if (rate !== null) {
                    ExchangeRateInput.value = rate.toFixed(2);
                } else {
                    ExchangeRateInput.value = "Error fetching rate";
                }
            }
        }

        editExchangeRate.addEventListener("change", function () {
            ExchangeRateInput.readOnly = !this.checked;
            if (!this.checked) {
                updateExchangeRate();
            }
        });

        primaryCurrency.addEventListener("change", updateExchangeRate);
        secondaryCurrency.addEventListener("change", updateExchangeRate);

        await fetchCurrencies(); // Populate dropdowns on page load
    });
</script>



    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>



