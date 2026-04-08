<?php
/**
 * Notification Template Manager
 * Centralized management for email, SMS, and push notification templates
 * 
 * Located: portals/admin/templates/
 */

require_once '../../../config/bootstrap.php';

class NotificationTemplateManager {
    protected $db;
    protected $basePath;
    protected $templates = [];

    public function __construct($database) {
        $this->db = $database;
        $this->basePath = dirname(__FILE__);
        $this->loadTemplates();
    }

    /**
     * Load all templates from JSON files
     */
    protected function loadTemplates() {
        $types = ['emails', 'sms', 'push'];
        
        foreach ($types as $type) {
            $templateFile = $this->basePath . '/' . $type . '/templates.json';
            if (file_exists($templateFile)) {
                $this->templates[$type] = json_decode(
                    file_get_contents($templateFile),
                    true
                ) ?? [];
            }
        }
    }

    /**
     * Get template by type and name
     */
    public function getTemplate($type, $name) {
        return $this->templates[$type][$name] ?? null;
    }

    /**
     * Save template
     */
    public function saveTemplate($type, $name, $data) {
        if (!isset($this->templates[$type])) {
            $this->templates[$type] = [];
        }
        
        $this->templates[$type][$name] = $data;
        
        $templateFile = $this->basePath . '/' . $type . '/templates.json';
        return file_put_contents(
            $templateFile,
            json_encode($this->templates[$type], JSON_PRETTY_PRINT)
        );
    }

    /**
     * Get all templates of a type
     */
    public function getAllTemplates($type) {
        return $this->templates[$type] ?? [];
    }

    /**
     * Delete template
     */
    public function deleteTemplate($type, $name) {
        if (isset($this->templates[$type][$name])) {
            unset($this->templates[$type][$name]);
            
            $templateFile = $this->basePath . '/' . $type . '/templates.json';
            return file_put_contents(
                $templateFile,
                json_encode($this->templates[$type], JSON_PRETTY_PRINT)
            );
        }
        return false;
    }

    /**
     * Send email using template
     */
    public function sendEmail($templateName, $to, $variables = []) {
        $template = $this->getTemplate('emails', $templateName);
        if (!$template) {
            return false;
        }

        $subject = $this->replaceVariables($template['subject'], $variables);
        $body = $this->replaceVariables($template['body'], $variables);

        // Use mail() or your email service here
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\n";
        return mail($to, $subject, $body, $headers);
    }

    /**
     * Send SMS using template
     */
    public function sendSMS($templateName, $phone, $variables = []) {
        $template = $this->getTemplate('sms', $templateName);
        if (!$template) {
            return false;
        }

        $message = $this->replaceVariables($template['message'], $variables);
        
        // Use your SMS service here
        // Example: Twilio, Nexmo, BulkSMS, etc.
        return true; // Placeholder
    }

    /**
     * Send push notification using template
     */
    public function sendPushNotification($templateName, $userId, $variables = []) {
        $template = $this->getTemplate('push', $templateName);
        if (!$template) {
            return false;
        }

        $title = $this->replaceVariables($template['title'], $variables);
        $message = $this->replaceVariables($template['message'], $variables);
        
        // Use Firebase or your push service here
        return true; // Placeholder
    }

    /**
     * Replace variables in template
     */
    protected function replaceVariables($text, $variables = []) {
        foreach ($variables as $key => $value) {
            $text = str_replace('{{' . $key . '}}', $value, $text);
        }
        return $text;
    }
}

?>
