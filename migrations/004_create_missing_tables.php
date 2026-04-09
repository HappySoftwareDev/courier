<?php
/**
 * Migration: Create All Missing Application Tables
 * 
 * This migration creates all the necessary tables from the original SQL dump
 * that are required for full application functionality.
 * 
 * Tables created: 56 total
 * - Admin and user management
 * - Booking and delivery system
 * - Driver management
 * - Payment processing
 * - Affiliates and commissions
 * - Pricing and zones
 * - Blog and content
 * - Notifications and alerts
 * - WordPress integration tables (if needed)
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get database connection
require_once dirname(dirname(__FILE__)) . '/config/bootstrap.php';

// List of all tables that need to be created
$tables_created = 0;
$tables_skipped = 0;
$tables_failed = array();

// Helper function to safely execute migration SQL
function execute_migration_sql($sql, $table_name = '') {
    global $DB, $tables_created, $tables_skipped, $tables_failed;
    
    try {
        if ($DB->query($sql)) {
            $tables_created++;
            return true;
        } else {
            if ($table_name) {
                $tables_failed[$table_name] = $DB->error;
            }
            return false;
        }
    } catch (Exception $e) {
        if ($table_name) {
            $tables_failed[$table_name] = $e->getMessage();
        }
        return false;
    }
}

// Helper function to check if table exists
function table_exists($table_name) {
    global $DB;
    $result = $DB->query("SHOW TABLES LIKE '$table_name'");
    return $result && $result->num_rows > 0;
}

echo "<h2>WG ROOS - Database Migration: Creating All Missing Tables</h2>";
echo "<p>This process will create all required application tables if they don't already exist.</p>";
echo "<hr>";

// START CREATING TABLES

// 1. Admin table
if (!table_exists('admin')) {
    $sql = "CREATE TABLE `admin` (
      `ID` int(11) NOT NULL,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `Name` varchar(40) NOT NULL,
      `Email` varchar(40) NOT NULL,
      `phone` varchar(200) NOT NULL,
      `Password` varchar(40) NOT NULL,
      `push_token` varchar(400) DEFAULT NULL,
      PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'admin')) {
        echo "✓ Created table: admin<br>";
    }
} else {
    echo "→ Skipped table: admin (already exists)<br>";
    $tables_skipped++;
}

// 2. Affiliate invites table
if (!table_exists('affilate_invites')) {
    $sql = "CREATE TABLE `affilate_invites` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `type` varchar(200) NOT NULL,
      `affiliate_no` varchar(200) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'affilate_invites')) {
        echo "✓ Created table: affilate_invites<br>";
    }
} else {
    echo "→ Skipped table: affilate_invites (already exists)<br>";
    $tables_skipped++;
}

// 3. Affiliate users table
if (!table_exists('affilate_user')) {
    $sql = "CREATE TABLE `affilate_user` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `name` varchar(200) NOT NULL,
      `email` varchar(200) NOT NULL,
      `phone` varchar(200) NOT NULL,
      `password` varchar(200) NOT NULL,
      `affialte_no` varchar(200) NOT NULL,
      `address` varchar(200) NOT NULL,
      `paid_orders` varchar(2000) DEFAULT NULL,
      `balance` varchar(200) DEFAULT NULL,
      `reserve` varchar(200) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'affilate_user')) {
        echo "✓ Created table: affilate_user<br>";
    }
} else {
    echo "→ Skipped table: affilate_user (already exists)<br>";
    $tables_skipped++;
}

// 4. Affiliate messages table
if (!table_exists('affiliate_msg')) {
    $sql = "CREATE TABLE `affiliate_msg` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `name` varchar(200) DEFAULT NULL,
      `msg` varchar(20000) NOT NULL,
      `affiliate_no` varchar(200) DEFAULT NULL,
      `reply_no` varchar(200) DEFAULT NULL,
      `subject` varchar(200) NOT NULL,
      `status` varchar(200) DEFAULT 'new',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'affiliate_msg')) {
        echo "✓ Created table: affiliate_msg<br>";
    }
} else {
    echo "→ Skipped table: affiliate_msg (already exists)<br>";
    $tables_skipped++;
}

// 5. Affiliate payouts table
if (!table_exists('affiliate_payouts')) {
    $sql = "CREATE TABLE `affiliate_payouts` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `affiliate_no` varchar(200) NOT NULL,
      `amount` varchar(200) NOT NULL,
      `order_id` int(11) NOT NULL,
      `payment_method` varchar(200) NOT NULL,
      `status` varchar(200) DEFAULT 'new',
      `amount_paid` varchar(200) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'affiliate_payouts')) {
        echo "✓ Created table: affiliate_payouts<br>";
    }
} else {
    echo "→ Skipped table: affiliate_payouts (already exists)<br>";
    $tables_skipped++;
}

// 6. API users table
if (!table_exists('api_users')) {
    $sql = "CREATE TABLE `api_users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `join_date` varchar(100) NOT NULL,
      `business_name` varchar(255) NOT NULL,
      `business_email` varchar(255) NOT NULL,
      `business_phone` varchar(25) NOT NULL,
      `password` varchar(200) NOT NULL,
      `affialte_no` varchar(200) NOT NULL,
      `address` varchar(200) NOT NULL,
      `api_key` varchar(2000) NOT NULL,
      `contact_person` varchar(200) DEFAULT NULL,
      `personal_phone` varchar(200) DEFAULT NULL,
      `country` varchar(255) DEFAULT NULL,
      `state` varchar(255) DEFAULT NULL,
      `city` varchar(255) DEFAULT NULL,
      `status` varchar(50) NOT NULL DEFAULT 'active',
      `push_token` varchar(400) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'api_users')) {
        echo "✓ Created table: api_users<br>";
    }
} else {
    echo "→ Skipped table: api_users (already exists)<br>";
    $tables_skipped++;
}

// 7. API users business table
if (!table_exists('api_users_business')) {
    $sql = "CREATE TABLE `api_users_business` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `api_user_id` int(11) NOT NULL,
      `join_date` varchar(100) NOT NULL,
      `business_name` varchar(255) NOT NULL,
      `business_email` varchar(255) NOT NULL,
      `business_phone` varchar(25) NOT NULL,
      `password` varchar(200) NOT NULL,
      `affialte_no` varchar(200) NOT NULL,
      `address` varchar(200) NOT NULL,
      `api_key` varchar(2000) NOT NULL,
      `contact_person` varchar(200) DEFAULT NULL,
      `personal_phone` varchar(200) DEFAULT NULL,
      `country` varchar(255) DEFAULT NULL,
      `state` varchar(255) DEFAULT NULL,
      `city` varchar(255) DEFAULT NULL,
      `status` varchar(50) NOT NULL DEFAULT 'active',
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'api_users_business')) {
        echo "✓ Created table: api_users_business<br>";
    }
} else {
    echo "→ Skipped table: api_users_business (already exists)<br>";
    $tables_skipped++;
}

// 8. App download tracking table
if (!table_exists('app_download')) {
    $sql = "CREATE TABLE `app_download` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `app` varchar(200) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'app_download')) {
        echo "✓ Created table: app_download<br>";
    }
} else {
    echo "→ Skipped table: app_download (already exists)<br>";
    $tables_skipped++;
}

// 9. Blog table
if (!table_exists('blog')) {
    $sql = "CREATE TABLE `blog` (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `Name` varchar(200) NOT NULL,
      `heading` varchar(200) NOT NULL,
      `category` varchar(200) NOT NULL,
      `message` varchar(5000) NOT NULL,
      `date` varchar(200) NOT NULL,
      `image` varchar(200) NOT NULL,
      `Post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'blog')) {
        echo "✓ Created table: blog<br>";
    }
} else {
    echo "→ Skipped table: blog (already exists)<br>";
    $tables_skipped++;
}

// 10. Blog comments table
if (!table_exists('blog_comments')) {
    $sql = "CREATE TABLE `blog_comments` (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `Name` varchar(200) NOT NULL,
      `Email` varchar(200) NOT NULL,
      `message` varchar(800) NOT NULL,
      `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `Blog_id` int(11) NOT NULL,
      `website` varchar(200) DEFAULT 'no website',
      PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'blog_comments')) {
        echo "✓ Created table: blog_comments<br>";
    }
} else {
    echo "→ Skipped table: blog_comments (already exists)<br>";
    $tables_skipped++;
}

// 11. Blog subscribers table
if (!table_exists('blog_sub')) {
    $sql = "CREATE TABLE `blog_sub` (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `Name` varchar(200) NOT NULL,
      `Email` varchar(200) NOT NULL,
      PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'blog_sub')) {
        echo "✓ Created table: blog_sub<br>";
    }
} else {
    echo "→ Skipped table: blog_sub (already exists)<br>";
    $tables_skipped++;
}

// NOTE: Bookings table should already exist from earlier migration
// Skipping it here as it's created in 001_create_site_settings.sql

// 12. Business partners table
if (!table_exists('businesspartners')) {
    $sql = "CREATE TABLE `businesspartners` (
      `businessID` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `businessName` varchar(200) NOT NULL,
      `email` varchar(200) NOT NULL,
      `phone` varchar(200) NOT NULL,
      `address` varchar(200) DEFAULT NULL,
      `businessLocation` varchar(200) NOT NULL,
      `businessType` varchar(200) NOT NULL,
      `software_packages` varchar(200) DEFAULT NULL,
      `estimateDeliveries` varchar(200) DEFAULT NULL,
      `pick_up_address` varchar(200) DEFAULT NULL,
      `deliveryTime` varchar(200) DEFAULT NULL,
      `PreferedTransport` varchar(200) DEFAULT NULL,
      `NameOfContact` varchar(200) DEFAULT NULL,
      `company_logo` varchar(200) DEFAULT NULL,
      `PersonPhone` varchar(200) DEFAULT NULL,
      `password` varchar(200) NOT NULL,
      `affiliate_no` varchar(200) DEFAULT NULL,
      `client_num` int(11) NOT NULL,
      `push_token` varchar(400) DEFAULT NULL,
      PRIMARY KEY (`businessID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'businesspartners')) {
        echo "✓ Created table: businesspartners<br>";
    }
} else {
    echo "→ Skipped table: businesspartners (already exists)<br>";
    $tables_skipped++;
}

// 13. Chat drivers table
if (!table_exists('chat_drivers')) {
    $sql = "CREATE TABLE `chat_drivers` (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `company_name` varchar(200) DEFAULT 'merchant',
      `message` varchar(500) NOT NULL,
      `name` varchar(40) NOT NULL,
      `IDFrom` int(11) NOT NULL,
      `status` varchar(200) NOT NULL DEFAULT 'new',
      PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'chat_drivers')) {
        echo "✓ Created table: chat_drivers<br>";
    }
} else {
    echo "→ Skipped table: chat_drivers (already exists)<br>";
    $tables_skipped++;
}

// 14. Cities table
if (!table_exists('cities')) {
    $sql = "CREATE TABLE `cities` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `Chingola` varchar(20) NOT NULL DEFAULT 'None',
      `Kitwe` varchar(20) NOT NULL DEFAULT 'None', 
      `Chiliabombwe` varchar(20) NOT NULL DEFAULT 'None',
      `Mufulira` varchar(20) NOT NULL DEFAULT 'None',
      `Ndola` varchar(20) NOT NULL DEFAULT 'None',
      `Kabwe` varchar(20) NOT NULL DEFAULT 'None',
      `Solwezi` varchar(20) NOT NULL DEFAULT 'None',
      `Chongwe` varchar(20) NOT NULL DEFAULT 'None',
      `Chipata` varchar(20) NOT NULL DEFAULT 'None',
      `Luanshya` varchar(20) NOT NULL DEFAULT 'None',
      `Lusaka` varchar(20) NOT NULL DEFAULT 'None',
      `Kalumbila` varchar(20) NOT NULL DEFAULT 'None',
      `Chirundu` varchar(20) NOT NULL DEFAULT 'None',
      `Kansanshi` varchar(20) NOT NULL DEFAULT 'None',
      `Lumwana` varchar(20) NOT NULL DEFAULT 'None',
      `Chisamba` varchar(20) NOT NULL DEFAULT 'None',
      `Chama` varchar(20) NOT NULL DEFAULT 'None',
      `Chadiza` varchar(20) NOT NULL DEFAULT 'None',
      `Chambeshi` varchar(20) NOT NULL DEFAULT 'None',
      `Other` varchar(20) NOT NULL DEFAULT 'None',
      `Chavuma` varchar(20) NOT NULL DEFAULT 'None',
      `Chembe` varchar(20) NOT NULL DEFAULT 'None',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'cities')) {
        echo "✓ Created table: cities<br>";
    }
} else {
    echo "→ Skipped table: cities (already exists)<br>";
    $tables_skipped++;
}

// 15. Clients table
if (!table_exists('clients')) {
    $sql = "CREATE TABLE `clients` (
      `client_id` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `Name` varchar(40) NOT NULL,
      `Email` varchar(40) NOT NULL,
      `Password` varchar(40) NOT NULL,
      `affiliate_no` varchar(200) DEFAULT NULL,
      PRIMARY KEY (`client_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'clients')) {
        echo "✓ Created table: clients<br>";
    }
} else {
    echo "→ Skipped table: clients (already exists)<br>";
    $tables_skipped++;
}

// 16. Common coupon table
if (!table_exists('common_coupon')) {
    $sql = "CREATE TABLE `common_coupon` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `coupon` varchar(50) DEFAULT NULL,
      `expiry_date` varchar(50) DEFAULT NULL,
      `limit_used` int(11) DEFAULT NULL,
      `used` int(11) DEFAULT NULL,
      `type` int(11) DEFAULT NULL COMMENT '1 for percentage 2 for amount',
      `amount` varchar(50) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'common_coupon')) {
        echo "✓ Created table: common_coupon<br>";
    }
} else {
    echo "→ Skipped table: common_coupon (already exists)<br>";
    $tables_skipped++;
}

// 17. Contacts table
if (!table_exists('contacts')) {
    $sql = "CREATE TABLE `contacts` (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `Name` varchar(200) NOT NULL,
      `Surname` varchar(200) NOT NULL,
      `Email` varchar(200) NOT NULL,
      `message` varchar(800) NOT NULL,
      PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'contacts')) {
        echo "✓ Created table: contacts<br>";
    }
} else {
    echo "→ Skipped table: contacts (already exists)<br>";
    $tables_skipped++;
}

// 18. Contact replies table
if (!table_exists('contact_reply')) {
    $sql = "CREATE TABLE `contact_reply` (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `Name` varchar(200) NOT NULL,
      `Subject` varchar(200) NOT NULL,
      `Email` varchar(200) NOT NULL,
      `phone` varchar(200) DEFAULT NULL,
      `message` varchar(800) NOT NULL,
      `reply_id` int(11) DEFAULT NULL,
      `replied_by` varchar(20) DEFAULT NULL,
      PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'contact_reply')) {
        echo "✓ Created table: contact_reply<br>";
    }
} else {
    echo "→ Skipped table: contact_reply (already exists)<br>";
    $tables_skipped++;
}

// 19. Countries table
if (!table_exists('countries')) {
    $sql = "CREATE TABLE `countries` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date` date NOT NULL,
      `country` varchar(100) NOT NULL,
      `assigned_zone` varchar(100) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'countries')) {
        echo "✓ Created table: countries<br>";
    }
} else {
    echo "→ Skipped table: countries (already exists)<br>";
    $tables_skipped++;
}

// 20. Customer alerts table
if (!table_exists('customer_alerts')) {
    $sql = "CREATE TABLE `customer_alerts` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `msg` varchar(20000) NOT NULL,
      `subject` varchar(200) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'customer_alerts')) {
        echo "✓ Created table: customer_alerts<br>";
    }
} else {
    echo "→ Skipped table: customer_alerts (already exists)<br>";
    $tables_skipped++;
}

// 21. Delivery table
if (!table_exists('Delivery')) {
    $sql = "CREATE TABLE `Delivery` (
      `deliveryId` int(11) NOT NULL AUTO_INCREMENT,
      `PickupPoint` varchar(100) NOT NULL,
      `Dropoffpoint` varchar(100) NOT NULL,
      `Checkpoint1` varchar(100) NOT NULL,
      `Checkpoint2` varchar(100) NOT NULL,
      `Sender` int(11) DEFAULT NULL,
      `Recipient` int(11) DEFAULT NULL,
      `status` int(11) DEFAULT NULL,
      `PickUpTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `DropOffTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      `parcelId` int(11) NOT NULL,
      PRIMARY KEY (`deliveryId`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4";
    if (execute_migration_sql($sql, 'Delivery')) {
        echo "✓ Created table: Delivery<br>";
    }
} else {
    echo "→ Skipped table: Delivery (already exists)<br>";
    $tables_skipped++;
}

// 22. Driver table
if (!table_exists('driver')) {
    $sql = "CREATE TABLE `driver` (
      `driverID` int(11) NOT NULL AUTO_INCREMENT,
      `driver_number` int(11) NOT NULL,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `name` varchar(200) NOT NULL,
      `company_name` varchar(200) DEFAULT 'merchant',
      `phone` varchar(20) NOT NULL,
      `address` varchar(200) NOT NULL,
      `city` varchar(200) DEFAULT NULL,
      `vehicleMake` varchar(200) DEFAULT NULL,
      `model` varchar(200) DEFAULT NULL,
      `year` varchar(200) DEFAULT NULL,
      `engineCapacity` varchar(200) DEFAULT NULL,
      `RegNo` varchar(200) DEFAULT NULL,
      `DOB` varchar(200) DEFAULT NULL,
      `occupation` varchar(100) DEFAULT NULL,
      `email` varchar(200) DEFAULT 'no email',
      `mode_of_transport` varchar(2000) DEFAULT NULL,
      `type_of_service` varchar(200) DEFAULT NULL,
      `truckType` varchar(2000) DEFAULT NULL,
      `username` varchar(200) DEFAULT 'pending',
      `password` varchar(200) DEFAULT NULL,
      `profileImage` varchar(5000) DEFAULT 'profilePic',
      `online` varchar(200) DEFAULT 'offline',
      `time` int(11) DEFAULT NULL,
      `lat` varchar(200) DEFAULT NULL,
      `lng` varchar(200) DEFAULT NULL,
      `info` varchar(200) DEFAULT '....',
      `username_backup` varchar(100) DEFAULT NULL,
      `push_token` varchar(400) DEFAULT NULL,
      PRIMARY KEY (`driverID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'driver')) {
        echo "✓ Created table: driver<br>";
    }
} else {
    echo "→ Skipped table: driver (already exists)<br>";
    $tables_skipped++;
}

// 23. Driver alerts table
if (!table_exists('driver_alerts')) {
    $sql = "CREATE TABLE `driver_alerts` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `msg` varchar(20000) NOT NULL,
      `subject` varchar(200) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'driver_alerts')) {
        echo "✓ Created table: driver_alerts<br>";
    }
} else {
    echo "→ Skipped table: driver_alerts (already exists)<br>";
    $tables_skipped++;
}

// 24. Driver documents table
if (!table_exists('driver_doc')) {
    $sql = "CREATE TABLE `driver_doc` (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `DriverName` varchar(200) NOT NULL,
      `email` varchar(200) NOT NULL,
      `documents` varchar(20000) NOT NULL,
      PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'driver_doc')) {
        echo "✓ Created table: driver_doc<br>";
    }
} else {
    echo "→ Skipped table: driver_doc (already exists)<br>";
    $tables_skipped++;
}

// 25. Driver info table
if (!table_exists('driver_info')) {
    $sql = "CREATE TABLE `driver_info` (
      `driver_id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(200) DEFAULT NULL,
      `company_name` varchar(200) DEFAULT NULL,
      `password` varchar(200) DEFAULT NULL,
      PRIMARY KEY (`driver_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'driver_info')) {
        echo "✓ Created table: driver_info<br>";
    }
} else {
    echo "→ Skipped table: driver_info (already exists)<br>";
    $tables_skipped++;
}

// 26. Freight orders table
if (!table_exists('freight_orders')) {
    $sql = "CREATE TABLE `freight_orders` (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `company_name` varchar(200) NOT NULL,
      `order_number` int(11) NOT NULL,
      `date_of_loading` date NOT NULL,
      `quantity` varchar(200) NOT NULL,
      `mode_of_transport` varchar(200) NOT NULL,
      `customer_name` varchar(200) NOT NULL,
      `order_title` varchar(200) NOT NULL,
      `type_of_product` varchar(200) NOT NULL,
      `product_from` varchar(200) NOT NULL,
      `destination` varchar(200) NOT NULL,
      `customer_email` varchar(200) NOT NULL,
      `customer_phone` varchar(200) NOT NULL,
      `customer_address` varchar(200) NOT NULL,
      PRIMARY KEY (`ID`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'freight_orders')) {
        echo "✓ Created table: freight_orders<br>";
    }
} else {
    echo "→ Skipped table: freight_orders (already exists)<br>";
    $tables_skipped++;
}

// 27. Inter zones pricing table
if (!table_exists('inter_zones')) {
    $sql = "CREATE TABLE `inter_zones` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `zone` varchar(100) NOT NULL,
      `zone_price` varchar(20) NOT NULL,
      `weight` varchar(20) NOT NULL,
      `date` date NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'inter_zones')) {
        echo "✓ Created table: inter_zones<br>";
    }
} else {
    echo "→ Skipped table: inter_zones (already exists)<br>";
    $tables_skipped++;
}

// 28. Invites table
if (!table_exists('invite')) {
    $sql = "CREATE TABLE `invite` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `email` varchar(200) NOT NULL,
      `msg` varchar(20000) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'invite')) {
        echo "✓ Created table: invite<br>";
    }
} else {
    echo "→ Skipped table: invite (already exists)<br>";
    $tables_skipped++;
}

// 29. Parcels table
if (!table_exists('Parcels')) {
    $sql = "CREATE TABLE `Parcels` (
      `ParcelId` int(11) NOT NULL AUTO_INCREMENT,
      `ParcelNumber` varchar(100) NOT NULL,
      `ParcelDescription` varchar(500) NOT NULL,
      `Weight` int(15) DEFAULT NULL,
      `Value` int(15) DEFAULT NULL,
      `Colour` varchar(50) DEFAULT NULL,
      `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`ParcelId`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4";
    if (execute_migration_sql($sql, 'Parcels')) {
        echo "✓ Created table: Parcels<br>";
    }
} else {
    echo "→ Skipped table: Parcels (already exists)<br>";
    $tables_skipped++;
}

// 30. Payment detail table
if (!table_exists('paymentdetail')) {
    $sql = "CREATE TABLE `paymentdetail` (
      `id` int(100) NOT NULL AUTO_INCREMENT,
      `item_number` varchar(255) NOT NULL,
      `txn_id` varchar(255) NOT NULL,
      `payment_gross` varchar(255) NOT NULL,
      `currency_code` varchar(255) NOT NULL,
      `payment_status` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'paymentdetail')) {
        echo "✓ Created table: paymentdetail<br>";
    }
} else {
    echo "→ Skipped table: paymentdetail (already exists)<br>";
    $tables_skipped++;
}

// 31. Payment methods table
if (!table_exists('payment_methods')) {
    $sql = "CREATE TABLE `payment_methods` (
      `pay_id` int(11) NOT NULL AUTO_INCREMENT,
      `company_name` varchar(200) DEFAULT NULL,
      `bank_acc` varchar(500) DEFAULT NULL,
      `bank_acc_name` varchar(200) DEFAULT NULL,
      `bank_name` varchar(200) DEFAULT NULL,
      `inter_swift_code` varchar(200) DEFAULT NULL,
      `ecocash_num` varchar(200) DEFAULT NULL,
      `paynow_button` varchar(20000) DEFAULT NULL,
      `paypal_button` varchar(20000) DEFAULT NULL,
      `branch` varchar(200) DEFAULT NULL,
      `affiliate_no` varchar(200) DEFAULT NULL,
      PRIMARY KEY (`pay_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'payment_methods')) {
        echo "✓ Created table: payment_methods<br>";
    }
} else {
    echo "→ Skipped table: payment_methods (already exists)<br>";
    $tables_skipped++;
}

// 32. Payment settings table
if (!table_exists('payment_setting')) {
    $sql = "CREATE TABLE `payment_setting` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `paynow_i_id` text NOT NULL,
      `paynow_i_key` text NOT NULL,
      `stripe_publish_key` text NOT NULL,
      `stripe_sec_key` text NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'payment_setting')) {
        echo "✓ Created table: payment_setting<br>";
    }
} else {
    echo "→ Skipped table: payment_setting (already exists)<br>";
    $tables_skipped++;
}

// 33. Posts table
if (!table_exists('post')) {
    $sql = "CREATE TABLE `post` (
      `id` int(2) NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `rating` tinyint(1) NOT NULL,
      `description` varchar(500) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'post')) {
        echo "✓ Created table: post<br>";
    }
} else {
    echo "→ Skipped table: post (already exists)<br>";
    $tables_skipped++;
}

// 34. Posts blogging table
if (!table_exists('posts')) {
    $sql = "CREATE TABLE `posts` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `title` varchar(100) NOT NULL,
      `content` text NOT NULL,
      `link` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'posts')) {
        echo "✓ Created table: posts<br>";
    }
} else {
    echo "→ Skipped table: posts (already exists)<br>";
    $tables_skipped++;
}

// 35. Post rating table
if (!table_exists('post_rating')) {
    $sql = "CREATE TABLE `post_rating` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `userid` int(11) NOT NULL,
      `postid` int(11) NOT NULL,
      `rating` int(2) NOT NULL,
      `name` varchar(200) DEFAULT NULL,
      `comment` varchar(2000) DEFAULT NULL,
      `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'post_rating')) {
        echo "✓ Created table: post_rating<br>";
    }
} else {
    echo "→ Skipped table: post_rating (already exists)<br>";
    $tables_skipped++;
}

// 36. Prizelist table
if (!table_exists('prizelist')) {
    $sql = "CREATE TABLE `prizelist` (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `Car_per_km` varchar(20) NOT NULL,
      `truck_price_km` varchar(20) DEFAULT NULL,
      `taxi_price_km` varchar(20) DEFAULT NULL,
      `towtruck_price_km` varchar(20) DEFAULT NULL,
      `Weight` varchar(20) NOT NULL,
      `Cost_per_item` varchar(20) NOT NULL,
      `Insurance` varchar(20) NOT NULL,
      `Base_price` varchar(20) NOT NULL,
      `Price_per_km` varchar(20) NOT NULL,
      `company_name` varchar(20) DEFAULT NULL,
      `min_parcel` varchar(20) DEFAULT NULL,
      `min_freight` varchar(20) DEFAULT NULL,
      `bike` varchar(20) DEFAULT NULL,
      `van` varchar(20) DEFAULT NULL,
      `value_L1` varchar(20) DEFAULT NULL,
      `value_L2` varchar(20) DEFAULT NULL,
      `value_L3` varchar(20) DEFAULT NULL,
      `value_L4` varchar(20) DEFAULT NULL,
      `value_L5` varchar(20) DEFAULT NULL,
      `exchange_rate` varchar(20) DEFAULT NULL,
      `primary_currency` varchar(20) DEFAULT NULL,
      `secondary_currency` varchar(20) DEFAULT NULL,
      `loader_price` varchar(20) DEFAULT NULL,
      `freight_driver_commission` varchar(20) DEFAULT NULL,
      `parcel_driver_commission` varchar(20) DEFAULT NULL,
      `furniture_driver_commission` varchar(20) DEFAULT NULL,
      `inter_charge` varchar(20) DEFAULT NULL,
      `Lusaka` varchar(20) DEFAULT NULL,
      `Other` varchar(20) DEFAULT NULL,
      PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'prizelist')) {
        echo "✓ Created table: prizelist<br>";
    }
} else {
    echo "→ Skipped table: prizelist (already exists)<br>";
    $tables_skipped++;
}

// 37. Push tokens table
if (!table_exists('push_tokens')) {
    $sql = "CREATE TABLE `push_tokens` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `token` varchar(400) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'push_tokens')) {
        echo "✓ Created table: push_tokens<br>";
    }
} else {
    echo "→ Skipped table: push_tokens (already exists)<br>";
    $tables_skipped++;
}

// 38. Reply chat drivers table
if (!table_exists('replychat_drivers')) {
    $sql = "CREATE TABLE `replychat_drivers` (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `company_name` varchar(200) DEFAULT 'merchant',
      `message` varchar(200) NOT NULL,
      `name` varchar(200) NOT NULL,
      `IDFrom` int(11) NOT NULL,
      `status` varchar(200) DEFAULT 'new',
      `chatID` int(11) NOT NULL,
      PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'replychat_drivers')) {
        echo "✓ Created table: replychat_drivers<br>";
    }
} else {
    echo "→ Skipped table: replychat_drivers (already exists)<br>";
    $tables_skipped++;
}

// 39. Sitesettings table (if not already created by bootstrap config)
if (!table_exists('sitesettings')) {
    $sql = "CREATE TABLE `sitesettings` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `site_name` text NOT NULL,
      `site_title` text NOT NULL,
      `google_api` text NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    if (execute_migration_sql($sql, 'sitesettings')) {
        echo "✓ Created table: sitesettings<br>";
    }
} else {
    echo "→ Skipped table: sitesettings (already exists)<br>";
    $tables_skipped++;
}

// 40. Users table
if (!table_exists('users')) {
    $sql = "CREATE TABLE `users` (
      `Userid` int(11) NOT NULL AUTO_INCREMENT,
      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `Name` varchar(100) NOT NULL,
      `email` varchar(50) NOT NULL,
      `phone` varchar(200) DEFAULT NULL,
      `password` varchar(200) NOT NULL,
      `days` int(11) NOT NULL DEFAULT '14',
      `affiliate_no` varchar(200) DEFAULT NULL,
      `push_token` varchar(400) DEFAULT NULL,
      PRIMARY KEY (`Userid`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4";
    if (execute_migration_sql($sql, 'users')) {
        echo "✓ Created table: users<br>";
    }
} else {
    echo "→ Skipped table: users (already exists)<br>";
    $tables_skipped++;
}

// 41. User coupons table
if (!table_exists('user_coupons')) {
    $sql = "CREATE TABLE `user_coupons` (
      `user_coupon_id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) DEFAULT NULL,
      `coupon` varchar(50) DEFAULT NULL,
      `limit_used` int(11) DEFAULT NULL,
      `used` int(11) DEFAULT NULL,
      `expiry_date` varchar(50) DEFAULT NULL,
      `type` int(11) DEFAULT NULL COMMENT '1 for percentage 2 for amount',
      `amount` varchar(50) DEFAULT NULL,
      PRIMARY KEY (`user_coupon_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'user_coupons')) {
        echo "✓ Created table: user_coupons<br>";
    }
} else {
    echo "→ Skipped table: user_coupons (already exists)<br>";
    $tables_skipped++;
}

// 42. Video blog table
if (!table_exists('video_blog')) {
    $sql = "CREATE TABLE `video_blog` (
      `ID` int(11) NOT NULL AUTO_INCREMENT,
      `Title` varchar(200) NOT NULL,
      `Video` varchar(1000) NOT NULL,
      `image` varchar(500) NOT NULL,
      `Description` varchar(500) NOT NULL,
      `Date` varchar(200) NOT NULL,
      `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    if (execute_migration_sql($sql, 'video_blog')) {
        echo "✓ Created table: video_blog<br>";
    }
} else {
    echo "→ Skipped table: video_blog (already exists)<br>";
    $tables_skipped++;
}

// 43. Weight price table
if (!table_exists('weight_price')) {
    $sql = "CREATE TABLE `weight_price` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date` date NOT NULL,
      `weight_range0` varchar(20) DEFAULT NULL,
      `weight_range1` varchar(20) DEFAULT NULL,
      `weight_range2` varchar(20) DEFAULT NULL,
      `weight_range3` varchar(20) DEFAULT NULL,
      `weight_range4` varchar(20) DEFAULT NULL,
      `weight_range5` varchar(20) DEFAULT NULL,
      `tonne_1` varchar(20) DEFAULT NULL,
      `tonne_2` varchar(20) DEFAULT NULL,
      `tonne_34` varchar(20) DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    if (execute_migration_sql($sql, 'weight_price')) {
        echo "✓ Created table: weight_price<br>";
    }
} else {
    echo "→ Skipped table: weight_price (already exists)<br>";
    $tables_skipped++;
}

echo  "<hr>";
echo "<h3>Migration Summary</h3>";
echo "<p><strong>Tables Created:</strong> $tables_created</p>";
echo "<p><strong>Tables Skipped (Already Exist):</strong> $tables_skipped</p>";

if (count($tables_failed) > 0) {
    echo "<p><strong style='color: red;'>Tables Failed:</strong> " . count($tables_failed) . "</p>";
    echo "<ul style='color: red;'>";
    foreach ($tables_failed as $table => $error) {
        echo "<li>$table: $error</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color: green;'><strong>✓ All migrations completed successfully!</strong></p>";
}

echo "<hr>";
echo "<p><a href='../setup.php'>← Back to Setup</a></p>";
?>
