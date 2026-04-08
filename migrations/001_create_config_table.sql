-- Migration: 001_create_config_table.sql
-- Purpose: Create centralized configuration table for dynamic settings
-- Created: Phase 3 - System Structure

CREATE TABLE IF NOT EXISTS `config` (
  `config_id` INT AUTO_INCREMENT PRIMARY KEY,
  `config_key` VARCHAR(255) UNIQUE NOT NULL COMMENT 'Configuration key (e.g., app_name, base_price)',
  `config_value` LONGTEXT NOT NULL COMMENT 'Configuration value (stored as JSON if needed)',
  `config_type` VARCHAR(50) DEFAULT 'string' COMMENT 'Data type: string, number, boolean, json',
  `description` TEXT COMMENT 'Human-readable description of this config',
  `section` VARCHAR(100) DEFAULT 'general' COMMENT 'Configuration section: general, pricing, email, payment, features',
  `is_locked` BOOLEAN DEFAULT FALSE COMMENT 'If true, cannot be modified via admin UI',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_section (section),
  INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default configuration values

-- General Settings
INSERT INTO `config` (`config_key`, `config_value`, `config_type`, `description`, `section`) VALUES
('app_name', 'Wgroos Logistics', 'string', 'Application name displayed to users', 'general'),
('app_url', 'https://app.wgroos.com', 'string', 'Main application URL', 'general'),
('support_email', 'support@wgroos.com', 'string', 'Support contact email address', 'general'),
('support_phone', '+265999999999', 'string', 'Support contact phone number', 'general'),
('timezone', 'Africa/Blantyre', 'string', 'Default timezone for the application', 'general'),
('company_address', 'Lilongwe, Malawi', 'string', 'Company physical address', 'general'),
('currency', 'MWK', 'string', 'Currency code (e.g., MWK, USD)', 'general'),
('currency_symbol', 'K', 'string', 'Currency symbol for display', 'general'),
('maintenance_mode', 'false', 'boolean', 'Enable/disable maintenance mode', 'general');

-- Pricing Settings
INSERT INTO `config` (`config_key`, `config_value`, `config_type`, `description`, `section`) VALUES
('base_price_parcel', '500', 'number', 'Base price for parcel delivery (in MWK)', 'pricing'),
('base_price_freight', '2000', 'number', 'Base price for freight (in MWK)', 'pricing'),
('base_price_furniture', '3000', 'number', 'Base price for furniture moving (in MWK)', 'pricing'),
('base_price_taxi', '300', 'number', 'Base price per km for taxi service (in MWK)', 'pricing'),
('base_price_towtruck', '1500', 'number', 'Base price for tow truck service (in MWK)', 'pricing'),
('price_per_km', '50', 'number', 'Price per kilometer for distance-based services (in MWK)', 'pricing'),
('insurance_percentage', '10', 'number', 'Insurance charge as percentage of base price', 'pricing'),
('platform_fee_percentage', '15', 'number', 'Platform fee as percentage of booking total', 'pricing'),
('emergency_surcharge', '25', 'number', 'Emergency/urgent surcharge in percentage', 'pricing'),
('discount_first_booking', '10', 'number', 'Discount percentage for first-time users', 'pricing');

-- Email Settings
INSERT INTO `config` (`config_key`, `config_value`, `config_type`, `description`, `section`) VALUES
('email_from_address', 'noreply@wgroos.com', 'string', 'From email address for system notifications', 'email'),
('email_from_name', 'Wgroos Logistics', 'string', 'From name for system emails', 'email'),
('smtp_host', 'mail.wgroos.com', 'string', 'SMTP server hostname', 'email'),
('smtp_port', '587', 'number', 'SMTP server port', 'email'),
('smtp_encryption', 'tls', 'string', 'SMTP encryption type (tls, ssl, none)', 'email'),
('smtp_username', 'noreply@wgroos.com', 'string', 'SMTP authentication username (encrypted in production)', 'email'),
('smtp_password', '', 'string', 'SMTP authentication password (encrypted in production)', 'email'),
('send_welcome_email', 'true', 'boolean', 'Send welcome email on user registration', 'email'),
('send_booking_confirmation', 'true', 'boolean', 'Send booking confirmation to customer', 'email'),
('send_driver_assignment', 'true', 'boolean', 'Send assignment notification to driver', 'email'),
('send_completion_email', 'true', 'boolean', 'Send completion email to customer', 'email');

-- Payment Settings
INSERT INTO `config` (`config_key`, `config_value`, `config_type`, `description`, `section`) VALUES
('paynow_integration_enabled', 'true', 'boolean', 'Enable PayNow payment gateway', 'payment'),
('paynow_merchant_code', '', 'string', 'PayNow merchant code (encrypted)', 'payment'),
('paynow_merchant_key', '', 'string', 'PayNow merchant key (encrypted)', 'payment'),
('stripe_integration_enabled', 'false', 'boolean', 'Enable Stripe payment gateway', 'payment'),
('stripe_public_key', '', 'string', 'Stripe publishable key (encrypted)', 'payment'),
('stripe_secret_key', '', 'string', 'Stripe secret key (encrypted)', 'payment'),
('allow_cash_payment', 'true', 'boolean', 'Allow customers to pay with cash to driver', 'payment'),
('require_payment_upfront', 'false', 'boolean', 'Require payment before booking confirmation', 'payment'),
('payment_timeout_minutes', '30', 'number', 'Minutes to wait for payment before cancelling booking', 'payment');

-- Feature Flags
INSERT INTO `config` (`config_key`, `config_value`, `config_type`, `description`, `section`) VALUES
('guest_booking_enabled', 'false', 'boolean', 'Allow guest users to create bookings', 'features'),
('instant_booking_enabled', 'true', 'boolean', 'Allow instant booking without scheduling', 'features'),
('scheduled_booking_enabled', 'true', 'boolean', 'Allow users to schedule future bookings', 'features'),
('email_verification_required', 'false', 'boolean', 'Require email verification on signup', 'features'),
('phone_verification_required', 'true', 'boolean', 'Require phone verification on signup', 'features'),
('auto_assign_driver', 'true', 'boolean', 'Automatically assign available driver to booking', 'features'),
('two_factor_auth_enabled', 'false', 'boolean', 'Enable two-factor authentication', 'features'),
('driver_rating_enabled', 'true', 'boolean', 'Enable customer rating of drivers', 'features'),
('customer_rating_enabled', 'true', 'boolean', 'Enable driver rating of customers', 'features'),
('referral_program_enabled', 'false', 'boolean', 'Enable user referral program', 'features'),
('affiliate_program_enabled', 'true', 'boolean', 'Enable affiliate/partner program', 'features');

-- SMS Settings (if SMS module exists)
INSERT INTO `config` (`config_key`, `config_value`, `config_type`, `description`, `section`) VALUES
('sms_provider', 'africastalking', 'string', 'SMS provider: africastalking, twilio, nexmo, local', 'email'),
('sms_api_key', '', 'string', 'SMS API key/token (encrypted)', 'email'),
('sms_api_url', '', 'string', 'SMS API endpoint URL', 'email'),
('send_sms_notifications', 'true', 'boolean', 'Send SMS notifications to customers', 'email');

-- Security Settings
INSERT INTO `config` (`config_key`, `config_value`, `config_type`, `description`, `section`) VALUES
('password_min_length', '8', 'number', 'Minimum password length requirement', 'general'),
('session_timeout_minutes', '60', 'number', 'Session timeout in minutes', 'general'),
('max_login_attempts', '5', 'number', 'Maximum login attempts before lockout', 'general'),
('lockout_duration_minutes', '30', 'number', 'Account lockout duration in minutes', 'general');

CREATE INDEX idx_config_key ON `config` (`config_key`);
CREATE INDEX idx_config_section ON `config` (`section`);
