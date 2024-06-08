<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <div class="container">
        <h1>Welcome Admin, {{ Auth::user()->name }}</h1>
        <p>This is your dashboard. You're logged in as {{ Auth::user()->name }}.</p>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#"
            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                Logout
            </a>
    </div>

   
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <meta name="description" content="Register now to get onboarded with eKomn. Fill in the required details to start your journey with us." />
  <meta name="keywords" content="register, eKomn, onboarding, business registration" />
  <link rel="stylesheet" href="assets/css//all.min.css" />
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body class="ek_db">
<div class="ek_nav">
  <div class="sidebar-header">
    <img src="assets/images/Logo.svg" alt="logo" height="40px">
  </div>
 @include('dashboard.layout.sidebarnavbar')
</div>
@include('dashboard.layout.topnavbar')
@include('dashboard.layout.section')
<script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="assets/js/ek.common.js"></script>
</body>
</html>

