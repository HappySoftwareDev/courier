<?php
/**
 * Database Configuration
 * 
 * This file centralizes all database connection settings.
 * Can be overridden by environment variables.
 */

return [
    'driver' => getenv('DB_DRIVER') ?: 'pdo',
    'host' => getenv('DB_HOST') ?: 'localhost',
    'user' => getenv('DB_USER') ?: 'wgroosco_wp598app',
    'pass' => getenv('DB_PASS') ?: 'Appwgrooscourier2024#$',
    'name' => getenv('DB_NAME') ?: 'wgroosco_app.wgroos',
    'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
    'port' => getenv('DB_PORT') ?: 3306,
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ]
];


