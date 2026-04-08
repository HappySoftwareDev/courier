<?php 

include('site_settings.php'); 

require_once '../../config/bootstrap.php';
require_once '../../function.php';

require("function.php");

$clients = getAllUserss();

if (isset($_POST['submit'])) {
    generateAndSubmitCoupon();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Coupons</title>
    

</head>

<body>
    <div id="wrapper">
        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

        <div id="page-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="login-panel panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Generate A Unique Coupon For Each User</h3>
                            </div>
                            <div class="panel-body">
                                <form action="" method="POST" role="form" name="">
                                    <fieldset>
                                        <div class="form-group">
                                            <label>
                                                <h4>Coupon Info</h4>
                                            </label><br />

                                        </div>
                                        <div class="form-group">
                                            <label>Limit of use</label>
                                            <input class="form-control" name="limit" type="number" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Discount in</label>
                                            <input class="" name="type" type="radio" value="1" style="margin-left:20px; " checked="">Percentage
                                            <input class="" name="type" type="radio" value="2" style="margin-left:20px; ">Amount
                                        </div>
                                        <div class="form-group">
                                            <label>% or amount</label>
                                            <input class="form-control" name="amount" type="number" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Expiry Date</label>
                                            <input class="form-control" name="expiry_date" type="date" required>

                                        </div>

                                        <!-- Change this to a button or input when using this as a form -->
                                        <input type="submit" class="btn btn-lg btn-success btn-block" name="submit" value="Generate & Submit">
                                    </fieldset>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".js-example-basic-single").select2({
                placeholder: "Please select a client",
                allowClear: true
            });
        });

        function makeid() {
            var length = 10;
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $('#coupon').val(result);
        }
    </script>

    <!-- Include footer template scripts -->
    <?php include 'footer-template-scripts.php'; ?>

</body>

</html>


