importScripts('https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js');
try {
    firebase.initializeApp({
        apiKey: 'AIzaSyBy3G_-OGoXyRaCqB4wZJAjrd3QE1PLDa8',
        authDomain: 'cashman-320612.firebaseapp.com',
        projectId: 'cashman-320612',
        storageBucket: 'cashman-320612.appspot.com',
        messagingSenderId: '291920612530',
        appId: '1:291920612530:web:ae679e33f6ced8a6a5cdab',
        measurementId: 'G-1MH9VQW03S'
    });
    const messaging = firebase.messaging();
    messaging.setBackgroundMessageHandler(function (payload) {
        console.log(
            "[firebase-messaging-sw.js] Received background message ",
            payload,
        );

        const notificationTitle = payload.data.title;
        const notificationOptions = {
            body: payload.data.body,
            icon: payload.data.image,
        };

        return self.registration.showNotification(
            notificationTitle,
            notificationOptions,
        );
    });
}
catch (e) {

}
