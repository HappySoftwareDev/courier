<?php include ("../admin/pages/site_settings.php"); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    
    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title>Sign Up | <?php echo $site_name ?></title>

    
    <style>
      form#multiphase>#phase2,
      #reg_step,
      #verify_stepp {
          display: none;
      }
  </style>

    <script>
      var businesslLocation, businessName, email, phone, deliveryTime, businessType, estDeliver, drop_phone, pick_name, pass,
          drop_address, PreferedType;

      function _(x) {
          return document.getElementById(x);
      }

      function showfield(name) {
          if (name == 'Other') document.getElementById('sho_it').innerHTML = '<div class="input-style-1"><label>Other:</label> <input type="text" class="input-block-level" placeholder="Enter Business Type" name="businessType" id="businessType" /></div>';
          else document.getElementById('sho_it').innerHTML = '';
      }

      function showfield2(name) {
          if (name == 'Individual') document.getElementById('sho_ind').innerHTML = '<div class="input-style-1"><label>Individual</label> <input  class="input-block-level" placeholder="Enter Your Full Name" type="text" id="businessName" name="businessName" required></div>';
          else document.getElementById('sho_ind').innerHTML = '';
          if (name == 'Company') document.getElementById('sho_bus').innerHTML = '<div class="input-style-1"><label>Company</label> <input  class="input-block-level" placeholder="Enter Business Name" type="text" id="businessName" name="businessName" required></div>';
          else document.getElementById('sho_bus').innerHTML = '';
      }

      function processPhase1() {
          businessName = _("businessName").value;
          businesslLocation = _("businesslLocation").value;
          email = _("email").value;
          phone = _("phone").value;
          estDeliver = _("estDeliver").value;
          businessType = _("businessType").value;
          if (businesslLocation == "" || businessName == "" || email == "" || phone == "" || businessType == "") {
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
          if (pick_name == "" || drop_phone == "" || pass == "") {
              alert("Please fill in the fields");
          } else {
              _("phase2").style.display = "block";
          }
          _("multiphase").method = "post";
          _("multiphase").action = "../freight.sub.php";
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
    <!-- Home Navigation -->
    <div style="position: absolute; top: 20px; left: 20px; z-index: 100;">
        <a href="../../" class="btn" style="background: white; color: #667eea; border: 1px solid #e5e7eb; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-weight: 600; font-size: 13px; display: inline-block; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onmouseover="this.style.background='#f3f4f6'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.15)'" onmouseout="this.style.background='white'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">← Back to Home</a>
    </div>
    
    <!-- ======== sidebar-nav start =========== -->
    
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main>
     

      <!-- ========== signin-section start ========== -->
      <section class="signin-section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
        
          <!-- ========== title-wrapper end ========== -->

          <div class="row g-0 auth-row">
            <div class="col-lg-6">
              <div class="auth-cover-wrapper bg-primary-100">
                <div class="auth-cover">
                  <div class="title text-center">
                    <h1 class="text-primary mb-10">Get Started</h1>
                    <p class="text-medium">
                      You're one step away from enjoying  
                      <br class="d-sm-block" />
                       parcel and cargo delivery convenience.
                    </p>
                  </div>
                  <div class="cover-image">
                    <img src="assets/images/auth/signin-image.svg" alt="" />
                  </div>
                  <div class="shape-image">
                    <img src="assets/images/auth/shape.svg" alt="" />
                  </div>
                </div>
              </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6">
              <div class="signup-wrapper">
                <div class="form-wrapper">
                  <h6 class="mb-15">Sign Up Form</h6>
                  <p class="text-sm mb-25">
                    Please fill in the form below.
                  </p>
                  <form method="POST" action="../freight.sub.php" name="partnerform" enctype="multipart/form-data" id="multiphase">
                    <div class="row">
                      <div class="col-12">
                        <div class="select-style-1">
                          <label>Individual/Company</label>
                          <div class="select-position">
                          <select id="businessName" name="businessName" onchange="showfield2(this.options[this.selectedIndex].value);" required>
                            <option></option>
                            <option>Individual</option>
                            <option>Company</option>
                        </select>
                      </div>
                        <div id=sho_ind></div>
                        <div id=sho_bus></div>
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Email</label>
                          <input type="email" placeholder="Email" id="email" name="email" required/>
                        </div>
                      </div>
                      <!-- end col -->
                      <input class="form-control" name="client_num" type="hidden" value="<?php echo $a = rand(100, 999); ?>" required>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Address</label>
                          <input type="text" class="input-block-level" placeholder="eg 31 Jason Moyo" id="drop_address" name="address" required>
                        </div>
                      </div>

                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                        <label>City</label>
                        <input type="text" class="input-block-level" placeholder="eg Harare Zimbabwe" id="businesslLocation" name="businesslLocation" required>
                      </div>
                      </div>

                      <!-- end col -->
                      <div class="col-12">
                        <div class="select-style-1">
                        <label>Type of Trade/Business </label>
                        <div class="select-position">
                        <select name="businessType" id="businessType" class="input-block-level" onchange="showfield(this.options[this.selectedIndex].value)" required>
                          <option></option>
                          <option>Retail Trade</option>
                          <option>Hospitality</option>
                          <option>Wholesale Trade</option>
                          <option>Manufacturing</option>
                          <option>Industrial</option>
                          <option>Farming</option>
                          <option>Mining</option>
                          <option>Other</option>
                        </select>
                        </div>
                      <div id="sho_it"></div>
                      <span style="color:red"></span>
                      </div>
                      </div>

                      <input type="hidden" class="input-block-level" placeholder="Address" id="img_logo" name="company_logo">
 
                      <!-- end col -->
                      <div class="col-12">
                        <div class="row">
                          <label>Phone Number</label>
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
                              <input type="tel" placeholder="Phone Number" id="number" name="phone" required>
                        </div>
                        </div>
                    </div>
                  </div>
                    

                      <div id="recaptcha-container"></div>
                      <div id="auth_stepp">
                        <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap">
                          <button onclick="phoneAuth();" id="sign-in-button" class="main-btn primary-btn btn-hover w-100 text-center">
                            Next
                          </button>
                      </div>
                      </div>
                      </div>
                      <!-- end col -->
                      <div id="verify_stepp">
                        <div class="col-12">
                          <div class="input-style-1">
                          <label>Enter Verification code</label>
                          <input type="tel" class="input-block-level" placeholder="Verification code" id="verificationCode" required>
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                          <div class="button-group d-flex justify-content-center flex-wrap">
                          <button onclick="codeverify();" class="main-btn primary-btn btn-hover w-100 text-center">
                            Verify code
                          </button>
                      </div>
                    </div>
                      </div>
                      <!-- end col -->

                      <div id="reg_step">
                        <label>CREATE YOUR ACCOUNT LOGIN AND PASSWORD </label><br />
                        <div class="col-12">
                        <div class="input-style-1">
                        <label>Contact Name</label>
                        <input type="text" class="input-block-level" placeholder="username" id="pick_name" name="username" required>
                      </div>
                      </div>
                      <!-- end col -->
                      
                    <div class="col-12">
                        <div class="input-style-2">
                        <label>Create a password</label>
                        <input type="password" placeholder="Create a password" id="pass" name="pass" required>
                        <span class="icon"> <a onclick="togglePassword()" > <i class="lni lni-eye"></i></a> </span>
                      </div>
                    </div>
                    <!-- end col -->

                      <div class="col-12">
                        <div class="form-check checkbox-style mb-30">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            value=""
                            id="checkbox-not-robot"/>
                          <label
                            class="form-check-label"
                            for="checkbox-not-robot">
                            By ticking the box you declare that you agree to abide by our terms and conditions to use <?php echo $site_name ?> Technology and  Application platforms to send LEGAL FREIGHT shipment requests only.<a href="terms.php" target='_blank'> Terms of Use</a></label>
                        </div>
                      </div>
                      <!-- end col -->
                      <input type="hidden" name="MM_insert" value="partnerform">
                        <div class="col-12">
                          <div class="button-group d-flex justify-content-center flex-wrap">
                            <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center">
                              Sign Up
                            </button>
                          </div>
                        </div>
                        <!-- end col -->
                    
                      </div>

                      
                    </div>
                    <!-- end row -->
                  </form>
                  <div class="singup-option pt-40">
                    <p class="text-sm text-medium text-dark text-center">
                      Already have an account? <a href="signin.php">Sign In</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
      </section>
      <!-- ========== signin-section end ========== -->
      
     
    </main>
    <!-- ======== main-wrapper end =========== -->
    <script>
    function togglePassword() {
            var x = document.getElementById("pass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
        
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
              (document.getElementById('businesslLocation')), {
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
  <?php
    $keysFile = '../../config/keys.json';
    if (file_exists($keysFile)) {
        $aData = json_decode(file_get_contents($keysFile));
    } else {
        $aData = (object)[];
    }
    $mapApi = !empty($aData->mapApi) ? $aData->mapApi : '';
  ?>
  <script src="https://maps.google.com/maps/api/js?key=<?php echo $mapApi ?>&sensor=false&libraries=places&callback=initAutocomplete" type="text/javascript"></script>

   
   <!-- The core Firebase JS SDK is always required and must be listed first -->
   <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

   <!-- TODO: Add SDKs for Firebase products that you want to use
    https://firebase.google.com/docs/web/setup#available-libraries -->

   
   
   <script>
       // Load Firebase configuration from site management
       <?php include '../../web_push/firebase-config.php'; ?>
       // Initialize Firebase
       firebase.initializeApp(firebaseConfig);
   </script>

   <script src="recaptcha.js"></script>

   <script>
       
       function phoneAuth() {
           //get the number
           var countryCode = document.getElementById('countryCode').value;
           var number = "+" + countryCode + document.getElementById('number').value;
           //phone number authentication function of firebase
           //it takes two parameter first one is number,,,second one is recaptcha
           firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {
               //s is in lowercase
               window.confirmationResult = confirmationResult;
               coderesult = confirmationResult;
               console.log(coderesult);
               document.getElementById('verify_stepp').style.display = "block";
               document.getElementById('auth_stepp').style.display = "none";
               document.getElementById('recaptcha-container').style.display = "none";
               alert("Verification code sent check your phone. ");
           }).catch(function(error) {
               alert(error.message);
           });
       }

       function codeverify() {
           var code = document.getElementById('verificationCode').value;
           coderesult.confirm(code).then(function(result) {
               document.getElementById('verify_stepp').style.display = "none";
               document.getElementById('reg_step').style.display = "block";
               //alert("Successfully registered");
               var user = result.user;
               console.log(user);
           }).catch(function(error) {
               alert(error.message);
           });
       }
       
       
   </script>
  
  <!-- ========= All Javascript files linkup ======== -->
    <?php include 'footerscripts.php'; ?>

  </body>
</html>


