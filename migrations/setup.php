<?php
/**
 * Complete Database Migration Setup
 * Creates all necessary tables for the application
 * Works with MySQLi (no PDO required)
 */

header('Content-Type: text/html; charset=utf-8');

// Allow access from web or CLI for setup
$isFirstRun = true;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Migration Setup</title>
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
            max-width: 800px;
            width: 100%;
            padding: 40px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .step {
            margin: 20px 0;
            padding: 15px;
            border-left: 4px solid #ddd;
            border-radius: 4px;
            background: #f9f9f9;
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
        
        .status {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .output {
            background: #263238;
            color: #aed581;
            padding: 12px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            max-height: 200px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        
        .progress-bar {
            width: 100%;
            height: 30px;
            background: #e0e0e0;
            border-radius: 15px;
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
            font-size: 12px;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        button {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .icon {
            font-size: 20px;
        }
        
        .tables-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }
        
        .table-item {
            padding: 10px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-size: 13px;
            font-family: monospace;
        }
        
        .table-item.created {
            background: #c8e6c9;
            border-color: #4caf50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>
            <span class="icon">🚀</span>
            Database Setup & Migration
        </h1>
        <p class="subtitle">Initializing your Courier Application Database</p>
        
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill">0%</div>
        </div>
        
        <div id="output"></div>
        
        <div class="button-group">
            <button class="btn-primary" id="runButton" onclick="runMigrations()">Run Migrations</button>
            <button class="btn-secondary" onclick="testConnection()">Test Connection</button>
            <button class="btn-secondary" onclick="location.href='import-sql-dump.php'" style="background: #4caf50;">Import SQL Dump (All 43+ Tables)</button>
        </div>
    </div>

    <script>
        let totalSteps = 0;
        let completedSteps = 0;
        
        function updateProgress() {
            const percentage = totalSteps > 0 ? Math.round((completedSteps / totalSteps) * 100) : 0;
            const fill = document.getElementById('progressFill');
            fill.style.width = percentage + '%';
            fill.textContent = percentage + '%';
        }
        
        function addStep(title, status, content = '') {
            const output = document.getElementById('output');
            const stepDiv = document.createElement('div');
            stepDiv.className = 'step ' + status;
            
            let statusIcon = '⏳';
            if (status === 'success') statusIcon = '✅';
            else if (status === 'error') statusIcon = '❌';
            else if (status === 'running') statusIcon = '⚙️';
            
            stepDiv.innerHTML = `
                <div class="status">${statusIcon} ${title}</div>
                ${content ? '<div class="output">' + escapeHtml(content) + '</div>' : ''}
            `;
            
            output.appendChild(stepDiv);
            output.scrollTop = output.scrollHeight;
            
            if (status !== 'running') {
                completedSteps++;
                updateProgress();
            }
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        function testConnection() {
            document.getElementById('output').innerHTML = '';
            completedSteps = 0;
            totalSteps = 1;
            updateProgress();
            
            addStep('Testing Database Connection', 'running');
            
            fetch('setup-database.php?action=test')
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        addStep('Database Connection', 'success', 'Connected to: ' + data.database + '\nHost: ' + data.host + '\nUser: ' + data.user);
                    } else {
                        addStep('Database Connection', 'error', data.error);
                    }
                    updateProgress();
                })
                .catch(e => {
                    addStep('Database Connection', 'error', 'Error: ' + e.message);
                    updateProgress();
                });
        }
        
        function runMigrations() {
            document.getElementById('output').innerHTML = '';
            document.getElementById('runButton').disabled = true;
            completedSteps = 0;
            totalSteps = 9;
            updateProgress();
            
            addStep('Step 1: Connecting to Database', 'running');
            
            fetch('setup-database.php?action=migrate')
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        addStep('Step 1: Connecting to Database', 'success', 'Connected successfully');
                        addStep('Step 2: Creating Bookings Table', 'success', 'Table created/exists');
                        addStep('Step 3: Creating Booking History Table', 'success', 'Table created/exists');
                        addStep('Step 4: Creating Booking Items Table', 'success', 'Table created/exists');
                        addStep('Step 5: Creating Driver Assignments Table', 'success', 'Table created/exists');
                        addStep('Step 6: Creating Config Table', 'success', 'Table created/exists');
                        addStep('Step 7: Creating Email Templates Table', 'success', 'Table created/exists');
                        addStep('Step 8: Creating Users Table', 'success', 'Table created/exists');
                        addStep('Step 9: Migration Complete', 'success', 'All tables created successfully!\n\nYour application is now ready to use.');
                        
                        completedSteps = totalSteps;
                        updateProgress();
                        
                        setTimeout(() => {
                            document.getElementById('runButton').disabled = false;
                            document.getElementById('runButton').textContent = 'Completed ✓';
                            document.getElementById('runButton').onclick = () => window.location.href = '../index.php';
                        }, 1000);
                    } else {
                        addStep('Migration Failed', 'error', data.error);
                        addStep('Debug Info', 'error', JSON.stringify(data.details || {}));
                        document.getElementById('runButton').disabled = false;
                    }
                })
                .catch(e => {
                    addStep('Migration Error', 'error', 'Error: ' + e.message);
                    document.getElementById('runButton').disabled = false;
                });
        }
    </script>
</body>
</html>
