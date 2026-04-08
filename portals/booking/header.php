 <?php
 require("../function.php"); 
 
 $aData = json_decode(file_get_contents("../admin/pages/keys.json"));
// echo "<pre>" . print_r($aData, true) . "</pre>";
$showStripe = isset($aData->stripe_handle) ? $aData->stripe_handle : "";
$showPaynow = isset($aData->paynow_handle) ? $aData->paynow_handle : "";
 
 ?>
 <?php
    // var_dump($Connect);
    $get = "SELECT * FROM `prizelist` WHERE company_name='merchant'";

    $stmt = $DB->prepare( $get);

    foreach ($results as $1) {
        $ID = $row_type['ID'];
        $exchange_rate = $row_type['exchange_rate'];
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
    }


    ?>
    <?php
    // var_dump($Connect);
    // die;
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
    $user = $_SESSION['CC_Username'];
    $get = "SELECT * FROM `businesspartners` WHERE email='$user'";
    $stmt = $DB->prepare( $get);
    $name = '';
    foreach ($results as $1) {
        $name = $row_type['businessName'];
        $affiliate_no = $row_type['affiliate_no'];
        $email = $row_type['email'];
        $phone = $row_type['phone'];
        $btype = $row_type['businessType'];
        $address = $row_type['address'];
        $city = $row_type['businessLocation'];
        $contact_name = $row_type['NameOfContact'];
        $person_phone = $row_type['PersonPhone'];
    }
    if ($name == "") {
        $get_user = "SELECT * FROM `users` WHERE email='$user'";
        $stmt = $DB->prepare( $get_user);

        foreach ($results as $1) {
            $name = $row_type['Name'];
            $affiliate_no = $row_type['affiliate_no'];
            $email = $row_type['email'];
            $phone = $row_type['phone'];
        }
    }
    ?>

    <?php
    $aData = json_decode(file_get_contents("../config/keys.json"));
    $mapApi = !empty($aData->mapApi) ? $aData->mapApi : "";
    ?>
    
    <!-- Include sidebar navigation and menu -->
        <?php include 'sidebar-nav-menu.php'; ?>

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
      <!-- ========== header start ========== -->
      <header class="header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
              <div class="header-left d-flex align-items-center">
                <div class="menu-toggle-btn mr-20">
                  <button
                    id="menu-toggle"
                    class="main-btn primary-btn btn-hover"
                  >
                    <i class="lni lni-chevron-left me-2"></i> Menu
                  </button>
                </div>
                <div class="header-search d-none d-md-flex">
                  <form action="#">
                    <input type="text" placeholder="Search..." />
                    <button><i class="lni lni-search-alt"></i></button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
              <div class="header-right">
                <!-- notification start -->
                <div class="notification-box ml-15 d-none d-md-flex">
                  <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown" aria-expanded="false" >
                    <i class="lni lni-alarm"></i>
                    <span>0</span>
                  </button>
                  <ul
                    class="dropdown-menu dropdown-menu-end"
                    aria-labelledby="notification" >
                    <li>
                      <a href="#0">
                        <div class="image">
                          <img src="assets/images/lead/lead-6.png" alt="" />
                        </div>
                        <div class="content">
                          <h6>
                            John Doe
                            <span class="text-regular">
                              comment on a product.
                            </span>
                          </h6>
                          <p>
                            Lorem ipsum dolor sit amet, consect etur adipiscing
                            elit Vivamus tortor.
                          </p>
                          <span>10 mins ago</span>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
                <!-- notification end -->
               
                <!-- profile start -->
                <div class="profile-box ml-15">
                  <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-info">
                      <div class="info">
                        <h6><?php echo $name; ?></h6>
                        <div class="image">
                          <img
                            src="assets/images/profile/PersonPlaceholder2.png"
                            alt=""/>
                          <span class="status"></span>
                        </div>
                      </div>
                    </div>
                    <i class="lni lni-chevron-down"></i>
                  </button>
                  <ul
                    class="dropdown-menu dropdown-menu-end"
                    aria-labelledby="profile"
                  >
                    <li>
                      <a href="settings.php">
                        <i class="lni lni-user"></i> View Profile
                      </a>
                    </li>
                    <li>
                      <a href="#0">
                        <i class="lni lni-alarm"></i> Notifications
                      </a>
                    </li>
                    <li>
                      <a href="settings.php"> <i class="lni lni-cog"></i> Settings </a>
                    </li>
                    <li>
                      <a href="<?php echo $logoutAction ?>"> <i class="lni lni-exit"></i> Sign Out </a>
                    </li>
                  </ul>
                </div>
                <!-- profile end -->
              </div>
            </div>
          </div>
        </div>
      </header>
      <!-- ========== header end ========== -->

