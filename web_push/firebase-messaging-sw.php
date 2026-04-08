<?php
/**
 * Firebase Service Worker Configuration
 * Dynamically injects Firebase config from site management
 * This file is served as javascript with config from website.json
 */

// Set header to serve as JavaScript
header('Content-Type: application/javascript');

// Read Firebase config from site management
$websiteJsonPath = __DIR__ . '/../portals/admin/pages/website.json';
$firebaseConfig = null;

if (file_exists($websiteJsonPath)) {
    $websiteData = json_decode(file_get_contents($websiteJsonPath), true);
    if (isset($websiteData['firebase_config'])) {
        $firebaseConfig = $websiteData['firebase_config'];
    }
}

// If config not found, use default (this shouldn't happen in production)
if (empty($firebaseConfig)) {
    $firebaseConfig = <<<'EOD'
{
    apiKey: "AIzaSyCSNGUwzJ0iXTz01MAWsfec5jbTWvbCYC8",
    authDomain: "merchant-booking.firebaseapp.com",
    databaseURL: "https://merchant-booking.firebaseio.com",
    projectId: "merchant-booking",
    storageBucket: "merchant-booking.appspot.com",
    messagingSenderId: "909204433162",
    appId: "1:909204433162:web:cd5165ba87c3e131ccb2f3"
}
EOD;
}
?>

importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');

var firebaseConfig = <?php echo $firebaseConfig; ?>;

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log(payload);
    const notification = JSON.parse(payload);
    const notificationOption = {
        body: notification.body,
        icon: notification.icon
    };
    return self.registration.showNotification(payload.notification.title, notificationOption);
});
