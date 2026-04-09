<?php
/**
 * Complete SQL Dump Import Migration
 * Imports wgroosco_app_wgroos.sql - All 43+ tables with one click
 * 
 * This script:
 * - Reads the SQL dump file
 * - Executes all CREATE TABLE statements
 * - Shows progress for each table
 * - Handles errors gracefully
 * - Safe to run multiple times (IF NOT EXISTS)
 */

// Handle API requests first
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'import') {
    // Clear any buffered output
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    // Set JSON header
    header('Content-Type: application/json; charset=utf-8');
    
    try {
        // Load database config - suppress any output
        $debug = false;
        ob_start();
        require_once dirname(__DIR__) . '/config/bootstrap.php';
        ob_end_clean();
        
        // Get database connection
        global $DB;
        if (!$DB) {
            throw new Exception("Database not connected. Run setup.php first.");
        }
        
        // Read SQL dump file - try multiple possible locations
        $possiblePaths = [
            dirname(__DIR__) . '/wgroosco_app_wgroos.sql',  // Root directory
            __DIR__ . '/wgroosco_app_wgroos.sql',           // Migrations directory
            dirname(dirname(__DIR__)) . '/wgroosco_app_wgroos.sql'  // Parent directory
        ];
        
        $sqlFile = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $sqlFile = $path;
                break;
            }
        }
        
        if (!$sqlFile) {
            throw new Exception("SQL dump file not found. Checked: " . implode(", ", $possiblePaths));
        }
        
        $sqlContent = file_get_contents($sqlFile);
        if (!$sqlContent) {
            throw new Exception("Could not read SQL dump file");
        }
        
        // Parse and extract CREATE TABLE statements
        $tables = [];
        
        // Match all CREATE TABLE statements
        $pattern = '/CREATE TABLE\s+(?:IF NOT EXISTS\s+)?`?([^`\s]+)`?\s*\((.*?)\)\s*(?:ENGINE|TYPE|DEFAULT|CHARACTER|COLLATE|COMMENT|;)/ims';
        
        if (preg_match_all($pattern, $sqlContent, $matches)) {
            for ($i = 0; $i < count($matches[1]); $i++) {
                $tableName = trim($matches[1][$i]);
                // Find the full CREATE TABLE statement
                preg_match('/CREATE TABLE\s+(?:IF NOT EXISTS\s+)?`?' . preg_quote($tableName) . '`?\s*\([^)]*\)([^;]*);/is', $sqlContent, $fullMatch);
                if (isset($fullMatch[0])) {
                    $tables[] = [
                        'name' => $tableName,
                        'sql' => $fullMatch[0]
                    ];
                }
            }
        }
        
        if (empty($tables)) {
            throw new Exception("No CREATE TABLE statements found in SQL file");
        }
        
        // Disable foreign key checks
        $DB->query("SET FOREIGN_KEY_CHECKS=0");
        
        // Create/import each table
        $results = [];
        foreach ($tables as $table) {
            $result = [
                'name' => $table['name'],
                'status' => 'error',
                'message' => ''
            ];
            
            try {
                // Check if table exists
                $checkResult = $DB->query("SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = '{$table['name']}'");
                
                if ($checkResult && $checkResult->num_rows > 0) {
                    $result['status'] = 'skipped';
                    $result['message'] = 'Table already exists';
                } else {
                    // Create table
                    if ($DB->query($table['sql'])) {
                        $result['status'] = 'success';
                        $result['message'] = 'Table created successfully';
                    } else {
                        $result['status'] = 'error';
                        $result['message'] = $DB->error;
                    }
                }
            } catch (Exception $e) {
                $result['status'] = 'error';
                $result['message'] = $e->getMessage();
            }
            
            $results[] = $result;
        }
        
        // Re-enable foreign key checks
        $DB->query("SET FOREIGN_KEY_CHECKS=1");
        
        // Return results
        echo json_encode([
            'success' => true,
            'total' => count($results),
            'tables' => $results
        ]);
        
    } catch (Exception $e) {
        while (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
    exit;
}

// Show HTML interface for non-API requests
header('Content-Type: text/html; charset=utf-8');
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import SQL Database - WG ROOS Courier</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 900px;
            width: 100%;
            padding: 40px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .progress-bar {
            width: 100%;
            height: 40px;
            background: #e0e0e0;
            border-radius: 20px;
            overflow: hidden;
            margin: 20px 0;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            width: 0%;
            transition: width 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }
        
        .step {
            margin: 15px 0;
            padding: 15px;
            border-left: 4px solid #ddd;
            border-radius: 4px;
            background: #f9f9f9;
            font-size: 13px;
        }
        
        .step.pending {
            border-left-color: #ccc;
            background: #f5f5f5;
        }
        
        .step.running {
            border-left-color: #ff9800;
            background: #fff3e0;
        }
        
        .step.success {
            border-left-color: #4caf50;
            background: #e8f5e9;
        }
        
        .step.error {
            border-left-color: #f44336;
            background: #ffebee;
        }
        
        .step.skipped {
            border-left-color: #2196f3;
            background: #e3f2fd;
        }
        
        .status {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .table-name {
            color: #667eea;
            font-weight: 600;
        }
        
        .output {
            background: #263238;
            color: #aed581;
            padding: 12px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-height: 150px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin-top: 8px;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        button {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }
        
        .btn-secondary:hover {
            background: #d0d0d0;
        }
        
        .summary {
            margin-top: 30px;
            padding: 20px;
            border-radius: 5px;
            background: #f0f7ff;
            border: 2px solid #667eea;
            display: none;
        }
        
        .summary.show {
            display: block;
        }
        
        .summary h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .stat-row {
            display: flex;
            justify-content: space-around;
            margin: 10px 0;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
        }
        
        .stat-label {
            font-size: 12px;
            color: #666;
        }
        
        .error-list {
            background: #ffebee;
            border: 1px solid #f44336;
            padding: 12px;
            border-radius: 4px;
            margin-top: 10px;
        }
        
        .error-list li {
            margin-left: 20px;
            color: #c62828;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 Import SQL Database</h1>
        <p class="subtitle">Importing wgroosco_app_wgroos.sql - Complete with all 43+ tables</p>
        
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill">0%</div>
        </div>
        
        <div id="output"></div>
        
        <div class="summary" id="summary">
            <h3>✅ Import Complete!</h3>
            <div class="stat-row">
                <div class="stat">
                    <div class="stat-number" id="successCount">0</div>
                    <div class="stat-label">Tables Created</div>
                </div>
                <div class="stat">
                    <div class="stat-number" id="skippedCount">0</div>
                    <div class="stat-label">Tables Skipped (Existed)</div>
                </div>
                <div class="stat">
                    <div class="stat-number" id="errorCount">0</div>
                    <div class="stat-label">Errors</div>
                </div>
            </div>
            <div id="errorSection"></div>
        </div>
        
        <div class="button-group">
            <button class="btn-primary" id="runButton" onclick="startImport()">🚀 Start Import</button>
            <button class="btn-secondary" onclick="location.href='/migrations/setup.php'">← Back</button>
        </div>
    </div>

    <script>
        let totalTables = 0;
        let processedTables = 0;
        let successCount = 0;
        let skippedCount = 0;
        let errorCount = 0;
        let errors = [];
        
        function updateProgress() {
            const percentage = totalTables > 0 ? Math.round((processedTables / totalTables) * 100) : 0;
            const fill = document.getElementById('progressFill');
            fill.style.width = percentage + '%';
            fill.textContent = percentage + '%';
        }
        
        function addStep(tableName, status, message = '') {
            const output = document.getElementById('output');
            const stepDiv = document.createElement('div');
            stepDiv.className = 'step ' + status;
            
            let statusIcon = '⏳';
            if (status === 'success') {
                statusIcon = '✅';
                successCount++;
            } else if (status === 'error') {
                statusIcon = '❌';
                errorCount++;
                errors.push(tableName + ': ' + message);
            } else if (status === 'skipped') {
                statusIcon = 'ℹ️';
                skippedCount++;
            } else if (status === 'running') {
                statusIcon = '⚙️';
            }
            
            stepDiv.innerHTML = `
                <div class="status">${statusIcon} <span class="table-name">${tableName}</span></div>
                ${message ? '<div class="output">' + escapeHtml(message) + '</div>' : ''}
            `;
            
            output.appendChild(stepDiv);
            output.scrollTop = output.scrollHeight;
            
            if (status !== 'running') {
                processedTables++;
                updateProgress();
            }
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        function startImport() {
            document.getElementById('output').innerHTML = '';
            document.getElementById('runButton').disabled = true;
            document.getElementById('summary').classList.remove('show');
            successCount = 0;
            skippedCount = 0;
            errorCount = 0;
            errors = [];
            processedTables = 0;
            
            addStep('Database Connection', 'running');
            
            fetch('import-sql-dump.php?action=import', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(r => r.json())
            .then(data => {
                if (data.error) {
                    addStep('Database Connection', 'error', data.error);
                    document.getElementById('runButton').disabled = false;
                    return;
                }
                
                addStep('Database Connection', 'success', 'Connected to database');
                
                totalTables = data.tables.length;
                
                // Process each table
                data.tables.forEach((table, index) => {
                    if (table.status === 'success') {
                        addStep(table.name, 'success', table.message || 'Table created successfully');
                    } else if (table.status === 'skipped') {
                        addStep(table.name, 'skipped', 'Table already exists');
                    } else if (table.status === 'error') {
                        addStep(table.name, 'error', table.message || 'Failed to create table');
                    }
                });
                
                // Show summary
                document.getElementById('successCount').textContent = successCount;
                document.getElementById('skippedCount').textContent = skippedCount;
                document.getElementById('errorCount').textContent = errorCount;
                
                if (errors.length > 0) {
                    const errorSection = document.getElementById('errorSection');
                    errorSection.innerHTML = '<div class="error-list"><strong>Errors:</strong><ul>' + 
                        errors.map(e => '<li>' + escapeHtml(e) + '</li>').join('') + 
                        '</ul></div>';
                }
                
                document.getElementById('summary').classList.add('show');
                document.getElementById('runButton').disabled = false;
            })
            .catch(e => {
                addStep('Database Import', 'error', 'Error: ' + e.message);
                document.getElementById('runButton').disabled = false;
            });
        }
    </script>
</body>
</html>
