
<!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper" style="background:#fff;">
      <div class="navbar-logo" >
        <a href="index.php"><img src="../admin/assets/images/<?php echo isset($logo) ? htmlspecialchars($logo) : 'logo.png'; ?>" alt="logo" width="150" height="56"></a>
      </div>
      <nav class="sidebar-nav" style="background:#262d3f; height:100%">
        <ul>
          <li class="nav-item nav-item-has-children">
            <a
              href="#0"
              data-bs-toggle="collapse"
              data-bs-target="#ddmenu_1"
              aria-controls="ddmenu_1"
              aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="icon"><i class="lni lni-dashboard"></i></span>
              <span class="text">Dashboard</span>
            </a>
            <ul id="ddmenu_1" class="collapse show dropdown-nav">
              <li>
                <a href="index.php" class="active">
                  <i class="lni lni-arrow-right"></i> Home
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="index.php?service=parcel">
              <span class="icon"><i class="lni lni-briefcase"></i></span>
              <span class="text">Parcel Delivery</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?service=freight">
              <span class="icon"><i class="lni lni-delivery"></i></span>
              <span class="text">Freight Delivery</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?service=furniture">
              <span class="icon"><i class="lni lni-archive"></i></span>
              <span class="text">Furniture Delivery</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="mybooking.php">
              <span class="icon"><i class="lni lni-credit-cards"></i></span>
              <span class="text">My Bookings</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="settings.php">
              <span class="icon"><i class="lni lni-cog"></i></span>
              <span class="text">Settings</span>
            </a>
          </li>

         
          <span class="divider"><hr /></span>

          <li class="nav-item">
            <a href="signin-security.php?doLogout=true">
              <span class="icon"><i class="lni lni-arrow-left"></i></span>
              <span class="text">Sign Out</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

