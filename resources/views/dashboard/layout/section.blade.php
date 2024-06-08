

<div class="ek_dashboard">
  <div class="card p-3 mb-2">
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
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe deserunt aspernatur sed voluptatibus quibusdam odit voluptate ex porro blanditiis obcaecati explicabo vero laboriosam impedit quia omnis, enim labore, debitis maiores.
  </div>
  <div class="card p-3 mb-2">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe deserunt aspernatur sed voluptatibus quibusdam odit voluptate ex porro blanditiis obcaecati explicabo vero laboriosam impedit quia omnis, enim labore, debitis maiores.
  </div>
  <div class="card p-3">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe deserunt aspernatur sed voluptatibus quibusdam odit voluptate ex porro blanditiis obcaecati explicabo vero laboriosam impedit quia omnis, enim labore, debitis maiores.
  </div>
</div>