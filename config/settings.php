<?php
/**
 * Application Settings
 * 
 * Centralized configuration for site-wide settings.
 * Can be overridden via environment variables or admin panel.
 */

return [
    // Site information
    'site_name' => getenv('SITE_NAME') ?: 'WGroos Courier',
    'site_email' => getenv('SITE_EMAIL') ?: 'support@app.wgroos.com',
    'site_phone' => getenv('SITE_PHONE') ?: '+263712345678',
    'site_address' => getenv('SITE_ADDRESS') ?: 'Harare, Zimbabwe',
    
    // Business settings
    'business_hours' => [
        'monday' => '08:00-17:00',
        'tuesday' => '08:00-17:00',
        'wednesday' => '08:00-17:00',
        'thursday' => '08:00-17:00',
        'friday' => '08:00-17:00',
        'saturday' => '09:00-14:00',
        'sunday' => 'Closed'
    ],
    
    // Pricing settings
    'pricing' => [
        'parcel' => [
            'base_price' => 5.00,
            'base_weight' => 5,
            'distance_rate' => 0.50,
            'weight_rate' => 0.10
        ],
        'freight' => [
            'base_price' => 25.00,
            'base_weight' => 100,
            'distance_rate' => 1.00,
            'weight_rate' => 0.20
        ],
        'furniture' => [
            'base_price' => 50.00,
            'base_weight' => 500,
            'distance_rate' => 1.50,
            'weight_rate' => 0.15
        ],
        'taxi' => [
            'base_price' => 3.00,
            'distance_rate' => 0.80,
            'time_rate' => 0.05
        ],
        'towtruck' => [
            'base_price' => 20.00,
            'distance_rate' => 2.00,
            'time_rate' => 0.10
        ]
    ],
    
    // Insurance
    'insurance_percentage' => 2.0, // 2% of order value
    
    // Commission rates
    'commission_rates' => [
        'parcel' => 15,
        'freight' => 20,
        'furniture' => 25,
        'taxi' => 18,
        'towtruck' => 22
    ],
    
    // Payment gateways
    'payment_gateways' => [
        'paynow' => [
            'enabled' => true,
            'test_mode' => false,
            'merchant_id' => getenv('PAYNOW_MERCHANT_ID') ?: ''
        ],
        'stripe' => [
            'enabled' => true,
            'test_mode' => false,
            'public_key' => getenv('STRIPE_PUBLIC_KEY') ?: '',
            'secret_key' => getenv('STRIPE_SECRET_KEY') ?: ''
        ]
    ],
    
    // Email settings
    'mail' => [
        'from' => getenv('MAIL_FROM') ?: 'noreply@app.wgroos.com',
        'from_name' => getenv('MAIL_FROM_NAME') ?: 'WGroos Courier',
        'host' => getenv('MAIL_HOST') ?: 'smtp.gmail.com',
        'port' => getenv('MAIL_PORT') ?: 587,
        'encryption' => getenv('MAIL_ENCRYPTION') ?: 'tls',
        'username' => getenv('MAIL_USERNAME') ?: '',
        'password' => getenv('MAIL_PASSWORD') ?: ''
    ],
    
    // SMS settings
    'sms' => [
        'provider' => getenv('SMS_PROVIDER') ?: 'twilio',
        'account_sid' => getenv('TWILIO_ACCOUNT_SID') ?: '',
        'auth_token' => getenv('TWILIO_AUTH_TOKEN') ?: '',
        'from_number' => getenv('SMS_FROM_NUMBER') ?: '+263712345678'
    ],
    
    // Firebase (push notifications)
    'firebase' => [
        'project_id' => getenv('FIREBASE_PROJECT_ID') ?: '',
        'api_key' => getenv('FIREBASE_API_KEY') ?: '',
        'credentials_file' => getenv('FIREBASE_CREDENTIALS_FILE') ?: ''
    ],
    
    // Logging
    'logging' => [
        'level' => getenv('LOG_LEVEL') ?: 'info',
        'path' => LOGS_PATH,
        'max_size' => 10485760 // 10MB
    ],
    
    // Features
    'features' => [
        'affiliate_program' => true,
        'driver_app' => true,
        'admin_panel' => true,
        'customer_portal' => true,
        'api' => true
    ]
];


