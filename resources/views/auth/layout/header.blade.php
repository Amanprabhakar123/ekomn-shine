<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <title>EKomn Login</title> -->
    <link rel="stylesheet" href="{{asset('assets/css/all.min.css')}}" as="style" onload="this.rel='stylesheet'" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" as="style" onload="this.rel='stylesheet'" />
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" as="style" onload="this.rel='stylesheet'" />
    <script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/request.js')}}"></script>
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
</head>