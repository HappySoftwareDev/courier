<?php 
/**
 * Main Landing Page & Portal Router
 * Serves as the entry point for the application
 * Routes to book, admin, and driver portals
 * 
 * Works from /public_html/app/ subdirectory (WordPress compatible)
 */

// Define APP_ROOT for consistency
define('APP_ROOT', dirname(__FILE__));

require_once 'config/bootstrap.php';

// Load legacy site settings for compatibility
if (file_exists('admin/pages/site_settings.php')) {
    include('admin/pages/site_settings.php');
}

// Get current user info if authenticated
$currentUser = null;
try {
    if (class_exists('AuthManager') && method_exists('AuthManager', 'isAuthenticated')) {
        if (AuthManager::isAuthenticated()) {
            $currentUser = [
                'id' => AuthManager::getUserId() ?? 'N/A',
                'email' => AuthManager::getUserEmail() ?? 'N/A',
                'role' => AuthManager::getUserRole() ?? 'guest',
                'name' => $_SESSION['user_name'] ?? 'User'
            ];
        }
    }
} catch (Exception $e) {
    // If auth check fails, continue without user info
    error_log("Auth check failed: " . $e->getMessage());
    $currentUser = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fast and reliable courier and logistics service - Parcel delivery, freight, furniture moving, taxi and tow truck services">
    <meta name="keywords" content="courier, delivery, parcel, freight, furniture, logistics">
    <meta name="author" content="<?php echo defined('APP_NAME') ? APP_NAME : 'Courier Service'; ?>">
    
    <title>Home | <?php echo defined('APP_NAME') ? APP_NAME : 'Courier Service'; ?></title>
    
    <link rel="icon" type="image/png" href="img/favicon.png">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.min.css">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 20px;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            padding: 60px 0;
        }

        .service-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .service-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 8px 24px rgba(0, 123, 255, 0.15);
            transform: translateY(-5px);
        }

        .service-icon {
            font-size: 48px;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .service-card h3 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .service-card p {
            color: #6c757d;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .cta-button {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 12px 30px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .cta-button:hover {
            background: #0056b3;
            color: white;
        }

        .nav-bar {
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .nav-logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .nav-logo img {
            max-height: 40px;
        }

        footer {
            background: #f8f9fa;
            padding: 40px 0;
            margin-top: 60px;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="nav-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="nav-logo">
                    <?php if (isset($logo) && file_exists('admin/pages/custom_files/' . $logo)): ?>
                        <img src="admin/pages/custom_files/<?php echo htmlspecialchars($logo); ?>" alt="Logo">
                    <?php else: ?>
                        <?php echo APP_NAME; ?>
                    <?php endif; ?>
                </div>
                
                <ul class="nav nav-pills" style="margin-bottom: 0;">
                    <li class="nav-item"><a class="nav-link" href="/portals/booking/index.php">Book Now</a></li>
                    <li class="nav-item"><a class="nav-link" href="/portals/driver/index.php">Driver Portal</a></li>
                    <li class="nav-item"><a class="nav-link" href="/portals/admin/index.php">Admin</a></li>
                    <?php if ($currentUser): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <?php echo htmlspecialchars($currentUser['name']); ?> (<?php echo ucfirst($currentUser['role']); ?>)
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/portals/booking/settings.php">Settings</a></li>
                                <li><a class="dropdown-item" href="/portals/booking/signin.php?doLogout=true">Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>Fast & Reliable Logistics</h1>
            <p>Deliver your parcels, freight, furniture, and more with confidence</p>
            <a href="/portals/booking/index.php" class="btn btn-light btn-lg">Start Booking Now</a>
        </div>
    </section>

    <!-- Services Section -->
    <section class="container">
        <h2 style="text-align: center; margin: 60px 0 40px; font-size: 36px; font-weight: 700;">Our Services</h2>
        
        <div class="service-grid">
            <!-- Parcel Delivery -->
            <a href="/portals/booking/index.php?service=parcel" class="service-card">
                <div class="service-icon"><i class="fas fa-box"></i></div>
                <h3>Parcel Delivery</h3>
                <p>Fast and secure delivery for your parcels within the city</p>
                <span class="cta-button">Book Parcel</span>
            </a>

            <!-- Freight -->
            <a href="/portals/booking/index.php?service=freight" class="service-card">
                <div class="service-icon"><i class="fas fa-dolly"></i></div>
                <h3>Freight Shipping</h3>
                <p>Heavy cargo and bulk freight transportation</p>
                <span class="cta-button">Ship Freight</span>
            </a>

            <!-- Furniture Moving -->
            <a href="/portals/booking/index.php?service=furniture" class="service-card">
                <div class="service-icon"><i class="fas fa-couch"></i></div>
                <h3>Furniture Moving</h3>
                <p>Professional furniture relocation and moving service</p>
                <span class="cta-button">Move Furniture</span>
            </a>

            <!-- Taxi -->
            <a href="/portals/booking/index.php?service=taxi" class="service-card">
                <div class="service-icon"><i class="fas fa-taxi"></i></div>
                <h3>Taxi Service</h3>
                <p>Quick and convenient taxi bookings</p>
                <span class="cta-button">Book Taxi</span>
            </a>

            <!-- Tow Truck -->
            <a href="/portals/booking/index.php?service=towtruck" class="service-card">
                <div class="service-icon"><i class="fas fa-truck"></i></div>
                <h3>Tow Truck</h3>
                <p>Vehicle towing and breakdown assistance</p>
                <span class="cta-button">Request Tow</span>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><?php echo APP_NAME; ?></h5>
                    <p><?php echo isset($site_tagline) ? htmlspecialchars($site_tagline) : 'Your trusted logistics partner'; ?></p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="/terms.php">Terms & Conditions</a></li>
                        <li><a href="/privacy.php">Privacy Policy</a></li>
                        <li><a href="/contact_sub.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Contact</h5>
                    <p><?php echo isset($site_phone) ? htmlspecialchars($site_phone) : 'Contact us for support'; ?></p>
                    <p><?php echo isset($site_email) ? htmlspecialchars($site_email) : 'info@example.com'; ?></p>
                </div>
            </div>
            <hr>
            <p style="text-align: center; margin: 0; color: #6c757d;">
                &copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Firebase Messaging (Optional) -->
    <?php if (file_exists('web_push/firebase-messaging-sw.php')): ?>
    <script src="web_push/firebase-messaging-sw.php"></script>
    <?php endif; ?>
</body>
</html>

