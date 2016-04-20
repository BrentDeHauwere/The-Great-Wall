@extends('masterlayout')

@section('title', 'Walls')

@section('content')

  @if (session('error'))
      <div class="alert alert-danger">
          {{ session('error') }}
      </div>
  @endif

  @foreach ($walls as $wall)
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-3">
          <p>{{ $wall->name }}</p>
        </div>
        @if (!empty($wall->password))
        <div class="col-sm-offset-3 col-sm-6">
          <div class="input-group">
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-lock"></span>
            </span>
            <form action="/walls/{{ $wall->id }}" method="POST">
              {{ csrf_field() }}
              <input type="text" class="form-control" placeholder="Password">
              <span class="input-group-btn">
                <button class="btn btn-secondary btn-block" type="button">Enter</button>
              </span>
            </form>
          </div>
        </div>
        @else
        <div class="col-sm-2 col-sm-offset-7">
          <form action="/walls/{{ $wall->id }}" method="POST">
            {{ csrf_field() }}
            <button class="btn btn-secondary btn-block" type="submit">Enter</button>
          </endform>
        </div>
        @endif
      </div>
    </div>
  </div>
  @endforeach
  <form method="GET" action="/walls/new">
    <button type="submit" class="btn btn-primary">Create Wall</button>
  </form>
  <p>Pas deze button aan wanneer we een user kunnen checken via CAPI.</p>
@stop
