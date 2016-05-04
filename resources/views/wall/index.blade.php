@extends('masterlayout')

@section('title', 'Walls')

@section('content')

  <!--@if (session('error'))
      <div class="alert alert-danger">
          {{ session('error') }}
      </div>
  @endif-->

  @foreach ($walls as $wall)
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-3">
          <h4 class="wallname">{{ $wall->name }}
            <br>
            <small>{{ $wall->username }}</small>
          </h4>
        </div>
        @if (!empty($wall->password))
        <div class="col-sm-offset-3 col-sm-6">
            <form action="{{ action('WallController@enterWallWithPassword') }}" method="POST">
              <div class="input-group">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-lock"></span>
                </span>
                {{ csrf_field() }}
                <input type="password" class="form-control wallpassword" name="password" placeholder="Password" required>
                <input type="hidden" name="wall_id" value="{{$wall->id}}">
                <span class="input-group-btn">
                  <button class="btn btn-default btn-block btn-slide" type="submit">Enter</button>
                </span>
              </div>
            </form>
        </div>
        @else
        <div class="col-sm-2 col-sm-offset-7">
          <form action="{{ action('WallController@show', ['wall_id' => $wall->id]) }}" method="GET">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button class="btn btn-default btn-block" type="submit">Enter</button>
          </form>
        </div>
        @endif
      </div>
    </div>
  </div>
  @endforeach
@stop
