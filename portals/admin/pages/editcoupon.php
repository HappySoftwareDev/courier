
<?php include ('site_settings.php'); ?>

<?php require_once('../../config/bootstrap.php');
require_once('../../function.php');

require("function.php");



if (isset($_GET['editid'])) {
    $single = getSingleUserCoupon();
}

// var_dump($single);
// die;

if (isset($_POST['update'])) {
    updateUserCoupon();
    header('location:usercoupon.php');
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Driver Registration</title>

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
                                <h3 class="panel-title">Generate a Common Coupon For all Users</h3>
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
                                            <input class="form-control" name="limit" type="number" value="<?php if (isset($single)) {
                                                                                                                echo $single['limit_used'];
                                                                                                            } ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Discount in</label>
                                            <input class="" name="type" type="radio" value="1" style="margin-left:20px; " <?php if (isset($single)) {
                                                                                                                                if ($single['type'] == 1) {
                                                                                                                                    echo "checked";
                                                                                                                                }
                                                                                                                            } else {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>Percentage
                                            <input class="" name="type" type="radio" value="2" style="margin-left:20px; " <?php if (isset($single)) {
                                                                                                                                if ($single['type'] == 2) {
                                                                                                                                    echo "checked";
                                                                                                                                }
                                                                                                                            } ?>>Amount
                                        </div>
                                        <div class="form-group">
                                            <label>% or amount</label>
                                            <input class="form-control" name="amount" type="number" value="<?php if (isset($single)) {
                                                                                                                echo $single['amount'];
                                                                                                            } ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Coupon</label>
                                            <input class="form-control" name="coupon" id="coupon" type="text" value="<?php if (isset($single)) {
                                                                                                                            echo $single['coupon'];
                                                                                                                        } ?>" required>
                                            <button class="btn btn-block btn-xm btn-info" type="button" onclick="makeid()">Generate Coupon</button>
                                        </div>
                                        <div class="form-group">
                                            <label>Expiry Date</label>
                                            <input class="form-control" name="expiry_date" type="date" value="<?php if (isset($single)) {
                                                                                                                    echo $single['expiry_date'];
                                                                                                                } ?>" required>

                                        </div>
                                        <?php if (isset($single)) : ?>
                                            <input type="hidden" name="id" value="<?php echo $single['user_coupon_id']; ?>">

                                            <!-- Change this to a button or input when using this as a form -->
                                            <input type="submit" class="btn btn-lg btn-success btn-block" name="update" value="Update">
                                        <?php else : ?>
                                            <input type="submit" class="btn btn-lg btn-success btn-block" name="submit" value="Submit">
                                        <?php endif; ?>
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
            $('#coupon').val('');
            var length = 10;
            var result = '';
            var characters = 'ABCDE0077FGHIJKLMNOPQRSTUVW555Zabcdefghijklmnopqrstuvwxyz0123456789';
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


