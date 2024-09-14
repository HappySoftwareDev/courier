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
                  <th>Title</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>API Key</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php foreach ($storecount as $item): ?>
                <tr>
                  <td><?=$item->business_name?></td>
                  <td><?=$item->business_email?><br>
                    <?=$item->business_phone?>
                  </td>
                  <td><?=$item->address?></td>
                  <td><?=($item->api_key?$item->api_key:'
                    <a href="'.base_url().'/my-store/api-key/'.$item->id.'" class="btn-xs btn-info" title="create API key">
                      create API key
                    </a>')?></td>
                  <td>
                    <!-- <a href="" class="btn-xs btn-info">
                      <i class="fas fa-pencil-alt"></i>
                    </a>
                    | -->
                    <a onclick="return confirm('Entry will be permanently deleted');" href="<?=base_url()?>/my-store/del/<?=$item->id?>" class="btn-xs btn-danger">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                    |<?php 
                      if($item->status=='active'):
                    ?>
                    <a href="<?=base_url()?>/my-store/inactiveAPI/<?=$item->id?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure ?');">
                      <i class="fa fa-ban"></i>
                    </a>
                    <?php else: ?>
                    <a href="<?=base_url()?>/my-store/activeAPI/<?=$item->id?>" class="btn btn-xs btn-success" onclick="return confirm('Are you sure ?');">
                      <i class="fa fa-check"></i>
                    </a>
                  <?php endif; ?>
                    
                  </td>
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
