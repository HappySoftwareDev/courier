<?php require ("login-security.php"); ?>

<?php include ('site_settings.php'); ?>

<!-- Function library already loaded via bootstrap.php -->

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Admin Area</title>

    
</head>

<body>

    <div id="wrapper">

        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Business Details</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Order List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Business Details</th>
                                                            <th>Delivery Info</th>
                                                            <th>Contact Details</th>
                                                            <th>Action</th>
                                                            <th></th>

                                                        </tr>
                                                    </thead>
                                                <tbody>
                                                    <?php getBusinessPartnerD(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->

                        <!-- /.panel -->
                        <div>
                            <!-- /.panel -->

                        </div>

                        <!-- /.col-lg-8 -->

                        <!-- /.col-lg-4 -->

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /#page-wrapper -->

            </div>
            <!-- /#wrapper -->

    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>


