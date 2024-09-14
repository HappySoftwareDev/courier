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
    <title>Inner city parcel delivery booking for Zimbabwe | Merchant Couriers</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/lineicons.css" />
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-messaging.js"></script>
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
                <div class="title mb-30">
                  <h2>Dashboard</h2>
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
                        Home
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
        
          <!-- End Row -->
          
          <div class="row">
             <!-- ========== cards-styles start ========== -->
          <div class="cards-styles">

            <!-- ========= card-style-2 start ========= -->
            <div class="row">
              <div class="col-12">
                <div class="title mt-30 mb-30">
                  <h2>Select Service</h2>
                </div>
              </div>
              <!-- end col -->
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="card-style-2 mb-30">
                  <!--<div class="card-image">-->
                  <!--  <a href="parcel-page.php">-->
                  <!--    <img src="assets/images/cards/card-style-2/parcel.png" alt="" />-->
                  <!--  </a>-->
                  <!--</div>-->
                  <div class="card-content text-center">
                      <br/>
                    <h4><a href="parcel-page.php">
                        <span class="icon"><i class="lni lni-briefcase"></i></span>
                        Parcel Delivery 
                        </a>
                        </h4>
                  </div>
                </div>
              </div>
              <!-- end col -->
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="card-style-2 mb-30">
                  <!--<div class="card-image">-->
                  <!--  <a href="freight-page.php">-->
                  <!--    <img-->
                  <!--      src="assets/images/cards/card-style-2/shipping.png"-->
                  <!--      alt=""-->
                  <!--    />-->
                  <!--  </a>-->
                  <!--</div>-->
                  <div class="card-content text-center">
                      <br/>
                    <h4><a href="freight-page.php">
                        <span class="icon"><i class="lni lni-delivery"></i></span>
                        Send Freight 
                        </a></h4>
                  </div>
                </div>
              </div>
              <!-- end col -->
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="card-style-2 mb-30">
                  <!--<div class="card-image">-->
                  <!--  <a href="furniture-page.php">-->
                  <!--    <img-->
                  <!--      src="assets/images/cards/card-style-2/move.png"-->
                  <!--      alt=""-->
                  <!--    />-->
                  <!--  </a>-->
                  <!--</div>-->
                  <div class="card-content text-center">
                      <br/>
                    <h4><a href="furniture-page.php">
                        <span class="icon"><i class="lni lni-archive"></i></span>
                        Move Furniture 
                        </a></h4>
            
                  </div>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
            <!-- ========= card-style-2 end ========= -->
          </div>
          <!-- ========== cards-styles end ========== -->
          </div>
           <!-- End Row -->
         
        </div>
        <!-- end container -->
      </section>
      <!-- ========== section end ========== -->

      <!-- ========== footer start =========== -->
     <?php include("footer.php"); ?>
      <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->
     <!--Firebase Push-->
    <script>
    var firebaseConfig = {
        apiKey: "AIzaSyCSNGUwzJ0iXTz01MAWsfec5jbTWvbCYC8",
		authDomain: "merchant-booking.firebaseapp.com",
		databaseURL: "https://merchant-booking.firebaseio.com",
		projectId: "merchant-booking",
		storageBucket: "merchant-booking.appspot.com",
		messagingSenderId: "909204433162",
		appId: "1:909204433162:web:cd5165ba87c3e131ccb2f3"
        //measurementId: "YOUR MEASUREMENT ID"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging=firebase.messaging();

    function IntitalizeFireBaseMessaging() {
        messaging
            .requestPermission()
            .then(function () {
                console.log("Notification Permission");
                return messaging.getToken();
            })
            .then(function (token) {
                console.log("Token : "+token);
                // document.getElementById("token").innerHTML=token;
                $.ajax({
                url: 'save_token.php',
                type: 'POST',
                data: 'token=' + token,
                success: function(result) {
                    if(result == "OK"){
                        console.log("token saved");
                    }
                    else if(result == "exist"){
                        console.log("token already exist")
                    };
                }
                 });
            })
            .catch(function (reason) {
                console.log(reason);
            });
    }

    messaging.onMessage(function (payload) {
        console.log(payload);
        const notificationOption={
            body:payload.notification.body,
            icon:payload.notification.icon
        };

        if(Notification.permission==="granted"){
            var notification=new Notification(payload.notification.title,notificationOption);

            notification.onclick=function (ev) {
                ev.preventDefault();
                window.open(payload.notification.click_action,'_blank');
                notification.close();
            }
        }

    });
    messaging.onTokenRefresh(function () {
        messaging.getToken()
            .then(function (newtoken) {
                console.log("New Token : "+ newtoken);
            })
            .catch(function (reason) {
                console.log(reason);
            })
    })
    IntitalizeFireBaseMessaging();
</script>
<!--End Firebase Push-->
    <!-- ========= All Javascript files linkup ======== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/js/dynamic-pie-chart.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/fullcalendar.js"></script>
    <script src="assets/js/jvectormap.min.js"></script>
    <script src="assets/js/world-merc.js"></script>
    <script src="assets/js/polyfill.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   
  </body>
</html>
