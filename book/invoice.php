<?php require ("signin-security.php"); ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=1024, initial-scale=0.1" />
    <link
      rel="shortcut icon"
      href="assets/images/favicon.png"
      type="image/x-icon"
    />
    <title>Invoice | Merchant Couriers</title>

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
      
      <?php

    if (isset($_GET['orderD'])) {

        $MrE = $_GET['orderD'];

        $get = "SELECT * FROM `bookings` WHERE order_number='$MrE' Limit 1";

        $run = mysqli_query($Connect, $get);

        while ($row_type = mysqli_fetch_array($run)) {
            $ID = $row_type['order_id'];
            $order_number = $row_type['order_number'];
            $Date = $row_type['Date'];
            $email_fro = $row_type['email'];
            $address = $row_type['pick_up_address'];
            $drop_address = $row_type['drop_address'];
            $name = $row_type['Name'];
            $invoicestatus = $row_type['invoice'];
            $phone = $row_type['phone'];
            $pick_up_date = $row_type['pick_up_date'];
            $drop_date = $row_type['drop_date'];
            $Drop_name = $row_type['Drop_name'];
            $Total_price = $row_type['Total_price'];
            $drop_phone = $row_type['drop_phone'];
            $weight_of_package = $row_type['weight'];
            $package_quantity = $row_type['quantity'];
            $insurance = $row_type['insurance'];
            $value_of_package = $row_type['value'];
            $type_of_transport = $row_type['type_of_transport'];
            $note = $row_type['drivers_note'];
            $time = $row_type['pick_up_time'];
            $drop_time = $row_type['drop_time'];
            $service = $row_type['vehicle_type'];

            $details = "<b>From: </b> $address <br/> <b>TO:</b> $drop_address 
                         <br/>
                        <b>Insurance:</b> $insurance
                        <br/>
                        <b>Weight:</b> $weight_of_package
                        <br/>
                        <b>Value of Package:</b> $value_of_package
                        <br/>
                        <b>Quantity:</b> $package_quantity
                        <br/>
                        <b>Type of transport:</b> $type_of_transport
                         ";
            
            $cost = number_format((float)$Total_price, 2, '.', '');

            $MC = "    Address: HarareZimbabwe<br>
                                Phone: +263772467352<br/>
                                Email: admin@merchantcouriers.com";
                                
              if($invoicestatus == "PAID"){
                  $pay_status = "info-alert";
              }else{
                  $pay_status = "warning-alert";
              }
                                
        }
    }
    ?>

      <!-- ========== section start ========== -->
      <section>
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="title d-flex align-items-center flex-wrap mb-30">
                  <h2 class="mr-40">Invoice</h2>
                        <a href="#0" class="main-btn primary-btn-outline btn-hover" onClick="CreatePDFfromHTML();">
                          <i class="lni lni-arrow-down mr-2"></i> Download Invoice
                        </a>
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
                        Invoice
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

          <!-- Invoice Wrapper Start -->
          
          <div class="invoice-wrapper">
            <div class="row">
              <div class="col-lg-12 col-md-6 col-sm-12 col-lx-12">
                <div class="invoice-card card-style mb-30">
                  <div class="invoice-header">
                    <div class="invoice-for">
                      <h2 class="mb-10">Invoice</h2>
                      <p class="text-sm">
                        Merchant Couriers
                      </p>
                    </div>
                    <div >
                      <img src="assets/images/invoice/w_logo.png" alt="" />
                    </div>
                    
                    <div class="col-md-2">
                     <div class="<?php echo $pay_status ?> text-center">
                      <div class="alert">
                        <b class="text-medium"><?php echo $invoicestatus; ?></b>
                      </div>
                      </div>
                      </div>
                      
                  </div>
                  <div class="invoice-address">
                    <div class="address-item">
                      <h5 class="text-bold">From</h5>
                      <h1>Merchant Couriers</h1>
                      <p class="text-sm">
                        +263772467352
                      </p>
                      <p class="text-sm">
                        <span class="text-medium">Email:</span>
                        admin@merchantcouriers.com
                      </p>
                    </div>
                    <div class="address-item">
                      <h5 class="text-bold">To</h5>
                      <h1><?php echo $name; ?></h1>
                      <p class="text-sm">
                        <?php echo $phone; ?>
                      </p>
                      <p class="text-sm">
                        <span class="text-medium">Email:</span>
                        <?php echo $email_fro; ?>
                      </p>
                    </div>
                    
                    <div class="address-item">
                      <div class="invoice-date">
                      <p><span class="text-bold">Date Issued:</span> <?php echo $Date; ?></p>
                      <p><span class="text-bold">Date Due:</span> <?php echo $pick_up_date; ?> </p>
                      <p><span class="text-bold">Order ID:</span> #<?php echo $order_number; ?></p>
                    </div>
                    </div>
                    
                  </div>
                  <div class="table-responsive">
                    <table class="invoice-table table">
                      <thead>
                        <tr>
                          <th class="service">
                            <h6 class="text-sm text-medium">Service</h6>
                          </th>
                          <th class="desc">
                            <h6 class="text-sm text-medium">Descriptions</h6>
                          </th>
                          <th class="qty">
                            <h6 class="text-sm text-medium">Qty</h6>
                          </th>
                          <th class="amount">
                            <h6 class="text-sm text-medium">Amounts</h6>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <p class="text-sm"><?php echo $service; ?></p>
                          </td>
                          <td>
                            <p class="text-sm">
                             <?php echo $details; ?>
                            </p>
                          </td>
                          <td>
                            <p class="text-sm">1</p>
                          </td>
                          <td>
                            <p class="text-sm">$<?php echo $cost; ?></p>
                          </td>
                        </tr>
                        
                        <tr>
                          <td></td>
                          <td></td>
                          <td>
                            <h6 class="text-sm text-medium">Subtotal</h6>
                          </td>
                          <td>
                            <h6 class="text-sm text-bold">$<?php echo $cost; ?></h6>
                          </td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td>
                            <h6 class="text-sm text-medium">Discount</h6>
                          </td>
                          <td>
                            <h6 class="text-sm text-bold">0%</h6>
                          </td>
                        </tr>
                       
                        <tr>
                          <td></td>
                          <td></td>
                          <td>
                            <h4>Total</h4>
                          </td>
                          <td>
                            <h4>$<?php echo $cost; ?></h4>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="note-wrapper warning-alert py-4 px-sm-3 px-lg-5">
                    <div class="alert">
                      <h5 class="text-bold mb-15">Notes:</h5>
                      <p class="text-sm text-gray">
                        All deliveries are paid in advance of shipment. 
                        To be paid online by mobile money wallet, credit or debt card, paypal or cash at pickup.
                      </p>
                    </div>
                  </div>
                  
                  <div class="invoice-action">
                    <div class="d-flex flex-wrap align-items-center justify-content-center">
                   <?php if ($invoicestatus == "UNPAID") {
                            // define('PAYPAL_URL', ("");
                        ?>
                            <?php

                            $aData = json_decode(file_get_contents("../admin/pages/keys.json"));
                            $paypalid = !empty($aData->paypalid) ? $aData->paypalid : "";
                            //var_dump($aData);
                            if ($aData->paypal_handle == "1") { ?>

                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="display: contents;">
                                    <!-- Identify your business so that you can collect the payments. -->
                                    <input type="hidden" name="business" value="<?php echo $paypalid; ?>">

                                    <!-- Specify a Buy Now button. -->
                                    <input type="hidden" name="cmd" value="_xclick">

                                    <!-- Specify details about the item that buyers will purchase. -->
                                    <input type="hidden" name="item_name" value="sale">
                                    <!-- <input type="hidden" name="item_number" value="<?php echo $row['id']; ?>"> -->
                                    <input type="hidden" name="amount" value="<?php echo $Total_price; ?>">
                                    <input type="hidden" name="currency_code" value="USD">

                                    <!-- Specify URLs -->
                                    <input type="hidden" name="return" value="invo.php">
                                    <input type="hidden" name="cancel_return" value="invo.php">

                                    <!-- Display the payment button. -->
                                    <button type="submit" name="submit" class="main-btn dark-btn-outline btn-hover" ><i class="lni lni-paypal"></i> Pay Via Paypal</button>
                                </form>
                            <?php
                            }
                            ?>
                            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" style="display: none;">

                                <!-- <select name="amount">
                                <option value="3.99">6 Months ($3.99)</option>
                                <option value="5.99">12 Months ($5.99)</option>

                                </select> -->
                                <input name="amount" type="hidden" value="<?php echo $Total_price; ?>">
                                <br>
                                <input name="currency_code" type="hidden" value="USD">
                                <input name="shipping" type="hidden" value="0.00">
                                <input name="tax" type="hidden" value="0.00">
                                <input name="return" type="hidden" value="invo.php">
                                <input name="cancel_return" type="hidden" value="invo.php">
                                <input name="notify_url" type="hidden" value="invo.php">
                                <input name="cmd" type="hidden" value="_xclick">
                                <input name="business" type="hidden" value="<?php echo  $paypalid ?>">
                                <input name="item_name" type="hidden" value="sale">
                                <input name="no_note" type="hidden" value="1">
                                <input type="hidden" name="no_shipping" value="1">
                                <input name="lc" type="hidden" value="EN">
                                <input name="bn" type="hidden" value="PP-BuyNowBF">
                                <input name="custom" type="hidden" value="custom data">

                                <button type="submit" name="submit" value='' class="main-btn primary-btn-outline btn-hover"><i class="lni lni-paypal"></i> Pay Via Paypal</button>
                                <!-- <img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1"> -->

                            </form>
                            <?php if ($aData->stripe_handle == "1") { ?>
                                <a target="_blank" href="https://merchantcouriers.com/invoice-admin.php?orderD=<?= $order_number; ?>&amount=<?php $Total_price; ?>">
                                <button class="main-btn primary-btn-outline btn-hover" onclick="pay(<?php echo $Total_price; ?>)">
                                        <i class="lni lni-stripe"></i> Pay Via Stripe</button>
                                </a>
                            <?php
                            }
                            if ($aData->paynow_handle == "1") {
                            ?>
                                <a target="_blank" href="https://merchantcouriers.com/paynow.php?orderD=<?= $order_number; ?>&amount=<?= $Total_price; ?>&ref=invoice"><button class="main-btn danger-btn-outline btn-hover" onclick="pay(<?php echo $Total_price; ?>)">
                                        <i class="lni lni-credit-cards"></i> Pay Via PayNow</button>
                                </a>
                            <?php
                            } ?>
                        <?php } ?>
                    </div>
                  </div>
                </div>
                <!-- End Card -->
              </div>
              <!-- ENd Col -->
            </div>
            <!-- End Row -->
          </div>
         
          <!-- Invoice Wrapper End -->
        </div>
        <!-- end container -->
      </section>
      <!-- ========== section end ========== -->

      <!-- ========== footer start =========== -->
      <?php include("footer.php") ?>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    
     <script type="text/javascript">
       //Create PDf from HTML...
        function CreatePDFfromHTML() {
            var HTML_Width = $(".invoice-wrapper").width();
            var HTML_Height = $(".invoice-wrapper").height();
            var top_left_margin = 15;
            var PDF_Width = HTML_Width + (top_left_margin * 2);
            var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;
        
            var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;
        
            html2canvas($(".invoice-wrapper")[0]).then(function (canvas) {
                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
                pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
                for (var i = 1; i <= totalPDFPages; i++) { 
                    pdf.addPage(PDF_Width, PDF_Height);
                    pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
                }
                pdf.save("Merchant_Couriers_invoice.pdf");
                // $(".invoice-wrapper").hide();
            });
        }
    </script>
  </body>
</html>
