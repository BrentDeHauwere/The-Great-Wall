@extends('masterlayout')

@section('title', 'Create a Wall')

@section('content')
<form action="/walls/store" method="POST">
  {{ csrf_field() }}
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" name="name" required>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="text" class="form-control" name="password">
    <p class="help-block">A password is optional, but recommended.</p>
  </div>
  <button type="submit" class="btn btn-primary">Create Wall</button>
</form>

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@stop
