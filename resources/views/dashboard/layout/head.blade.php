<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <meta name="description" content="Register now to get onboarded with eKomn. Fill in the required details to start your journey with us." />
    <meta name="keywords" content="register, eKomn, onboarding, business registration" />
    <link rel="stylesheet" href="{{asset('assets/css//all.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if session flash data exists for 'token'
            @if(session('token'))

            let token = "{{ session('token') }}";

            const object = "{{ json_encode(session('user_details')) }}";
            const user_details = object.replace(/&quot;/g, '"');
            // Function to set an item in localStorage
            // function setLocalStorageItem(key, value) {
            //     localStorage.setItem(key, value);
            // }

            // Function to set an item in sessionStorage
            function setSessionStorageItem(key, value) {
                sessionStorage.setItem(key, value);
            }

            // // Store the token in localStorage
            // setLocalStorageItem('token', token);

            // Store the token in sessionStorage (if needed)
            setSessionStorageItem('token', token);

            setSessionStorageItem('user_details', user_details);

            // Example: Alert the stored value from localStorage
            // alert('Token stored in LocalStorage: ' + localStorage.getItem('token'));
            // alert('Token stored in SessionStorage: ' + sessionStorage.getItem('token'));
            @endif
        });
    </script>

    <script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/request.js')}}"></script>
    

    @yield('styles')
  </head>
  <body class="ek_db">