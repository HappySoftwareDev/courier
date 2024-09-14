<?php include_once('common/header.php') ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?=base_url()?>/public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
            <!-- <a href="" class="btn-info btn-sm pull-right"> Add New</a> -->
          <div class="card">
            <!-- <div class="card-header">
              <h3 class="card-title">DataTable with default features</h3>
            </div> -->
            <!-- /.card-header -->
            
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>

                <tr>
                  <th>Order Number</th>
                  <th>date</th>
                  <th>Customer Details</th>
                  <th>From/To</th>
                  <th>Details</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                  <?php //var_dump($data); die; ?>
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
                  <td>
                    <form method="post" action="<?=base_url()?>/my-orders">
                    <input type="hidden" name="order_id" value="<?=$item->order_id?>">
                    <select name="status" onchange="return this.form.submit();">
                      <option <?=($item->status=='new'?'SELECTED':'')?> value="new" disabled>New</option>
                      <option <?=($item->status=='ready'?'SELECTED':'')?> value="ready">Ready</option>
                      <option <?=($item->status=='on the way'?'SELECTED':'')?>  value="on the way" disabled>on the way</option>
                      <option <?=($item->status=='deliverd'?'SELECTED':'')?>  value="deliverd" disabled>deliverd</option>
                    </select>
                    </form>
                    
                </tr>
                  <?php endforeach ?>
                
                </tbody>
                <tfoot>
                <tr>
                  <th>Title</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>API Key</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<?php include_once('common/footer.php'); ?>
  
<script src="<?=base_url()?>/public/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>/public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
