<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EhackB - @yield('title')</title>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css"/>
    @yield('header')
    @yield('page-script')
  </head>
  <body>
    <div class="container">

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
  </body>
</html>
