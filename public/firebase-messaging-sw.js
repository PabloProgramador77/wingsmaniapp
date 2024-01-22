// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
// Import the functions you need from the SDKs you need
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
//importScripts('https://www.gstatic.com/firebasejs/9.0.2/firebase-app.js');
//importScripts('https://www.gstatic.com/firebasejs/9.0.2/firebase-messaging.js');
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
firebase.initializeApp({
    apiKey: "AIzaSyCfwO2i_u_kUhFfOS_HSWQI-RYsTf5Ny9k",
    authDomain: "fcmlaravel-c8f4b.firebaseapp.com",
    projectId: "fcmlaravel-c8f4b",
    storageBucket: "fcmlaravel-c8f4b.appspot.com",
    messagingSenderId: "808595646536",
    appId: "1:808595646536:web:c4baa60eaf4ccb8d0f507d",
    measurementId: "G-H9V41V6KQF"
});

const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});