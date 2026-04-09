<?php
/**
 * Admin Dashboard - Redirects to Modern Dashboard
 * This page has been replaced with a modern UI at ../index.php
 */

require_once('../../../config/bootstrap.php');

// Check session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verify admin is logged in
if (!isset($_SESSION['admin_id']) && (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin')) {
    header('Location: login.php', true, 302);
    exit;
}

// Redirect to new modern dashboard
header('Location: ../index.php', true, 301);
exit;
?>


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
                <div class="row">

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-2">
                                        <i class="fa fa-usd fa-5x"></i>
                                    </div>
                                    <div class="col-xs-10 text-right">
                                        <div class="huge"><?php echo getCountTotalSales(); ?> </div>
                                        <div>Total USD Sales</div>
                                    </div>
                                </div>
                            </div>
                            <!--<a href="seller_orders.php?more=<?php echo $seller_email; ?>">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>-->
                            </a>
                        </div>
                    </div>
                    <!--<div class="col-lg-3 col-md-6">-->
                    <!--    <div class="panel panel-primary">-->
                    <!--<div class="panel-heading">-->
                    <!--    <div class="row">-->
                    <!--        <div class="col-xs-2">-->
                    <!--            <i class="fa fa-usd fa-5x"></i>-->
                    <!--        </div>-->
                    <!--        <div class="col-xs-10 text-right">-->
                    <div class="huge"><?php //getCountTotalRTGSSales(); 
                                        ?></div>
                    <!--            <div>Total RTGS Sales</div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <!--<a href="seller_orders.php?more=<?php echo $seller_email; ?>">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>-->
                    <!--        </a>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user-plus fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo getCountAllSellers(); ?></div>
                                        <div>Business Partners</div>
                                    </div>
                                </div>
                            </div>
                            <!-- <a href="sellers.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div> -->
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo getCountNewOrders();  ?></div>
                                        <div>New Orders!</div>
                                    </div>
                                </div>
                            </div>
                            <!-- <a href="seller_orders.php?more=<?php echo $seller_email; ?>">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div> -->
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-car fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo getCountAllDrivers(); ?></div>
                                        <div>Drivers</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-history fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div>Total Orders!</div>
                                        <div class="huge"><?php echo getCountAllOrders();  ?></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-times fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div>Cancelled Orders!</div>
                                        <div class="huge"><?php echo getCountCancelledOrders();  ?></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                   
                </div>
            <!-- /.row -->
            <div class="row">
                <div>
                    <!-- /.panel -->
                    <!------------------ Jobs ----------------------->
                    <div class="tab-content">
                        <!-- /.panel -->
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Job Number</th>
                                                    <th>Date</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Invoice</th>
                                                    <th>Status</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php getBookings(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                        <!-- /.panel -->
                        <!------------------ /Jobs ----------------------->
                        <!-- /.panel -->

                        <!-- /.panel -->
                        <div>
                            <!-- /.panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-bar-chart-o fa-fw"></i> Clients List
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table id="clients_Ac" class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Business Name</th>
                                                            <th>Business Type</th>
                                                            <th>Business Location</th>
                                                            <th>Contact Name</th>
                                                            <th>Details</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php getBusinessPartner(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
                                        </div>
                                        <!-- /.col-lg-4 (nested) -->
                                        <!-- /.col-lg-8 (nested) -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->

                            <!-- /.panel -->
                        </div>
                    </div>

                    <!-- /.col-lg-8 -->
                    <!-- <div class="col-lg-4"> -->

                        <!-- /.panel -->
                        <!-- <div class="chat-panel panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-comments fa-fw"></i> Messages
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-chevron-down"></i>
                                    </button>

                                </div>
                            </div> -->
                            <!-- /.panel-heading -->
                            <!-- <div class="panel-body">
                                <ul class="chat">
                                    <?php getContacts(); ?>
                                </ul>
                            </div> -->
                            <!-- /.panel-body -->
                            <!-- <div class="panel-footer">

                            </div> -->
                            <!-- /.panel-footer -->
                        <!-- </div> -->
                        <!-- /.panel .chat-panel -->
                    <!-- </div> -->
                    <!-- /.col-lg-4 -->

                    <<!-- div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bell fa-fw"></i> Messages From Drivers
                            </div> -->
                            <!-- /.panel-heading -->
                            <!-- <div class="panel-body">
                                <div class="list-group">
                                    <?php getChats(); ?>

                                </div>
                            </div> -->
                            <!-- /.panel-body -->
                     <!--    </div>
                    </div> -->

                <!-- </div> -->
                <!-- /.row -->
            <!-- </div> -->
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

    <!-- Include firebase push notification scripts -->
    <?php include 'firebase-push-script.php'; ?>
        
    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>
    
</body>

</html>


