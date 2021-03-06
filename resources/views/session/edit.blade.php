@extends('masterlayout')

@section('title', 'Edit Session: ' . $wall->name)

@section('page','moderate')

@section('content')
	<div class="body_customized">
		<h1>Edit - {{ $wall->name }}</h1>

		<form class="ui form" action="{{action('SessionController@update', $wall->id)}}" method="post" enctype="multipart/form-data">

			<div class="field required">
				<label for="name">Name</label>
				<input id="name" type="text" name="name" value="{{ $wall->name }}" placeholder="Name">
				@helper('name')
			</div>

			<div class="field required">
				<label for="name">Speaker</label>
				<div class="ui fluid selection dropdown required">
					<input type="hidden" name="speaker" value="{{ $wall->user_id }}">
					<i class="dropdown icon"></i>
					<div class="default text">Select Speaker</div>
					<div class="menu">
						@foreach($speakers as $speaker)
							<div class="item" data-value="{{ $speaker->id }}">
								<img class="ui mini avatar image circular" src="{{ route('user_images', ['filename' => $speaker->id]) }}">
								{{ $speaker->name }}
							</div>
						@endforeach
					</div>
				</div>
				@helper('speaker')
			</div>

			<div class="field">
				<label for="description">Description</label>
				<textarea id="description" type="text" name="description" placeholder="Description">{{ $wall->description }}</textarea>
				@helper('description')
			</div>

			<div class="field">
				<label for="hashtag">Hashtag (only if session is not password protected)</label>
				<div class="ui labeled input">
					<div class="ui basic blue label">
						#
					</div>
					<input type="text" placeholder="TalkLaravel" name="hashtag" id="hashtag" value="{{ $wall->hashtag }}">
				</div>
				@helper('hashtag')
			</div>

			<div class="field">
				<label for="tags">Tags</label>
				<div class="ui tag labels" id="tagrow">
					@foreach($wall->tags as $tag)
						@if ($tag != null)
							<a class="ui label">
								{{$tag}}
								<i class="delete icon"></i>
							</a>
						@endif
					@endforeach
				</div>
				<div class="ui right labeled left icon input">
					<i class="tags icon"></i>
					<input type="text" placeholder="Your tag" id="tagInputField">
					<a class="ui tag label" id="addTagButton">
						Add Tag
					</a>
				</div>
				<input type="hidden" value="{{ implode(";", $wall->tags) }}" name="tags" id="tagForm">
				</input>
			</div>

			<div class="field">
				<label for="image">Image</label>
				<input id="image" type="file" name="image">
				@helper('image')
			</div>

			<div class="field">
				<label for="password">Password</label>
				<input id="password" type="password" name="password" placeholder="Password">
				@helper('password')
			</div>

			<div class="field">
				<label for="password_confirmation">Confirm password</label>
				<input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm password">
				@helper('password_confirmation')
			</div>

			<div class="field">
				<label for="open_until">Open until</label>
				<input id="open_until" type="datetime-local" name="open_until" value="{{ $wall->open_until }}" placeholder="Open until">
				@helper('open_until')
			</div>

			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<input type="hidden" name="_method" value="put">

			<button class="ui button primary right floated" type="submit">Submit</button>
		</form>
	</div>
@endsection

@section('footer')
	<script>
		$("#addTagButton").on("click", function() {
			var input = $("#tagInputField").val();
			var output = '<a class="ui label">' +  input + '<i class="delete icon"></i></a>';
			if (input != ""){
				$( "#tagrow" ).prepend(output);
				$( "#tagForm" ).val($("#tagForm").val() + input + ";");
				$( "#tagInputField" ).val("");
			}
		});

		$("#tagrow").on('click', '.delete', function(){
			var text = $(this).parent().text() + ";";
			console.log(text);
			$(this).parent().remove();
			$("#tagForm").val($("#tagForm").val().replace(text, ""));
		});
	</script>
@endsection
