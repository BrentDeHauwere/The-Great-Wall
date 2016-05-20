@extends('masterlayout')

@section('title', 'Create Session')

@section('page','moderate')

@section('content')
	<div class="body_customized">
		<h1>Add Session</h1>

		<form class="ui form" action="{{action('SessionController@store')}}" method="post" enctype="multipart/form-data">

			<div class="field required">
				<label for="name">Name</label>
				<input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Name">
				@helper('name')
			</div>

			<div class="field required">
				<label for="name">Speaker</label>
				<div class="ui fluid selection dropdown required">
					<input type="hidden" name="speaker" value="{{ old('speaker') }}">
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
				<textarea id="description" type="text" name="description" placeholder="Description">{{ old('description') }}</textarea>
				@helper('description')
			</div>

			<div class="field">
				<label for="hashtag">Twitter Hashtag (only if session is not password protected)</label>
				<div class="ui labeled input">
					<div class="ui basic blue label">
						#
					</div>
					<input type="text" placeholder="TalkLaravel" name="hashtag" id="hashtag" value="{{ old('hashtag') }}">
				</div>
				@helper('hashtag')
			</div>

			<div class="field">
				<label for="tags">Tags</label>
				<div class="ui labels" id="tagrow">
					<a class="ui label">
						Talk
						<i class="delete icon"></i>
					</a>
					<a class="ui label">
						EHackB
						<i class="delete icon"></i>
					</a>
				</div>
				<div class="ui right labeled left icon input">
					<i class="tags icon"></i>
					<input type="text" placeholder="Your tag" id="tagInputField">
					<a class="ui tag label" id="addTagButton">
						Add Tag
					</a>
				</div>
				<input type="hidden" value="Talk;EHackB;" name="tags" id="tagForm">
				</input>
			</div>

			<div class="field">
				<label for="image">Image</label>
				<input id="image" type="file" name="image" value="{{ old('image') }}">
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
				<input id="open_until" type="datetime-local" name="open_until" value="{{ old('open_until') }}" placeholder="Open until">
				@helper('open_until')
			</div>

			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<button class="ui button primary right floated" type="submit">Submit</button>
		</form>
	</div>
@endsection

@section('footer')
	<script>
		$("#addTagButton").click(function() {
			var input = $("#tagInputField").val();
			var output = '<a class="ui label">' +  input + '<i class="delete icon"></i></a>';
			if (input != ""){
				$( "#tagrow" ).prepend(output);
				$( "#tagForm" ).val($("#tagForm").val() + input + ";");
				$( "#tagInputField" ).val("");
			}
		});

		$(".delete").click(function(){
			$(this).parent().remove();
			var value = $("#tagForm").val();
			value.replace($(this).val(), '');
			console.log($(this));
		});
	</script>
@endsection
