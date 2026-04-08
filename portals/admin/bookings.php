<?php
/**
 * Admin Booking Management Page
 * View and manage bookings by service type
 */

// Verify user is admin
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['user_role']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: /login.php');
    exit;
}

// Load configuration
require_once dirname(__DIR__) . '/config/bootstrap.php';

$bookingProcessor = new BookingProcessor($DB, $CONFIG);
$fieldConfig = require_once dirname(__DIR__) . '/config/booking-fields-config.php';

// Get filter parameters
$filterServiceType = $_GET['service_type'] ?? '';
$filterStatus = $_GET['status'] ?? '';
$filterDate = $_GET['date'] ?? '';
$page = (int)($_GET['page'] ?? 1);
$perPage = 20;

// Build query
$query = "SELECT * FROM bookings WHERE 1=1";
$params = [];

if ($filterServiceType && isset($fieldConfig[$filterServiceType])) {
    $query .= " AND service_type = ?";
    $params[] = $filterServiceType;
}

if ($filterStatus) {
    $query .= " AND status = ?";
    $params[] = $filterStatus;
}

if ($filterDate) {
    $query .= " AND DATE(created_at) = ?";
    $params[] = $filterDate;
}

// Get total count
$countStmt = $DB->prepare(str_replace("SELECT *", "SELECT COUNT(*) as count", $query));
$countStmt->execute($params);
$totalBookings = $countStmt->fetch(PDO::FETCH_ASSOC)['count'];
$totalPages = ceil($totalBookings / $perPage);

// Add pagination
$offset = ($page - 1) * $perPage;
$query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
$params[] = $perPage;
$params[] = $offset;

// Fetch bookings
$stmt = $DB->prepare($query);
$stmt->execute($params);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get statistics
$statsQuery = "SELECT service_type, COUNT(*) as count, SUM(total_price) as revenue FROM bookings";
if ($filterDate) {
    $statsQuery .= " WHERE DATE(created_at) = ?";
    $statsStmt = $DB->prepare($statsQuery);
    $statsStmt->execute([$filterDate]);
} else {
    $statsStmt = $DB->prepare($statsQuery);
    $statsStmt->execute();
}
$statistics = $statsStmt->fetchAll(PDO::FETCH_ASSOC);

// Handle status update via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    header('Content-Type: application/json');
    
    $bookingId = (int)$_POST['booking_id'];
    $newStatus = $_POST['status'] ?? '';
    
    if ($bookingId && $newStatus && in_array($newStatus, ['pending', 'confirmed', 'in-progress', 'completed', 'cancelled'])) {
        if ($bookingProcessor->updateBookingStatus($bookingId, $newStatus)) {
            echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Booking Management</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/fontawesome-all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            padding: 20px;
        }

        .dashboard-header {
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #007bff;
        }

        .stat-card.parcel { border-left-color: #28a745; }
        .stat-card.freight { border-left-color: #ffc107; }
        .stat-card.furniture { border-left-color: #17a2b8; }
        .stat-card.taxi { border-left-color: #fd7e14; }
        .stat-card.towtruck { border-left-color: #e83e8c; }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
        }

        .stat-revenue {
            font-size: 1.3rem;
            color: #28a745;
            margin-top: 10px;
        }

        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .filter-section h5 {
            margin-bottom: 15px;
            font-weight: bold;
        }

        .filter-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-row > div {
            flex: 1;
            min-width: 150px;
        }

        .filter-row label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 5px;
            color: #555;
        }

        .filter-row select,
        .filter-row input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-filter {
            padding: 8px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .btn-filter:hover {
            background-color: #0056b3;
        }

        .btn-reset {
            padding: 8px 20px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-reset:hover {
            background-color: #5a6268;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .table {
            margin: 0;
        }

        .table thead {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .table th {
            padding: 15px;
            border: 1px solid #dee2e6;
        }

        .table td {
            padding: 15px;
            border: 1px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .service-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: bold;
            color: white;
        }

        .badge-parcel { background-color: #28a745; }
        .badge-freight { background-color: #ffc107; color: #333; }
        .badge-furniture { background-color: #17a2b8; }
        .badge-taxi { background-color: #fd7e14; }
        .badge-towtruck { background-color: #e83e8c; }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-confirmed { background-color: #cfe2ff; color: #084298; }
        .status-in-progress { background-color: #d1ecf1; color: #0c5460; }
        .status-completed { background-color: #d4edda; color: #155724; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-small {
            padding: 5px 10px;
            font-size: 0.8rem;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-view {
            background-color: #007bff;
            color: white;
        }

        .btn-view:hover {
            background-color: #0056b3;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #333;
        }

        .btn-edit:hover {
            background-color: #ffb300;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            cursor: pointer;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination .active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .modal-close {
            cursor: pointer;
            color: #999;
            font-size: 1.5rem;
            float: right;
        }

        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
            }

            .filter-row > div {
                width: 100%;
            }

            .action-buttons {
                flex-direction: column;
            }

            .table {
                font-size: 0.9rem;
            }

            .table th, .table td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <h1><i class="fas fa-list"></i> Booking Management</h1>
        <p>Manage all bookings across different service types</p>
    </div>

    <!-- Statistics -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-label">Total Bookings</div>
            <div class="stat-value"><?php echo $totalBookings; ?></div>
        </div>
        
        <?php foreach ($statistics as $stat): ?>
            <div class="stat-card <?php echo $stat['service_type']; ?>">
                <div class="stat-label"><?php echo ucfirst($stat['service_type']); ?> Bookings</div>
                <div class="stat-value"><?php echo $stat['count']; ?></div>
                <div class="stat-revenue">Revenue: $<?php echo number_format($stat['revenue'], 2); ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <h5><i class="fas fa-filter"></i> Filter Bookings</h5>
        <form method="GET" class="filter-row">
            <div>
                <label>Service Type</label>
                <select name="service_type">
                    <option value="">All Services</option>
                    <?php foreach ($fieldConfig as $type => $config): ?>
                        <option value="<?php echo $type; ?>" <?php echo $filterServiceType === $type ? 'selected' : ''; ?>>
                            <?php echo $config['service_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Status</label>
                <select name="status">
                    <option value="">All Status</option>
                    <option value="pending" <?php echo $filterStatus === 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="confirmed" <?php echo $filterStatus === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="in-progress" <?php echo $filterStatus === 'in-progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="completed" <?php echo $filterStatus === 'completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="cancelled" <?php echo $filterStatus === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            <div>
                <label>Date</label>
                <input type="date" name="date" value="<?php echo htmlspecialchars($filterDate); ?>">
            </div>
            <div class="filter-buttons">
                <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Filter</button>
                <a href="?page=1" class="btn-reset"><i class="fas fa-redo"></i> Reset</a>
            </div>
        </form>
    </div>

    <!-- Bookings Table -->
    <div class="table-container">
        <?php if (!empty($bookings)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Service Type</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <?php 
                            $bookingData = is_array($booking['booking_data']) 
                                ? $booking['booking_data'] 
                                : json_decode($booking['booking_data'], true);
                            $serviceConfig = $fieldConfig[$booking['service_type']] ?? [];
                        ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($booking['order_id']); ?></strong></td>
                            <td>
                                <span class="service-badge badge-<?php echo $booking['service_type']; ?>">
                                    <i class="<?php echo htmlspecialchars($serviceConfig['icon'] ?? 'fas fa-box'); ?>"></i>
                                    <?php echo htmlspecialchars($serviceConfig['service_name'] ?? ucfirst($booking['service_type'])); ?>
                                </span>
                            </td>
                            <td>
                                <div><?php echo htmlspecialchars($bookingData['name'] ?? 'N/A'); ?></div>
                                <small><?php echo htmlspecialchars($bookingData['email'] ?? ''); ?></small>
                            </td>
                            <td><strong>$<?php echo number_format($booking['total_price'], 2); ?></strong></td>
                            <td>
                                <select class="status-select" data-booking-id="<?php echo $booking['booking_id']; ?>">
                                    <option value="pending" <?php echo $booking['status'] === 'pending' ? 'selected' : ''; ?> class="status-pending">Pending</option>
                                    <option value="confirmed" <?php echo $booking['status'] === 'confirmed' ? 'selected' : ''; ?> class="status-confirmed">Confirmed</option>
                                    <option value="in-progress" <?php echo $booking['status'] === 'in-progress' ? 'selected' : ''; ?> class="status-in-progress">In Progress</option>
                                    <option value="completed" <?php echo $booking['status'] === 'completed' ? 'selected' : ''; ?> class="status-completed">Completed</option>
                                    <option value="cancelled" <?php echo $booking['status'] === 'cancelled' ? 'selected' : ''; ?> class="status-cancelled">Cancelled</option>
                                </select>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($booking['created_at'])); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-small btn-view" onclick="viewBooking(<?php echo $booking['booking_id']; ?>)">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>" 
                           class="<?php echo $page === $i ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="no-data">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #ddd;"></i>
                <p style="margin-top: 20px;">No bookings found matching your criteria</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Booking Details Modal -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-close" onclick="closeModal()">&times;</span>
                Booking Details
            </div>
            <div class="modal-body" id="modalBody">
                Loading...
            </div>
        </div>
    </div>

    <script>
        // Handle status change
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                const bookingId = this.getAttribute('data-booking-id');
                const newStatus = this.value;
                
                updateBookingStatus(bookingId, newStatus);
            });
        });

        function updateBookingStatus(bookingId, status) {
            fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=update_status&booking_id=' + bookingId + '&status=' + status
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Status updated successfully');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function viewBooking(bookingId) {
            // In a real app, this would fetch booking details via AJAX
            // For now, you could redirect to a detailed view
            alert('Booking details: ID ' + bookingId);
        }

        function closeModal() {
            document.getElementById('bookingModal').classList.remove('show');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('bookingModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>

<?php
/**
 * Usage:
 * 1. Include this file in admin panel
 * 2. Ensure user is authenticated as admin
 * 3. Database must have bookings table
 * 4. Service configuration must be loaded
 */
?>


