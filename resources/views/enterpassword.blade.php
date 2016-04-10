<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
          <form method="GET" action="/walls/{wall}/enter">
            {{ csrf_field() }}
            <label for="password">Please provide the wall password:</label>
            <input type="text" id="password" name="password" required>
            <button type="submit">Enter</button>
          </endform>
        </div>
    </body>
</html>
