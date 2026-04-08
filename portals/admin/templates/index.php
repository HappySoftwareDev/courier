<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Templates Manager</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/main.css">
</head>
<body>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1>📧 Notification Templates Management</h1>
                <p class="text-muted">Manage Email, SMS, and Push Notification templates</p>
                <hr>
            </div>
        </div>

        <!-- Tabs for different notification types -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#emails">📧 Emails</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#sms">💬 SMS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#push">🔔 Push Notifications</a>
            </li>
        </ul>

        <div class="tab-content mt-4">
            <!-- Email Templates -->
            <div id="emails" class="tab-pane fade show active">
                <h3>Email Templates</h3>
                <p class="text-muted">Create and manage email templates for system communications</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <h5>Available Templates</h5>
                        <div class="list-group" id="email-templates-list">
                            <p class="text-muted">Loading templates...</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Edit Template</h5>
                        <form id="email-form">
                            <div class="form-group">
                                <label>Template Name</label>
                                <input type="text" class="form-control" id="email-name" placeholder="e.g., booking_confirmation">
                            </div>
                            <div class="form-group">
                                <label>Subject Line</label>
                                <input type="text" class="form-control" id="email-subject" placeholder="Use {{variable}} for dynamic content">
                            </div>
                            <div class="form-group">
                                <label>Email Body (HTML)</label>
                                <textarea class="form-control" id="email-body" rows="8" placeholder="HTML content here..."></textarea>
                            </div>
                            <div class="form-group">
                                <small class="text-muted">Available variables: {{name}}, {{email}}, {{order_number}}, {{amount}}, etc.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Template</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SMS Templates -->
            <div id="sms" class="tab-pane fade">
                <h3>SMS Templates</h3>
                <p class="text-muted">Create and manage SMS message templates</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <h5>Available Templates</h5>
                        <div class="list-group" id="sms-templates-list">
                            <p class="text-muted">Loading templates...</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Edit Template</h5>
                        <form id="sms-form">
                            <div class="form-group">
                                <label>Template Name</label>
                                <input type="text" class="form-control" id="sms-name" placeholder="e.g., booking_confirmation">
                            </div>
                            <div class="form-group">
                                <label>Message Content</label>
                                <textarea class="form-control" id="sms-message" rows="8" placeholder="SMS message (max 160 chars recommended)"></textarea>
                                <small class="text-muted" id="sms-length">Character count: 0/160</small>
                            </div>
                            <div class="form-group">
                                <small class="text-muted">Available variables: {{name}}, {{phone}}, {{order_number}}, {{amount}}, etc.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Template</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Push Notification Templates -->
            <div id="push" class="tab-pane fade">
                <h3>Push Notification Templates</h3>
                <p class="text-muted">Create and manage push notification templates</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <h5>Available Templates</h5>
                        <div class="list-group" id="push-templates-list">
                            <p class="text-muted">Loading templates...</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Edit Template</h5>
                        <form id="push-form">
                            <div class="form-group">
                                <label>Template Name</label>
                                <input type="text" class="form-control" id="push-name" placeholder="e.g., new_order">
                            </div>
                            <div class="form-group">
                                <label>Notification Title</label>
                                <input type="text" class="form-control" id="push-title" placeholder="Title (max 50 chars)">
                            </div>
                            <div class="form-group">
                                <label>Notification Message</label>
                                <textarea class="form-control" id="push-message" rows="6" placeholder="Message content"></textarea>
                            </div>
                            <div class="form-group">
                                <small class="text-muted">Available variables: {{name}}, {{order_number}}, {{amount}}, etc.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Template</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load templates on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadTemplates('emails');
            loadTemplates('sms');
            loadTemplates('push');
        });

        function loadTemplates(type) {
            // This would load from the JSON files via API
            console.log('Loading ' + type + ' templates');
        }

        // Form submissions would handle saving templates
        document.getElementById('email-form').addEventListener('submit', function(e) {
            e.preventDefault();
            // Save email template
        });
    </script>
</body>
</html>
