@extends('masterlayout')

@section('title', 'Walls')

@section('content')
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
            <form>
            <input type="text" class="form-control" placeholder="Password">
            <span class="input-group-btn">
              <button class="btn btn-secondary" type="button">Enter</button>
            </span>
          </form>
          </div>
        </div>
        @else
        <div class="col-sm-offset-8 col-sm-1">
          <form action="/walls/{{ $wall->id }}" method="get">
            <button class="btn btn-secondary" type="submit">Enter</button>
          </endform>
        </div>
        @endif
      </div>
    </div>
  </div>
  @endforeach
@stop
