<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Worldskills Project') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/navigation.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.datetimepicker.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.datetimepicker.full.js') }}"></script>
    <script>
        $(document).ready(function(){
            const time = new Date().toLocaleString("en-US", {timeZone: "Asia/Singapore"});
            const currentTime = new Date(time);

            $('#id_start').datetimepicker({
                format: 'Y-m-d H:i',
                minDate: currentTime,
                onSelectTime: function (time) {
                    if(time.getHours() <= currentTime.getHours()){
                        $('#submit').attr("disabled",true);
                    }
                    else {
                        $('#submit').attr("disabled",false);
                    }
                }
            });

            $('#id_end').datetimepicker({
                format: 'Y-m-d H:i',
                minDate: currentTime,
                onSelectTime: function (time) {
                    if(time.getHours() <= currentTime.getHours()+1){
                        $('#submit').attr("disabled",true);
                    }
                    else {
                        $('#submit').attr("disabled",false);
                    }
                }
            });

        });
    </script>
</head>
<body>

<div id="wrapper">
  <!-- Side bar -->
  @include('layouts.side-navigation')

  <div id="content">
  	<nav class="navbar navbar-dark bg-dark">
      <div class="container-fluid">
        <div class="navbar-header">
          {{-- <a class="navbar-brand" href="#">WorldSkills</a> --}}

          <a class="navbar-brand" href="{{ url('/') }}">
            {{-- {{ config('app.name', 'Laravel') }} --}}
            WorldSkills
          </a>
        </div>
          <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
              @guest
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                      </li>
                  @endif
              @else
                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }} <span class="caret"></span>
                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                              {{ __('Logout') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                          </form>
                      </div>
                  </li>
              @endguest
          </ul>
      </div>
    </nav>

    <div id="content-main">
      @yield('content')
    </div>

  </div><!-- End of content -->
</div><!-- End of wrapper -->

<!-- Scripts -->

</body>

</html>
