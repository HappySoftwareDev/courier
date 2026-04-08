-- Migration: Add exchange rates table and update config for currency/country
-- Created: 2026-01-28

-- Table to cache exchange rates (for performance)
CREATE TABLE IF NOT EXISTS `exchange_rates` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `from_currency` varchar(3) NOT NULL,
  `to_currency` varchar(3) NOT NULL,
  `rate` decimal(15,8) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `currency_pair` (`from_currency`, `to_currency`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add currency and country configuration fields to config table
-- These will be added via ConfigManager seed during migration

-- Config entries to add (via CompatibilityMigrator):
-- base_currency: Default currency for the business (USD, GBP, ZAR, etc.)
-- base_country: Country of operation (affects timezone, currency defaults)
-- allow_currency_selection: Boolean - allow customers to select payment currency
-- currency_list: JSON array of supported currencies for booking
-- exchange_rate_cache_duration: How long to cache rates (in seconds, default 3600)
