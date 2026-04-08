-- Migration: 002_create_email_templates_table.sql
-- Purpose: Create email templates table for customizable notification templates
-- Created: Phase 3 - System Structure

CREATE TABLE IF NOT EXISTS `email_templates` (
  `template_id` INT AUTO_INCREMENT PRIMARY KEY,
  `template_key` VARCHAR(255) UNIQUE NOT NULL COMMENT 'Unique key for template (e.g., booking_confirmation)',
  `template_name` VARCHAR(255) NOT NULL COMMENT 'Human-readable template name',
  `subject` VARCHAR(500) NOT NULL COMMENT 'Email subject line',
  `body` LONGTEXT NOT NULL COMMENT 'Email body HTML version',
  `plain_text` LONGTEXT COMMENT 'Email body plain text version',
  `description` TEXT COMMENT 'Description of when this template is used',
  `is_active` BOOLEAN DEFAULT TRUE COMMENT 'Whether template is active',
  `placeholders` JSON COMMENT 'Available placeholders for this template',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_template_key (template_key),
  INDEX idx_is_active (is_active),
  INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default email templates

-- 1. Booking Confirmation Template
INSERT INTO `email_templates` (`template_key`, `template_name`, `subject`, `body`, `plain_text`, `description`, `placeholders`) VALUES
(
  'booking_confirmation',
  'Booking Confirmation',
  'Your {{app_name}} Booking #{{order_id}} Confirmed',
  '<h2>Booking Confirmation</h2>
<p>Hi {{customer_name}},</p>
<p>Thank you for using {{app_name}}! Your booking has been confirmed.</p>
<h3>Booking Details</h3>
<ul>
  <li><strong>Order ID:</strong> {{order_id}}</li>
  <li><strong>Service Type:</strong> {{service_type}}</li>
  <li><strong>Pickup Location:</strong> {{pickup_location}}</li>
  <li><strong>Delivery Location:</strong> {{delivery_location}}</li>
  <li><strong>Scheduled Date & Time:</strong> {{scheduled_datetime}}</li>
</ul>
<h3>Pricing</h3>
<ul>
  <li><strong>Base Price:</strong> {{currency_symbol}}{{base_price}}</li>
  <li><strong>Insurance:</strong> {{currency_symbol}}{{insurance_cost}}</li>
  <li><strong>Platform Fee:</strong> {{currency_symbol}}{{platform_fee}}</li>
  <li><strong>Total:</strong> {{currency_symbol}}{{total_price}}</li>
</ul>
<h3>Next Steps</h3>
<p>Your driver will be assigned shortly. You will receive a notification once your driver is on the way.</p>
<p>If you have any questions, contact us at {{support_phone}} or {{support_email}}</p>
<p>Thank you for choosing {{app_name}}!</p>
<p>Best regards,<br>{{app_name}} Team</p>',
  'Booking Confirmation

Hi {{customer_name}},

Thank you for using {{app_name}}! Your booking has been confirmed.

Booking Details:
- Order ID: {{order_id}}
- Service Type: {{service_type}}
- Pickup Location: {{pickup_location}}
- Delivery Location: {{delivery_location}}
- Scheduled Date & Time: {{scheduled_datetime}}

Pricing:
- Base Price: {{currency_symbol}}{{base_price}}
- Insurance: {{currency_symbol}}{{insurance_cost}}
- Platform Fee: {{currency_symbol}}{{platform_fee}}
- Total: {{currency_symbol}}{{total_price}}

Next Steps:
Your driver will be assigned shortly. You will receive a notification once your driver is on the way.

If you have any questions, contact us at {{support_phone}} or {{support_email}}

Thank you for choosing {{app_name}}!

Best regards,
{{app_name}} Team',
  'Sent when customer completes a booking',
  JSON_OBJECT('customer_name', 'string', 'order_id', 'string', 'service_type', 'string', 'pickup_location', 'string', 'delivery_location', 'string', 'scheduled_datetime', 'string', 'base_price', 'number', 'insurance_cost', 'number', 'platform_fee', 'number', 'total_price', 'number')
),

-- 2. Driver Assignment Template
(
  'booking_assigned',
  'Driver Assigned',
  'Driver {{driver_name}} Assigned to {{app_name}} Order #{{order_id}}',
  '<h2>Driver Assigned</h2>
<p>Hi {{customer_name}},</p>
<p>Great news! A driver has been assigned to your {{service_type}} order.</p>
<h3>Driver Information</h3>
<ul>
  <li><strong>Driver Name:</strong> {{driver_name}}</li>
  <li><strong>Vehicle:</strong> {{vehicle_make}} {{vehicle_model}} ({{vehicle_color}})</li>
  <li><strong>License Plate:</strong> {{vehicle_plate}}</li>
  <li><strong>Driver Rating:</strong> {{driver_rating}}/5</li>
  <li><strong>Driver Phone:</strong> {{driver_phone}}</li>
</ul>
<h3>Estimated Arrival</h3>
<p><strong>ETA:</strong> {{eta_time}} ({{eta_minutes}} minutes)</p>
<h3>Booking Status</h3>
<ul>
  <li><strong>Order ID:</strong> {{order_id}}</li>
  <li><strong>Pickup:</strong> {{pickup_location}}</li>
  <li><strong>Delivery:</strong> {{delivery_location}}</li>
</ul>
<p>You can track your booking in real-time on the {{app_name}} mobile app.</p>
<p>If you need to contact your driver or have any issues, call {{support_phone}}</p>
<p>Thank you for using {{app_name}}!</p>',
  'Driver Assigned

Hi {{customer_name}},

Great news! A driver has been assigned to your {{service_type}} order.

Driver Information:
- Driver Name: {{driver_name}}
- Vehicle: {{vehicle_make}} {{vehicle_model}} ({{vehicle_color}})
- License Plate: {{vehicle_plate}}
- Driver Rating: {{driver_rating}}/5
- Driver Phone: {{driver_phone}}

Estimated Arrival:
ETA: {{eta_time}} ({{eta_minutes}} minutes)

Booking Status:
- Order ID: {{order_id}}
- Pickup: {{pickup_location}}
- Delivery: {{delivery_location}}

You can track your booking in real-time on the {{app_name}} mobile app.

If you need to contact your driver or have any issues, call {{support_phone}}

Thank you for using {{app_name}}!',
  'Sent when a driver is assigned to the booking',
  JSON_OBJECT('customer_name', 'string', 'order_id', 'string', 'service_type', 'string', 'driver_name', 'string', 'vehicle_make', 'string', 'vehicle_model', 'string', 'vehicle_color', 'string', 'vehicle_plate', 'string', 'driver_rating', 'number', 'driver_phone', 'string', 'pickup_location', 'string', 'delivery_location', 'string', 'eta_time', 'string', 'eta_minutes', 'number')
),

-- 3. Booking Completed Template
(
  'booking_completed',
  'Booking Completed',
  'Your {{app_name}} Order #{{order_id}} is Complete',
  '<h2>Booking Completed</h2>
<p>Hi {{customer_name}},</p>
<p>Your {{service_type}} booking has been completed successfully!</p>
<h3>Booking Summary</h3>
<ul>
  <li><strong>Order ID:</strong> {{order_id}}</li>
  <li><strong>Service Type:</strong> {{service_type}}</li>
  <li><strong>Driver:</strong> {{driver_name}}</li>
  <li><strong>Completed At:</strong> {{completed_time}}</li>
  <li><strong>Total Duration:</strong> {{duration_minutes}} minutes</li>
</ul>
<h3>Route Summary</h3>
<ul>
  <li><strong>Pickup:</strong> {{pickup_location}}</li>
  <li><strong>Delivery:</strong> {{delivery_location}}</li>
  <li><strong>Distance Traveled:</strong> {{distance_km}} km</li>
</ul>
<h3>Payment</h3>
<ul>
  <li><strong>Total Amount:</strong> {{currency_symbol}}{{total_price}}</li>
  <li><strong>Payment Method:</strong> {{payment_method}}</li>
  <li><strong>Status:</strong> {{payment_status}}</li>
</ul>
<h3>Rate Your Experience</h3>
<p><a href="{{rating_link}}">Click here to rate your driver and give feedback</a></p>
<p>Your feedback helps us improve our service!</p>
<p>Thank you for using {{app_name}}. We hope to serve you again soon!</p>',
  'Booking Completed

Hi {{customer_name}},

Your {{service_type}} booking has been completed successfully!

Booking Summary:
- Order ID: {{order_id}}
- Service Type: {{service_type}}
- Driver: {{driver_name}}
- Completed At: {{completed_time}}
- Total Duration: {{duration_minutes}} minutes

Route Summary:
- Pickup: {{pickup_location}}
- Delivery: {{delivery_location}}
- Distance Traveled: {{distance_km}} km

Payment:
- Total Amount: {{currency_symbol}}{{total_price}}
- Payment Method: {{payment_method}}
- Status: {{payment_status}}

Rate Your Experience:
Please visit {{rating_link}} to rate your driver and give feedback.

Your feedback helps us improve our service!

Thank you for using {{app_name}}. We hope to serve you again soon!',
  'Sent when a booking is completed',
  JSON_OBJECT('customer_name', 'string', 'order_id', 'string', 'service_type', 'string', 'driver_name', 'string', 'completed_time', 'string', 'duration_minutes', 'number', 'pickup_location', 'string', 'delivery_location', 'string', 'distance_km', 'number', 'total_price', 'number', 'payment_method', 'string', 'payment_status', 'string', 'rating_link', 'string')
),

-- 4. Password Reset Template
(
  'password_reset',
  'Password Reset Request',
  'Reset Your {{app_name}} Password',
  '<h2>Password Reset Request</h2>
<p>Hi {{customer_name}},</p>
<p>We received a request to reset your {{app_name}} password.</p>
<h3>Reset Your Password</h3>
<p><a href="{{reset_link}}" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Reset Password</a></p>
<p><strong>Reset Link:</strong> {{reset_link}}</p>
<h3>Security Information</h3>
<ul>
  <li>This link will expire in {{expiration_hours}} hours</li>
  <li>If you did not request this reset, please ignore this email</li>
  <li>Your account will remain secure unless you click the reset link</li>
</ul>
<p>If you have any questions, contact our support team at {{support_email}}</p>
<p>Best regards,<br>{{app_name}} Team</p>',
  'Password Reset Request

Hi {{customer_name}},

We received a request to reset your {{app_name}} password.

Reset Your Password:
{{reset_link}}

Security Information:
- This link will expire in {{expiration_hours}} hours
- If you did not request this reset, please ignore this email
- Your account will remain secure unless you click the reset link

If you have any questions, contact our support team at {{support_email}}

Best regards,
{{app_name}} Team',
  'Sent when user requests a password reset',
  JSON_OBJECT('customer_name', 'string', 'reset_link', 'string', 'expiration_hours', 'number')
),

-- 5. Welcome Email Template
(
  'welcome',
  'Welcome to {{app_name}}',
  'Welcome to {{app_name}}, {{customer_name}}!',
  '<h2>Welcome to {{app_name}}!</h2>
<p>Hi {{customer_name}},</p>
<p>Thank you for signing up for {{app_name}}. We are excited to have you on board!</p>
<h3>Getting Started</h3>
<ol>
  <li><strong>Complete Your Profile:</strong> Add your address and payment information</li>
  <li><strong>Download Our App:</strong> Get the {{app_name}} mobile app for better tracking</li>
  <li><strong>Create Your First Booking:</strong> Choose a service and get started</li>
  <li><strong>Special Offer:</strong> Get {{discount_first_booking}}% off your first booking!</li>
</ol>
<h3>Our Services</h3>
<ul>
  <li><strong>Parcel Delivery:</strong> Fast and reliable parcel delivery</li>
  <li><strong>Freight Transport:</strong> Heavy load transportation</li>
  <li><strong>Furniture Moving:</strong> Professional furniture relocation</li>
  <li><strong>Taxi Service:</strong> On-demand taxi rides</li>
  <li><strong>Tow Truck:</strong> Vehicle towing and roadside assistance</li>
</ul>
<h3>Helpful Resources</h3>
<ul>
  <li><a href="{{app_url}}/help">Help Center</a></li>
  <li><a href="{{app_url}}/faq">FAQ</a></li>
  <li><a href="{{app_url}}/contact">Contact Us</a></li>
  <li><a href="{{app_url}}/terms">Terms & Conditions</a></li>
</ul>
<h3>Need Help?</h3>
<p>If you have any questions or need assistance, feel free to reach out:</p>
<ul>
  <li><strong>Email:</strong> {{support_email}}</li>
  <li><strong>Phone:</strong> {{support_phone}}</li>
</ul>
<p>Welcome aboard!<br>{{app_name}} Team</p>',
  'Welcome to {{app_name}}!

Hi {{customer_name}},

Thank you for signing up for {{app_name}}. We are excited to have you on board!

Getting Started:
1. Complete Your Profile - Add your address and payment information
2. Download Our App - Get the {{app_name}} mobile app for better tracking
3. Create Your First Booking - Choose a service and get started
4. Special Offer - Get {{discount_first_booking}}% off your first booking!

Our Services:
- Parcel Delivery: Fast and reliable parcel delivery
- Freight Transport: Heavy load transportation
- Furniture Moving: Professional furniture relocation
- Taxi Service: On-demand taxi rides
- Tow Truck: Vehicle towing and roadside assistance

Helpful Resources:
- Help Center: {{app_url}}/help
- FAQ: {{app_url}}/faq
- Contact Us: {{app_url}}/contact
- Terms & Conditions: {{app_url}}/terms

Need Help?
If you have any questions or need assistance, feel free to reach out:
- Email: {{support_email}}
- Phone: {{support_phone}}

Welcome aboard!
{{app_name}} Team',
  'Sent when a new user registers',
  JSON_OBJECT('customer_name', 'string', 'discount_first_booking', 'number', 'app_url', 'string', 'support_email', 'string', 'support_phone', 'string')
);

-- Create indexes for performance
CREATE INDEX idx_email_template_active ON `email_templates` (`is_active`);
CREATE INDEX idx_email_template_created ON `email_templates` (`created_at`);

-- Add comment about template usage
ALTER TABLE `email_templates` COMMENT='Email notification templates with customizable content and placeholders';
