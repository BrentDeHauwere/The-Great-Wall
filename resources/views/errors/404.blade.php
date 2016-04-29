@extends('masterlayout')

@section('title', '404')

@section('page-script')
<style>
p, h1, marquee {
    font-family: "Comic Sans MS";
}
</style>
<script>
  var random_images_array = ["siege.jpeg", "team.jpg"];

  var num = Math.floor( Math.random() * imgAr.length );
  var img = imgAr[ num ];
  var imgStr = '<img src="' + img + '" alt = "error image">';
  document.write(imgStr); document.close();
</script>
@stop

@section('content')
<div class="text-center">
  <h1>Oh no!</h1>
  <p>You lost The Great Wall to the Mongols.</p>
  <img src="{{asset('img/team.jpg')}}" alt="Team Photo">
  <p>Error 404: Page not found.</p>
  <marquee behavior="alternate">
    <img src="{{asset('img/arco.png')}}" alt="Team Photo">
    GEEN PANIEK IK BEN STUDENTENVERTEGENWOORDIGER
  </marquee>
</div>
@stop
