<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <title>EhackB - @yield('title')</title>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="{{asset('/js/smoothscroll.js')}}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css"/>

    <!-- Semantic UI -->
    <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="css/customize_semantic.css">

    @yield('header')
    @yield('page-script')
  </head>
  <body>

    <div class="ui inverted segment noradius">
      <div class="ui inverted secondary pointing menu">
        <a class="active item" href="{{ route('home') }}">
          Home
        </a>
        <a class="item" href="{{ action('SessionController@index') }}">
          Moderate
        </a>
        <a class="item" href="{{ action('BlacklistController@index') }}">
          Blacklist
        </a>
        <div class="right menu">
          <div class="ui dropdown item">
            Username <i class="user icon"></i>
            <div class="menu">
              <a class="item">Logout</a>
              <a class="item">More</a>
              <a class="item">More</a>
            </div>
          </div>
        </div>
      </div>
    </div>

      @if(session()->has('success'))
        @success({{ session('success') }})
      @endif

      @if(session()->has('warning'))
        @warning({{ session('warning') }})
      @endif

      @if(session()->has('danger'))
        @danger({{ session('danger') }})
      @endif

      @if(session()->has('info'))
        @info({{ session('info') }})
      @endif

      @yield('content')
    </div>
    @yield('footer')

        <!-- Semantic UI -->
    <script src="semantic/dist/semantic.min.js"></script>
    <script src="js/customize_semantic.js"></script>
  </body>
</html>
