importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');

var firebaseConfig = {
    apiKey: "AIzaSyCSNGUwzJ0iXTz01MAWsfec5jbTWvbCYC8",
    authDomain: "merchant-booking.firebaseapp.com",
    databaseURL: "https://merchant-booking.firebaseio.com",
    projectId: "merchant-booking",
    storageBucket: "merchant-booking.appspot.com",
    messagingSenderId: "909204433162",
    appId: "1:909204433162:web:cd5165ba87c3e131ccb2f3"
	 // measurementId: "YOUR MEASUREMENT ID"
};

firebase.initializeApp(firebaseConfig);
const messaging=firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log(payload);
    const notification=JSON.parse(payload);
    const notificationOption={
        body:notification.body,
        icon:notification.icon
    };
    return self.registration.showNotification(payload.notification.title,notificationOption);
});