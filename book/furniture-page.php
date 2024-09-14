<?php require ("signin-security.php"); ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="assets/images/favicon.png"
      type="image/x-icon"
    />
    <title>Book your freight and logistics heavy trucks here | Merchant Couriers</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/lineicons.css" />
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
   

    <!-- ============================================================ -->
    <style>
      form#multiphase>#phase2,
      #phase3,
      #sho_fo, 
      #loaders_div{
          display: none;
      }
    
      form#multiphase>
      #phase2,
      #phase3,
      #sho_msg {
          display: none;
      }
  </style>

   
    <!-- ============================================================ -->

  </head>
  <body>
    <!-- ======== sidebar-nav start =========== -->
    <?php include("header.php"); ?>
      <!-- ========== header end ========== -->

      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="titlemb-30">
                  <h2>Furniture Delivery</h2>
                </div>
              </div>
              <!-- end col -->
              <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="#0">Dashboard</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                      Furniture Page
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- ========== title-wrapper end ========== -->
          <div class="row">
           <!-- input style start -->
           <div class="card-style mb-30">
            
            <form action="<?php echo $editFormAction; ?>" method="POST" id="multiphase" onsubmit="showLocation();calcRoute(); return false" name="bookingform">
              <div id="phase1">
                    <input id="totalp" value="<?php echo $Price_per_km; ?>" type="hidden">
                    <input id="totalW" value="<?php echo $weight; ?>" type="hidden">
                    <input id="totalC" value="<?php echo $Car_per_km; ?>" type="hidden">
                    <input id="totalT" value="<?php echo $Cost_per_item; ?>" type="hidden">
                    <input id="totalIn" value="<?php echo $Insurance; ?>" type="hidden">
                    <input id="totalB" value="<?php echo $Base_price; ?>" type="hidden">
                    <input id="min_freight" value="<?php echo $min_freight; ?>" type="hidden">
                    <input id="value_L1" value="<?php echo $value_L1; ?>" type="hidden">
                    <input id="value_L2" value="<?php echo $value_L2; ?>" type="hidden">
                    <input id="value_L3" value="<?php echo $value_L3; ?>" type="hidden">
                    <input id="value_L4" value="<?php echo $value_L4; ?>" type="hidden">
                    <input id="value_L5" value="<?php echo $value_L5; ?>" type="hidden">
                    <input id="zim_dollar_rate" value="<?php echo $zim_dollar_rate; ?>" type="hidden">
                    <input id="loader_price" value="<?php echo $loader_price; ?>" type="hidden">
    
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
                    <input id="tonne_1" value="<?php echo $tonne_1; ?>" type="hidden">
                    <input id="tonne_2" value="<?php echo $tonne_2; ?>" type="hidden">
                    <input id="tonne_3" value="<?php echo $tonne_3; ?>" type="hidden">
                    <input id="tonne_4" value="<?php echo $tonne_4; ?>" type="hidden">
                    <input id="tonne_5" value="<?php echo $tonne_5; ?>" type="hidden">
                    <input id="tonne_6" value="<?php echo $tonne_6; ?>" type="hidden">
                    <input id="tonne_7" value="<?php echo $tonne_7; ?>" type="hidden">
                    <input id="tonne_8" value="<?php echo $tonne_8; ?>" type="hidden">
                    <input id="tonne_9" value="<?php echo $tonne_9; ?>" type="hidden">
                    <input id="tonne_10" value="<?php echo $tonne_10; ?>" type="hidden">
                    <input id="tonne_11" value="<?php echo $tonne_11; ?>" type="hidden">
                    <input id="tonne_12" value="<?php echo $tonne_12; ?>" type="hidden">
                    <input id="tonne_13" value="<?php echo $tonne_13; ?>" type="hidden">
                    <input id="tonne_14" value="<?php echo $tonne_14; ?>" type="hidden">
                    <input id="tonne_15" value="<?php echo $tonne_15; ?>" type="hidden">
                    <input id="tonne_16" value="<?php echo $tonne_16; ?>" type="hidden">
                    <input id="tonne_17" value="<?php echo $tonne_17; ?>" type="hidden">
                    <input id="tonne_18" value="<?php echo $tonne_18; ?>" type="hidden">
                    <input id="tonne_19" value="<?php echo $tonne_19; ?>" type="hidden">
                    <input id="tonne_20" value="<?php echo $tonne_20; ?>" type="hidden">
                    <input id="tonne_21" value="<?php echo $tonne_21; ?>" type="hidden">
                    <input id="tonne_22" value="<?php echo $tonne_22; ?>" type="hidden">
                    <input id="tonne_23" value="<?php echo $tonne_23; ?>" type="hidden">
                    <input id="tonne_24" value="<?php echo $tonne_24; ?>" type="hidden">
                    <input id="tonne_25" value="<?php echo $tonne_25; ?>" type="hidden">
                    <input id="tonne_26" value="<?php echo $tonne_26; ?>" type="hidden">
                    <input id="tonne_27" value="<?php echo $tonne_27; ?>" type="hidden">
                    <input id="tonne_28" value="<?php echo $tonne_28; ?>" type="hidden">
                    <input id="tonne_29" value="<?php echo $tonne_29; ?>" type="hidden">
                    <input id="tonne_30" value="<?php echo $tonne_30; ?>" type="hidden">
                    <input id="tonne_31" value="<?php echo $tonne_31; ?>" type="hidden">
                    <input id="tonne_32" value="<?php echo $tonne_32; ?>" type="hidden">
                    <input id="tonne_33" value="<?php echo $tonne_33; ?>" type="hidden">
                    <input id="tonne_34" value="<?php echo $tonne_34; ?>" type="hidden">
                    <input type="hidden" name="affiliate_no" class="form-control" value="<?php echo $affiliate_no; ?>" required />
                  
                    <input type="hidden" placeholder="Full Name" value="<?php echo $name; ?>" id="name" name="name">
                    <input type="hidden" placeholder="email address" value="<?php echo $email; ?>" id="email" name="email">
                    <input type="hidden" placeholder="Phone Number" value="<?php echo $phone; ?>" id="phone" name="phone">
                    <!--==================== End hidden ====================-->
            <h6 class="mb-25">Enter Pick Up Details!</h6>
            <div class="row">
            <div class="col-md-6">
            <div class="input-style-2">
                <label>Pick Address</label>
                <input id="autocomplete" placeholder="Enter your address" type="text" name="address" onFocus="geolocate()">
              <span class="icon"> <i class="lni lni-map-marker"></i> </span>
            </div>
             <span style="color:red" id="addstatus"></span>
           </div>
            <!-- end input -->
            <div class="col-md-6">
           <div class="input-style-2">
               <label>Delivery Address</label>
             <input type="text" placeholder="Delivery Address"  name="drop_address" id="drop_address" onFocus="geolocate()" />
             <span class="icon"> <i class="lni lni-map-marker"></i> </span>
           </div>
            <span style="color:red" id="addstatus2"></span>
          </div>
           <!-- end input -->
             
        </div>
        <!-- end row -->

        <div class="row">
       
            <div class="col-md-6">
                <div class="select-style-1">
                    <label>Area of Delivery</label>
                    <div class="select-position">
                      <select name="area_delivery" id="area_d" required placeholder="amount" onChange="shoPricePhase1()">
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
                    </div>
                  </div>
                  <!-- end select -->
            </div>
           <!-- end col -->
           <div class="col-md-6">
            <div class="select-style-1">
                <label>Truck Size (in tonnes)</label>
                <div class="select-position">
                <select placeholder="Weight in tonnes per truck" name="weight_of_package" id="weight_of_package" onchange="calculateTotal()" onFocus="shoPricePhase1()">
                        <option></option>
                        <option>1 tonne</option>
                        <option>2 tonne</option>
                        <option>3 tonne</option>
                        <option>4 tonne</option>
                        <option>5 tonne</option>
                        <option>6 tonne</option>
                        <option>7 tonne</option>
                        <option>8 tonne</option>
                        <option>9 tonne</option>
                        <option>10 tonne</option>
                        <option>11 tonne</option>
                        <option>12 tonne</option>
                        <option>13 tonne</option>
                        <option>14 tonne</option>
                        <option>15 tonne</option>
                        <option>16 tonne</option>
                        <option>17 tonne</option>
                        <option>18 tonne</option>
                        <option>19 tonne</option>
                        <option>20 tonne</option>
                        <option>21 tonne</option>
                        <option>22 tonne</option>
                        <option>23 tonne</option>
                        <option>24 tonne</option>
                        <option>25 tonne</option>
                        <option>26 tonne</option>
                        <option>27 tonne</option>
                        <option>28 tonne</option>
                        <option>29 tonne</option>
                        <option>30 tonne</option>
                        <option>31 tonne</option>
                        <option>32 tonne</option>
                        <option>32 tonne</option>
                        <option>33 tonne</option>
                        <option>34 tonne</option>
                    </select>
                    
                </div>
                <span style="color:red" id="weight"></span>
              </div>
              <!-- end select -->
        </div>
       <!-- end col -->
          
       </div>
       <!-- end row -->

       <div class="row">
       <div class="col-md-6">
        <div class="select-style-1">
            <label>Number of Trucks Required</label>
            <div class="select-position">
            <select type="number" name="trucks_num" id="trucks_num" onchange="calculateTotal()">
                <option value="0"></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
            </select>
            </div>
            <span style="color:red" id="valueofpackage"></span>
          </div>
          <!-- end select -->
      </div>
       <!-- end col -->
       <div class="col-md-6">
        <div class="select-style-1">
            <label>I need Furniture Lifters (Yes/No)</label>
            <div class="select-position">
            <select name="loaders" id="loaders" onchange="calculateTotal()">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </div>
          </div>
          <!-- end select -->
           <span style="color:red" id="inr"></span>
    </div>
   <!-- end col -->
   </div>
   <!-- end row -->

<div class="row">
<div id="loaders_div">
<div class="col-md-6">
        <div class="select-style-1">
            <label>How many lifters?</label>
            <div class="select-position">
            <select type="number" name="loader_num" id="loader_num" onchange="calculateTotal()">
                    <option value="0"></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                </select>
            </div>
          </div>
          <!-- end select -->
    </div>
   <!-- end col --> 
</div>
<!-- End loaders -->
   <div class="col-md-6">
        <input type="hidden" name="c_disc" id="c_disc">
   <div class="input-style-2">
    <label>Coupon</label>
    <input placeholder="Enter your Coupon" type="text" name="coupon" id="coupon" onkeyup="getCouponDiscount()" onFocus="geolocate()">
     <span class="icon"> <i class="lni lni-ticket"></i> </span>
   </div>
  </div>
   <!-- end input -->
    
</div>
<!-- end row -->

 
     <!-- show price start -->
     <div class="row">
      <div class="col-8">
     <div class="primary-alert">
      <div class="alert">
        <h4 class="alert-heading">Total price: $ <span id="tp_phase1"></span></h4>
      </div>
    </div>
      </div>
       <!-- end col -->
       <div class="col-4">
        <div class="alert-box primary-alert">
            <div class="alert">
              <select id="price_in" onchange="calculateTotal(1);" >
                <option value="USD">USD</option>
                <option value="RTGS">RTGS</option>
            </select>
            </div>
          </div>
          <!-- end select -->
    </div>
     </div>
    <!-- show price end -->
<div class="row">
<div class="col-md-6">
    <div class="button-group d-flex justify-content-center flex-wrap action">
      <button class="main-btn light-btn btn-hover w-100 text-center" id="moreAction" data-bs-toggle="dropdown" aria-expanded="false">
         Share Quote
      </button>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction">
        <li class="dropdown-item">
        <a class="text-gray" href="#0" onclick="sho_email();"> Email Quote </a>
        </li>
        <li class="dropdown-item">
        <a class="text-gray" href="#0" onclick="sho_sms();"> SMS Quote </a>
        </li>
        <li class="dropdown-item">
        <a class="text-gray" href="#0" onclick="sendWhatsApp()">Whatsapp Message</a>
        </li>
      </ul>
      
  </div>
  </div>
  <div class="col-md-6">
    <div class="button-group d-flex justify-content-center flex-wrap">
      <button onclick="processPhase1();" id="sign-in-button" class="main-btn primary-btn btn-hover w-100 text-center">
        Next
      </button>
  </div>
  </div>
  <!-- end col -->
   <!--====================== Share Quotation =======================-->
  <span id="sho_fo">
        <div class="col-md-12">
           <div class="input-style-2">
            <label>Email Quote</label>
             <input type="text" id="email_quote" placeholder="name@domain.com" name="email_invo2">
             <a href="0#" class="icon" onClick="SendQuote()"><i class="lni lni-arrow-right-circle"></i></a> 
           </div>
         </div>
    </span>
    
    <span id="sho_msg">
            <div class="col-md-12">
               <div class="input-style-2">
                <label>Message Quote</label>
                  <input type="tel" id="sms_quote"  placeholder="enter phone number " name="sms_invo2">
                 <a href="0#" class="icon" onClick="SendMsg()"><i class="lni lni-arrow-right-circle"></i></a> 
               </div>
             </div> 
        </span>
    <!--====================== End Share Quotation =======================-->
</div>
<!-- end row -->
</div>
  <!-- ================== End Phase one ================ -->
   <!--------------------------------------------- Phase 2 -------------------------------------------------->
   <div id="phase2">
    <div class="row">
    <div class="text-center">
        <h4>Pick Up Details</h4>
        Address:<span class="glyphicon glyphicon-map-marker"></span><span id="display_address" style="text-transform: uppercase"></span><br>
        Delivery Address:<span class="glyphicon glyphicon-map-marker"></span><span id="display_drop_address" style="text-transform: uppercase"></span><br>
        <!--<span style=" font-size: medium;"> Date: </span> <span class="icon-calendar"></span> <span id="display_pickupdate" style="text-transform: uppercase;"></span>-->
        <!--<span style=" font-size: medium;"> Time: </span> <span class="icon-time"></span> <span id="display_pickuptime" style="text-transform: uppercase;"></span>-->
        <span><a href="#" onclick="change_phase1()" style="color:orange;">Change</a></span><br /><br />
    </div>
    </div>
    <!-- end row -->
    <h6 class="mb-25">Enter drop off details!</h6>

    <div class="row">
        <!-- end col -->
        <div class="col-md-6">
          <div class="input-style-2">
              <label>Full Name (receiver/company)</label>
              <input type="text" placeholder="Full Name" id="drop_name" name="drop_name">
            <span class="icon"> <i class="lni lni-user"></i> </span>
          </div>
          <span style="color:red" id="namestatus2"></span>
         </div>
          <!-- end input -->

           <!-- end col -->
        <div class="col-md-6">
           <div class="col-12">
            <div class="row">
              <label>Phone Number (receiver)</label>
            <div class="col-4">
            <div class="select-style-1">
            
            <div class="select-position">
                  <select name="countryCode" id="countryCode" class="col-md-03">
                      <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                      <optgroup label="Other countries">
                          <option data-countryCode="DZ" value="213">Algeria (+213)</option>
                          <option data-countryCode="AD" value="376">Andorra (+376)</option>
                          <option data-countryCode="AO" value="244">Angola (+244)</option>
                          <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
                          <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                          <option data-countryCode="AR" value="54">Argentina (+54)</option>
                          <option data-countryCode="AM" value="374">Armenia (+374)</option>
                          <option data-countryCode="AW" value="297">Aruba (+297)</option>
                          <option data-countryCode="AU" value="61">Australia (+61)</option>
                          <option data-countryCode="AT" value="43">Austria (+43)</option>
                          <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
                          <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
                          <option data-countryCode="BH" value="973">Bahrain (+973)</option>
                          <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
                          <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
                          <option data-countryCode="BY" value="375">Belarus (+375)</option>
                          <option data-countryCode="BE" value="32">Belgium (+32)</option>
                          <option data-countryCode="BZ" value="501">Belize (+501)</option>
                          <option data-countryCode="BJ" value="229">Benin (+229)</option>
                          <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
                          <option data-countryCode="BT" value="975">Bhutan (+975)</option>
                          <option data-countryCode="BO" value="591">Bolivia (+591)</option>
                          <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
                          <option data-countryCode="BW" value="267">Botswana (+267)</option>
                          <option data-countryCode="BR" value="55">Brazil (+55)</option>
                          <option data-countryCode="BN" value="673">Brunei (+673)</option>
                          <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
                          <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
                          <option data-countryCode="BI" value="257">Burundi (+257)</option>
                          <option data-countryCode="KH" value="855">Cambodia (+855)</option>
                          <option data-countryCode="CM" value="237">Cameroon (+237)</option>
                          <option data-countryCode="CA" value="1">Canada (+1)</option>
                          <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
                          <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
                          <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
                          <option data-countryCode="CL" value="56">Chile (+56)</option>
                          <option data-countryCode="CN" value="86">China (+86)</option>
                          <option data-countryCode="CO" value="57">Colombia (+57)</option>
                          <option data-countryCode="KM" value="269">Comoros (+269)</option>
                          <option data-countryCode="CG" value="242">Congo (+242)</option>
                          <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
                          <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
                          <option data-countryCode="HR" value="385">Croatia (+385)</option>
                          <option data-countryCode="CU" value="53">Cuba (+53)</option>
                          <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
                          <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
                          <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
                          <option data-countryCode="DK" value="45">Denmark (+45)</option>
                          <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
                          <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                          <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
                          <option data-countryCode="EC" value="593">Ecuador (+593)</option>
                          <option data-countryCode="EG" value="20">Egypt (+20)</option>
                          <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                          <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
                          <option data-countryCode="ER" value="291">Eritrea (+291)</option>
                          <option data-countryCode="EE" value="372">Estonia (+372)</option>
                          <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
                          <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
                          <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
                          <option data-countryCode="FJ" value="679">Fiji (+679)</option>
                          <option data-countryCode="FI" value="358">Finland (+358)</option>
                          <option data-countryCode="FR" value="33">France (+33)</option>
                          <option data-countryCode="GF" value="594">French Guiana (+594)</option>
                          <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
                          <option data-countryCode="GA" value="241">Gabon (+241)</option>
                          <option data-countryCode="GM" value="220">Gambia (+220)</option>
                          <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
                          <option data-countryCode="DE" value="49">Germany (+49)</option>
                          <option data-countryCode="GH" value="233">Ghana (+233)</option>
                          <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
                          <option data-countryCode="GR" value="30">Greece (+30)</option>
                          <option data-countryCode="GL" value="299">Greenland (+299)</option>
                          <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
                          <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
                          <option data-countryCode="GU" value="671">Guam (+671)</option>
                          <option data-countryCode="GT" value="502">Guatemala (+502)</option>
                          <option data-countryCode="GN" value="224">Guinea (+224)</option>
                          <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
                          <option data-countryCode="GY" value="592">Guyana (+592)</option>
                          <option data-countryCode="HT" value="509">Haiti (+509)</option>
                          <option data-countryCode="HN" value="504">Honduras (+504)</option>
                          <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
                          <option data-countryCode="HU" value="36">Hungary (+36)</option>
                          <option data-countryCode="IS" value="354">Iceland (+354)</option>
                          <option data-countryCode="IN" value="91">India (+91)</option>
                          <option data-countryCode="ID" value="62">Indonesia (+62)</option>
                          <option data-countryCode="IR" value="98">Iran (+98)</option>
                          <option data-countryCode="IQ" value="964">Iraq (+964)</option>
                          <option data-countryCode="IE" value="353">Ireland (+353)</option>
                          <option data-countryCode="IL" value="972">Israel (+972)</option>
                          <option data-countryCode="IT" value="39">Italy (+39)</option>
                          <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
                          <option data-countryCode="JP" value="81">Japan (+81)</option>
                          <option data-countryCode="JO" value="962">Jordan (+962)</option>
                          <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
                          <option data-countryCode="KE" value="254">Kenya (+254)</option>
                          <option data-countryCode="KI" value="686">Kiribati (+686)</option>
                          <option data-countryCode="KP" value="850">Korea North (+850)</option>
                          <option data-countryCode="KR" value="82">Korea South (+82)</option>
                          <option data-countryCode="KW" value="965">Kuwait (+965)</option>
                          <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
                          <option data-countryCode="LA" value="856">Laos (+856)</option>
                          <option data-countryCode="LV" value="371">Latvia (+371)</option>
                          <option data-countryCode="LB" value="961">Lebanon (+961)</option>
                          <option data-countryCode="LS" value="266">Lesotho (+266)</option>
                          <option data-countryCode="LR" value="231">Liberia (+231)</option>
                          <option data-countryCode="LY" value="218">Libya (+218)</option>
                          <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
                          <option data-countryCode="LT" value="370">Lithuania (+370)</option>
                          <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
                          <option data-countryCode="MO" value="853">Macao (+853)</option>
                          <option data-countryCode="MK" value="389">Macedonia (+389)</option>
                          <option data-countryCode="MG" value="261">Madagascar (+261)</option>
                          <option data-countryCode="MW" value="265">Malawi (+265)</option>
                          <option data-countryCode="MY" value="60">Malaysia (+60)</option>
                          <option data-countryCode="MV" value="960">Maldives (+960)</option>
                          <option data-countryCode="ML" value="223">Mali (+223)</option>
                          <option data-countryCode="MT" value="356">Malta (+356)</option>
                          <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
                          <option data-countryCode="MQ" value="596">Martinique (+596)</option>
                          <option data-countryCode="MR" value="222">Mauritania (+222)</option>
                          <option data-countryCode="YT" value="269">Mayotte (+269)</option>
                          <option data-countryCode="MX" value="52">Mexico (+52)</option>
                          <option data-countryCode="FM" value="691">Micronesia (+691)</option>
                          <option data-countryCode="MD" value="373">Moldova (+373)</option>
                          <option data-countryCode="MC" value="377">Monaco (+377)</option>
                          <option data-countryCode="MN" value="976">Mongolia (+976)</option>
                          <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
                          <option data-countryCode="MA" value="212">Morocco (+212)</option>
                          <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
                          <option data-countryCode="MN" value="95">Myanmar (+95)</option>
                          <option data-countryCode="NA" value="264">Namibia (+264)</option>
                          <option data-countryCode="NR" value="674">Nauru (+674)</option>
                          <option data-countryCode="NP" value="977">Nepal (+977)</option>
                          <option data-countryCode="NL" value="31">Netherlands (+31)</option>
                          <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
                          <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
                          <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
                          <option data-countryCode="NE" value="227">Niger (+227)</option>
                          <option data-countryCode="NG" value="234">Nigeria (+234)</option>
                          <option data-countryCode="NU" value="683">Niue (+683)</option>
                          <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
                          <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
                          <option data-countryCode="NO" value="47">Norway (+47)</option>
                          <option data-countryCode="OM" value="968">Oman (+968)</option>
                          <option data-countryCode="PK" value="92">Pakistan (+92)</option>
                          <option data-countryCode="PW" value="680">Palau (+680)</option>
                          <option data-countryCode="PA" value="507">Panama (+507)</option>
                          <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
                          <option data-countryCode="PY" value="595">Paraguay (+595)</option>
                          <option data-countryCode="PE" value="51">Peru (+51)</option>
                          <option data-countryCode="PH" value="63">Philippines (+63)</option>
                          <option data-countryCode="PL" value="48">Poland (+48)</option>
                          <option data-countryCode="PT" value="351">Portugal (+351)</option>
                          <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
                          <option data-countryCode="QA" value="974">Qatar (+974)</option>
                          <option data-countryCode="RE" value="262">Reunion (+262)</option>
                          <option data-countryCode="RO" value="40">Romania (+40)</option>
                          <option data-countryCode="RU" value="7">Russia (+7)</option>
                          <option data-countryCode="RW" value="250">Rwanda (+250)</option>
                          <option data-countryCode="SM" value="378">San Marino (+378)</option>
                          <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
                          <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                          <option data-countryCode="SN" value="221">Senegal (+221)</option>
                          <option data-countryCode="CS" value="381">Serbia (+381)</option>
                          <option data-countryCode="SC" value="248">Seychelles (+248)</option>
                          <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
                          <option data-countryCode="SG" value="65">Singapore (+65)</option>
                          <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
                          <option data-countryCode="SI" value="386">Slovenia (+386)</option>
                          <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
                          <option data-countryCode="SO" value="252">Somalia (+252)</option>
                          <option data-countryCode="ZA" value="27">South Africa (+27)</option>
                          <option data-countryCode="ES" value="34">Spain (+34)</option>
                          <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
                          <option data-countryCode="SH" value="290">St. Helena (+290)</option>
                          <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
                          <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
                          <option data-countryCode="SD" value="249">Sudan (+249)</option>
                          <option data-countryCode="SR" value="597">Suriname (+597)</option>
                          <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
                          <option data-countryCode="SE" value="46">Sweden (+46)</option>
                          <option data-countryCode="CH" value="41">Switzerland (+41)</option>
                          <option data-countryCode="SI" value="963">Syria (+963)</option>
                          <option data-countryCode="TW" value="886">Taiwan (+886)</option>
                          <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
                          <option data-countryCode="TH" value="66">Thailand (+66)</option>
                          <option data-countryCode="TG" value="228">Togo (+228)</option>
                          <option data-countryCode="TO" value="676">Tonga (+676)</option>
                          <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                          <option data-countryCode="TN" value="216">Tunisia (+216)</option>
                          <option data-countryCode="TR" value="90">Turkey (+90)</option>
                          <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
                          <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
                          <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
                          <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
                          <option data-countryCode="UG" value="256">Uganda (+256)</option>
                          <option data-countryCode="GB" value="44">UK (+44)</option>
                          <option data-countryCode="UA" value="380">Ukraine (+380)</option>
                          <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
                          <option data-countryCode="UY" value="598">Uruguay (+598)</option>
                          <option data-countryCode="US" value="1">USA (+1)</option>
                          <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
                          <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
                          <option data-countryCode="VA" value="379">Vatican City (+379)</option>
                          <option data-countryCode="VE" value="58">Venezuela (+58)</option>
                          <option data-countryCode="VN" value="84">Vietnam (+84)</option>
                          <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
                          <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
                          <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                          <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
                          <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
                          <option data-countryCode="ZM" value="260">Zambia (+260)</option>
                      </optgroup>
                  </select>
            </div>
              </div>
            </div>
            <div class="col-8">
              <div  class="input-style-1">
                  <input type="tel" placeholder="Phone Number" id="drop_phone" name="drop_phone" required>
            </div>
            </div>
        </div>
      </div>

          <span style="color:red" id="phonestatus2"></span>
         </div>
          <!-- end input -->
      </div>
       <!-- end row -->
    <div class="row">
    <!-- end col -->
    <div class="col-md-6">
      <div class="input-style-2">
          <label>Enter Pick Up Date</label>
          <input type="date" id="date" name="date">
        <span class="icon"> <i class="lni lni-calendar"></i> </span>
      </div>
      <span style="color:red" id="datestatus"></span>
     </div>
      <!-- end input -->
      <div class="col-md-6">
        <div class="select-style-1">
            <label>Enter Pick Up Time</label>
            <div class="select-position">
              <select name="time" id="time">
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
            </div>
          </div>
          <!-- end select -->
    </div>
   <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
      <!-- end col -->
      <div class="col-md-6">
        <div class="input-style-2">
            <label> Expected Delivery Date</label>
            <input type="date" class="input-block-level" name="drop_date" id="drop_date">
          <span class="icon"> <i class="lni lni-calendar"></i> </span>
        </div>
        <span style="color:red" id="datestatus2"></span>
       </div>
        <!-- end input -->
        <div class="col-md-6">
          <div class="select-style-1">
              <label>Expected Delivery Time</label>
              <div class="select-position">
                <select name="drop_time" id="drop_time">
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
              </div>
            </div>
            <!-- end select -->
            <span style="color:red" id="timestatus2"></span>
      </div>
     <!-- end col -->
      </div>
      <!-- end row -->
   
     

       
       <!-- show price start -->
      <div class="primary-alert">
        <div class="alert">
          <h4 class="alert-heading">Total price: $ <span id="tp_phase2"></span></h4>
        </div>
      </div>
      <!-- show price end -->

    <div class="col-12">
      <div class="button-group d-flex justify-content-center flex-wrap">
        <button onclick="processPhase2();" id="sign-in-button" class="main-btn primary-btn btn-hover w-100 text-center">
          Next
        </button>
    </div>
    </div>
</div>

 <!-- ===================== end phase two ===================== -->
  <!--------------------------------------------- Phase 3 -------------------------------------------------->
  <div id="phase3">
    <div class="row">
    <div class="text-center">
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
        </div>
        <div class="row">
          <div class="col-12">
              <div class="select-style-1">
                  <label>Select Payment Method</label>
                  <div class="select-position">
                    <select name="paymentOpt" id="paymentOpt" oninvalid="this.setCustomValidity('Please select a payment mode')" oninput="this.setCustomValidity('')" required="required">
                        <option value="">Select one</option>
                        <option value="USD">Pay via Stripe (Online USD)</option>
                        <option value="RTGS">Pay Online in Local CURRENCY (RTGS)</option>
                        <option value="cash">Pay Cash at Pickup</option>
                  </select>
                  </div>
                </div>
                <!-- end select -->
          </div>
         <!-- end col -->
        </div>
        <!-- end row -->

         <div class="row">
        <div class="col-md-6">
           <div class="input-style-2">
               <label>Goods To Be Shipped</label>
               <input type="text" name="goods" placeholder="Enter the types of Products To be shipped" id="package_type">
             
           </div>
          </div>
           <!-- end input -->
            <div class="col-md-6">
                <div class="select-style-1">
                    <label>Type of Truck</label>
                    <div class="select-position">
                    <select name="transport" id="transport" required="required" onchange="calculateTotal()">
                                <option value="0"></option>
                                <option value="Closed Panel Van">Closed Van</option>
                                <option value="3 tonne open truck">Open Drop Sided</option>
                                <option value="Box Truck">Boxed Truck</option>
                                <option value="Curtain Side">Curtain Side</option>
                                <option value="Refrigerated Truck">Refrigerated Truck</option>
                                <option value="Super Link">Super-Link</option>
                                <option value="Low Loader">Low Bed Trailer</option>
                                <option value="Side Tipper">Side Tipper</option>
                                <option value="30 tonne Flat Bed Truck">Flat Deck</option>
                                <option value="Fuel Tanker">Fuel Tanker</option>
                                <option value="Rigid Truck">Rigid Truck</option>
                                <option value="Water Bowser">Water Bowser</option>
                                <option value="Crane Lorry">Crane Truck</option>
                            </select>
                    </div>
                  </div>
                  <!-- end select -->
            </div>
           <!-- end col -->
          
       </div>
       <!-- end row -->

       <div class="row">
        <!-- end col -->
        <div class="col-12">
          <div class="input-style-1">
              <label>Note for the driver / Package Description</label>
              <textarea rows="6" class="input-block-level" placeholder="Add a note for the driver" id="note" name="note">please be on time</textarea>
          </div>
          <span style="color:red" id="msg"></span>
         </div>
          <!-- end input -->
      </div>
       <!-- end row -->
       
      </div>
        <!-- end row -->
    
    

    <input type="hidden" placeholder="Order Number" name="order_number" class="form-control" value="<?php echo $a = rand(10000, 99999); ?>" required />
    <input type="hidden" name="vehicle_type" class="form-control" value="Parcel Delivery" required />
    <input type="hidden" id="outputDiv">
    <input type="hidden" id="outputDist" name="distance">
    <input type="hidden" id="tpp" name="Total_price">

     <!-- show price start -->
     <div class="primary-alert">
      <div class="alert">
        <h4 class="alert-heading">Total price: $ <span id="tp"></span></h4>
      </div>
    </div>
    <!-- show price end -->

    <div class="form-check checkbox-style mb-20">
      <input class="form-check-input" type="checkbox" value="" id="harm" required="required"/>
      <label class="form-check-label" for="checkbox-1">
        I hereby declare that the goods I am sending are not illegal contents or 
        anything that will cause harm to the health, life
         and welfare of people, such as illegal drugs, contraband, explosives etc.
        </label>
    </div>
    <span id="harmstatus" style="color:red"></span>
    <input type="hidden" name="MM_insert" value="bookingform">
    <div class="col-12">
      <div class="button-group d-flex justify-content-center flex-wrap">
        <button onclick="submitForm();" id="sign-in-button" class="main-btn primary-btn btn-hover w-100 text-center">
         Submit
        </button>
    </div>
    </div>

</div>
</form>
<!-- ============================ form end ========================================== -->
          </div>
          <!-- end card -->
        </div> <!-- ============== end row ===============-->
          <!-- ======= input style end ======= -->

        </div>
        <!-- end container -->
      </section>
      <!-- ========== section end ========== -->
        <script>
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
    <script src="https://maps.google.com/maps/api/js?key=<?php echo $mapApi ?>&sensor=false&libraries=places&callback=initAutocomplete" type="text/javascript"></script>

    <div id="map-canvas"></div>
      <!-- ========== footer start =========== -->
      <?php include("footer.php"); ?>
      <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/world-merc.js"></script>
    <script src="assets/js/polyfill.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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
            if (address == "" || drop_address == "") {
                alert("Please fill in the fields");
            } else if (address.length < 2) {
                _("addstatus").innerHTML = "Please enter a valid address!";
            } else {

                _("phase1").style.display = "none";
                _("phase2").style.display = "block";
                _("display_address").innerHTML = address;
                _("display_drop_address").innerHTML = drop_address;
                // _("progressBar").value = 50;
                // _("status").innerHTML = "Step 2 of 3...";
                // _("startAdd").innerHTML = address;
            }
        }

        function shoPricePhase1() {
            address = _("autocomplete").value;
            drop_address = _("drop_address").value;

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

            if (drop_name == "" || drop_phone == "" || drop_date == "" || drop_time == "") {
                alert("Please fill in the fields");
            } else if (address.length < 2) {
                _("addstatus2").innerHTML = "Please enter a valid address!";
            } else if (drop_name.length < 2) {
                _("namestatus2").innerHTML = "Please fill the name field!";
            } else if (drop_date.length < 2) {
                _("datestatus2").innerHTML = "A date is required!";
            } else if (drop_phone.length < 2) {
                _("phonestatus2").innerHTML = "Phone number is required!";
            } else if (drop_time.length < 2) {
                _("timestatus2").innerHTML = "pick up time is required!";
            } else {
                _("phase2").style.display = "none";
                _("phase3").style.display = "block";
                // _("progressBar").value = 100;
                // _("status").innerHTML = "Last Step...";
                _("display_address2").innerHTML = address;
                _("display_pickuptime2").innerHTML = time;
                _("display_pickupdate2").innerHTML = date;
                _("display_drop_address").innerHTML = drop_address;
                _("display_droptime").innerHTML = drop_time;
                _("display_dropdate").innerHTML = drop_date;
                _("endAdd").innerHTML = drop_address;

            }

        }

        var insur = new Array();
        insur["Yes"] = 0.1;
        insur["No"] = "";

        var weight_prices = new Array();
        weight_prices["n"] = 0;
        weight_prices["0 KG - 5 KG"] = 0.11;
        weight_prices["5 KG - 10 KG"] = 0.21;
        weight_prices["11 KG - 15 KG"] = 0.41;
        weight_prices["20 KG - above"] = 0.81;

        var quantity_prices = new Array();
        quantity_prices["0"] = 0;
        quantity_prices["1"] = 1;
        quantity_prices["2"] = 2;
        quantity_prices["3"] = 3;
        quantity_prices["4"] = 4;
        quantity_prices["5"] = 5;
        quantity_prices["6"] = 6;
        quantity_prices["7"] = 7;
        quantity_prices["8"] = 8;
        quantity_prices["9"] = 9;
        quantity_prices["10"] = 10;
        quantity_prices["11"] = 11;
        quantity_prices["12"] = 12;
        quantity_prices["13"] = 13;
        quantity_prices["14"] = 14;
        quantity_prices["15"] = 15;
        quantity_prices["16"] = 16;
        quantity_prices["17"] = 17;
        quantity_prices["18"] = 18;
        quantity_prices["19"] = 19;
        quantity_prices["20"] = 20;
        quantity_prices["21"] = 19;
        quantity_prices["22"] = 22;

        var car_prices = new Array();
        car_prices["0"] = 0;
        car_prices["Back Tipper"] = 0.5;
        car_prices["Closed Panel Van"] = 0.5;
        car_prices["30 tonne Flat Bed Truck"] = 0.5;
        car_prices["Fuel Tanker"] = 0.5;
        car_prices["Recovery Truck"] = 0.5;
        car_prices["Refrigerated Truck"] = 1;
        car_prices["Rigid Flatbed Truck"] = 0.6;
        car_prices["Box Truck"] = 0.6;
        car_prices["Crane Lorry"] = 0.8;
        car_prices["Side Tipper"] = 4;
        car_prices["Low Loader"] = 1;
        car_prices["3 tonne open truck"] = 0.25;
        car_prices["Water Bowser"] = 0.25;


        function getTruckNum() {
            var packageQuantityPrice = 0;
            var theForm = document.forms["multiphase"];
            var selectedQuantity = theForm.elements["trucks_num"];

            packageQuantityPrice = quantity_prices[selectedQuantity.value];

            return packageQuantityPrice;
        }

        function getCarPrice() {
            var CarPrice = 0;
            var theForm = document.forms["multiphase"];
            var selectedCar = theForm.elements["transport"];

            CarPrice = car_prices[selectedCar.value];

            return CarPrice;
        }

        function getLoaders() {
            var loaders = 0;
            var selectedValue = _("loaders").value;
            var loaders_num = _("loader_num").value;
            var loader_price = _("loader_price").value;
            if (selectedValue == "Yes") {
                _("loaders_div").style.display = "block";
                loaders = loader_price * loaders_num;
            }

            return loaders;
        }

        function getWeightRange() {
            var packageWeightRange = 0;
            var selectedValue = _("weight_of_package").value;
            if (selectedValue == "1 tonne") {
                packageWeightRange = parseFloat(_("tonne_1").value);
            } else if (selectedValue == "2 tonne") {
                packageWeightRange = parseFloat(_("tonne_2").value);
            } else if (selectedValue == "3 tonne") {
                packageWeightRange = parseFloat(_("tonne_3").value);
            } else if (selectedValue == "4 tonne") {
                packageWeightRange = parseFloat(_("tonne_4").value);
            } else if (selectedValue == "5 tonne") {
                packageWeightRange = parseFloat(_("tonne_5").value);
            } else if (selectedValue == "6 tonne") {
                packageWeightRange = parseFloat(_("tonne_6").value);
            } else if (selectedValue == "7 tonne") {
                packageWeightRange = parseFloat(_("tonne_7").value);
            } else if (selectedValue == "8 tonne") {
                packageWeightRange = parseFloat(_("tonne_8").value);
            } else if (selectedValue == "9 tonne") {
                packageWeightRange = parseFloat(_("_tonne_9").value);
            } else if (selectedValue == "10 tonne") {
                packageWeightRange = parseFloat(_("tonne_10").value);
            } else if (selectedValue == "11 tonne") {
                packageWeightRange = parseFloat(_("tonne_11").value);
            } else if (selectedValue == "12 tonne") {
                packageWeightRange = parseFloat(_("tonne_12").value);
            } else if (selectedValue == "13 tonne") {
                packageWeightRange = parseFloat(_("tonne_13").value);
            } else if (selectedValue == "14 tonne") {
                packageWeightRange = parseFloat(_("tonne_14").value);
            } else if (selectedValue == "15 tonne") {
                packageWeightRange = parseFloat(_("tonne_15").value);
            } else if (selectedValue == "16 tonne") {
                packageWeightRange = parseFloat(_("tonne_16").value);
            } else if (selectedValue == "17 tonne") {
                packageWeightRange = parseFloat(_("tonne_17").value);
            } else if (selectedValue == "18 tonne") {
                packageWeightRange = parseFloat(_("tonne_18").value);
            } else if (selectedValue == "19 tonne") {
                packageWeightRange = parseFloat(_("tonne_19").value);
            } else if (selectedValue == "20 tonne") {
                packageWeightRange = parseFloat(_("tonne_20").value);
            } else if (selectedValue == "21 tonne") {
                packageWeightRange = parseFloat(_("tonne_21").value);
            } else if (selectedValue == "22 tonne") {
                packageWeightRange = parseFloat(_("tonne_22").value);
            } else if (selectedValue == "23 tonne") {
                packageWeightRange = parseFloat(_("tonne_23").value);
            } else if (selectedValue == "24 tonne") {
                packageWeightRange = parseFloat(_("tonne_24").value);
            } else if (selectedValue == "25 tonne") {
                packageWeightRange = parseFloat(_("tonne_25").value);
            } else if (selectedValue == "26 tonne") {
                packageWeightRange = parseFloat(_("tonne_26").value);
            } else if (selectedValue == "27 tonne") {
                packageWeightRange = parseFloat(_("tonne_27").value);
            } else if (selectedValue == "28 tonne") {
                packageWeightRange = parseFloat(_("tonne_28").value);
            } else if (selectedValue == "29 tonne") {
                packageWeightRange = parseFloat(_("tonne_29").value);
            } else if (selectedValue == "30 tonne") {
                packageWeightRange = parseFloat(_("tonne_30").value);
            } else if (selectedValue == "31 tonne") {
                packageWeightRange = parseFloat(_("tonne_31").value);
            } else if (selectedValue == "32 tonne") {
                packageWeightRange = parseFloat(_("tonne_32").value);
            } else if (selectedValue == "33 tonne") {
                packageWeightRange = parseFloat(_("tonne_33").value);
            } else if (selectedValue == "34 tonne") {
                packageWeightRange = parseFloat(_("tonne_34").value);
            }
            return packageWeightRange;
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
            var weight_of_package = getWeightRange();
            var CarPrice = getCarPrice();
            var actaulPrice = getTruckNum();
            // var Ins = getInsure();
            var inter_city = getInterCityPrice();
            var loaders_p = getLoaders();
            var totDist = parseFloat(_('outputDiv').value) + weight_of_package;
            // var f = totDist * Ins;
            var roundTp = totDist * actaulPrice + loaders_p;
            var roundTpp = totDist * actaulPrice + loaders_p;
            var min = parseFloat(_("min_freight").value);
            if (roundTpp < min) {
                roundTpp = min;
            }
            if (roundTp < min) {
                roundTp = min;
            }
            var dis = _('c_disc').value;

            if (dis == '') {
                dis = 0;
            }
            if (price_in == "RTGS") {
                if (chk > 0) {
                    $("#paymentOpt option[value='USD']").remove();
                    $("#paymentOpt option[value='RTGS']").remove();
                    $("#paymentOpt option[value='paypal']").remove();
                    if (showPaynow == 1) {
                        $("#paymentOpt").append('<option value="RTGS">Pay Online in Local CURRENCY (RTGS)</option>');
                    }
                }
                dis1 = dis * zim_dollar_rate;
                roundTp = roundTp * zim_dollar_rate;
                roundTpp = roundTpp * zim_dollar_rate;
                roundTp = roundTp - dis1;
                roundTpp = roundTpp - dis1;
            } else if (price_in == "USD") {
                if (chk > 0) {
                    $("#paymentOpt option[value='USD']").remove();
                    $("#paymentOpt option[value='RTGS']").remove();
                    if (showStripe == 1) {

                        <?php

                        $aDatas = json_decode(file_get_contents("../admin/keys.json"));
                        if ($aDatas->paypal_handle == "1") {
                        ?>
                            $("#paymentOpt").append('<option value="USD">Pay via Stripe (Online USD)</option><option value="paypal">Pay Through Paypal</option>');
                        <?php } else { ?>
                            $("#paymentOpt").append('<option value="USD">Pay via Stripe (Online USD)</option>');

                        <?php    } ?>
                    }
                    if (showPaynow == 1) {
                        $("#paymentOpt").append('<option value="RTGS">Pay Online in Local CURRENCY (RTGS)</option>');
                    }
                }
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
                            var c_afterDisc = parseFloat(c_totaAmount - c_rate);

                            _('tp_phase1').innerHTML = c_afterDisc;
                            _('tp_phase2').innerHTML = c_afterDisc;
                            _('tp').innerHTML = c_afterDisc;
                            _('c_disc').value = c_rate;
                            $("#coupon").prop("disabled", true);

                        } else {

                            var c_afterDisc = parseFloat(c_totaAmount - c_amount);

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

                        _('outputDiv').value = parseFloat(str.replace(/[^\d\.]*/g, ''));
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
            paymentOpt = _("paymentOpt");
            transport = _("transport").value;
            weight_of_package = _("weight_of_package").value;
            value_of_package = _("package_type").value;
            var trucks_num = _("trucks_num").value;
            harm = _("harm").value;

            if (transport.length < 3 && weight_of_package.length < 0 && value_of_package.length < 4 && trucks_num.length < 4) {
                alert("Please fill in the fields");
                exit;
            } else if (paymentOpt.value == "") {
                _("harmstatus").innerHTML = "Please select a payment method";
                die;
            } else if (harm.checked == false) {
                _("harmstatus").innerHTML = "Please check the box to agree with our terms!";
                die;
            } else {
                _("phase3").style.display = "block";
                _("multiphase").method = "post";
                _("multiphase").action = "submit_furniture.php";
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
            _("sho_msg").style.display = "none";
        }

        function sho_sms() {
            _("sho_msg").style.display = "block";
            _("sho_fo").style.display = "none";
        }

        function SendMsg() {
            var address_e = _("autocomplete").value;
            var drop_address_e = _("drop_address").value;
            var email_e = _("email_quote").value;
            var name_e = _("name").value;
            var Total_price = _('tpp').value;
            var distance_e = _("outputDist").value;
            var number_e = _("sms_quote").value;
            var weight_e = _("weight_of_package").value;
            var trucks_num_e = _("trucks_num").value;
            var currency_e = _("price_in").value
            var delivery_type_e = "Freight";
            window.open('sms:' + number_e + '?&body=Hi, Merchant Couriers move furniture quotation.' +
                '\n *Pick up:* ' + address_e +
                ',\n *Drop off:* ' + drop_address_e +
                ',\n *Truck No:* ' + trucks_num_e +
                ',\n *Truck size:* ' + weight_e +
                ',\n *Distance:* ' + distance_e +
                ',\n *Price:* $' + Total_price + currency_e +
                ',\n https://merchantcouriers.com/furniture_go.php',
                '_self');
            
            
            // 		alert("sent!");
            _("sho_msg").style.display = "none";
        }

        function SendQuote() {
            var address_e = _("autocomplete").value;
            var drop_address_e = _("drop_address").value;
            var email_e = _("email_quote").value;
            var name_e = _("name").value;
            var Total_price = _('tpp').value;
            var distance_e = _("outputDist").value;
            // var transport_e = _("transport").value;
            var loader_num_e = _("loader_num").value;
            var weight_e = _("weight_of_package").value;
            var trucks_num_e = _("trucks_num").value;
            var loaders_e = _("loaders").value;
            var delivery_type_e = "Freight";
            //var acc_id_e = $('#acc_id');
            var data = "address=" + address_e + "&drop_address=" + drop_address_e + "&email=" + email_e +
                "&Total_price=" + Total_price + "&distance=" + distance_e + "&delivery_type=" + delivery_type_e + "&weight=" + weight_e + "&trucks_num=" + trucks_num_e + "&loaders=" + loaders_e + "&loader_num=" + loader_num_e;

            if ($.trim(address_e).length == 0 || $.trim(drop_address_e).length == 0) {
                exit();
            }
            $.ajax({

                type: 'POST',
                url: 'email_furniture_move_quote.php',
                data: data,
                beforeSend: function() {
                    //$("#error").fadeOut();
                    //$("#confirm_btn").html('processing ...');
                    //alert(data);
                },
                success: function(data) {
                    if (data == "OK") {
                        alert("Quote sent!");
                    } else if (data == "error") {
                        alert("Error");
                    } else if (data == "1") {
                        alert("Error");
                        //  _("error").fadeIn(500, function(){
                        //   _("error").innerHTML('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error quote was not sent please try again!</div>');

                        //   $("#acc_btn").html('Create Program3');

                        //  });

                    }

                }

            });
            alert("sent!");
            _("sho_fo").style.display = "none";
        }

        function sendWhatsApp() {
            //alert("sent!");
            var address_e = _("autocomplete").value;
            var drop_address_e = _("drop_address").value;
            var email_e = _("email_quote").value;
            var name_e = _("name").value;
            var Total_price = _('tpp').value;
            var distance_e = _("outputDist").value;
            // var transport_e = _("transport").value;
            // var value_e = _("value_of_package").value;
            var weight_e = _("weight_of_package").value;
            var trucks_num_e = _("trucks_num").value;
            // 	var insure_e = _("insure").value;
            var currency_e = _("price_in").value
            var delivery_type_e = "Freight";
            window.open('https://api.whatsapp.com/send?text=Hi, Merchant Couriers move furniture quotation. ' +
                '\n *Pick up:* ' + address_e +
                ',\n *Drop off:* ' + drop_address_e +
                ',\n *Truck No:* ' + trucks_num_e +
                ',\n *Truck size:* ' + weight_e +
                ',\n *Distance:* ' + distance_e +
                ',\n *Price:* $' + Total_price + currency_e +
                ',\n https://merchantcouriers.com/furniture_go.php',
                '_self');
        }
    </script>
  </body>
</html>
