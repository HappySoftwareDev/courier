<?php
/**
 * Database Configuration
 * 
 * This file centralizes all database connection settings.
 * Can be overridden by environment variables.
 */

return [
    'driver' => getenv('DB_DRIVER') ?: 'mysqli',
    'host' => getenv('DB_HOST') ?: 'localhost',
    'user' => getenv('DB_USER') ?: 'faithinf_courier',
    'pass' => getenv('DB_PASS') ?: 'courier2026#$',
    'name' => getenv('DB_NAME') ?: 'faithinf_courier',
    'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
    'port' => getenv('DB_PORT') ?: 3306,
];


