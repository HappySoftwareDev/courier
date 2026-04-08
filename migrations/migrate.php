<?php
/**
 * Database Schema Migration
 * Creates the bookings table and related tables for the dynamic booking system
 * 
 * Run this script once to set up the database schema
 * Usage: php migrate.php OR access via web browser
 */

require_once dirname(__FILE__) . '/../config/bootstrap.php';

$messages = [];
$errors = [];

try {
    // Create bookings table
    $createBookingsTable = "
    CREATE TABLE IF NOT EXISTS bookings (
        booking_id INT PRIMARY KEY AUTO_INCREMENT,
        order_id VARCHAR(50) UNIQUE NOT NULL,
        user_id INT DEFAULT NULL,
        service_type VARCHAR(50) NOT NULL,
        booking_data JSON NOT NULL,
        base_price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        modifiers JSON DEFAULT NULL,
        coupon_code VARCHAR(50) DEFAULT NULL,
        coupon_discount DECIMAL(10, 2) DEFAULT 0.00,
        total_price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
        status VARCHAR(20) NOT NULL DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        created_ip VARCHAR(45),
        notes TEXT,
        INDEX idx_order_id (order_id),
        INDEX idx_service_type (service_type),
        INDEX idx_status (status),
        INDEX idx_user_id (user_id),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $DB->exec($createBookingsTable);
    $messages[] = "✓ Bookings table created successfully";
    
} catch (Exception $e) {
    $errors[] = "Failed to create bookings table: " . $e->getMessage();
}

try {
    // Create booking_history table for tracking status changes
    $createHistoryTable = "
    CREATE TABLE IF NOT EXISTS booking_history (
        history_id INT PRIMARY KEY AUTO_INCREMENT,
        booking_id INT NOT NULL,
        old_status VARCHAR(20),
        new_status VARCHAR(20) NOT NULL,
        changed_by INT,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_booking_id (booking_id),
        FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $DB->exec($createHistoryTable);
    $messages[] = "✓ Booking history table created successfully";
    
} catch (Exception $e) {
    $errors[] = "Failed to create booking_history table: " . $e->getMessage();
}

try {
    // Create booking_items table for multi-item bookings
    $createItemsTable = "
    CREATE TABLE IF NOT EXISTS booking_items (
        item_id INT PRIMARY KEY AUTO_INCREMENT,
        booking_id INT NOT NULL,
        item_type VARCHAR(100),
        description TEXT,
        quantity INT DEFAULT 1,
        weight DECIMAL(8, 2),
        dimensions VARCHAR(100),
        special_handling BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_booking_id (booking_id),
        FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $DB->exec($createItemsTable);
    $messages[] = "✓ Booking items table created successfully";
    
} catch (Exception $e) {
    $errors[] = "Failed to create booking_items table: " . $e->getMessage();
}

try {
    // Create driver_assignments table
    $createAssignmentsTable = "
    CREATE TABLE IF NOT EXISTS driver_assignments (
        assignment_id INT PRIMARY KEY AUTO_INCREMENT,
        booking_id INT NOT NULL,
        driver_id INT,
        assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        assigned_by INT,
        accepted_at TIMESTAMP NULL,
        declined_at TIMESTAMP NULL,
        completed_at TIMESTAMP NULL,
        status VARCHAR(20) DEFAULT 'pending',
        notes TEXT,
        INDEX idx_booking_id (booking_id),
        INDEX idx_driver_id (driver_id),
        FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $DB->exec($createAssignmentsTable);
    $messages[] = "✓ Driver assignments table created successfully";
    
} catch (Exception $e) {
    $errors[] = "Failed to create driver_assignments table: " . $e->getMessage();
}

try {
    // Create booking_locations table for tracking stops
    $createLocationsTable = "
    CREATE TABLE IF NOT EXISTS booking_locations (
        location_id INT PRIMARY KEY AUTO_INCREMENT,
        booking_id INT NOT NULL,
        location_type VARCHAR(20) NOT NULL,
        latitude DECIMAL(10, 8),
        longitude DECIMAL(11, 8),
        address TEXT,
        city VARCHAR(100),
        postal_code VARCHAR(20),
        arrival_time TIMESTAMP NULL,
        departure_time TIMESTAMP NULL,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_booking_id (booking_id),
        FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $DB->exec($createLocationsTable);
    $messages[] = "✓ Booking locations table created successfully";
    
} catch (Exception $e) {
    $errors[] = "Failed to create booking_locations table: " . $e->getMessage();
}

try {
    // Create indexes for better performance
    $indexQueries = [
        "ALTER TABLE bookings ADD UNIQUE INDEX idx_unique_order_id (order_id)" => "Order ID unique index",
        "ALTER TABLE booking_history ADD INDEX idx_created_at (created_at)" => "History timestamp index",
        "ALTER TABLE driver_assignments ADD INDEX idx_status (status)" => "Assignment status index",
        "ALTER TABLE booking_locations ADD INDEX idx_location_type (location_type)" => "Location type index"
    ];
    
    foreach ($indexQueries as $query => $description) {
        try {
            $DB->exec($query);
            $messages[] = "✓ $description created";
        } catch (Exception $e) {
            // Index might already exist, not critical
            if (strpos($e->getMessage(), 'Duplicate key name') === false) {
                $errors[] = "Index creation warning: $description";
            }
        }
    }
    
} catch (Exception $e) {
    // Non-critical, continue
}

// Verify tables exist
$verifyQueries = [
    "SELECT 1 FROM bookings LIMIT 1" => "bookings",
    "SELECT 1 FROM booking_history LIMIT 1" => "booking_history",
    "SELECT 1 FROM booking_items LIMIT 1" => "booking_items",
    "SELECT 1 FROM driver_assignments LIMIT 1" => "driver_assignments",
    "SELECT 1 FROM booking_locations LIMIT 1" => "booking_locations"
];

$verification = [];
foreach ($verifyQueries as $query => $table) {
    try {
        $DB->query($query);
        $verification[$table] = true;
    } catch (Exception $e) {
        $verification[$table] = false;
        $errors[] = "Failed to verify table: $table";
    }
}

// Generate sample data (optional)
$sampleData = isset($_GET['sample']) && $_GET['sample'] === '1';
if ($sampleData) {
    try {
        $DB->exec("
        INSERT INTO bookings (order_id, service_type, booking_data, base_price, total_price, status)
        VALUES (
            'ORD-20250127-SAMPLE001',
            'parcel',
            JSON_OBJECT('name', 'John Doe', 'email', 'john@example.com', 'weight', '5', 'from_address', '123 Main St', 'to_address', '456 Oak Ave'),
            35.00,
            35.00,
            'pending'
        );
        ");
        $messages[] = "✓ Sample booking data inserted";
    } catch (Exception $e) {
        // Might be a duplicate, that's ok
    }
}

// Output results
$isCLI = php_sapi_name() === 'cli';

if (!$isCLI) {
    echo "<!DOCTYPE html>
<html>
<head>
    <title>Database Migration - Dynamic Booking System</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .message { padding: 12px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #28a745; background-color: #d4edda; color: #155724; }
        .error { border-left-color: #dc3545; background-color: #f8d7da; color: #721c24; }
        .section { margin: 20px 0; }
        .section-title { font-weight: bold; color: #007bff; margin: 15px 0 10px 0; }
        .table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .table th, .table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .table th { background-color: #f8f9fa; font-weight: bold; }
        .status-ok { color: #28a745; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
        .button { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
        .button:hover { background-color: #0056b3; }
        .button-secondary { background-color: #6c757d; }
        .button-secondary:hover { background-color: #5a6268; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Database Migration - Dynamic Booking System</h1>";
} else {
    echo "\n=== DATABASE MIGRATION ===\n\n";
}

if ($isCLI) {
    echo "Migration Results:\n";
    echo "==================\n\n";
}

// Display messages
if (!empty($messages)) {
    if ($isCLI) {
        foreach ($messages as $msg) {
            echo "$msg\n";
        }
    } else {
        echo "<div class='section'>";
        echo "<div class='section-title'>✓ Success Messages</div>";
        foreach ($messages as $msg) {
            echo "<div class='message'>$msg</div>";
        }
        echo "</div>";
    }
}

// Display errors
if (!empty($errors)) {
    if ($isCLI) {
        echo "\nErrors:\n";
        foreach ($errors as $err) {
            echo "✗ $err\n";
        }
    } else {
        echo "<div class='section'>";
        echo "<div class='section-title'>⚠ Errors/Warnings</div>";
        foreach ($errors as $err) {
            echo "<div class='message error'>$err</div>";
        }
        echo "</div>";
    }
}

// Display verification
if ($isCLI) {
    echo "\nTable Verification:\n";
} else {
    echo "<div class='section'>";
    echo "<div class='section-title'>Table Verification</div>";
    echo "<table class='table'>";
    echo "<tr><th>Table</th><th>Status</th></tr>";
}

foreach ($verification as $table => $exists) {
    $status = $exists ? "✓ OK" : "✗ FAILED";
    if ($isCLI) {
        echo "$table: $status\n";
    } else {
        $class = $exists ? 'status-ok' : 'status-error';
        echo "<tr><td>$table</td><td class='$class'>$status</td></tr>";
    }
}

if (!$isCLI) {
    echo "</table>";
    echo "</div>";
    
    // Display summary
    $allSuccess = empty($errors) && array_filter($verification);
    echo "<div class='section'>";
    if ($allSuccess) {
        echo "<div class='message' style='border-left-color: #28a745; background-color: #d4edda; color: #155724;'>";
        echo "<strong>✓ Migration Completed Successfully!</strong><br>";
        echo "All database tables have been created and verified.";
        echo "</div>";
    } else {
        echo "<div class='message error'>";
        echo "<strong>⚠ Migration Completed with Issues</strong><br>";
        echo "Some tables may not have been created. Please review the errors above.";
        echo "</div>";
    }
    echo "</div>";
    
    // Display action buttons
    echo "<div class='section'>";
    echo "<a href='?' class='button'>Re-run Migration</a>";
    echo "<a href='?sample=1' class='button button-secondary'>Add Sample Data</a>";
    echo "<a href='/verify-booking-system.php' class='button button-secondary'>Verify System</a>";
    echo "</div>";
    
    echo "</div></body></html>";
} else {
    echo "\n";
    if (empty($errors) && array_filter($verification)) {
        echo "✓ Migration completed successfully!\n";
    } else {
        echo "⚠ Migration completed with issues. Please review above.\n";
    }
}

?>


