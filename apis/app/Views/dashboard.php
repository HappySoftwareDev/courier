<?php include_once('common/header.php') ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-md-3">
        <a class="btn btn-block btn-lg btn-success" data-toggle="modal" data-target="#mymodal">
            <i class="fa fa-money-bill-alt" id="icone_grande"></i> <br><br>
            <span class="texto_grande"> Bookings: $ <?=$total_business->Total_price?></span></a>
      </div>
      <div class="col-md-3">
        <a class="btn btn-block btn-lg btn-danger" data-toggle="modal" data-target="#mymodal">
            <i class="fa fa-database" id="icone_grande"></i> <br><br>
            <span class="texto_grande"><i class="fa fa-times-circle-o"></i> API Keys: <?=count($storecount)?> </span></a>
      </div>
      <div class="col-md-3">
        <a class="btn btn-block btn-lg btn-primary" data-toggle="modal" data-target="#mymodal">
            <i class="fa fa-cog fa-spin" id="icone_grande"></i> <br><br>
            <span class="texto_grande"> Stores : <?=count($storecount)?></span></a>
      </div>
      <div class="col-md-3">
        <a class="btn btn-block btn-lg btn-warning" data-toggle="modal" data-target="#mymodal">
            <i class="fa fa-list-alt" id="icone_grande"></i> <br><br>
            <span class="texto_grande"> Orders: <?=$orders->order_id?></span></a>
      </div> 
    </div>
    <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Latest Bookings</h3>
                <!-- <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div> -->
              </div>
              <div class="card-body p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Order Number</th>
                    <th>date</th>
                    <th>Customer Details</th>
                    <th>From/To</th>
                    <th>Details</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($data as $item): ?>
                <tr>
                  <td><?=$item->order_number?></td>
                  <td><b>pick</b>:<?=$item->pick_up_date?> <?=$item->pick_up_time?><br>
                      <b>drop</b>:<?=$item->drop_date?> <?=$item->drop_time?>
                    </td>
                    <td>
                    <?=$item->Name?><br><?=$item->phone?><br><?=$item->email?>
                  </td>
                  <td><b>From</b>:<?=$item->pick_up_address?><br>
                      <b>To</b>:<?=$item->drop_address?></td>
                  <td>
                    <b>weight</b>:<?=$item->weight?><br>
                    <b>Qty</b>:<?=$item->quantity?><br>
                    <b>Insurance</b>:<?=$item->insurance?><br>
                    <b>Value</b>:<?=$item->value?><br>
                    <b>Distance</b>:<?=$item->distance?><br>
                    <b>Transport</b>:<?=$item->type_of_transport?><br>
                    <b>Charges</b>:$ <?=$item->Total_price?></td>
                  
                    
                </tr>
                  <?php endforeach ?>
                
                  </tbody>
                </table>
              </div>
            </div>
            
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
<?php include_once('common/footer.php'); ?>
<style type="text/css">
  .texto_grande {
    font-size: 1.5rem;
    color: white;
} 
#icone_grande {
    font-size: 4rem;
    color:#fff;
} 
</style>

