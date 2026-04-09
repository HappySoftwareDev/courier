-- ============================================================
-- Initial User Seed Data Creation
-- Run this migration during first-time app installation
-- After running this, use seed-users.php to generate API keys
-- ============================================================

-- ============================================================
-- ADMIN PORTAL - Create Initial Admin User
-- ============================================================
INSERT INTO `admin` (`ID`, `date`, `Name`, `Email`, `phone`, `Password`, `push_token`) VALUES
(1, NOW(), 'System Admin', 'admin@app.wgroos.com', '+000000000000', '12345#$', NULL);

-- ============================================================
-- BOOKING/CUSTOMER PORTAL - Create Initial Test Customer
-- ============================================================
INSERT INTO `users` (`Userid`, `date`, `Name`, `email`, `phone`, `password`, `days`, `affiliate_no`) VALUES
(1, NOW(), 'Test Customer', 'customer@app.wgroos.com', '+000000000000', '12345#$', 14, NULL);

-- ============================================================
-- DRIVER PORTAL - Create Initial Test Driver
-- Driver requires: driver_number (random 5 digits)
-- ============================================================
INSERT INTO `driver` (
    `driverID`, 
    `driver_number`, 
    `date`, 
    `name`, 
    `company_name`, 
    `phone`, 
    `address`, 
    `city`, 
    `vehicleMake`, 
    `model`, 
    `year`, 
    `engineCapacity`, 
    `RegNo`, 
    `DOB`, 
    `occupation`, 
    `email`, 
    `mode_of_transport`, 
    `type_of_service`, 
    `truckType`, 
    `username`, 
    `password`, 
    `profileImage`, 
    `online`, 
    `info`, 
    `username_backup`
) VALUES
(1, 10001, NOW(), 'Test Driver', 'Test Company', '+000000000000', 'Test Address', 'Test City', 'Test Make', 'Test Model', '2020', '2000cc', 'TEST001', '1990-01-01', 'Driver', 'driver@app.wgroos.com', 'Car', 'Parcel Delivery', 'Standard', 'testdriver', '12345#$', 'profilePic', 'offline', '....', NULL);

-- ============================================================
-- API USERS - Create Initial API User (WITHOUT API KEY initially)
-- API Key should be generated with UUID/random key via seed-users.php script
-- ============================================================
INSERT INTO `api_users` (
    `id`, 
    `join_date`, 
    `business_name`, 
    `business_email`, 
    `business_phone`, 
    `password`, 
    `affialte_no`, 
    `address`, 
    `api_key`, 
    `contact_person`, 
    `personal_phone`, 
    `country`, 
    `state`, 
    `city`, 
    `status`
) VALUES
(1, NOW(), 'Internal API User', 'api@app.wgroos.com', '+000000000000', '12345#$', '', 'Internal', '', 'System', '+000000000000', 'Internal', 'Internal', 'Internal', 'active');

-- ============================================================
-- API USERS BUSINESS - Link API user to business
-- ============================================================
INSERT INTO `api_users_business` (
    `id`, 
    `api_user_id`, 
    `join_date`, 
    `business_name`, 
    `business_email`, 
    `business_phone`, 
    `password`, 
    `affialte_no`, 
    `address`, 
    `api_key`, 
    `contact_person`, 
    `personal_phone`, 
    `country`, 
    `state`, 
    `city`, 
    `status`
) VALUES
(1, 1, NOW(), 'Internal API Business', 'api@app.wgroos.com', '+000000000000', '12345#$', '', 'Internal', '', 'System', '+000000000000', 'Internal', 'Internal', 'Internal', 'active');

-- ============================================================
-- Notes for manual database execution:
-- 1. Update the email addresses to match your environment
-- 2. Update phone numbers as needed
-- 3. After running this, execute seed-users.php to generate API keys
-- ============================================================
