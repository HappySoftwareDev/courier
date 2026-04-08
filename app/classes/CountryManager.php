<?php
/**
 * Country Manager
 * Provides country data and currency mapping for all countries
 */

class CountryManager {
    private $countries = [
        'US' => ['name' => 'United States', 'currency' => 'USD', 'code' => 'US', 'timezone' => 'America/New_York'],
        'GB' => ['name' => 'United Kingdom', 'currency' => 'GBP', 'code' => 'GB', 'timezone' => 'Europe/London'],
        'CA' => ['name' => 'Canada', 'currency' => 'CAD', 'code' => 'CA', 'timezone' => 'America/Toronto'],
        'AU' => ['name' => 'Australia', 'currency' => 'AUD', 'code' => 'AU', 'timezone' => 'Australia/Sydney'],
        'NZ' => ['name' => 'New Zealand', 'currency' => 'NZD', 'code' => 'NZ', 'timezone' => 'Pacific/Auckland'],
        'DE' => ['name' => 'Germany', 'currency' => 'EUR', 'code' => 'DE', 'timezone' => 'Europe/Berlin'],
        'FR' => ['name' => 'France', 'currency' => 'EUR', 'code' => 'FR', 'timezone' => 'Europe/Paris'],
        'IT' => ['name' => 'Italy', 'currency' => 'EUR', 'code' => 'IT', 'timezone' => 'Europe/Rome'],
        'ES' => ['name' => 'Spain', 'currency' => 'EUR', 'code' => 'ES', 'timezone' => 'Europe/Madrid'],
        'NL' => ['name' => 'Netherlands', 'currency' => 'EUR', 'code' => 'NL', 'timezone' => 'Europe/Amsterdam'],
        'BE' => ['name' => 'Belgium', 'currency' => 'EUR', 'code' => 'BE', 'timezone' => 'Europe/Brussels'],
        'AT' => ['name' => 'Austria', 'currency' => 'EUR', 'code' => 'AT', 'timezone' => 'Europe/Vienna'],
        'SE' => ['name' => 'Sweden', 'currency' => 'SEK', 'code' => 'SE', 'timezone' => 'Europe/Stockholm'],
        'NO' => ['name' => 'Norway', 'currency' => 'NOK', 'code' => 'NO', 'timezone' => 'Europe/Oslo'],
        'CH' => ['name' => 'Switzerland', 'currency' => 'CHF', 'code' => 'CH', 'timezone' => 'Europe/Zurich'],
        'JP' => ['name' => 'Japan', 'currency' => 'JPY', 'code' => 'JP', 'timezone' => 'Asia/Tokyo'],
        'CN' => ['name' => 'China', 'currency' => 'CNY', 'code' => 'CN', 'timezone' => 'Asia/Shanghai'],
        'SG' => ['name' => 'Singapore', 'currency' => 'SGD', 'code' => 'SG', 'timezone' => 'Asia/Singapore'],
        'HK' => ['name' => 'Hong Kong', 'currency' => 'HKD', 'code' => 'HK', 'timezone' => 'Asia/Hong_Kong'],
        'IN' => ['name' => 'India', 'currency' => 'INR', 'code' => 'IN', 'timezone' => 'Asia/Kolkata'],
        'TH' => ['name' => 'Thailand', 'currency' => 'THB', 'code' => 'TH', 'timezone' => 'Asia/Bangkok'],
        'MY' => ['name' => 'Malaysia', 'currency' => 'MYR', 'code' => 'MY', 'timezone' => 'Asia/Kuala_Lumpur'],
        'PH' => ['name' => 'Philippines', 'currency' => 'PHP', 'code' => 'PH', 'timezone' => 'Asia/Manila'],
        'ID' => ['name' => 'Indonesia', 'currency' => 'IDR', 'code' => 'ID', 'timezone' => 'Asia/Jakarta'],
        'VN' => ['name' => 'Vietnam', 'currency' => 'VND', 'code' => 'VN', 'timezone' => 'Asia/Ho_Chi_Minh'],
        'KR' => ['name' => 'South Korea', 'currency' => 'KRW', 'code' => 'KR', 'timezone' => 'Asia/Seoul'],
        'TR' => ['name' => 'Turkey', 'currency' => 'TRY', 'code' => 'TR', 'timezone' => 'Europe/Istanbul'],
        'AE' => ['name' => 'United Arab Emirates', 'currency' => 'AED', 'code' => 'AE', 'timezone' => 'Asia/Dubai'],
        'SA' => ['name' => 'Saudi Arabia', 'currency' => 'SAR', 'code' => 'SA', 'timezone' => 'Asia/Riyadh'],
        'EG' => ['name' => 'Egypt', 'currency' => 'EGP', 'code' => 'EG', 'timezone' => 'Africa/Cairo'],
        'ZA' => ['name' => 'South Africa', 'currency' => 'ZAR', 'code' => 'ZA', 'timezone' => 'Africa/Johannesburg'],
        'NG' => ['name' => 'Nigeria', 'currency' => 'NGN', 'code' => 'NG', 'timezone' => 'Africa/Lagos'],
        'GH' => ['name' => 'Ghana', 'currency' => 'GHS', 'code' => 'GH', 'timezone' => 'Africa/Accra'],
        'KE' => ['name' => 'Kenya', 'currency' => 'KES', 'code' => 'KE', 'timezone' => 'Africa/Nairobi'],
        'UG' => ['name' => 'Uganda', 'currency' => 'UGX', 'code' => 'UG', 'timezone' => 'Africa/Kampala'],
        'ZW' => ['name' => 'Zimbabwe', 'currency' => 'ZWL', 'code' => 'ZW', 'timezone' => 'Africa/Harare'],
        'BZ' => ['name' => 'Brazil', 'currency' => 'BRL', 'code' => 'BZ', 'timezone' => 'America/Sao_Paulo'],
        'MX' => ['name' => 'Mexico', 'currency' => 'MXN', 'code' => 'MX', 'timezone' => 'America/Mexico_City'],
        'AR' => ['name' => 'Argentina', 'currency' => 'ARS', 'code' => 'AR', 'timezone' => 'America/Argentina/Buenos_Aires'],
        'CL' => ['name' => 'Chile', 'currency' => 'CLP', 'code' => 'CL', 'timezone' => 'America/Santiago'],
        'CO' => ['name' => 'Colombia', 'currency' => 'COP', 'code' => 'CO', 'timezone' => 'America/Bogota'],
        'PE' => ['name' => 'Peru', 'currency' => 'PEN', 'code' => 'PE', 'timezone' => 'America/Lima'],
        'PK' => ['name' => 'Pakistan', 'currency' => 'PKR', 'code' => 'PK', 'timezone' => 'Asia/Karachi'],
        'HU' => ['name' => 'Hungary', 'currency' => 'HUF', 'code' => 'HU', 'timezone' => 'Europe/Budapest'],
        'CZ' => ['name' => 'Czech Republic', 'currency' => 'CZK', 'code' => 'CZ', 'timezone' => 'Europe/Prague'],
        'PL' => ['name' => 'Poland', 'currency' => 'PLN', 'code' => 'PL', 'timezone' => 'Europe/Warsaw'],
        'RO' => ['name' => 'Romania', 'currency' => 'RON', 'code' => 'RO', 'timezone' => 'Europe/Bucharest'],
        'RU' => ['name' => 'Russia', 'currency' => 'RUB', 'code' => 'RU', 'timezone' => 'Europe/Moscow'],
        'BG' => ['name' => 'Bulgaria', 'currency' => 'BGN', 'code' => 'BG', 'timezone' => 'Europe/Sofia'],
    ];

    /**
     * Get all countries sorted by name
     */
    public function getAllCountries() {
        $countries = $this->countries;
        usort($countries, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        return $countries;
    }

    /**
     * Get country by code
     */
    public function getCountry($code) {
        return $this->countries[strtoupper($code)] ?? null;
    }

    /**
     * Get currency for country
     */
    public function getCurrencyForCountry($code) {
        $country = $this->getCountry($code);
        return $country ? $country['currency'] : 'USD';
    }

    /**
     * Get timezone for country
     */
    public function getTimezoneForCountry($code) {
        $country = $this->getCountry($code);
        return $country ? $country['timezone'] : 'UTC';
    }

    /**
     * Get list of countries as key-value for HTML select
     */
    public function getCountriesForSelect() {
        $select = [];
        $countries = $this->getAllCountries();
        foreach ($countries as $country) {
            $select[$country['code']] = $country['name'];
        }
        return $select;
    }

    /**
     * Get list of currencies as key-value
     */
    public function getCurrenciesForSelect() {
        // Return available currencies
        return [
            'USD' => 'US Dollar (USD)',
            'EUR' => 'Euro (EUR)',
            'GBP' => 'British Pound (GBP)',
            'JPY' => 'Japanese Yen (JPY)',
            'AUD' => 'Australian Dollar (AUD)',
            'CAD' => 'Canadian Dollar (CAD)',
            'CHF' => 'Swiss Franc (CHF)',
            'CNY' => 'Chinese Yuan (CNY)',
            'SEK' => 'Swedish Krona (SEK)',
            'NZD' => 'New Zealand Dollar (NZD)',
            'MXN' => 'Mexican Peso (MXN)',
            'SGD' => 'Singapore Dollar (SGD)',
            'HKD' => 'Hong Kong Dollar (HKD)',
            'NOK' => 'Norwegian Krone (NOK)',
            'KRW' => 'South Korean Won (KRW)',
            'TRY' => 'Turkish Lira (TRY)',
            'RUB' => 'Russian Ruble (RUB)',
            'INR' => 'Indian Rupee (INR)',
            'BRL' => 'Brazilian Real (BRL)',
            'ZAR' => 'South African Rand (ZAR)',
            'ZWL' => 'Zimbabwean Dollar (ZWL)',
            'NGN' => 'Nigerian Naira (NGN)',
            'GHS' => 'Ghanaian Cedi (GHS)',
            'KES' => 'Kenyan Shilling (KES)',
            'UGX' => 'Ugandan Shilling (UGX)',
            'EGP' => 'Egyptian Pound (EGP)',
            'THB' => 'Thai Baht (THB)',
            'MYR' => 'Malaysian Ringgit (MYR)',
            'PHP' => 'Philippine Peso (PHP)',
            'IDR' => 'Indonesian Rupiah (IDR)',
            'VND' => 'Vietnamese Dong (VND)',
            'PKR' => 'Pakistani Rupee (PKR)',
            'AED' => 'UAE Dirham (AED)',
            'SAR' => 'Saudi Riyal (SAR)',
            'CLP' => 'Chilean Peso (CLP)',
            'COP' => 'Colombian Peso (COP)',
            'PEN' => 'Peruvian Sol (PEN)',
            'ARS' => 'Argentine Peso (ARS)',
            'HUF' => 'Hungarian Forint (HUF)',
            'CZK' => 'Czech Koruna (CZK)',
            'PLN' => 'Polish Zloty (PLN)',
            'RON' => 'Romanian Leu (RON)',
            'BGN' => 'Bulgarian Lev (BGN)',
        ];
    }
}
