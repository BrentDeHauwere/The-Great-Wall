@extends('masterlayout')

@section('title', '404')

@section('page-script')
<style>
p, h1, marquee {
    font-family: "Comic Sans MS";
}
</style>
@stop

@section('content')
<div class="text-center">
  <h1>Oh no!</h1>
  <p>You lost The Great Wall to the Mongols.</p>
  <img src="{{asset('img/team.jpg')}}" alt="Team Photo">
  <p>Error 404: Page not found.</p>
  <marquee behavior="alternate">Oopsie.</marquee>
</div>
@stop
