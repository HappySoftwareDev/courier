<?php
/**
 * Admin Users Management Page
 * View, filter, and manage all users in the system
 */

require_once '../../../config/bootstrap.php';
require_once 'login-security.php';

// Set variables for layout
$page_title = 'Users Management';
$site_name = 'WG ROOS Courier Admin';

// Make sure functions are available
if (!function_exists('getCount')) {
    require_once '../../../function.php';
}

// Get filter and search parameters
$type = $_GET['type'] ?? 'all';
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? 'all';

// Build query based on filter
$query = "SELECT * FROM `users` WHERE 1=1";
$params = [];

if ($type === 'customers') {
    $query .= " AND user_type = 'customer'";
} elseif ($type === 'partners') {
    $query .= " AND user_type = 'partner'";
}

if ($status === 'active') {
    $query .= " AND status = 'active'";
} elseif ($status === 'inactive') {
    $query .= " AND status = 'inactive'";
} elseif ($status === 'suspended') {
    $query .= " AND status = 'suspended'";
}

if (!empty($search)) {
    $query .= " AND (Name LIKE ? OR email LIKE ? OR phone LIKE ?)";
    $searchTerm = "%$search%";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
}

$query .= " ORDER BY created_at DESC LIMIT 100";

$users = [];
try {
    global $DB;
    $stmt = $DB->prepare($query);
    $stmt->execute($params);
    $users = $stmt->fetchAll();
} catch (Exception $e) {
    error_log('Users query error: ' . $e->getMessage());
}

// Prepare stats
$totalUsers = count($users);
$customers = count(array_filter($users, fn($u) => ($u['user_type'] ?? '') === 'customer'));
$partners = count(array_filter($users, fn($u) => ($u['user_type'] ?? '') === 'partner'));
$active = count(array_filter($users, fn($u) => ($u['status'] ?? '') === 'active'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $page_title; ?> | <?php echo $site_name; ?></title>
    <?php include '../head.php'; ?>
</head>

<body class="admin-portal">

    <div class="page-container">
        
        <!-- Sidebar Navigation -->
        <?php include '../sidebar-nav-menu.php'; ?>
        
        <!-- Main Content Wrapper -->
        <div class="main-content">
            
            <!-- Header -->
            <?php include '../header.php'; ?>
            
            <!-- Main Content Area -->
            <main class="main-wrapper">
                <section class="section">
                    <div class="container-fluid">
                        
                        <!-- Page Header -->
                        <div class="page-header mb-40">
                            <h1><?php echo $page_title; ?></h1>
                            <p class="text-muted">Manage customers and partners on the platform</p>
                        </div>

                        <!-- Quick Stats -->
                        <div class="row gap-3 mb-40">
                            <div class="col-md-3">
                                <div class="card stat-card border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-primary">
                                                <i class="lni lni-users"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Total Users</h6>
                                                <h3 class="mb-0"><?php echo $totalUsers; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card stat-card border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-success">
                                                <i class="lni lni-user"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Customers</h6>
                                                <h3 class="mb-0"><?php echo $customers; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card stat-card border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-info">
                                                <i class="lni lni-briefcase"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Partners</h6>
                                                <h3 class="mb-0"><?php echo $partners; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card stat-card border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-warning">
                                                <i class="lni lni-checkmark-circle"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="text-muted mb-1">Active</h6>
                                                <h3 class="mb-0"><?php echo $active; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter and Search Bar -->
                        <div class="card mb-40">
                            <div class="card-body">
                                <form method="GET" action="" class="row align-items-end gap-3">
                                    <div class="col-md-2">
                                        <label class="form-label">User Type</label>
                                        <select name="type" class="form-select" onchange="this.form.submit()">
                                            <option value="all" <?php echo $type === 'all' ? 'selected' : ''; ?>>All Users</option>
                                            <option value="customers" <?php echo $type === 'customers' ? 'selected' : ''; ?>>Customers</option>
                                            <option value="partners" <?php echo $type === 'partners' ? 'selected' : ''; ?>>Partners</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" onchange="this.form.submit()">
                                            <option value="all" <?php echo $status === 'all' ? 'selected' : ''; ?>>All Status</option>
                                            <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Active</option>
                                            <option value="inactive" <?php echo $status === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                            <option value="suspended" <?php echo $status === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Search</label>
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone" value="<?php echo htmlspecialchars($search); ?>">
                                            <button class="btn btn-outline-primary" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Users List (<?php echo $totalUsers; ?>)</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="usersTable">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Joined</th>
                                                <th>Bookings</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($users)): ?>
                                                <tr>
                                                    <td colspan="8" class="text-center py-4">
                                                        <p class="text-muted">No users found</p>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($users as $user): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?php echo htmlspecialchars($user['Name'] ?? ''); ?></strong>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                                                        <td><?php echo htmlspecialchars($user['phone'] ?? ''); ?></td>
                                                        <td>
                                                            <span class="badge 
                                                                <?php 
                                                                if (($user['user_type'] ?? '') === 'partner') {
                                                                    echo 'bg-primary';
                                                                } else {
                                                                    echo 'bg-secondary';
                                                                }
                                                                ?>">
                                                                <?php echo htmlspecialchars(ucfirst($user['user_type'] ?? 'customer')); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge 
                                                                <?php 
                                                                if (($user['status'] ?? '') === 'active') {
                                                                    echo 'bg-success';
                                                                } elseif (($user['status'] ?? '') === 'suspended') {
                                                                    echo 'bg-danger';
                                                                } else {
                                                                    echo 'bg-warning';
                                                                }
                                                                ?>">
                                                                <?php echo htmlspecialchars($user['status'] ?? 'inactive'); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <small class="text-muted">
                                                                <?php echo htmlspecialchars(date('M d, Y', strtotime($user['created_at'] ?? 'now'))); ?>
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-light text-dark">0</span>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                    Actions
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="javascript:viewUser('<?php echo htmlspecialchars($user['ID'] ?? ''); ?>')">View Profile</a></li>
                                                                    <li><a class="dropdown-item" href="javascript:editUser('<?php echo htmlspecialchars($user['ID'] ?? ''); ?>')">Edit</a></li>
                                                                    <li><hr class="dropdown-divider"></li>
                                                                    <li><a class="dropdown-item" href="javascript:suspendUser('<?php echo htmlspecialchars($user['ID'] ?? ''); ?>')">Suspend</a></li>
                                                                    <li><a class="dropdown-item text-danger" href="javascript:deleteUser('<?php echo htmlspecialchars($user['ID'] ?? ''); ?>')">Delete</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </main>

        </div>

    </div>

    <!-- Footer -->
    <?php include '../footer.php'; ?>

    <!-- Footer Scripts -->
    <?php include '../footerscripts.php'; ?>

    <script>
        // DataTables initialization
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('usersTable')) {
                new DataTable('#usersTable', {
                    responsive: true,
                    pageLength: 25,
                    order: [[5, 'desc']]
                });
            }
        });

        function viewUser(userId) {
            alert('Viewing user ' + userId);
            // In production, redirect to user detail page
        }

        function editUser(userId) {
            alert('Editing user ' + userId);
            // In production, redirect to user edit page
        }

        function suspendUser(userId) {
            if (confirm('Are you sure you want to suspend this user?')) {
                alert('User suspended successfully');
                // In production, make AJAX request to suspend user
            }
        }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                alert('User deleted successfully');
                // In production, make AJAX request to delete user
            }
        }
    </script>

</body>

</html>


