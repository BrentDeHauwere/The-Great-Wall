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
  <p>We lost The Great Wall to the Mongols. :(</p>
  <img src="{{asset('img/team.jpg')}}" alt="Team Photo">
  <marquee behavior="alternate">
    <img src="{{asset('img/arco.png')}}" alt="Team Photo">
    GEEN PANIEK IK BEN STUDENTENVERTEGENWOORDIGER
  </marquee>
  <p>Error 404: Page not found.</p>
</div>
@stop
