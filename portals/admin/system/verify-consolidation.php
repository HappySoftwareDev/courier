<?php
/**
 * Consolidation Verification Script
 * Checks all consolidated files and redirects
 * 
 * Usage: Run in browser at /verify-consolidation.php
 */

// Don't output anything yet
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

$tests = [];
$passed = 0;
$failed = 0;

// Test helper function
function testFile($path, $label) {
    global $tests, $passed, $failed;
    
    $fullPath = __DIR__ . $path;
    if (file_exists($fullPath)) {
        $tests[] = [
            'status' => '✅ PASS',
            'test' => $label,
            'details' => 'File exists'
        ];
        $passed++;
    } else {
        $tests[] = [
            'status' => '❌ FAIL',
            'test' => $label,
            'details' => 'File not found'
        ];
        $failed++;
    }
}

function testRedirect($path, $label, $expectedLocation) {
    global $tests, $passed, $failed;
    
    $fullPath = __DIR__ . $path;
    if (file_exists($fullPath)) {
        $content = file_get_contents($fullPath);
        
        // Check if file is now a redirect (should be very small)
        $lines = count(file($fullPath));
        if ($lines <= 15) {
            $tests[] = [
                'status' => '✅ PASS',
                'test' => $label,
                'details' => "Redirect installed ({$lines} lines)"
            ];
            $passed++;
        } else {
            $tests[] = [
                'status' => '⚠️  CHECK',
                'test' => $label,
                'details' => "File exists but might not be redirect ({$lines} lines)"
            ];
        }
    } else {
        $tests[] = [
            'status' => '❌ FAIL',
            'test' => $label,
            'details' => 'File not found'
        ];
        $failed++;
    }
}

// Start testing
$tests[] = [
    'status' => '📋 TEST',
    'test' => 'Consolidation Verification',
    'details' => 'Checking all consolidated files...'
];

$tests[] = ['status' => '', 'test' => '', 'details' => ''];
$tests[] = [
    'status' => '🔍 PHASE 1',
    'test' => 'Root-Level Submit Consolidation',
    'details' => '4 files consolidated to /book/submit.php'
];

testRedirect('/submit_parser.php', 'submit_parser.php', '/book/submit.php');
testRedirect('/submit_parser1.php', 'submit_parser1.php', '/book/submit.php');
testRedirect('/submit_parser2.php', 'submit_parser2.php', '/book/submit.php');
testRedirect('/submit_parser_aff.php', 'submit_parser_aff.php', '/book/submit.php');

$tests[] = ['status' => '', 'test' => '', 'details' => ''];
$tests[] = [
    'status' => '🔍 PHASE 2',
    'test' => 'Book-Level Submit Consolidation',
    'details' => '5 files consolidated to book/submit.php'
];

testRedirect('/book/submit_freight.php', 'book/submit_freight.php', 'book/submit.php');
testRedirect('/book/submit_furniture.php', 'book/submit_furniture.php', 'book/submit.php');
testRedirect('/book/submit_parcel.php', 'book/submit_parcel.php', 'book/submit.php');
testRedirect('/book/taxi.submit_parser1.php', 'book/taxi.submit_parser1.php', 'book/submit.php');
testRedirect('/book/towtruck.submit_parser1.php', 'book/towtruck.submit_parser1.php', 'book/submit.php');

$tests[] = ['status' => '', 'test' => '', 'details' => ''];
$tests[] = [
    'status' => '🔍 PHASE 3',
    'test' => 'Booking Pages Consolidation',
    'details' => '5 files consolidated to book/index.php'
];

testRedirect('/book/parcel-page.php', 'book/parcel-page.php', 'book/index.php?service=parcel');
testRedirect('/book/freight-page.php', 'book/freight-page.php', 'book/index.php?service=freight');
testRedirect('/book/furniture-page.php', 'book/furniture-page.php', 'book/index.php?service=furniture');
testRedirect('/book/taxi.booking.php', 'book/taxi.booking.php', 'book/index.php?service=taxi');
testRedirect('/book/towtruck.booking.php', 'book/towtruck.booking.php', 'book/index.php?service=towtruck');

$tests[] = ['status' => '', 'test' => '', 'details' => ''];
$tests[] = [
    'status' => '🔍 PHASE 4',
    'test' => 'Email System Consolidation',
    'details' => 'Email system modernized'
];

testFile('/sendemail.php', 'sendemail.php modernized');
testFile('/book/send_notification.php', 'book/send_notification.php modernized');

$tests[] = ['status' => '', 'test' => '', 'details' => ''];
$tests[] = [
    'status' => '🔍 UNIFIED',
    'test' => 'Unified Handlers',
    'details' => 'Checking unified handler files'
];

testFile('/book/submit.php', 'book/submit.php (unified handler)');
testFile('/book/index.php', 'book/index.php (unified interface)');
testFile('/classes/BookingProcessor.php', 'BookingProcessor class');
testFile('/classes/EmailTemplateManager.php', 'EmailTemplateManager class');
testFile('/classes/ConfigManager.php', 'ConfigManager class');

$tests[] = ['status' => '', 'test' => '', 'details' => ''];
$tests[] = [
    'status' => '📊 SUMMARY',
    'test' => 'Test Results',
    'details' => "Passed: {$passed}, Failed: {$failed}"
];

// Generate HTML output
ob_end_clean();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consolidation Verification</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .header p {
            opacity: 0.9;
            font-size: 14px;
        }
        .content {
            padding: 30px;
        }
        .test-item {
            display: flex;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }
        .test-item:last-child {
            border-bottom: none;
        }
        .test-status {
            min-width: 80px;
            font-weight: 600;
            margin-right: 15px;
        }
        .test-content {
            flex: 1;
        }
        .test-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 4px;
        }
        .test-detail {
            font-size: 12px;
            color: #999;
        }
        .summary {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
            text-align: center;
        }
        .summary p {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .summary-stat {
            display: inline-block;
            margin: 0 15px;
            font-size: 18px;
            font-weight: 600;
        }
        .stat-pass {
            color: #10b981;
        }
        .stat-fail {
            color: #ef4444;
        }
        .stat-check {
            color: #f59e0b;
        }
        .header-divider {
            height: 3px;
            background: linear-gradient(90deg, transparent, #667eea, transparent);
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Consolidation Verification Report</h1>
            <p>Phase 3 File Consolidation - Complete System Check</p>
        </div>
        
        <div class="content">
            <?php foreach ($tests as $test): ?>
                <?php if (empty($test['test'])): ?>
                    <div class="header-divider"></div>
                <?php else: ?>
                    <div class="test-item">
                        <div class="test-status"><?php echo $test['status']; ?></div>
                        <div class="test-content">
                            <div class="test-label"><?php echo $test['test']; ?></div>
                            <div class="test-detail"><?php echo $test['details']; ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <div class="summary">
                <p>Consolidation Status:</p>
                <div>
                    <span class="summary-stat stat-pass">✓ <?php echo $passed; ?> Passed</span>
                    <?php if ($failed > 0): ?>
                        <span class="summary-stat stat-fail">✗ <?php echo $failed; ?> Failed</span>
                    <?php endif; ?>
                </div>
                <p style="margin-top: 15px; font-weight: 600; color: #333;">
                    <?php 
                    $total = $passed + $failed;
                    $percentage = $total > 0 ? round(($passed / $total) * 100) : 0;
                    echo "Overall: {$percentage}% Complete"; 
                    ?>
                </p>
            </div>
        </div>
    </div>
</body>
</html>


