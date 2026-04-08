<?php
/**
 * City Manager
 * Manages cities by country for booking location selection
 */

class CityManager {
    private $cities = [
        // Zimbabwe
        'ZW' => [
            'Harare', 'Bulawayo', 'Chitungwiza', 'Mutare', 'Gweru',
            'Kwekwe', 'Norton', 'Marondera', 'Bindura', 'Zvishavane',
            'Kadoma', 'Chegutu', 'Rusape', 'Mazowe', 'Karoi',
            'Chirundu', 'Beitbridge', 'Kariba', 'Victoria Falls', 'Chiredzi'
        ],
        // Zambia
        'ZM' => [
            'Lusaka', 'Kitwe', 'Ndola', 'Kabwe', 'Chingola',
            'Mufulira', 'Kalulushi', 'Livingstone', 'Kasama', 'Chipata',
            'Kaoma', 'Mongu', 'Solwezi', 'Kapiri Mposhi', 'Kafue',
            'Mazabuka', 'Choma', 'Siavonga', 'Chirundu', 'Kabompo'
        ],
        // Kenya
        'KE' => [
            'Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret',
            'Kericho', 'Nyeri', 'Muranga', 'Machakos', 'Thika',
            'Isiolo', 'Garissa', 'Kamba', 'Lamu', 'Malindi',
            'Kilifi', 'Wajir', 'Mandera', 'Naivasha', 'Limuru'
        ],
        // South Africa
        'ZA' => [
            'Johannesburg', 'Cape Town', 'Durban', 'Pretoria', 'Port Elizabeth',
            'Bloemfontein', 'Pietermaritzburg', 'East London', 'Polokwane', 'Hoedspruit',
            'Nelspruit', 'Rustenburg', 'Limpopo', 'Kroonstad', 'Vereeniging',
            'Kempton Park', 'Benoni', 'Randfontein', 'Springbok', 'Upington'
        ],
        // Ghana
        'GH' => [
            'Accra', 'Kumasi', 'Sekondi-Takoradi', 'Tamale', 'Cape Coast',
            'Tema', 'Ashaiman', 'Obuasi', 'Akim Oda', 'Tarkwa',
            'Koforidua', 'Sunyani', 'Bolgatanga', 'Wa', 'Gowrie'
        ],
        // Uganda
        'UG' => [
            'Kampala', 'Gulu', 'Lira', 'Soroti', 'Mbarara',
            'Masaka', 'Jinja', 'Kitgum', 'Mbale', 'Moroto',
            'Arua', 'Fort Portal', 'Hoima', 'Kabale', 'Kisoro'
        ],
        // Nigeria
        'NG' => [
            'Lagos', 'Abuja', 'Ibadan', 'Kano', 'Katsina',
            'Port Harcourt', 'Enugu', 'Benin City', 'Owerri', 'Akure',
            'Ilorin', 'Abeokuta', 'Maiduguri', 'Bauchi', 'Kaduna'
        ],
        // Tanzania
        'TZ' => [
            'Dar es Salaam', 'Mwanza', 'Arusha', 'Mbeya', 'Dodoma',
            'Zanibar', 'Tanga', 'Iringa', 'Morogoro', 'Moshi',
            'Bukoba', 'Kigoma', 'Singida', 'Tabora', 'Lindi'
        ],
        // Ethiopia
        'ET' => [
            'Addis Ababa', 'Dire Dawa', 'Adama', 'Mekelle', 'Arba Minch',
            'Dessie', 'Bahir Dar', 'Hawassa', 'Injibara', 'Jijiga',
            'Gondar', 'Asosa', 'Kombolcha', 'Robe', 'Harar'
        ],
        // USA
        'US' => [
            'New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix',
            'Philadelphia', 'San Antonio', 'San Diego', 'Dallas', 'San Jose',
            'Austin', 'Jacksonville', 'Fort Worth', 'Memphis', 'Boston',
            'Seattle', 'Denver', 'Washington DC', 'Atlanta', 'Miami'
        ],
        // UK
        'GB' => [
            'London', 'Birmingham', 'Manchester', 'Leeds', 'Glasgow',
            'Liverpool', 'Edinburgh', 'Bristol', 'Leicester', 'Coventry',
            'Bradford', 'Cardiff', 'Belfast', 'Nottingham', 'Sheffield',
            'Southampton', 'Portsmouth', 'Oxford', 'Cambridge', 'York'
        ],
        // Canada
        'CA' => [
            'Toronto', 'Montreal', 'Vancouver', 'Calgary', 'Ottawa',
            'Edmonton', 'Winnipeg', 'Quebec City', 'Hamilton', 'Kitchener',
            'London', 'Halifax', 'Victoria', 'Windsor', 'Saskatoon',
            'Laval', 'Surrey', 'Markham', 'Scarborough', 'St Catharines'
        ],
        // Australia
        'AU' => [
            'Sydney', 'Melbourne', 'Brisbane', 'Perth', 'Adelaide',
            'Gold Coast', 'Canberra', 'Newcastle', 'Wollongong', 'Logan City',
            'Hobart', 'Fremantle', 'Parramatta', 'Manly', 'Penrith',
            'Central Coast', 'Geelong', 'Townsville', 'Cairns', 'Toowoomba'
        ],
        // India
        'IN' => [
            'Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Chennai',
            'Kolkata', 'Pune', 'Ahmedabad', 'Jaipur', 'Lucknow',
            'Chandigarh', 'Surat', 'Indore', 'Bhopal', 'Kochi',
            'Visakhapatnam', 'Vadodara', 'Nagpur', 'Ghaziabad', 'Ludhiana'
        ],
        // Singapore
        'SG' => [
            'Singapore Central', 'Jurong', 'Bedok', 'Tampines', 'Yishun',
            'Clementi', 'Bukit Batok', 'Bukit Merah', 'Geylang', 'Marine Parade',
            'Outram', 'Tuas', 'Tengah', 'Pasir Ris', 'Punggol'
        ],
        // Default cities
        'DEFAULT' => [
            'City Center', 'North', 'South', 'East', 'West',
            'Central Business District', 'Downtown', 'Uptown', 'Suburb'
        ]
    ];

    /**
     * Get cities for a country
     */
    public function getCitiesForCountry($countryCode) {
        $code = strtoupper($countryCode);
        return $this->cities[$code] ?? $this->cities['DEFAULT'];
    }

    /**
     * Get cities as JSON for AJAX
     */
    public function getCitiesJSON($countryCode) {
        $cities = $this->getCitiesForCountry($countryCode);
        return json_encode($cities);
    }

    /**
     * Validate if city belongs to country
     */
    public function validateCity($countryCode, $city) {
        $cities = $this->getCitiesForCountry($countryCode);
        return in_array($city, $cities);
    }
}
