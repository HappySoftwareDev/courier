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
    <title>Settings | Merchant Couriers</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/lineicons.css" />
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/css/fullcalendar.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
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
                  <h2>Settings</h2>
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
                      <li class="breadcrumb-item"><a href="#0">Pages</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Settings
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
            <div class="col-lg-6">
              <div class="card-style settings-card-1 mb-30">
                <div
                  class="title mb-30 d-flex justify-content-between align-items-center"
                >
                  <h6>My Profile</h6>
                  <button class="border-0 bg-transparent">
                    <i class="lni lni-pencil-alt"></i>
                  </button>
                </div>
                <div class="profile-info">
                  <div class="d-flex align-items-center mb-30">
                    <div class="profile-image">
                      <img src="assets/images/profile/PersonPlaceholder2.png" alt="" />
                      <div class="update-image">
                        <input type="file" />
                        <label for=""
                          ><i class="lni lni-cloud-upload"></i
                        ></label>
                      </div>
                    </div>
                    <div class="profile-meta">
                      <h5 class="text-bold text-dark mb-10"><?php echo $name ?></h5>
                      <p class="text-sm text-gray"><?php echo $phone ?></p>
                      <p class="text-sm text-gray"><?php echo $email ?>
                    </div>
                  </div>
                  
                </div>
              </div>
              <!-- end card -->
            </div>
            <!-- end col -->

            <div class="col-lg-6">
              <div class="card-style settings-card-2 mb-30">
                <div class="title mb-30">
                  <h6>Edit Profile</h6>
                </div>
                <form action="#">
                  <div class="row">
                    <div class="col-12">
                      <div class="input-style-1">
                        <label>Full Name</label>
                        <input type="text" placeholder="Full Name" value="<?php echo $contact_name ?>"/>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="input-style-1">
                        <label>Email</label>
                        <input type="email" placeholder="Email" value="<?php echo $email ?>" />
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="input-style-1">
                        <label>Company</label>
                        <input type="text" placeholder="Company" value="<?php echo $name ?>"/>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="input-style-1">
                        <label>Address</label>
                        <input type="text" placeholder="Address" value="<?php echo $address ?>"/>
                      </div>
                    </div>
                    <div class="col-xxl-4">
                      <div class="input-style-1">
                        <label>Phone</label>
                        <input type="text" placeholder="Phone" value="<?php echo $phone ?>"/>
                      </div>
                    </div>
                    <div class="col-xxl-4">
                      <div class="input-style-1">
                        <label>City</label>
                        <input type="text" placeholder="city" value="<?php echo $city ?>"/>
                      </div>
                    </div>
                    <div class="col-xxl-4">
                      <div class="input-style-1">
                        <label>Business Category</label>
                        <input type="text" placeholder="Business Category" value="<?php echo $btype ?>"/>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="main-btn primary-btn btn-hover">
                        Update Profile
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end card -->
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
        <!-- end container -->
      </section>
      <!-- ========== section end ========== -->

      <!-- ========== footer start =========== -->
      <?php include("footer.php"); ?>
      <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

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
  </body>
</html>
