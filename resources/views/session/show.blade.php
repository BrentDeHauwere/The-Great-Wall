@extends('masterlayout')

@section('title', 'Session')

@section('page','moderate')

@section('header')

@stop

@section('content')

    <script>
        $(document).ready(function () {
            $(window).resize(function () {
                $(".stackable").removeClass('four').removeClass('three').removeClass('two');
                if ($(window).width() < 1000) {
                    $(".stackable").addClass('two');
                }
                else if ($(window).width() < 1300) {
                    $(".stackable").addClass('three');
                }
                else {
                    $(".stackable").addClass('four');
                }
            });
        });
    </script>

    <div class="body_customized">
        @if(isset($wall))
            <h1>Session: {{ $wall->name }}</h1>
        @else
            <h1>
                Sessions:
                {{ $walls[0]->name }}
                @for($i = 1;$i < $walls->count();$i++)
                    {{ ", ".$walls[$i]->name}}
                @endfor
            </h1>
        @endif


        <div class="ui cards four stackable">
            @foreach($posts as $post)

                @if($post[0]=='m')
                    <div class="card">
                        <div class="content">
                            <img class="right floated mini ui image"
                                 src="http://semantic-ui.com/images/avatar/large/elliot.jpg">
                            <div class="header">
                                {{ \App\User::find($post[1]->user_id)->name }}
                            </div>
                            <div class="meta">
                                {{ $post[1]->wall->name }}
                            </div>
                            <div class="description">
                                {{ $post[1]->text }}
                                @if($post[1]->question)
                                    <div class="ui divider"></div>
                                    <div class="meta">Answer on message</div>
                                    {{$post[1]->question->text}}
                                @endif
                            </div>
                        </div>
                        <div class="extra content">

                            <div class="ui three buttons">
                                <button type="submit"
                                        class="ui basic green button {{ $post[1]->moderation_level == 0 ? "disabled" : "" }}"
                                        form="{{ "M_{$post[1]->id}_A" }}">Approve
                                </button>
                                <button type="submit"
                                        class="ui basic red button {{ $post[1]->moderation_level == 1 ? "disabled" : "" }}"
                                        form="{{ "M_{$post[1]->id}_D" }}">Decline
                                </button>
                                <button class="ui basic grey button {{ in_array($post[1]->user_id, $blacklistedUserIDs) == 1 ? "disabled" : "" }}"
                                        form="{{ "M_{$post[1]->id}_B" }}">Block
                                </button>
                            </div>

                            <form method="post" action="{{ action('MessageController@accept') }}"
                                  id="{{ "M_{$post[1]->id}_A" }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="message_id" value="{{ $post[1]->id }}">
                            </form>
                            <form method="post" action="{{ action('MessageController@decline') }}"
                                  id="{{ "M_{$post[1]->id}_D" }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="message_id" value="{{ $post[1]->id }}">
                            </form>
                            <form method="get" action="{{action('BlacklistController@create')}}"
                                  id="{{ "M_{$post[1]->id}_B" }}">
                                <input type="hidden" name="message_id" value="{{ $post[1]->id }}">
                            </form>
                        </div>
                    </div>

                @elseif($post[0]=='p')
                    <div class="card">
                        <div class="content">
                            <img class="right floated mini ui image"
                                 src="http://semantic-ui.com/images/avatar/large/steve.jpg">
                            <div class="header">
                                {{ \App\User::find($post[1]->user_id)->name }}
                            </div>
                            <div class="meta">
                                {{ $post[1]->wall->name }}
                            </div>
                            <div class="description">
                                {{ $post[1]->question }}
                            </div>
                        </div>
                        <div class="extra content">

                            <div class="ui three buttons">
                                <button type="submit"
                                        class="ui basic green button {{ $post[1]->moderation_level == 0 ? "disabled" : "" }}"
                                        form="{{ "P_{$post[1]->id}_A" }}">Approve
                                </button>
                                <button type="submit"
                                        class="ui basic red button {{ $post[1]->moderation_level == 1 ? "disabled" : "" }}"
                                        form="{{ "P_{$post[1]->id}_D" }}">Decline
                                </button>
                                <button class="ui basic grey button {{ in_array($post[1]->user_id, $blacklistedUserIDs) == 1 ? "disabled" : "" }}"
                                        form="{{ "P_{$post[1]->id}_B" }}">Block
                                </button>
                            </div>

                            <form method="post" action="{{ action('PollController@accept') }}"
                                  id="{{ "P_{$post[1]->id}_A" }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="poll_id" value="{{ $post[1]->id }}">
                            </form>
                            <form method="post" action="{{ action('PollController@decline') }}"
                                  id="{{ "P_{$post[1]->id}_D" }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="poll_id" value="{{ $post[1]->id }}">
                            </form>
                            <form method="get" action="{{action('BlacklistController@create')}}"
                                  id="{{ "P_{$post[1]->id}_B" }}">
                                <input type="hidden" name="poll_id" value="{{ $post[1]->id }}">
                            </form>
                        </div>
                    </div>

                    @if($post[1]->choices)
                        @foreach($post[1]->choices as $choice)
                            <div class="card">
                                <div class="content">
                                    <img class="right floated mini ui image"
                                         src="http://semantic-ui.com/images/avatar/large/stevie.jpg">
                                    <div class="header">
                                        {{ \App\User::find($post[1]->user_id)->name }}
                                    </div>
                                    <div class="meta">
                                        {{ $post[1]->wall->name }}
                                    </div>
                                    <div class="description">
                                        {{ $choice->text }}
                                        <div class="ui divider"></div>
                                        <div class="meta">
                                           Answer on poll
                                        </div>
                                        {{$post[1]->question}}
                                    </div>
                                </div>
                                <div class="extra content">

                                    <div class="ui three buttons">
                                        <h1>Work in progress</h1>
                                        <!--
                                        <button type="submit"
                                                class="ui basic green button {{ $post[1]->moderation_level == 0 ? "disabled" : "" }}"
                                                form="{{ "P_{$post[1]->id}_A" }}">Approve
                                        </button>
                                        <button type="submit"
                                                class="ui basic red button {{ $post[1]->moderation_level == 1 ? "disabled" : "" }}"
                                                form="{{ "P_{$post[1]->id}_D" }}">Decline
                                        </button>
                                        <button class="ui basic grey button {{ in_array($post[1]->user_id, $blacklistedUserIDs) == 1 ? "disabled" : "" }}"
                                                form="{{ "P_{$post[1]->id}_B" }}">Block
                                        </button>
                                        -->
                                    </div>

                                    <form method="post" action="{{ action('PollController@accept') }}"
                                          id="{{ "P_{$post[1]->id}_A" }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="poll_id" value="{{ $post[1]->id }}">
                                    </form>
                                    <form method="post" action="{{ action('PollController@decline') }}"
                                          id="{{ "P_{$post[1]->id}_D" }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="poll_id" value="{{ $post[1]->id }}">
                                    </form>
                                    <form method="get" action="{{action('BlacklistController@create')}}"
                                          id="{{ "P_{$post[1]->id}_B" }}">
                                        <input type="hidden" name="poll_id" value="{{ $post[1]->id }}">
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endif
            @endforeach
        </div>
    </div>
@stop
