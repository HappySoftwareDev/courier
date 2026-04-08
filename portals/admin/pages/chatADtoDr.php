<?php require ("login-security.php"); ?>

<?php include ('site_settings.php'); ?>

<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "msgAdForm")) {
    $insertSQL = sprintf(
        "INSERT INTO replychat_drivers (message, name, IDFrom, chatID) VALUES (%s, %s, %s, %s)",
        GetSQLValueString($_POST['message'], "text"),
        GetSQLValueString($_POST['adName'], "text"),
        GetSQLValueString($_POST['driverID'], "int"),
        GetSQLValueString($_POST['ChatID'], "int")
    );

    mysql_select_db($database_Connect, $Connect);
    $Result1 = mysql_query($insertSQL, $Connect) or die(mysql_error());

    $insertGoTo = "chatADtoDr.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php require("function.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Driver Messaging</title>


</head>

<body>

    <div id="wrapper">

        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <?php
            if (isset($_GET['chatD'])) {
                $MrE = $_GET['chatD'];
                global $DB;

                $get = "SELECT * FROM `chat_drivers` where ID = '$MrE'";

                $stmt = $DB->prepare( $get);

                foreach ($results as $1) {
                    $ID = $row_type['ID'];
                    $Date = $row_type['Date'];
                    $Name = $row_type['name'];
                    $msg = $row_type['message'];
                    $IDFrom = $row_type['IDFrom'];
                }
            }

            ?>

            <?php
            $user = $_SESSION['MM_Username'];
            $get = "SELECT * FROM `admin` where Email = '$user' ";

            $stmt = $DB->prepare( $get);

            foreach ($results as $1) {
                $AdID = $row_type['ID'];
                $AdName = $row_type['Name'];
                $AdEmail = $row_type['Email'];
                $Adphone = $row_type['phone'];
                $Adpass = $row_type['Password'];
            }
            ?>

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <!-- /.panel -->
                    <div class="chat-panel panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i> Messages From Drivers
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-chevron-down"></i>
                                </button>

                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="chat">
                                <?php getChatsFroDr(); ?>
                                <?php getReplyChatsFroDr(); ?>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <form action="<?php echo $editFormAction; ?>" method="POST" name="msgAdForm">
                                <div class="input-group">
                                    <textarea id="btn-input" type="text" name="message" class="form-control input-sm" placeholder="Type your message here..."></textarea>
                                    <input type="hidden" name="ChatID" value="<?php echo $ID; ?>">
                                    <input type="hidden" name="driverID" value="<?php echo $IDFrom; ?>">
                                    <input type="hidden" name="adName" value="<?php echo $AdName; ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-warning btn-lg" type="submit" id="btn-chat">Send</button>
                                </div>
                                <input type="hidden" name="MM_insert" value="msgAdForm">
                            </form>
                            </span>
                        </div>
                        <!-- /.panel-footer -->
                    </div>
                </div>
                <!-- /.panel -->

                <!-- /.panel -->

                <!-- /.col-lg-8 -->


                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Notifications Panel
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <?php getChats(); ?>

                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>


                <!-- /.row -->

                <!-- /#page-wrapper -->

            </div>
            <!-- /#wrapper -->

        <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>


