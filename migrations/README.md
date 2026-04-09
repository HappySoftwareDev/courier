# WG ROOS Courier - Database Migrations

Complete database migration system for setting up and maintaining the WG ROOS Courier application.

## What Are Migrations?

Database migrations are scripts that automatically create and manage database tables. They ensure the database has all required tables with correct structure when you're setting up the system for the first time.

## Available Migrations

### 001_create_config_table.sql
**Purpose:** Creates site_settings table for application configuration  
**Tables Created:** 1 (sitesettings)  
**Status:** Recommended (completed during setup)  
**When to Use:** Initial setup (executed by setup.php)

### 002_create_email_templates_table.sql
**Purpose:** Email template storage for notifications  
**Tables Created:** 1 (email_templates)  
**Status:** Recommended (completed during setup)  
**When to Use:** Initial setup (executed by setup.php)

### 003_add_currency_and_exchange_tables.sql
**Purpose:** Multi-currency and exchange rate support  
**Tables Created:** 2 (currencies, exchange_rates)  
**Status:** Optional  
**When to Use:** If using multiple currencies in pricing

### setup.php ⭐ RECOMMENDED - CLEAN UI MIGRATION TOOL
**Purpose:** Visual migration interface for creating all application tables  
**Tables Created:** All tables automatically detected and created  
**Status:** Recommended - Run immediately after setup.php  
**When to Use:** After completing root setup.php steps  
**Features:**
- Clean visual interface with progress bars
- Real-time status for each table creation
- Error handling and reporting
- Success confirmation message
**Run Via:**
- Web: Click link in root setup.php success page
- Direct URL: `/migrations/setup.php`
- Best experience: Use in web browser (visual feedback)

### import-sql-dump.php ⭐⭐ BEST OPTION - COMPLETE SQL IMPORT
**Purpose:** Import complete wgroosco_app_wgroos.sql - ALL 43+ tables with one click  
**Tables Created:** 43+ comprehensive application tables  
**Status:** RECOMMENDED - Complete functionality  
**When to Use:** After root setup.php to get FULL database setup  
**Features:**
- Imports entire SQL dump file automatically
- Clean visual interface with progress
- Real-time feedback for each table
- Skips existing tables (safe to run multiple times)
- Summary showing: Created count, Skipped count, Errors
- Handles WordPress integration tables (if present)
**Run Via:**
- Direct button: Click "📊 Import 43+ Tables" from root setup.php
- Direct URL: `/migrations/import-sql-dump.php`
- Dashboard link: From `/migrations/setup.php`

**Creates 43+ Tables:**
- All user & admin tables
- Complete booking/delivery system
- Full driver management
- Payment processing system
- Pricing & zone management  
- Affiliate system
- Blog & content management
- Notifications & alerts
- Configuration tables
- WordPress integration (if applicable)

## Setup Procedure

### Step 1: Database Connection
Create a database and user in your hosting control panel (cPanel, Plesk, etc.)

### Step 2: Run Setup Wizard
1. Visit `/setup.php` in your browser
2. Enter database credentials (host, user, password, database name)
3. Create admin user
4. Complete setup

### Step 3: Run Migrations (IMPORTANT)
After setup completion, you have TWO options:

**OPTION A - RECOMMENDED: Import Complete SQL Database**
1. Click "📊 Click Here to Import 43+ Tables" link from setup.php success page
2. OR visit `/migrations/import-sql-dump.php` directly
3. Click "🚀 Start Import" button
4. Wait for completion (shows progress for each table)
5. See summary: Created count, Skipped count, Errors
6. Your complete database is ready!

**OPTION B - BASIC: Run Simple Migration**
1. Click "⚙️ Run Basic Migration" link from setup.php success page  
2. OR visit `/migrations/setup.php` directly
3. Click "Run Migrations" button
4. Creates 7-8 basic tables (bookings, users, config, etc.)
5. Use only if you don't need full feature set

The migration will:
- Check which tables already exist
- Create any missing tables
- Report results with creation count
- List any failures (if any)

### Step 4: Verify Installation
1. Log in to admin panel at `/portals/admin/`
2. Go to Site Management → Database
3. Check that all tables are created (should show 43 new tables)
4. Verify booking fields and pricing settings

### Step 5: Configure Payment
1. Get API keys from payment providers (PayNow, Stripe, etc.)
2. Go to Site Management → Payment Settings
3. Enter keys and test transactions

### Step 6: Security
1. Delete `setup.php` from your server
2. Ensure `config/.setup-complete` file exists
3. Verify proper file permissions (644 for files, 755 for directories)

## Running Migrations Later

If you need to run migrations again:

### Option 1: Web Interface
Access `/migrations/004_create_missing_tables.php` directly in your browser.
- Shows which tables will be created
- Safe to run multiple times (skips existing tables)
- Visual feedback on completion

### Option 2: Command Line (if SSH access available)
```bash
cd /path/to/app
php migrations/004_create_missing_tables.php
```

### Option 3: phpMyAdmin
1. Log in to phpMyAdmin in cPanel
2. Select your database
3. Copy SQL from each migration file
4. Paste in SQL tab and execute

## Table Categories

### Admin & Users (5 tables)
- `admin` - Admin users
- `users` - Regular users/customers
- `api_users` - API integration users
- `api_users_business` - Business API users
- `businesspartners` - Business partner accounts

### Booking System (5 tables)
- `bookings` - Booking records
- `Delivery` - Delivery tracking
- `Parcels` - Parcel information
- `freight_orders` - Freight/cargo orders
- `booking_fields` - Custom booking form fields

### Driver Management (4 tables)
- `driver` - Driver profiles and status
- `driver_info` - Additional driver information
- `driver_doc` - Driver documents/licenses
- `chat_drivers` - Chat with drivers

### Payment System (3 tables)
- `payment_methods` - Payment method configuration
- `payment_setting` - Payment gateway settings
- `paymentdetail` - Payment transaction logs

### Pricing & Zones (3 tables)
- `prizelist` - Pricing configuration
- `weight_price` - Weight-based pricing
- `inter_zones` - Inter-zone pricing

### Affiliate System (4 tables)
- `affilate_user` - Affiliate user accounts
- `affiliate_msg` - Affiliate messages
- `affiliate_payouts` - Payout tracking
- `affilate_invites` - Affiliate invitations

### Content & Blog (5 tables)
- `blog` - Blog posts
- `blog_comments` - Blog comments
- `blog_sub` - Blog subscribers
- `posts` - Additional posts
- `video_blog` - Video blog entries

### Notifications (2 tables)
- `customer_alerts` - Customer alerts/notifications
- `driver_alerts` - Driver alerts/notifications

### Configuration & System (4 tables)
- `cities` - City configuration
- `countries` - Country/zone assignments
- `common_coupon` - Coupon codes
- `user_coupons` - User-specific coupons

### Communications (2 tables)
- `contacts` - Contact form submissions
- `contact_reply` - Replies to contacts

### Other (1 table)
- `push_tokens` - Push notification tokens

## Troubleshooting

### "Table already exists" Error
This is normal! The migration script checks for existing tables and skips them. It's safe to run multiple times.

### "Database connection failed"
- Check database credentials in `config/database-config.php`
- Verify database user has CREATE TABLE permissions
- Ensure database exists and is accessible

### Missing Tables After Migration
If tables weren't created:
1. Check database user permissions (needs CREATE, ALTER)
2. Review error messages in migration output
3. Check database size limits/quotas
4. Try running migration again

### File Permission Issues
If migration won't run:
- Ensure `config/` directory is writable (755 or 775)
- Ensure `migrations/` directory is readable (755)
- Check PHP execution permissions

## Manual Table Creation

If migrations fail, manually import the SQL from `wgroosco_app_wgroos.sql`:

1. In cPanel, open phpMyAdmin
2. Select your database
3. Click "Import"
4. Choose `wgroosco_app_wgroos.sql` file
5. Click "Go"

This will restore all tables and possibly existing data.

## Support

For issues or questions:
1. Check error messages carefully
2. Verify all prerequisites are met
3. Review file permissions
4. Ensure PHP version ≥ 7.2
5. Contact hosting provider if database issues persist

---

**Last Updated:** 2024  
**Migration Version:** 004  
**Total Tables:** 43 application tables + system tables
