<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <div class="container">
        <h1>Welcome Buyer, {{ Auth::user()->name }}</h1>
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
</html>
