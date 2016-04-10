<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
          <ul>
            @foreach ($walls as $wall)
              <li><a href="/walls/{{ $wall->id }}">{{ $wall->name }} </a></li>
            @endforeach
          </ul>
        </div>
    </body>
</html>
