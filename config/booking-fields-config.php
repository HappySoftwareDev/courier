<?php
/**
 * Booking Fields Configuration
 * Defines which fields are required/optional for each service type
 * This drives the dynamic form behavior
 */

return [
    'parcel' => [
        'service_name' => 'Parcel Delivery',
        'icon' => 'fas fa-box',
        'description' => 'Send small to medium packages',
        'common_fields' => [
            'fullname' => ['type' => 'text', 'label' => 'Full Name', 'required' => true, 'placeholder' => 'Your full name'],
            'email' => ['type' => 'email', 'label' => 'Email Address', 'required' => true, 'placeholder' => 'your@email.com'],
            'phone' => ['type' => 'tel', 'label' => 'Phone Number', 'required' => true, 'placeholder' => '+1 (555) 123-4567'],
            'from_address' => ['type' => 'text', 'label' => 'Pickup Location', 'required' => true, 'placeholder' => '123 Main Street, City'],
            'to_address' => ['type' => 'text', 'label' => 'Delivery Location', 'required' => true, 'placeholder' => '456 Oak Avenue, City'],
        ],
        'service_fields' => [
            'weight' => ['type' => 'number', 'label' => 'Package Weight (kg)', 'required' => true, 'placeholder' => '5', 'min' => 0.1, 'step' => 0.1],
            'dimensions' => ['type' => 'text', 'label' => 'Dimensions (L x W x H cm)', 'required' => false, 'placeholder' => '30 x 20 x 15'],
            'description' => ['type' => 'textarea', 'label' => 'Package Description', 'required' => true, 'placeholder' => 'e.g., Electronics, Documents, Clothing'],
            'fragile' => ['type' => 'checkbox', 'label' => 'Fragile Items (Extra Care)', 'required' => false],
            'insurance' => ['type' => 'checkbox', 'label' => 'Add Insurance', 'required' => false],
        ],
        'pricing_factors' => ['weight', 'distance', 'fragile', 'insurance'],
    ],
    
    'freight' => [
        'service_name' => 'Freight Delivery',
        'icon' => 'fas fa-dolly',
        'description' => 'Heavy or bulk items delivery',
        'common_fields' => [
            'fullname' => ['type' => 'text', 'label' => 'Full Name', 'required' => true, 'placeholder' => 'Your full name'],
            'email' => ['type' => 'email', 'label' => 'Email Address', 'required' => true, 'placeholder' => 'your@email.com'],
            'phone' => ['type' => 'tel', 'label' => 'Phone Number', 'required' => true, 'placeholder' => '+1 (555) 123-4567'],
            'from_address' => ['type' => 'text', 'label' => 'Pickup Location', 'required' => true, 'placeholder' => 'Warehouse Address'],
            'to_address' => ['type' => 'text', 'label' => 'Delivery Location', 'required' => true, 'placeholder' => 'Destination Address'],
        ],
        'service_fields' => [
            'weight' => ['type' => 'number', 'label' => 'Total Weight (kg)', 'required' => true, 'placeholder' => '500', 'min' => 50, 'step' => 1],
            'item_count' => ['type' => 'number', 'label' => 'Number of Items', 'required' => true, 'placeholder' => '1', 'min' => 1],
            'item_type' => ['type' => 'select', 'label' => 'Item Type', 'required' => true, 'options' => [
                'machinery' => 'Machinery & Equipment',
                'furniture' => 'Furniture & Furnishings',
                'construction' => 'Construction Materials',
                'automotive' => 'Automotive Parts',
                'electronics' => 'Large Electronics',
                'raw_materials' => 'Raw Materials',
                'other' => 'Other'
            ]],
            'special_handling' => ['type' => 'checkbox', 'label' => 'Requires Special Handling (Crane, etc.)', 'required' => false],
            'loading_assistance' => ['type' => 'checkbox', 'label' => 'Loading/Unloading Assistance', 'required' => false],
            'insurance' => ['type' => 'checkbox', 'label' => 'Add Insurance', 'required' => false],
            'notes' => ['type' => 'textarea', 'label' => 'Special Instructions', 'required' => false, 'placeholder' => 'Any special instructions for delivery'],
        ],
        'pricing_factors' => ['weight', 'distance', 'special_handling', 'loading_assistance', 'insurance'],
    ],
    
    'furniture' => [
        'service_name' => 'Furniture Moving',
        'icon' => 'fas fa-couch',
        'description' => 'Furniture and home relocation',
        'common_fields' => [
            'fullname' => ['type' => 'text', 'label' => 'Full Name', 'required' => true, 'placeholder' => 'Your full name'],
            'email' => ['type' => 'email', 'label' => 'Email Address', 'required' => true, 'placeholder' => 'your@email.com'],
            'phone' => ['type' => 'tel', 'label' => 'Phone Number', 'required' => true, 'placeholder' => '+1 (555) 123-4567'],
            'from_address' => ['type' => 'text', 'label' => 'Pickup Location', 'required' => true, 'placeholder' => 'Current Address'],
            'to_address' => ['type' => 'text', 'label' => 'Delivery Location', 'required' => true, 'placeholder' => 'New Address'],
        ],
        'service_fields' => [
            'item_type' => ['type' => 'select', 'label' => 'Main Item Type', 'required' => true, 'options' => [
                'sofa' => 'Sofa/Couch',
                'bed' => 'Bed Frame',
                'table' => 'Table',
                'wardrobe' => 'Wardrobe/Cabinet',
                'bookshelf' => 'Bookshelf/Storage',
                'mattress' => 'Mattress',
                'multiple' => 'Multiple Items (House Move)',
                'other' => 'Other Furniture'
            ]],
            'item_count' => ['type' => 'number', 'label' => 'Number of Items', 'required' => true, 'placeholder' => '1', 'min' => 1],
            'disassembly_required' => ['type' => 'checkbox', 'label' => 'Disassembly/Reassembly Required', 'required' => false],
            'packing_required' => ['type' => 'checkbox', 'label' => 'Packing Materials Needed', 'required' => false],
            'storage' => ['type' => 'checkbox', 'label' => 'Temporary Storage Required', 'required' => false],
            'insurance' => ['type' => 'checkbox', 'label' => 'Add Insurance', 'required' => false],
            'notes' => ['type' => 'textarea', 'label' => 'Additional Details', 'required' => false, 'placeholder' => 'Describe items and any special requirements'],
        ],
        'pricing_factors' => ['distance', 'item_count', 'disassembly_required', 'packing_required', 'storage', 'insurance'],
    ],
    
    'taxi' => [
        'service_name' => 'Taxi Service',
        'icon' => 'fas fa-taxi',
        'description' => 'Personal transportation service',
        'common_fields' => [
            'fullname' => ['type' => 'text', 'label' => 'Full Name', 'required' => true, 'placeholder' => 'Your full name'],
            'email' => ['type' => 'email', 'label' => 'Email Address', 'required' => true, 'placeholder' => 'your@email.com'],
            'phone' => ['type' => 'tel', 'label' => 'Phone Number', 'required' => true, 'placeholder' => '+1 (555) 123-4567'],
            'from_address' => ['type' => 'text', 'label' => 'Pickup Location', 'required' => true, 'placeholder' => 'Where should we pick you up'],
            'to_address' => ['type' => 'text', 'label' => 'Destination', 'required' => true, 'placeholder' => 'Where are you going'],
        ],
        'service_fields' => [
            'passengers' => ['type' => 'number', 'label' => 'Number of Passengers', 'required' => true, 'placeholder' => '1', 'min' => 1, 'max' => 8],
            'luggage' => ['type' => 'checkbox', 'label' => 'Extra Luggage/Cargo', 'required' => false],
            'preferred_time' => ['type' => 'datetime-local', 'label' => 'Preferred Pickup Time', 'required' => false],
            'return_journey' => ['type' => 'checkbox', 'label' => 'Return Journey Required', 'required' => false],
            'vehicle_type' => ['type' => 'select', 'label' => 'Vehicle Type Preference', 'required' => false, 'options' => [
                'economy' => 'Economy (Standard Car)',
                'comfort' => 'Comfort (Spacious Sedan)',
                'premium' => 'Premium (Luxury Car)',
                'van' => 'Van (Group/Cargo)'
            ]],
            'special_requests' => ['type' => 'textarea', 'label' => 'Special Requests', 'required' => false, 'placeholder' => 'Any special needs or preferences'],
        ],
        'pricing_factors' => ['distance', 'passengers', 'luggage', 'return_journey'],
    ],
    
    'towtruck' => [
        'service_name' => 'Tow Truck Service',
        'icon' => 'fas fa-truck',
        'description' => 'Vehicle towing and roadside assistance',
        'common_fields' => [
            'fullname' => ['type' => 'text', 'label' => 'Full Name', 'required' => true, 'placeholder' => 'Your full name'],
            'email' => ['type' => 'email', 'label' => 'Email Address', 'required' => true, 'placeholder' => 'your@email.com'],
            'phone' => ['type' => 'tel', 'label' => 'Phone Number', 'required' => true, 'placeholder' => '+1 (555) 123-4567'],
            'from_address' => ['type' => 'text', 'label' => 'Current Location', 'required' => true, 'placeholder' => 'Where is the vehicle located'],
            'to_address' => ['type' => 'text', 'label' => 'Destination', 'required' => true, 'placeholder' => 'Where to tow the vehicle'],
        ],
        'service_fields' => [
            'vehicle_type' => ['type' => 'select', 'label' => 'Vehicle Type', 'required' => true, 'options' => [
                'car' => 'Car (Sedan)',
                'suv' => 'SUV/Crossover',
                'truck' => 'Pickup Truck',
                'van' => 'Van',
                'motorcycle' => 'Motorcycle',
                'trailer' => 'Trailer',
                'bus' => 'Bus',
                'other' => 'Other'
            ]],
            'vehicle_condition' => ['type' => 'select', 'label' => 'Vehicle Condition', 'required' => true, 'options' => [
                'running' => 'Running (Minor Issue)',
                'not_running' => 'Not Running',
                'accident' => 'Accident Damage',
                'mechanical' => 'Mechanical Breakdown',
                'flat_tire' => 'Flat Tire',
                'other' => 'Other'
            ]],
            'towing_type' => ['type' => 'select', 'label' => 'Towing Type', 'required' => true, 'options' => [
                'wheel_lift' => 'Wheel Lift Towing',
                'flatbed' => 'Flatbed Towing',
                'dolly' => 'Dolly Towing',
                'roadside' => 'Roadside Assistance Only'
            ]],
            'urgent' => ['type' => 'checkbox', 'label' => 'Urgent/Emergency (Extra Charge)', 'required' => false],
            'additional_services' => ['type' => 'checkbox', 'label' => 'Battery Jump/Fuel Assistance', 'required' => false],
            'notes' => ['type' => 'textarea', 'label' => 'Detailed Description of Issue', 'required' => true, 'placeholder' => 'Describe what happened and current vehicle condition'],
        ],
        'pricing_factors' => ['distance', 'vehicle_type', 'towing_type', 'urgent'],
    ]
];
?>


