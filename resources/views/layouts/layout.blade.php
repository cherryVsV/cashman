<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>CashMan - @yield('title')</title>
    <meta name="description" content="CashMan Mobile">
    <meta name="keywords"
          content="bootstrap, wallet, banking, fintech mobile template, cordova, phonegap, mobile, html, responsive"/>
    <link rel="icon" type="image/png" href="{{ asset('assets/icon.png') }}?version={{env("APP_VERSION")}}" sizes="32x32">
    <link href="{{ asset('css/app.css') }}?version={{env("APP_VERSION")}}" rel="stylesheet">
    @if (Illuminate\Support\Facades\Auth::check())
    <meta name="user" content="{{ App\Models\User::self() }}"/>
    @endif
    @laravelPWA
</head>
<body>
<div id="app">
    <!-- loader -->
    <div id="loader">
        <img src="{{ asset('assets/logo-icon.png') }}" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->
    @yield('content')
</div>
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js?version={{env("APP_VERSION")}}"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js?version={{env("APP_VERSION")}}"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js?version={{env("APP_VERSION")}}"></script>
@if(Illuminate\Support\Facades\Auth::check())
<script type="text/javascript">
    var firebaseConfig = {
        apiKey: 'AIzaSyBy3G_-OGoXyRaCqB4wZJAjrd3QE1PLDa8',
        authDomain: 'cashman-320612.firebaseapp.com',
        projectId: 'cashman-320612',
        storageBucket: 'cashman-320612.appspot.com',
        messagingSenderId: '291920612530',
        appId: '1:291920612530:web:ae679e33f6ced8a6a5cdab',
        measurementId: 'G-1MH9VQW03S'
    };

    firebase.initializeApp(firebaseConfig);
    messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken({ vapidKey: 'BL33NB4gjDr1gikXM9k8Np3ZSRmLrAfezQwa40i5P6BIl039XujRTMcTy7ZxbKS3R3L40G0ZPtVG8591Ph47v-o' })
            })
            .then(function(token) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route("save-push-notification-token") }}',
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                });

            }).catch(function (err) {
        });
    }
        initFirebaseMessagingRegistration();
</script>
@endif
<!-- Scripts -->
<script type="text/javascript" src="{{ asset('js/app.js') }}?version={{env("APP_VERSION")}}"></script>
<script type="text/javascript" src="{{ asset('js/base.js') }}?version={{env("APP_VERSION")}}"></script>
<script type="text/javascript" src="{{ asset('js/carousel.js') }}?version={{env("APP_VERSION")}}" defer></script>
<script type="text/javascript" src="{{asset('js/splide.min.js')}}?version={{env("APP_VERSION")}}"></script>
<script src="https://unpkg.com/@popperjs/core@2?version={{env("APP_VERSION")}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js?version={{env("APP_VERSION")}}" integrity="undefined"
        crossorigin="anonymous"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js?version={{env("APP_VERSION")}}"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js?version={{env("APP_VERSION")}}"></script>
<script src="https://js.pusher.com/7.0.3/pusher.min.js?version={{env("APP_VERSION")}}"></script>

</body>
</html>

<style>
    .padding-bottom-70 {
        padding-bottom: 70px;
    }
</style>

