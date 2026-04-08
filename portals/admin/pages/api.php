<?php require ("login-security.php"); ?>

<?php include ('site_settings.php'); ?>

<?php require ("get-sql-value.php"); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$sResponse = "";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "invite")) {
    $myFile = "../keys.json";
    $myFilea = "../../keys.json";
    file_put_contents($myFile, json_encode($_POST));
    file_put_contents($myFilea, json_encode($_POST));
    $sResponse = '<div class="alert alert-success">Record Updated Successfully</div>';
}

?>

<?php require("function.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>


    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - API Integrations</title>

</head>

<body>

    <div id="wrapper">

        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Manage APIs</h1>
                        <div class="row">
                            <?php
                            echo $sResponse;
                            $aData = json_decode(file_get_contents("../keys.json"));
                            // echo "<pre>" . print_r($aData, true) . "</pre>";
                            $stripePk = !empty($aData->stripePk) ? $aData->stripePk : "";
                            $stripeSk = !empty($aData->stripeSk) ? $aData->stripeSk : "";
                            $paynowIk = !empty($aData->paynowIk) ? $aData->paynowIk : "";
                            $paynowId = !empty($aData->paynowId) ? $aData->paynowId : "";
                            $paypalid = !empty($aData->paypalid) ? $aData->paypalid : "";
                            $mapApi = !empty($aData->mapApi) ? $aData->mapApi : "";
                            $smsID = !empty($aData->smsId) ? $aData->smsId : "";
                            $smsUsername = !empty($aData->smsUsername) ? $aData->smsUsername : "";
                            $smsPwd = !empty($aData->smsPwd) ? $aData->smsPwd : "";

                            $twiliosmsID = !empty($aData->twiliosmsID) ? $aData->twiliosmsID : "";
                            $twiliosmsUsername = !empty($aData->twiliosmsUsername) ? $aData->twiliosmsUsername : "";
                            $twilioPhoneNumber = !empty($aData->twilioPhoneNumber) ? $aData->twilioPhoneNumber : "";
                            ?>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-12">
                                <form role="form" method="POST" name="invite" action="api.php">
                                    <div class="form-group">
                                        <p><span id="sent"></span></p>
                                        <p class="help-block"></p>

                                        <div class="panel panel-default">
                                            <!-- .panel-heading -->
                                            <div class="panel-body">
                                                <div class="panel-group" id="accordion">
                                                    <!----------Strip Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Stripe API (International Payments)</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseOne" class="panel-collapse collapse in">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="stripe_handle" id="stripe_handle" <?php echo ($aData->stripe_handle == 1) ? "checked" : ""; ?> value="1" type="radio" />Show Stripe
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="stripe_handle" id="stripe_handle" <?php echo ($aData->stripe_handle == 2) ? "checked" : ""; ?> value="2" type="radio" />Hide Stripe
                                                                        </label>
                                                                        <br /><br />
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Stripe Publish Key</label>
                                                                        <input type="text" class="form-control" value="<?php echo $stripePk; ?>" name="stripePk" placeholder="Enter Stripe Publish Key" required /><br />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Stripe Secret Key</label>
                                                                        <input type="text" class="form-control" value="<?php echo $stripeSk; ?>" name="stripeSk" placeholder="Enter Stripe Secret Key" required /><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Strip End --------->

                                                    <!----------Paynow Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Paynow API (Zimbabwe Payments)</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseTwo" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="paynow_handle" id="paynow_handle" <?php echo ($aData->paynow_handle == 1) ? "checked" : ""; ?> value="1" type="radio" />Show PayNow
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="paynow_handle" id="paynow_handle" <?php echo ($aData->paynow_handle == 2) ? "checked" : ""; ?> value="2" type="radio" />Hide PayNow
                                                                        </label>
                                                                        <br /><br />
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>PayNow Integration ID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $paynowId; ?>" name="paynowId" placeholder="Enter PayNow Integration ID" required /><br />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>PayNow Integration ID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $paynowIk; ?>" name="paynowIk" placeholder="Enter PayNow Integration Key" required /><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/PayNow End --------->

                                                    <!----------Paypal Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">PayPal API (International Payments)</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseThree" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="paypal_handle" id="paypal_handle" <?php echo ($aData->paypal_handle == 1) ? "checked" : ""; ?> value="1" type="radio" />Show Paypal
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="paypal_handle" id="paypal_handle" <?php echo ($aData->paypal_handle == 2) ? "checked" : ""; ?> value="2" type="radio" />Hide Paypal
                                                                        </label>
                                                                        <br /><br />
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Paypal ID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $paypalid; ?>" name="paypalid" placeholder="Enter PayNow Integration Key" required /><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Paypal End --------->

                                                    <!----------Google Maps Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Google Maps API (International Geolocation)</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseFour" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Google Map API</label>
                                                                        <input type="text" class="form-control" value="<?php echo $mapApi; ?>" name="mapApi" placeholder="Enter Google Map API Key" required /><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Google Maps End --------->

                                                    <!----------Bulk SMS Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">Bulk SMS API (Zimbabwe Messaging)</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseFive" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Bulk SMS ID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $smsID; ?>" name="smsId" placeholder="Enter SMS ID" required /><br />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Bulk SMS Username</label>
                                                                        <input type="text" class="form-control" value="<?php echo $smsUsername; ?>" name="smsUsername" placeholder="Enter SMS Username" required />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Bulk SMS Password</label>
                                                                        <input type="text" class="form-control" value="<?php echo $smsPwd; ?>" name="smsPwd" placeholder="Enter SMS Password" required /> <br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Bulk SMS End --------->

                                                    <!----------Twilio Start --------->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">Twilio SMS API (International Messaging)</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseSix" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="twilio_handle" id="twilio_handle" <?php echo ($aData->twilio_handle == 1) ? "checked" : ""; ?> value="1" type="radio" />Active
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <label class="radio-inline">
                                                                            <input name="twilio_handle" id="twilio_handle" <?php echo ($aData->twilio_handle == 2) ? "checked" : ""; ?> value="2" type="radio" />Deactivate
                                                                        </label>

                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Account SID</label>
                                                                        <input type="text" class="form-control" value="<?php echo $twiliosmsID; ?>" name="twiliosmsID" placeholder="Enter SMS ID" required /><br />
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label>Auth Token</label>
                                                                        <input type="text" class="form-control" value="<?php echo $twiliosmsUsername; ?>" name="twiliosmsUsername" placeholder="Enter SMS Username" required />
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label>Phone Number</label>
                                                                        <input type="text" class="form-control" value="<?php echo $twilioPhoneNumber; ?>" name="twilioPhoneNumber" placeholder="Enter SMS Password" required /> <br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----------/Twilio End --------->

                                                    <div class="col-lg-6 pull-right">
                                                        <br /><br />
                                                        <input type="submit" name="invite" class="btn btn-primary btn-lg btn-block" value="Submit">
                                                        <input type="hidden" name="MM_insert" value="invite">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr />

                            </div>

                            <!-- /.col-lg-6 -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>


