<?php
/**
 * Pricing Engine Class
 * Handles all pricing calculations and currency conversions with live rates
 */

class PricingEngine {
    private $db;
    private $config;
    private $currencyManager;

    public function __construct($db, $config) {
        $this->db = $db;
        $this->config = $config;
        $this->currencyManager = new CurrencyExchangeManager($db);
    }

    /**
     * Calculate booking price using base currency
     */
    public function calculateBookingPrice($serviceType, $weight, $pickupAddress, $dropAddress, $insurance = false, $currency = null) {
        try {
            // Use base currency from config if not specified
            if ($currency === null) {
                $currency = $this->config->get('base_currency', 'USD');
            }

            $pricing = $this->config->getPricing();
            $serviceConfig = $this->getServiceConfig($serviceType, $pricing);
            $baseCurrency = $this->config->get('base_currency', 'USD');

            // Get distance (in real app, use Google Maps API)
            $distance = $this->estimateDistance($pickupAddress, $dropAddress);

            // Calculate base price (in base currency)
            $basePrice = $serviceConfig['base_price'];

            // Add distance charge
            $distanceCharge = $distance * $serviceConfig['distance_rate'];

            // Add weight charge (only for weight over base weight)
            $weightCharge = 0;
            if (isset($serviceConfig['base_weight']) && $weight > $serviceConfig['base_weight']) {
                $weightCharge = ($weight - $serviceConfig['base_weight']) * $serviceConfig['weight_rate'];
            }

            $subtotal = $basePrice + $distanceCharge + $weightCharge;

            // Add insurance if applicable
            $insuranceCharge = 0;
            if ($insurance) {
                $insurancePercentage = $pricing['insurance_percentage'] ?? 2.0;
                $insuranceCharge = $subtotal * ($insurancePercentage / 100);
                $subtotal += $insuranceCharge;
            }

            // Convert to requested currency using live rates
            $finalPrice = $this->convertCurrency($subtotal, $baseCurrency, $currency);

            return [
                'base_price' => round($basePrice, 2),
                'distance_charge' => round($distanceCharge, 2),
                'weight_charge' => round($weightCharge, 2),
                'insurance_charge' => round($insuranceCharge, 2),
                'subtotal' => round($subtotal, 2),
                'total_price' => round($finalPrice, 2),
                'base_currency' => $baseCurrency,
                'currency' => $currency,
                'exchange_rate' => $baseCurrency !== $currency ? $this->currencyManager->getExchangeRate($baseCurrency, $currency) : 1.0,
                'distance' => $distance,
                'weight' => $weight,
            ];

        } catch (Exception $e) {
            error_log("Price Calculation Error: " . $e->getMessage());
            return ['error' => 'Error calculating price'];
        }
    }

    /**
     * Get service configuration
     */
    private function getServiceConfig($serviceType, $pricing) {
        $configs = [
            'parcel' => [
                'base_price' => $pricing['parcel_base_price'],
                'distance_rate' => $pricing['parcel_distance_rate'],
                'weight_rate' => $pricing['parcel_weight_rate'],
                'base_weight' => 5,
            ],
            'freight' => [
                'base_price' => $pricing['freight_base_price'],
                'distance_rate' => $pricing['freight_distance_rate'],
                'weight_rate' => $pricing['freight_weight_rate'],
                'base_weight' => 100,
            ],
            'furniture' => [
                'base_price' => $pricing['furniture_base_price'],
                'distance_rate' => $pricing['furniture_distance_rate'],
                'weight_rate' => $pricing['parcel_weight_rate'],
                'base_weight' => 500,
            ],
        ];

        return $configs[$serviceType] ?? $configs['parcel'];
    }

    /**
     * Calculate driver commission
     */
    public function calculateDriverCommission($totalPrice, $serviceType) {
        try {
            $commissions = $this->config->getCommission();
            
            $commissionKey = $serviceType . '_commission';
            $commissionRate = $commissions[$commissionKey] ?? 15;

            $commission = ($totalPrice * $commissionRate) / 100;
            $platformFee = $totalPrice - $commission;

            return [
                'gross_amount' => $totalPrice,
                'commission_rate' => $commissionRate,
                'driver_earning' => round($commission, 2),
                'platform_fee' => round($platformFee, 2),
            ];

        } catch (Exception $e) {
            error_log("Commission Calculation Error: " . $e->getMessage());
            return ['error' => 'Error calculating commission'];
        }
    }

    /**
     * Convert currency using live exchange rates
     */
    public function convertCurrency($amount, $from, $to) {
        if ($from === $to) {
            return $amount;
        }

        try {
            $rate = $this->currencyManager->getExchangeRate($from, $to);
            return $amount * $rate;
        } catch (Exception $e) {
            error_log("Currency Conversion Error: " . $e->getMessage());
            return $amount; // Return original if conversion fails
        }
    }

    /**
     * Estimate distance between two addresses
     * In production, this should use Google Maps API
     */
    private function estimateDistance($from, $to) {
        // Placeholder - integrate with Google Maps API
        // For now, return a default value
        // In real implementation: use geolocation or Google Distance Matrix API
        
        return 10; // 10 km default
    }

    /**
     * Apply discount/coupon
     */
    public function applyDiscount($totalPrice, $discountAmount) {
        $discounted = $totalPrice - $discountAmount;
        
        return [
            'original_price' => $totalPrice,
            'discount' => $discountAmount,
            'final_price' => max(0, round($discounted, 2)), // Ensure non-negative
        ];
    }

    /**
     * Get available currencies for selection
     */
    public function getAvailableCurrencies() {
        return $this->currencyManager->getAllCurrencies();
    }

    /**
     * Get currency information
     */
    public function getCurrencyInfo($code) {
        return $this->currencyManager->getCurrencyInfo($code);
    }
}

