@extends("masterlayout")

@section('header')
    <link rel="stylesheet" type="text/css" href="/css/messagewall.css">
    <script src="/js/moment.min.js"></script>
    <script src="/js/moment-timezone.min.js"></script>
    <script src="http://10.3.50.20:1338/socket.io/socket.io.js"></script>
    <script>
        var socket = io('http://10.3.50.20:1338');
        var userid = {{Auth::user()->id}};
        console.log(userid);
        socket.on('msg1.msg.{{$wall->id}}:App\\Events\\NewMessageEvent', function (data) {
            var date = moment(data.message.created_at + '+0000').fromNow();
            if (data.question == null) {
                var token = $("#token").val();
                console.log('Message: ');
                console.log(data);
                var e = '<div id="messageholder' + data.message.id + '" class="ui comments">';
                e += '<div class="ui raised segment">';
                e += '<div class="comment">';
                e += '<a class="avatar">';
                e += '<img src="/user_images/' + data.user.id + '" class="ui mini circular image">';
                e += '</a>';
                e += '<div class="content">';
                if (data.message.anonymous == 0) {
                    e += '<a class="author">' + data.user.name + '</a>';
                } else {
                    e += '<a class="author">Anonymous</a>';
                }
                e += '<div class="metadata">';
                e += '<span class="date">' + date + '</span>';
                e += '<div class="rating">';
                e += '<form method="POST" action="/votemessage">';
                e += '<button type="submit" class="ui icon button">';
                e += '<i id="iconholder' + data.message.id + '" class="star icon"></i>';
                e += '</button>';
                e += '<input type="hidden" name="_token" value="' + token + '">';
                e += '<input type=hidden name="message_id" value="' + data.message.id + '">';
                e += '<input type=hidden name="user_id" value="' + {{ Auth::user()->id }} + '">';
                e += '<span id="favholder' + data.message.id + '">' + data.message.count + ' Faves</span>';
                e += '</form>';
                e += '</div>';//rating
                e += '</div>';//metadata
                e += '<div class="text">';
                e += '<p>' + data.message.text + '</p>';
                e += '</div>';//text
                e += '</div>';//content
                e += '<div id="commentsholder' + data.message.id + '" class="comments">';
                e += '</div>';//comments
                e += '</div>';//comment
                e += '<form class="ui reply form" method="POST" action="/message">';
                e += '<input type="hidden" name="_token" value="' + token + '">';
                e += '<div class="field">';
                e += '<div class="ui action input">';
                e += '<div class="inline field" style="margin-bottom:7px;margin-top:7px;margin-right:14px;">';
                e += '<div class="ui input checkbox">';
                e += '<input type="hidden" name="anonymous value="0">';
                e += '<input type="checkbox" name="anonymous" value="1" tabindex="0">';
                e += '<label>Anonymous</label>';
                e += '</div>';//checkbox
                e += '</div>';//inlinefield
                e += '<input type="text">';
                e += '<button class="ui blue right labeled icon button">';
                e += '<i class="edit icon"></i>';
                e += 'Add Reply';
                e += '</button>';
                e += '</div>';//field;
                e += '</div>';//actioninput
                e += '</form>';
                e += '</div>';//raisedsegment
                e += '</div>';//comments
                $(e).prependTo("#wallholder").hide().fadeIn(1500);
            }
            else if (data.question != null) {
                var token = $("#token").val();
                console.log('Answer: ');
                console.log(data);
                var e = '<div id="messageholder' + data.message.id + '" class="comment">';
                e += '<a class="avatar">';
                e += '<img src="/user_images/' + data.user.id + '" class="ui mini circular image">';
                e += '</a>';
                e += '<div class="content">';
                if (data.message.anonymous == 0) {
                    e += '<a class="author">' + data.user.name + '</a>';
                } else {
                    e += '<a class="author">Anonymous</a>';
                }
                e += '<div class="metadata">';
                e += '<span class="date">' + date + '</span>';
                e += '<div class="rating">';
                e += '<form method="POST" action="/votemessage">';
                e += '<button type="submit" class="ui icon button">';
                e += '<i id="iconholder' + data.message.id + '" class="star icon grey"></i>';
                e += '</button>';
                e += '<span id="favholder' + data.message.id + '">' + data.message.count + ' Faves</span>';
                e += '<input type="hidden" name="_token" value="' + token + '">';
                e += '<input type=hidden name="message_id" value="' + data.message.id + '">';
                e += '<input type=hidden name="user_id" value="' + {{ Auth::user()->id }} + '">';
                e += '</form>';
                e += '</div>';//rating
                e += '</div>';//metadata
                e += '<div class="text">';
                e += '<p>' + data.message.text + '</p>';
                e += '</div>';//text
                e += '</div>';//content
                e += '</div>';//comment
                console.log("#commentsholder" + data.question.id);
                console.log($("#commentsholder" + data.question.id).length);
                $(e).appendTo("#commentsholder" + data.question.id).hide().fadeIn(1500);
            }
        });
        socket.on('msg1.vote.msg.{{$wall->id}}:App\\Events\\NewMessageVoteEvent', function (data) {
            console.log(data);
            console.log("Message Vote: " + data);
            if (userid == data.user.id) {
                if ($("#iconholder" + data.message.id).hasClass("grey")) {
                    $("#iconholder" + data.message.id).removeClass("grey").addClass("blue");
                }
                else if ($("#iconholder" + data.message.id).hasClass("blue")) {
                    $("#iconholder" + data.message.id).removeClass("blue").addClass("grey");
                }
            }
            else {
                if ($("#iconholder" + data.message.id).hasClass("blue")) {
                    $("#iconholder" + data.message.id).removeClass("blue").addClass("grey");
                }
            }
            $("#favholder" + data.message.id).html(data.message.count + ' Faves');
        });
        socket.on('msg1.polls.{{$wall->id}}:App\\Events\\NewPollEvent', function (data) {
            var date = moment(data.poll.created_at + '+0000').fromNow();
            var token = $("#token").val();
            console.log('Poll: ');
            console.log(data);
            var e = '<div id="pollholder' + data.poll.id + '"class="ui comments">';
            e += '<div class="ui raised segment">';
            e += '<div class="comment">';
            e += '<a class="avatar">';
            e += '<img src="/user_images/' + data.user.id + '" class="ui mini circular image">';
            e += '</a>';
            e += '<div class="content">';
            e += '<a class="author">' + data.user.name + '</a>';
            e += '<div class="metadata">';
            e += '<span class="date">' + date + '</span>';
            e += '</div>';//metadata
            e += '<div class="text">';
            e += '<p>' + data.poll.question + '</p>';
            e += '</div>';//text
            e += '<div id="choicesholder' + data.poll.id + '" class="actions group">';
            e += '</div>';//content
            e += '</div>';//group
            e += '</div>';//comment
            if (data.poll.addable == 1) {
                e += '<form class="ui reply form" method="POST" action="/poll" style="margin-top:20px;">';
                e += '<input type="hidden" name="_token" value="' + token + '">';
                e += '<div class="field">';
                e += '<div class="ui action input">';
                e += '<input type="text">';
                e += '<button class="ui blue right labeled icon button">';
                e += '<i class="edit icon"></i>';
                e += 'Add Option';
                e += '</button>';
                e += '</div>';//field;
                e += '</div>';//actioninput
                e += '</form>';
            }
            e += '</div>';//raisedsegment
            e += '</div>';//comments
            $(e).prependTo("#wallholder").hide().fadeIn(1500);

        });
        socket.on('msg1.choice.polls.{{$wall->id}}:App\\Events\\NewPollChoiceEvent', function (data) {
            console.log(data);
            console.log("Poll Choice: " + data);
            var token = $("#token").val();
            var e = '<form method="POST" action="/votepoll">';
            e += '<div id="choiceholder' + data.poll_choice.id + '" class="ui indicating progress success progress_jquery" data-percent="' + data.poll_choice.count + '">';
            e += '<input type="hidden" name="_token" value="' + token + '">';
            e += '<input type="hidden" name="poll_choice_id" value="' + data.poll_choice.id + '">';
            console.log(userid);
            e += '<input type="hidden" name="user_id" value="' + {{  Auth::user()->id }} + '">';
            if (data.voted == true) {
                e += '<button type="submit" class="choiceButton ui icon button" disabled>';
                e += '<i class="check cirlce outline icon"></i>';
            }
            else {
                e += '<button type="submit" class="choiceButton ui icon button">';
                e += '<i class="radio icon"></i>';
            }
            e += '</button>';
            e += '<div class="bar">';
            e += '<div class="progress"></div>';
            e += '</div>';//bar
            e += '<div class="label">' + data.poll_choice.text + '</div>';
            e += '</div>';//progress
            e += '</form>';

            console.log(e);
            console.log($('#choicesholder' + data.poll.id).length);
            $(e).appendTo('#choicesholder' + data.poll.id).hide().fadeIn(1500);
        });
        socket.on('msg1.vote.polls.{{$wall->id}}:App\\Events\\NewPollVoteEvent', function (data) {
            console.log(data);
            console.log("Poll Vote: " + data);
            $("#choiceholder" + data.poll_choice.id).progress({
                percent: data.count
            });
            if (data.voted == true) {
                console.log("true");
                if ($("#choiceholder" + data.poll_choice.id).find("i").hasClass("radio")) {
                    $("#choiceholder" + data.poll_choice.id).find("i").removeClass("radio").addClass("check circle outline");
                }
            }
            else {
                if ($("#choiceholder" + data.poll_choice.id).find("i").hasClass("check circle outline")) {
                    $("#choiceholder" + data.poll_choice.id).find("i").removeClass("check circle outline").addClass("radio");
                }
            }
        });
        socket.on('msg1.moda.msg.{{$wall->id}}:App\\Events\\NewMessageModeratorAcceptedEvent', function (data) {
            console.log(data);
            console.log("Moderator Message Accepted: " + data);
            var date = moment(data.message.created_at + '+0000').fromNow();
            if (data.question == null) {
                var token = $("#token").val();
                console.log('Message: ');
                console.log(data);
                var e = '<div id="messageholder' + data.message.id + '" class="ui comments">';
                e += '<div class="ui raised segment">';
                e += '<div class="comment">';
                e += '<a class="avatar">';
                e += '<img src="/user_images/' + data.user.id + '" class="ui mini circular image">';
                e += '</a>';
                e += '<div class="content">';
                if (data.message.anonymous == 0) {
                    e += '<a class="author">' + data.user.name + '</a>';
                } else {
                    e += '<a class="author">Anonymous</a>';
                }
                e += '<div class="metadata">';
                e += '<span class="date">' + date + '</span>';
                e += '<div class="rating">';
                e += '<form method="POST" action="/votemessage">';
                e += '<button type="submit" class="ui icon button">';
                e += '<i id="iconholder' + data.message.id + '" class="star icon"></i>';
                e += '</button>';
                e += '<input type="hidden" name="_token" value="' + token + '">';
                e += '<input type=hidden name="message_id" value="' + data.message.id + '">';
                e += '<input type=hidden name="user_id" value="' + {{ Auth::user()->id }} + '">';
                e += '<span id="favholder' + data.message.id + '">' + data.message.count + ' Faves</span>';
                e += '</form>';
                e += '</div>';//rating
                e += '</div>';//metadata
                e += '<div class="text">';
                e += '<p>' + data.message.text + '</p>';
                e += '</div>';//text
                e += '</div>';//content
                e += '<div id="commentsholder' + data.message.id + '" class="comments">';
                e += '</div>';//comments
                e += '</div>';//comment
                e += '<form class="ui reply form" method="POST" action="/message">';
                e += '<input type="hidden" name="_token" value="' + token + '">';
                e += '<div class="field">';
                e += '<div class="ui action input">';
                e += '<div class="inline field" style="margin-bottom:7px;margin-top:7px;margin-right:14px;">';
                e += '<div class="ui input checkbox">';
                e += '<input type="hidden" name="anonymous value="0">';
                e += '<input type="checkbox" name="anonymous" value="1" tabindex="0">';
                e += '<label>Anonymous</label>';
                e += '</div>';//checkbox
                e += '</div>';//inlinefield
                e += '<input type="text">';
                e += '<button class="ui blue right labeled icon button">';
                e += '<i class="edit icon"></i>';
                e += 'Add Reply';
                e += '</button>';
                e += '</div>';//field;
                e += '</div>';//actioninput
                e += '</form>';
                e += '</div>';//raisedsegment
                e += '</div>';//comments
                $(e).prependTo("#wallholder").hide().fadeIn(1500);
            }
            else if (data.question != null) {
                var token = $("#token").val();
                console.log('Answer: ');
                console.log(data);
                var e = '<div id="messageholder' + data.message.id + '" class="comment">';
                e += '<a class="avatar">';
                e += '<img src="/user_images/' + data.user.id + '" class="ui mini circular image">';
                e += '</a>';
                e += '<div class="content">';
                if (data.message.anonymous == 0) {
                    e += '<a class="author">' + data.user.name + '</a>';
                } else {
                    e += '<a class="author">Anonymous</a>';
                }
                e += '<div class="metadata">';
                e += '<span class="date">' + date + '</span>';
                e += '<div class="rating">';
                e += '<form method="POST" action="/votemessage">';
                e += '<button type="submit" class="ui icon button">';
                e += '<i id="iconholder' + data.message.id + '" class="star icon"></i>';
                e += '</button>';
                e += '<span id="favholder' + data.message.id + '">' + data.message.count + ' Faves</span>';
                e += '<input type="hidden" name="_token" value="' + token + '">';
                e += '<input type=hidden name="message_id" value="' + data.message.id + '">';
                e += '<input type=hidden name="user_id" value="' + {{ Auth::user()->id }} + '">';
                e += '</form>';
                e += '</div>';//rating
                e += '</div>';//metadata
                e += '<div class="text">';
                e += '<p>' + data.message.text + '</p>';
                e += '</div>';//text
                e += '</div>';//content
                e += '</div>';//comment
                console.log("#commentsholder" + data.question.id);
                console.log($("#commentsholder" + data.question.id).length);
                $(e).appendTo("#commentsholder" + data.question.id).hide().fadeIn(1500);
            }
        });
        socket.on('msg1.modd.msg.{{$wall->id}}:App\\Events\\NewMessageModeratorDeclinedEvent', function (data) {
            console.log(data);
            console.log("Moderator Message Declined: " + data);
            $("#messageholder" + data.message.id).fadeOut(1000).remove();
        });
        socket.on('msg1.moda.polls.{{$wall->id}}:App\\Events\\NewPollModeratorAcceptEvent', function (data) {
            console.log(data);
            console.log("Moderator Poll Accepted: " + data);
            var date = moment(data.poll.created_at + '+0000').fromNow();
            var token = $("#token").val();
            console.log('Poll: ');
            console.log(data);
            var e = '<div id="pollholder' + data.poll.id + '"class="ui comments">';
            e += '<div class="ui raised segment">';
            e += '<div class="comment">';
            e += '<a class="avatar">';
            e += '<img src="/user_images/' + data.user.id + '" class="ui mini circular image">';
            e += '</a>';
            e += '<div class="content">';
            e += '<a class="author">' + data.user.name + '</a>';
            e += '<div class="metadata">';
            e += '<span class="date">' + date + '</span>';
            e += '</div>';//metadata
            e += '<div class="text">';
            e += '<p>' + data.poll.question + '</p>';
            e += '</div>';//text
            e += '<div id="choicesholder' + data.poll.id + '" class="actions group">';
            e += '</div>';//content
            e += '</div>';//group
            e += '</div>';//comment
            if (data.poll.addable == 1) {
                e += '<form class="ui reply form" method="POST" action="/poll" style="margin-top:14px;">';
                e += '<input type="hidden" name="_token" value="' + token + '">';
                e += '<div class="field">';
                e += '<div class="ui action input">';
                e += '<input type="text">';
                e += '<button class="ui blue right labeled icon button">';
                e += '<i class="edit icon"></i>';
                e += 'Add Option';
                e += '</button>';
                e += '</div>';//field;
                e += '</div>';//actioninput
                e += '</form>';
            }
            e += '</div>';//raisedsegment
            e += '</div>';//comments
            $(e).prependTo("#wallholder").hide().fadeIn(1500);
        });
        socket.on('msg1.modd.polls.{{$wall->id}}:App\\Events\\NewPollModeratorDeclineEvent', function (data) {
            console.log(data);
            console.log("Moderator Poll Declined: " + data);
            $("#pollholder" + data.poll.id).fadeOut(1000).remove();
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.menu .item')
                    .tab()
            ;

            $('.ui.checkbox')
                    .checkbox()
            ;


            $('.tab').on('click', '.poll_option_add', function () {
                $(this).children().removeClass("plus icon");
                $(this).children().addClass("minus icon");
                $(this).removeClass("blue");
                $(this).addClass("red");

                $(this).removeClass("poll_option_add");
                $(this).addClass("poll_option_remove");

                $('<div class="field"><div class="ui action input poll_option"><input name="choices[]" type="text" placeholder="Answer"><button type="button" class="ui blue right icon button poll_option_add"> <i class="plus icon"></i> </button> </div> </div>')
                        .insertBefore('#poll_submit');
            });

            $('.tab').on('click', '.poll_option_remove', function () {
                $(this).closest('.field').remove();
            });

            $('.submitButton').click(function () {
                //alert($(this).closest("form").attr("action"));
                $.ajax({
                    method: "POST",
                    url: $(this).closest("form").attr("action"),
                    data: $(this).closest("form").serialize()
                });
                if($(this).prev().prop("tagName")=="INPUT")
                {
                    $(this).prev().val('');
                }
            });
        });
    </script>
@stop

@section('title', 'The Great Wall')

@section('page','home')

@section('content')
    <input type="hidden" id="token" value="{{ csrf_token() }}">
    <div class="body_customized">
        <h1>{{$wall->name}}</h1>

        @unless(Auth::user()->banned())
            <div class="ui top attached tabular menu">
                <a class="item active" data-tab="message">Post Message</a>
                <a class="item" data-tab="poll">Post Poll</a>
            </div>
            <div class="ui bottom attached tab segment" data-tab="message">
                <form method="POST" action="/message">
                    <div class="ui form">
                        <div class="field">
                            <label>Message</label>
                            <textarea rows="2" name="text"></textarea>
                        </div>
                        <div class="inline field group">
                            <div class="ui checkbox">
                                <input type="hidden" name="anonymous" value=0>
                                <input type="checkbox" name="anonymous" value="1" tabindex="0" class="hidden">
                                <label>Anonymous</label>
                            </div>
                            <button class="ui button primary right floated" type="submit">Submit</button>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="wall_id" value="{{$wall->id}}">
                    <input type="hidden" name="channel_id" value="{{1}}">
                </form>
            </div>
            <div class="ui bottom attached tab segment" data-tab="poll">
                <div class="ui form">
                    <form id="formPoll" method="POST" action="/poll">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="wall_id" value="{{$wall->id}}">
                        <input type="hidden" name="channel_id" value={{1}}>

                        <div class="field">
                            <label>Poll</label>
                            <textarea rows="2" name="question" placeholder="Question"></textarea>
                        </div>
                        <div class="field">
                            <label>Answers</label>
                            <div class="ui action input poll_option">
                                <input type="text" placeholder="Answer" name="choices[]">
                                <button type="button" class="ui blue right icon button poll_option_add">
                                    <i class="plus icon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="inline field group" id="poll_submit">
                            <div class="ui checkbox">
                                <input type="hidden" name="addable" value=0>
                                <input type="checkbox" name="addable" value=1 tabindex="0" class="hidden">
                                <label>Can add options</label>
                            </div>
                            <button class="ui button primary right floated" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        @endunless
        <br/>
        <div id="wallholder">
            @include("/wall/posts", array("posts" => $posts))
        </div>

        <div id="append"></div>
    </div>
@stop


@section('footer')
    <script text="text/javascript" src="{{ asset('js/messagewall.js') }}"></script>
    <script>
        var nextPage = 2;
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                console.log("botoom" + nextPage);
                var url = "/wall/update/{{ $wall->id }}";//$(location).attr('href');
                console.log(url);
                var request = $.ajax({
                    method: "GET",
                    url: url + "?page=" + nextPage,
                    contentType: "html",
                    success: function (html) {
                        nextPage += 1;
                        console.log("ajax done");
                        console.log(html);
                        $("#append").append(html);
                    }
                });
            }
        });
    </script>
@stop
