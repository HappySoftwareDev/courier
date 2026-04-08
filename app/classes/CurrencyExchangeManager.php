<?php
/**
 * Currency Exchange Rate Manager
 * Handles real-time currency conversion using Google Finance API and caching
 */

class CurrencyExchangeManager {
    private $db;
    private $cacheTimeout = 3600; // 1 hour cache
    
    // World Currency Database
    private $currencyDatabase = [
        'USD' => ['name' => 'US Dollar', 'symbol' => '$', 'country' => 'United States'],
        'EUR' => ['name' => 'Euro', 'symbol' => '€', 'country' => 'Eurozone'],
        'GBP' => ['name' => 'British Pound', 'symbol' => '£', 'country' => 'United Kingdom'],
        'JPY' => ['name' => 'Japanese Yen', 'symbol' => '¥', 'country' => 'Japan'],
        'AUD' => ['name' => 'Australian Dollar', 'symbol' => 'A$', 'country' => 'Australia'],
        'CAD' => ['name' => 'Canadian Dollar', 'symbol' => 'C$', 'country' => 'Canada'],
        'CHF' => ['name' => 'Swiss Franc', 'symbol' => 'CHF', 'country' => 'Switzerland'],
        'CNY' => ['name' => 'Chinese Yuan', 'symbol' => '¥', 'country' => 'China'],
        'SEK' => ['name' => 'Swedish Krona', 'symbol' => 'kr', 'country' => 'Sweden'],
        'NZD' => ['name' => 'New Zealand Dollar', 'symbol' => 'NZ$', 'country' => 'New Zealand'],
        'MXN' => ['name' => 'Mexican Peso', 'symbol' => '$', 'country' => 'Mexico'],
        'SGD' => ['name' => 'Singapore Dollar', 'symbol' => 'S$', 'country' => 'Singapore'],
        'HKD' => ['name' => 'Hong Kong Dollar', 'symbol' => 'HK$', 'country' => 'Hong Kong'],
        'NOK' => ['name' => 'Norwegian Krone', 'symbol' => 'kr', 'country' => 'Norway'],
        'KRW' => ['name' => 'South Korean Won', 'symbol' => '₩', 'country' => 'South Korea'],
        'TRY' => ['name' => 'Turkish Lira', 'symbol' => '₺', 'country' => 'Turkey'],
        'RUB' => ['name' => 'Russian Ruble', 'symbol' => '₽', 'country' => 'Russia'],
        'INR' => ['name' => 'Indian Rupee', 'symbol' => '₹', 'country' => 'India'],
        'BRL' => ['name' => 'Brazilian Real', 'symbol' => 'R$', 'country' => 'Brazil'],
        'ZAR' => ['name' => 'South African Rand', 'symbol' => 'R', 'country' => 'South Africa'],
        'ZWL' => ['name' => 'Zimbabwean Dollar', 'symbol' => 'Z$', 'country' => 'Zimbabwe'],
        'NGN' => ['name' => 'Nigerian Naira', 'symbol' => '₦', 'country' => 'Nigeria'],
        'GHS' => ['name' => 'Ghanaian Cedi', 'symbol' => '₵', 'country' => 'Ghana'],
        'KES' => ['name' => 'Kenyan Shilling', 'symbol' => 'KSh', 'country' => 'Kenya'],
        'UGX' => ['name' => 'Ugandan Shilling', 'symbol' => 'USh', 'country' => 'Uganda'],
        'EGP' => ['name' => 'Egyptian Pound', 'symbol' => 'E£', 'country' => 'Egypt'],
        'THB' => ['name' => 'Thai Baht', 'symbol' => '฿', 'country' => 'Thailand'],
        'MYR' => ['name' => 'Malaysian Ringgit', 'symbol' => 'RM', 'country' => 'Malaysia'],
        'PHP' => ['name' => 'Philippine Peso', 'symbol' => '₱', 'country' => 'Philippines'],
        'IDR' => ['name' => 'Indonesian Rupiah', 'symbol' => 'Rp', 'country' => 'Indonesia'],
        'VND' => ['name' => 'Vietnamese Dong', 'symbol' => '₫', 'country' => 'Vietnam'],
        'PKR' => ['name' => 'Pakistani Rupee', 'symbol' => '₨', 'country' => 'Pakistan'],
        'AED' => ['name' => 'UAE Dirham', 'symbol' => 'د.إ', 'country' => 'United Arab Emirates'],
        'SAR' => ['name' => 'Saudi Riyal', 'symbol' => '﷼', 'country' => 'Saudi Arabia'],
        'CLP' => ['name' => 'Chilean Peso', 'symbol' => '$', 'country' => 'Chile'],
        'COP' => ['name' => 'Colombian Peso', 'symbol' => '$', 'country' => 'Colombia'],
        'PEN' => ['name' => 'Peruvian Sol', 'symbol' => 'S/', 'country' => 'Peru'],
        'ARS' => ['name' => 'Argentine Peso', 'symbol' => '$', 'country' => 'Argentina'],
        'HUF' => ['name' => 'Hungarian Forint', 'symbol' => 'Ft', 'country' => 'Hungary'],
        'CZK' => ['name' => 'Czech Koruna', 'symbol' => 'Kč', 'country' => 'Czech Republic'],
        'PLN' => ['name' => 'Polish Zloty', 'symbol' => 'zł', 'country' => 'Poland'],
        'RON' => ['name' => 'Romanian Leu', 'symbol' => 'lei', 'country' => 'Romania'],
        'BGN' => ['name' => 'Bulgarian Lev', 'symbol' => 'лв', 'country' => 'Bulgaria'],
    ];

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get all available currencies
     */
    public function getAllCurrencies() {
        return $this->currencyDatabase;
    }

    /**
     * Get currency info by code
     */
    public function getCurrencyInfo($code) {
        return $this->currencyDatabase[strtoupper($code)] ?? null;
    }

    /**
     * Fetch live exchange rates from Google Finance
     */
    public function getExchangeRate($fromCurrency, $toCurrency) {
        if ($fromCurrency === $toCurrency) {
            return 1.0;
        }

        // Check cache first
        $cached = $this->getCachedRate($fromCurrency, $toCurrency);
        if ($cached !== null) {
            return $cached;
        }

        // Fetch from Google Finance API
        $rate = $this->fetchFromGoogle($fromCurrency, $toCurrency);
        
        if ($rate) {
            // Cache the rate
            $this->cacheRate($fromCurrency, $toCurrency, $rate);
            return $rate;
        }

        // Fallback: try reverse conversion
        $reverseRate = $this->getCachedRate($toCurrency, $fromCurrency);
        if ($reverseRate !== null) {
            return 1 / $reverseRate;
        }

        // Last resort: return 1.0 (no conversion)
        error_log("Exchange rate not found for $fromCurrency -> $toCurrency");
        return 1.0;
    }

    /**
     * Fetch exchange rate from Google
     */
    private function fetchFromGoogle($from, $to) {
        try {
            // Google Finance URL (stable and doesn't require API key)
            $url = "https://www.google.com/finance/quote/{$from}-{$to}";
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5,
                    'user_agent' => 'Mozilla/5.0'
                ]
            ]);

            $html = @file_get_contents($url, false, $context);
            if (!$html) {
                return null;
            }

            // Extract rate from HTML (Google's structure)
            if (preg_match('/data-last-price="([0-9.]+)"/', $html, $matches)) {
                return (float) $matches[1];
            }

            // Alternative: Try data attribute
            if (preg_match('/class="YMlKec fxKbqc">([0-9.]+)</', $html, $matches)) {
                return (float) $matches[1];
            }

            return null;
        } catch (Exception $e) {
            error_log("Google Finance API Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get cached exchange rate
     */
    private function getCachedRate($from, $to) {
        try {
            $stmt = $this->db->prepare(
                "SELECT rate FROM exchange_rates 
                 WHERE from_currency = :from AND to_currency = :to 
                 AND created_at > DATE_SUB(NOW(), INTERVAL :timeout SECOND)
                 LIMIT 1"
            );
            
            $stmt->execute([
                ':from' => strtoupper($from),
                ':to' => strtoupper($to),
                ':timeout' => $this->cacheTimeout
            ]);

            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return (float) $result['rate'];
            }

            return null;
        } catch (Exception $e) {
            error_log("Cache Lookup Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Cache an exchange rate
     */
    private function cacheRate($from, $to, $rate) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO exchange_rates (from_currency, to_currency, rate, created_at)
                 VALUES (:from, :to, :rate, NOW())
                 ON DUPLICATE KEY UPDATE rate = :rate, created_at = NOW()"
            );
            
            $stmt->execute([
                ':from' => strtoupper($from),
                ':to' => strtoupper($to),
                ':rate' => (float) $rate
            ]);
        } catch (Exception $e) {
            error_log("Cache Save Error: " . $e->getMessage());
        }
    }

    /**
     * Convert amount from one currency to another
     */
    public function convert($amount, $fromCurrency, $toCurrency) {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        $rate = $this->getExchangeRate($fromCurrency, $toCurrency);
        return $amount * $rate;
    }
}
