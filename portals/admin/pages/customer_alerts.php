<?php
// Load centralized bootstrap
require_once('../../config/bootstrap.php');
require_once('../../function.php');

// Admin auth check
if (!isset($_SESSION['admin_email'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['invite'])) {
    // Retrieve form data
    $email_to = $_POST['email'];
    $msg = $_POST['msg'];
    $subject2 = $_POST['subject'];

    try {
        // Insert into the database using PDO
        $insertSQL = "INSERT INTO `customer_alerts`(`msg`, `subject`) VALUES (:msg, :subject)";
        $stmt = $DB_con->prepare($insertSQL);
        $stmt->bindParam(':msg', $msg, PDO::PARAM_STR);
        $stmt->bindParam(':subject', $subject2, PDO::PARAM_STR);
        $stmt->execute();

        // Define email headers and content
        $from = "registrations@" . $web_url;
        $htmlContent2 = '
            <html>
                <head>
                <title>' . $site_name . '</title>
                </head>
                <body>
                <div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#eeeeee; padding:8px; ">
                <h1 style="color:#FF8C00">' . $site_name . '</h1>
                <h3>Dear Valued Customer</h3>
                <p>' . $msg . '</p>
                
                <h3>Enjoy delivery convenience, book a parcel, freight, furniture moving delivery now <a href="http://' . $web_url . '"><b>Book Today.</b></a></h3>
                <footer>
                <div style="background-color:#CCC; padding:10px;">
                    <p>For inquiries, visit <a href="http://' . $web_url . '">' . $web_url . '</a>. Call/WhatsApp <b>' . $bus_phone . '</b>.</p>
                    <p>PLEASE DO NOT REPLY TO THIS EMAIL.</p>
                    <h4 style="color:#FF8C00">' . $site_name . '</h4>
                </div>
                </footer>
                </div>
                </body>
            </html>
        ';

        // Set content-type header for HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $site_name . '<registrations@' . $web_url . '>' . "\r\n";
        $headers .= 'Bcc:' . $email_to . "\r\n";

        // Send email
        if (mail($email_to, $subject2, $htmlContent2, $headers)) {
            echo "<script>alert('Your bulk Email alert sent successfully!')</script>";
        } else {
            echo "<script>alert('Failed to send alert. Please check your configuration.')</script>";
        }

        echo "<script>window.open('customer_alerts.php','_self')</script>";
    } catch (PDOException $e) {
        // Handle database error
        echo "<script>alert('Database error: " . $e->getMessage() . "')</script>";
    }
}
?>




<?php
if ((isset($_POST["MM_insert_sms"])) && ($_POST["MM_insert_sms"] == "invite_sms")) {
    try {
        // Insert data into the database using PDO
        $insertSQL = "INSERT INTO `affiliate_msg`(`msg`, `subject`) VALUES (:msg, :subject)";
        $stmt = $DB_con->prepare($insertSQL);
        $stmt->bindParam(':msg', $_POST['msg'], PDO::PARAM_STR);
        $stmt->bindParam(':subject', $_POST['subject'], PDO::PARAM_STR);
        $stmt->execute();

        $email_to = $_POST['email'];
        $msg = $_POST['msg'];
        $from = "registrations@" . $web_url;
        $subject2 = $_POST['subject'];

        // Send email
        mail(null, $subject2, $htmlContent2, $headers);

        // $sms_phone = $_POST['phone'];
        // $uname = "Business";
        // $pwd = "Merchant2017";
        // $id = "5cb7afb730f8fefe60780e67871c117f";
        // $sms_msg = "$msg";
        // $data = "&u=" . $uname . "&h=" . $id . "&op=pv&to=" . $sms_phone . "&msg=" . urlencode($sms_msg);

        // $ch = curl_init('http://portal.bulksmsweb.com/index.php?app=ws');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $result = curl_exec($ch);
        // curl_close($ch);

        echo "<script>alert('Your bulk SMS alert sent successfully!')</script>";
        echo "<script>window.open('customer_alerts.php','_self')</script>";
    } catch (PDOException $e) {
        // Handle database error
        echo "<script>alert('Database error: " . $e->getMessage() . "')</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>


    <!-- Include common meta and links -->
    <?php include 'head.php'; ?>

    <title><?php echo $site_name ?> - Alerts</title>


</head>

<?php
// Set records per page
$records_per_page = 5;

// Get the current page from the URL or default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = $page < 1 ? 1 : $page; // Ensure page is at least 1

// Calculate the offset for the SQL query
$offset = ($page - 1) * $records_per_page;

// Fetch total number of records
$stmt = $DB_con->prepare("SELECT COUNT(*) FROM customer_alerts");
$stmt->execute();
$total_records = $stmt->fetchColumn();

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);

// Fetch records for the current page
$stmt = $DB_con->prepare("SELECT * FROM customer_alerts ORDER BY id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$alerts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body>
    <div id="wrapper">
        <!-- Include sidebar navigation and menu -->
        <?php include 'admin-nav.php'; ?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Customer Alerts</h1>
                        <div class="row">
                            <!-- Email Form -->
                            <div class="col-lg-6">
                                <form role="form" method="POST" name="invite" action="customer_alerts.php">
                                    <div class="form-group">
                                        <p><span id="sent"></span></p>
                                        <p class="help-block">Send Bulk Email Alert to all Customers.</p> <br />
                                        <label>Subject</label>
                                        <input type="text" class="form-control" name="subject" placeholder="Subject" required /><br />
                                        <input type="hidden" class="form-control" name="email" placeholder="Email" value="<?php
                                                                                                                            $get = "SELECT email FROM `businesspartners`";
                                                                                                                            $run = $DB_con->query($get);
                                                                                                                            $emails = [];
                                                                                                                            while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
                                                                                                                                $emails[] = $row['email'];
                                                                                                                            }
                                                                                                                            echo implode(',', $emails);
                                                                                                                            ?>" />
                                        <textarea class="form-control" rows="5" name="msg" placeholder="Message" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea><br />
                                        <input type="submit" name="invite" class="btn btn-primary btn-lg btn-block" value="Send Email">
                                        <input type="hidden" name="MM_insert" value="invite">
                                        <p class="help-block">Send a bulk email alert to all registered customers here.</p>
                                    </div>
                                </form>
                                <hr />
                            </div>

                            <!-- SMS Form -->
                            <div class="col-lg-6">
                                <form role="form" method="POST" name="invite_sms" action="customer_alerts.php">
                                    <div class="form-group">
                                        <p><span id="sent"></span></p>
                                        <p class="help-block">Send Bulk SMS Alert to all Customers.</p> <br />
                                        <label>Subject</label>
                                        <input type="text" class="form-control" name="subject" placeholder="Subject" required /><br />
                                        <input type="hidden" class="form-control" name="phone" placeholder="Phone" value="<?php
                                                                                                                            $get = "SELECT phone FROM `affilate_user`";
                                                                                                                            $run = $DB_con->query($get);
                                                                                                                            $phones = [];
                                                                                                                            while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
                                                                                                                                $phones[] = $row['phone'];
                                                                                                                            }
                                                                                                                            echo implode(',', $phones);
                                                                                                                            ?>" />
                                        <textarea class="form-control" rows="5" name="msg" placeholder="Message" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea><br />
                                        <input type="submit" name="invite" class="btn btn-warning btn-lg btn-block" value="Send SMS">
                                        <input type="hidden" name="MM_insert_sms" value="invite_sms">
                                        <p class="help-block">Send bulk SMS alerts to all registered customers here.</p>
                                    </div>
                                </form>
                                <hr />
                            </div>

                            <!-- Customer Alerts Table -->
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Customer Alerts
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date</th>
                                                        <th>Email</th>
                                                        <th>Message</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Display alerts
                                                    foreach ($alerts as $index => $alert) {
                                                        echo "<tr>
                                                            <td>" . (($page - 1) * $records_per_page + $index + 1) . "</td>
                                                            <td>" . htmlspecialchars($alert['date'], ENT_QUOTES) . "</td>
                                                            <td>" . htmlspecialchars($alert['email'], ENT_QUOTES) . "</td>
                                                            <td>" . htmlspecialchars($alert['msg'], ENT_QUOTES) . "</td>
                                                            <td>
                                                                <a href='customer_alerts.php?delete_custAlert=" . $alert['id'] . "' class='btn btn-danger'>Delete</a>
                                                            </td>
                                                        </tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination Controls -->
                                        <nav>
                                            <ul class="pagination">
                                                <?php if ($page > 1): ?>
                                                    <li>
                                                        <a href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                                    <li class="<?php echo ($i === $page) ? 'active' : ''; ?>">
                                                        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php endfor; ?>

                                                <?php if ($page < $total_pages): ?>
                                                    <li>
                                                        <a href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>

                            <?php
                            // Handle deletion
                            if (isset($_GET['delete_custAlert'])) {
                                $delete_alert = $_GET['delete_custAlert'];
                                $stmt = $DB_con->prepare("DELETE FROM customer_alerts WHERE id = :id");
                                $stmt->bindParam(':id', $delete_alert, PDO::PARAM_INT);
                                if ($stmt->execute()) {
                                    echo "<script>alert('Alert deleted')</script>";
                                    echo "<script>window.open('customer_alerts.php','_self')</script>";
                                } else {
                                    echo "<script>alert('Failed to delete alert')</script>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


