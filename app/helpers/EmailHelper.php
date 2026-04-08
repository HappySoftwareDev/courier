<?php
/**
 * Email Helper
 * Handles email sending operations
 */

class EmailHelper {
    private $config;
    private $fromEmail;
    private $fromName;

    public function __construct($config) {
        $this->config = $config;
        $emailSettings = $config->getEmail();
        $this->fromEmail = $emailSettings['from_email'];
        $this->fromName = $emailSettings['from_name'];
    }

    /**
     * Send booking confirmation email
     */
    public function sendBookingConfirmation($booking) {
        $subject = 'Booking Confirmation - ' . $booking[':order_num'];
        
        $body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; }
                .header { background-color: #FF8C00; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                .booking-details { background-color: #f5f5f5; padding: 15px; border-radius: 5px; }
                .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Booking Confirmation</h1>
                </div>
                <div class='content'>
                    <p>Dear {$booking[':name']},</p>
                    <p>Thank you for booking with us! Your booking has been confirmed.</p>
                    
                    <div class='booking-details'>
                        <h3>Booking Details</h3>
                        <p><strong>Order Number:</strong> {$booking[':order_num']}</p>
                        <p><strong>Pickup Address:</strong> {$booking[':pickup_addr']}</p>
                        <p><strong>Delivery Address:</strong> {$booking[':drop_addr']}</p>
                        <p><strong>Pickup Date:</strong> {$booking[':pickup_date']}</p>
                        <p><strong>Total Price:</strong> {$booking[':currency_symbol']}{$booking[':total']}</p>
                    </div>
                    
                    <p>You will be notified once a driver accepts your booking.</p>
                    <p>If you have any questions, please contact us.</p>
                </div>
                <div class='footer'>
                    <p>&copy; 2026 Merchant Couriers. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>";

        return $this->sendEmail($booking[':email'], $subject, $body);
    }

    /**
     * Send driver acceptance email
     */
    public function sendDriverAcceptanceEmail($booking, $driver) {
        $subject = 'Booking Accepted - ' . $booking['order_number'];
        
        $body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Booking Accepted!</h2>
                <p>Hi {$booking['Name']},</p>
                <p>Great news! A driver has accepted your booking.</p>
                
                <div style='background-color: #f5f5f5; padding: 15px; border-radius: 5px;'>
                    <h3>Driver Details</h3>
                    <p><strong>Driver Name:</strong> {$driver['name']}</p>
                    <p><strong>Phone:</strong> {$driver['phone']}</p>
                    <p><strong>Vehicle:</strong> {$driver['year']} {$driver['vehicleMake']} {$driver['model']}</p>
                </div>
                
                <p>The driver will contact you shortly to confirm pickup details.</p>
            </div>
        </body>
        </html>";

        return $this->sendEmail($booking['email'], $subject, $body);
    }

    /**
     * Send password reset email
     */
    public function sendPasswordResetEmail($email, $resetLink) {
        $subject = 'Password Reset Request';
        
        $body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; }
                .button { 
                    display: inline-block; 
                    padding: 10px 20px; 
                    background-color: #FF8C00; 
                    color: white; 
                    text-decoration: none; 
                    border-radius: 5px; 
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Password Reset Request</h2>
                <p>We received a request to reset your password.</p>
                <p><a href='{$resetLink}' class='button'>Reset Password</a></p>
                <p>If you didn't request this, you can ignore this email.</p>
                <p>This link will expire in 1 hour.</p>
            </div>
        </body>
        </html>";

        return $this->sendEmail($email, $subject, $body);
    }

    /**
     * Generic email sender
     */
    private function sendEmail($to, $subject, $body, $isHtml = true) {
        try {
            $headers = "From: {$this->fromName} <{$this->fromEmail}>\r\n";
            $headers .= "Reply-To: {$this->fromEmail}\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            
            if ($isHtml) {
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            }

            return mail($to, $subject, $body, $headers);

        } catch (Exception $e) {
            error_log("Email Send Error: " . $e->getMessage());
            return false;
        }
    }
}

?>


