<script type="text/javascript" src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/ek.common.js')}}"></script>
    @yield('scripts')
<script>
    $(document).ready(function() {
        if ($('.dashboard-header').length > 0) {
            $('.dashboard-header ul').prepend('<li><a class="dropdown-item" href="{{ url('/') }}">Go To Website</a></li>');
        }
    });
  </script>
  </body>
</html>