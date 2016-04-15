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
            @if (empty($error))
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-lock"></span>
            @else
            <span class="input-group-addon alert-danger">
              <span class="glyphicon glyphicon-remove "></span>
              @endif
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
@stop
