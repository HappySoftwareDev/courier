<?php
/**
 * Email Template Manager
 * Unified email template system for all notifications
 */

class EmailTemplateManager {
    private $db;
    private $config;

    public function __construct($db, $config) {
        $this->db = $db;
        $this->config = $config;
    }

    /**
     * Get email template by key
     */
    public function getTemplate($template_key, $data = []) {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM email_templates WHERE template_key = :key AND is_active = 1 LIMIT 1"
            );
            $stmt->execute([':key' => $template_key]);

            if ($stmt->rowCount() === 0) {
                return $this->getDefaultTemplate($template_key);
            }

            $template = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Replace placeholders with actual data
            return [
                'subject' => $this->replacePlaceholders($template['subject'], $data),
                'body' => $this->replacePlaceholders($template['body'], $data),
                'plain_text' => $this->replacePlaceholders($template['plain_text'], $data)
            ];

        } catch (Exception $e) {
            error_log("Get template error: " . $e->getMessage());
            return $this->getDefaultTemplate($template_key);
        }
    }

    /**
     * Replace placeholders in template
     */
    private function replacePlaceholders($text, $data) {
        foreach ($data as $key => $value) {
            $text = str_replace('{{' . $key . '}}', $value, $text);
        }
        // Add global placeholders
        $text = str_replace('{{app_name}}', $this->config['app_name'] ?? 'WGRoos', $text);
        $text = str_replace('{{support_email}}', $this->config['support_email'] ?? '', $text);
        $text = str_replace('{{support_phone}}', $this->config['support_phone'] ?? '', $text);
        $text = str_replace('{{app_url}}', $this->config['app_url'] ?? '', $text);
        return $text;
    }

    /**
     * Get default templates
     */
    private function getDefaultTemplate($template_key) {
        $templates = [
            'booking_confirmation' => [
                'subject' => 'Booking Confirmation - {{order_id}}',
                'body' => $this->getDefaultBookingConfirmationHTML(),
                'plain_text' => $this->getDefaultBookingConfirmationText()
            ],
            'booking_assigned' => [
                'subject' => 'Driver Assigned - {{order_id}}',
                'body' => $this->getDefaultBookingAssignedHTML(),
                'plain_text' => $this->getDefaultBookingAssignedText()
            ],
            'booking_completed' => [
                'subject' => 'Booking Completed - {{order_id}}',
                'body' => $this->getDefaultBookingCompletedHTML(),
                'plain_text' => $this->getDefaultBookingCompletedText()
            ],
            'password_reset' => [
                'subject' => 'Password Reset Request',
                'body' => $this->getDefaultPasswordResetHTML(),
                'plain_text' => $this->getDefaultPasswordResetText()
            ],
            'welcome' => [
                'subject' => 'Welcome to {{app_name}}',
                'body' => $this->getDefaultWelcomeHTML(),
                'plain_text' => $this->getDefaultWelcomeText()
            ]
        ];

        return $templates[$template_key] ?? [
            'subject' => 'Notification from {{app_name}}',
            'body' => '<p>No template found</p>',
            'plain_text' => 'No template found'
        ];
    }

    // ============================================
    // DEFAULT TEMPLATE HTML BODIES
    // ============================================

    private function getDefaultBookingConfirmationHTML() {
        return '
        <html>
            <body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
                <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                    <h1 style="color: #007bff;">Booking Confirmation</h1>
                    <p>Thank you {{customer_name}}, your booking has been confirmed!</p>
                    
                    <div style="background: #f9f9f9; padding: 20px; border-radius: 5px; margin: 20px 0;">
                        <h3>Order Details</h3>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px; font-weight: bold;">Order ID:</td>
                                <td style="padding: 10px;">{{order_id}}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px; font-weight: bold;">Service Type:</td>
                                <td style="padding: 10px;">{{service_type}}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px; font-weight: bold;">From:</td>
                                <td style="padding: 10px;">{{from_address}}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px; font-weight: bold;">To:</td>
                                <td style="padding: 10px;">{{to_address}}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px; font-weight: bold;">Total Amount:</td>
                                <td style="padding: 10px; color: #007bff; font-weight: bold;">{{total_price}}</td>
                            </tr>
                        </table>
                    </div>

                    <p>Next Steps:</p>
                    <ol>
                        <li>Complete payment to confirm your booking</li>
                        <li>Our driver will be assigned shortly</li>
                        <li>You will receive driver details via SMS/Email</li>
                        <li>Track your booking in real-time</li>
                    </ol>

                    <p style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; font-size: 0.9em;">
                        If you have any questions, please contact us at {{support_email}} or {{support_phone}}
                    </p>
                </div>
            </body>
        </html>
        ';
    }

    private function getDefaultBookingConfirmationText() {
        return "
Booking Confirmation

Thank you {{customer_name}}, your booking has been confirmed!

Order Details:
Order ID: {{order_id}}
Service Type: {{service_type}}
From: {{from_address}}
To: {{to_address}}
Total Amount: {{total_price}}

Next Steps:
1. Complete payment to confirm your booking
2. Our driver will be assigned shortly
3. You will receive driver details via SMS/Email
4. Track your booking in real-time

Questions? Contact us at {{support_email}} or {{support_phone}}
        ";
    }

    private function getDefaultBookingAssignedHTML() {
        return '
        <html>
            <body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
                <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                    <h1 style="color: #28a745;">Driver Assigned</h1>
                    <p>Great news {{customer_name}}! Your driver has been assigned.</p>
                    
                    <div style="background: #f9f9f9; padding: 20px; border-radius: 5px; margin: 20px 0;">
                        <h3>Driver Information</h3>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px; font-weight: bold;">Driver Name:</td>
                                <td style="padding: 10px;">{{driver_name}}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px; font-weight: bold;">Phone:</td>
                                <td style="padding: 10px;">{{driver_phone}}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px; font-weight: bold;">Vehicle:</td>
                                <td style="padding: 10px;">{{vehicle_type}} - {{vehicle_plate}}</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; font-weight: bold;">ETA:</td>
                                <td style="padding: 10px;">{{eta}}</td>
                            </tr>
                        </table>
                    </div>

                    <p>You can track your booking in real-time or contact your driver directly at {{driver_phone}}.</p>
                </div>
            </body>
        </html>
        ';
    }

    private function getDefaultBookingAssignedText() {
        return "
Driver Assigned

Great news {{customer_name}}! Your driver has been assigned.

Driver Information:
Driver Name: {{driver_name}}
Phone: {{driver_phone}}
Vehicle: {{vehicle_type}} - {{vehicle_plate}}
ETA: {{eta}}

You can track your booking in real-time or contact your driver directly at {{driver_phone}}.
        ";
    }

    private function getDefaultBookingCompletedHTML() {
        return '
        <html>
            <body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
                <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                    <h1 style="color: #28a745;">✓ Booking Completed</h1>
                    <p>Thank you {{customer_name}}! Your booking has been completed successfully.</p>
                    
                    <div style="background: #f9f9f9; padding: 20px; border-radius: 5px; margin: 20px 0;">
                        <h3>Summary</h3>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px; font-weight: bold;">Order ID:</td>
                                <td style="padding: 10px;">{{order_id}}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px; font-weight: bold;">Completed Time:</td>
                                <td style="padding: 10px;">{{completion_time}}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px; font-weight: bold;">Total Amount:</td>
                                <td style="padding: 10px;">{{total_price}}</td>
                            </tr>
                        </table>
                    </div>

                    <p>We appreciate your business! Please rate your experience and help us improve.</p>
                    <p style="text-align: center;">
                        <a href="{{rating_url}}" style="display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">Rate Your Experience</a>
                    </p>
                </div>
            </body>
        </html>
        ';
    }

    private function getDefaultBookingCompletedText() {
        return "
Booking Completed

Thank you {{customer_name}}! Your booking has been completed successfully.

Summary:
Order ID: {{order_id}}
Completed Time: {{completion_time}}
Total Amount: {{total_price}}

We appreciate your business! Please rate your experience at: {{rating_url}}
        ";
    }

    private function getDefaultPasswordResetHTML() {
        return '
        <html>
            <body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
                <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                    <h1>Password Reset Request</h1>
                    <p>We received a request to reset your password. Click the link below to proceed:</p>
                    
                    <p style="text-align: center; margin: 30px 0;">
                        <a href="{{reset_link}}" style="display: inline-block; padding: 12px 30px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">Reset Password</a>
                    </p>

                    <p style="color: #666; font-size: 0.9em;">
                        This link will expire in 24 hours. If you did not request this, please ignore this email.<br>
                        Never share this link with anyone else.
                    </p>
                </div>
            </body>
        </html>
        ';
    }

    private function getDefaultPasswordResetText() {
        return "
Password Reset Request

We received a request to reset your password. Use this link to proceed:
{{reset_link}}

This link will expire in 24 hours. If you did not request this, please ignore this email.
Never share this link with anyone else.
        ";
    }

    private function getDefaultWelcomeHTML() {
        return '
        <html>
            <body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
                <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                    <h1 style="color: #007bff;">Welcome to {{app_name}}</h1>
                    <p>Hi {{customer_name}},</p>
                    
                    <p>Welcome to {{app_name}}! We are excited to have you on board.</p>
                    
                    <div style="background: #f9f9f9; padding: 20px; border-radius: 5px; margin: 20px 0;">
                        <h3>Get Started</h3>
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 10px 0;">✓ Complete your profile</li>
                            <li style="padding: 10px 0;">✓ Verify your email address</li>
                            <li style="padding: 10px 0;">✓ Add payment methods</li>
                            <li style="padding: 10px 0;">✓ Create your first booking</li>
                        </ul>
                    </div>

                    <p>If you have any questions, our support team is here to help at {{support_email}} or {{support_phone}}.</p>
                    
                    <p>Happy shipping!<br>The {{app_name}} Team</p>
                </div>
            </body>
        </html>
        ';
    }

    private function getDefaultWelcomeText() {
        return "
Welcome to {{app_name}}

Hi {{customer_name}},

Welcome to {{app_name}}! We are excited to have you on board.

Get Started:
✓ Complete your profile
✓ Verify your email address
✓ Add payment methods
✓ Create your first booking

Questions? Contact us at {{support_email}} or {{support_phone}}.

Happy shipping!
The {{app_name}} Team
        ";
    }
}

?>


