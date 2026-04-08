<?php
function getBookingsToTruckDrivers(){

$user = $_SESSION['user_email'];  // Updated from MM_Username to new session standard
global $DB;  // Use PDO instead of MySQLi

$get_driver = "SELECT * FROM driver WHERE username=?";  // Parameterized query
$stmt = $DB->prepare($get_driver);
$stmt->execute([$user]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $row_type) {
    $ID = $row_type['driverID'];
    $company_name = $row_type['company_name'];
    $online = $row_type['online'];
    $mode_of_transport = $row_type['mode_of_transport'];
    $type_of_service = $row_type['type_of_service'];
    $username = $row_type['username'];

    $get = "SELECT * FROM `users` WHERE Name = ?";
    $stmt = $DB->prepare($get);
    $stmt->execute([$company_name]);
    $company_results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($company_results as $company_row) {
        $ID = $company_row['ID'];
        $Name = $company_row['Name'];
        $Email = $company_row['email'];
        $date = $company_row['date'];
        $days = $company_row['days'];

        $expire = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date))."+ $days day"));

        if(date("Y-m-d") < $expire) {
            $get = "SELECT * FROM bookings WHERE status = ? AND vehicle_type = ? AND company_name = ? ORDER BY Date DESC LIMIT 8";
            $stmt = $DB->prepare($get);
            $stmt->execute(['new', $type_of_service, $company_name]);
            $booking_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($booking_results as $booking_row) {
                $ID = $booking_row['order_id'];
                $Date = $booking_row['Date'];
                $email_fro = $booking_row['email'];
                $address = $booking_row['pick_up_address'];
                $drop_address = $booking_row['drop_address'];
                $name = $booking_row['Name'];
                $phone = $booking_row['phone'];
                $pick_up_date = $booking_row['pick_up_date'];
                $drop_date = $booking_row['drop_date'];
                $Drop_name = $booking_row['Drop_name'];
                $Total_price = $booking_row['Total_price'];
                $drop_phone = $booking_row['drop_phone'];
                $weight_of_package = $booking_row['weight'];
                $package_quantity = $booking_row['quantity'];
                $insurance = $booking_row['insurance'];
                $value_of_package = $booking_row['value'];
                $type_of_transport = $booking_row['type_of_transport'];
                $note = $booking_row['drivers_note'];
                $time = $booking_row['pick_up_time'];
                $service = $booking_row['vehicle_type'];
                $drop_time = $booking_row['drop_time'];
                
                if($service == "Parcel Delivery") {
                    $url = "order_datails.php?orderD=$ID";
                    $cost = 70 / 100 * $Total_price;
                } else if($service == "Freight Delivery") {
                    $url = "freight_order_details.php?orderD=$ID";
                    $cost = 80 / 100 * $Total_price;
                } else if($service == "Test") {
                    $url = "freight_order_details.php?orderD=$ID";
                    $cost = 70 / 100 * $Total_price;
                }
                
                $cost1 = number_format((float)$cost, 2, '.', '');
                
                if ($online == "offline") {
                    echo "
                    <ul class='list-group'>
                        <li class='list-group-item'><a style='color:#ff8c00;' href='#'> Order From $name <button class='btn btn-info btn-sm pull-right'>new</button></a> <br> $$cost1 </li>
                    </ul>
                    ";
                } else {
                    echo "
                    <tr>
                        <ul class='list-group'>
                            <li class='list-group-item'><a style='color:#ff8c00;' href='freight_order_details.php?orderD=$ID'> Order From $name <button class='btn btn-info btn-sm pull-right'>new</button></a> <br> $$cost1 </li>
                        </ul>
                    </tr>
                    ";
                }
            }
        } else {
            echo "<div style='color:red'><h2>Your account has expired please recharge!</h2></div>";
        }
    }
}



