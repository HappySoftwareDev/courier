#!/bin/bash
# Admin Dashboard Health Check Script
# Test all admin pages and verify they work with the new UI

echo "========================================"
echo "WG ROOS Admin Dashboard Health Check"
echo "========================================"
echo ""

# Admin URL (change based on your server)
ADMIN_URL="${ADMIN_URL:-http://localhost/portals/admin}"

# Function to test page
test_page() {
    local page=$1
    local name=$2
    echo -n "Testing $name... "
    response=$(curl -s -o /dev/null -w "%{http_code}" "$ADMIN_URL/$page")
    if [ "$response" = "200" ]; then
        echo "✓ OK (200)"
    elif [ "$response" = "302" ]; then
        echo "✓ Redirect (302)"
    else
        echo "✗ ERROR ($response)"
    fi
}

echo "Core Pages:"
test_page "index.php" "Dashboard"
test_page "pages/bookings.php" "Bookings"
test_page "pages/users.php" "Users"
test_page "pages/drivers.php" "Drivers"
test_page "pages/profile.php" "Profile"

echo ""
echo "New Feature Pages:"
test_page "pages/reports.php" "Reports & Analytics"
test_page "pages/commissions.php" "Commission Management"
test_page "pages/activity_logs.php" "Activity Logs"
test_page "pages/system_health.php" "System Health"
test_page "pages/api.php" "API Configuration"

echo ""
echo "Assets:"
test_page "assets/css/main.css" "Main CSS"
test_page "assets/js/main.js" "Main JavaScript"
test_page "placeholder.php?type=logo" "Logo Placeholder"

echo ""
echo "========================================"
echo "Health check complete!"
echo "========================================"
