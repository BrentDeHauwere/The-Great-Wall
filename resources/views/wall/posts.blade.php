@foreach($posts as $post)
    @if($post[0]=='m' && empty($post[1]->question_id))
        <div id="messageholder{{$post[1]->id}}" class="ui comments">
            <div class="ui raised segment">
                <div class="comment">
                    <a class="avatar">
                        <img src="{{ route('user_images', ['filename' => Auth::user()->id]) }}"
                             class="ui mini circular image">
                    </a>
                    <div class="content">
                        <a class="author">
                            @if($post[1]->anonymous==0)
                                {{$post[1]->user()->first()->name}}
                            @else
                                Anonymous
                            @endif
                        </a>
                        <div class="metadata">
                            <span class="date">{{\App\Http\Controllers\WallController::humanTimeDifference($post[1]->created_at)}}</span>
                            <div class="rating">
                                @if(Auth::user()->messageVotes()->where('message_id', $post[1]->id)->first())
                                    <form method="POST" action="/votemessage">
                                        <button type="submit" class="ui icon button">
                                            <i id="iconholder{{$post[1]->id}}" class="star icon blue"></i>
                                        </button>
                                        @if($post[1]->count!=1)
                                            <span id="favholder{{$post[1]->id}}">{{$post[1]->count}} Faves</span>
                                        @else
                                            <span id="favholder{{$post[1]->id}}">{{$post[1]->count}} Fave</span>
                                        @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="message_id" value="{{$post[1]->id}}">
                                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    </form>
                                @else
                                    <form method="POST" action="/votemessage">
                                        <button type="submit" class="ui icon button">
                                            <i id="iconholder{{$post[1]->id}}" class="star icon grey"></i>
                                        </button>
                                        @if($post[1]->count!=1)
                                            <span id="favholder{{$post[1]->id}}">{{$post[1]->count}} Faves</span>
                                        @else
                                            <span id="favholder{{$post[1]->id}}">{{$post[1]->count}} Fave</span>
                                        @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="message_id" value="{{$post[1]->id}}">
                                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="text">
                            <p>{{$post[1]->text}}</p>
                        </div>
                    </div>
                    {{-- Answers on message --}}
                    <div id="commentsholder{{$post[1]->id}}" class="comments">
                        <?php $answercounter = 0 ?>
                        @foreach($post[1]->answers->where('moderation_level',0) as $answer)
                            <div id="messageholder{{$answer->id}}" class="comment">
                                <a class="avatar">
                                    <img src="{{ route('user_images', ['filename' => Auth::user()->id]) }}"
                                         class="ui mini circular image">
                                </a>
                                <div class="content">
                                    <a class="author">
                                        @if($answer->anonymous==0)
                                            {{$answer->user()->first()->name}}
                                        @else
                                            Anonymous
                                        @endif
                                    </a>
                                    <div class="metadata">
                                        <span class="date">{{\App\Http\Controllers\WallController::humanTimeDifference($answer->created_at)}}</span>
                                        <div class="rating blue">
                                            @if(Auth::user()->messageVotes()->where('message_id', $answer->id)->first())
                                                <form method="POST" action="/votemessage">
                                                    <button type="submit" class="ui icon button">
                                                        <i class="star icon blue"></i>
                                                    </button>
                                                    @if($answer->count!=1)
                                                        <span id="favholder{{$answer->id}}">{{$answer->count}}
                                                            Faves</span>
                                                    @else
                                                        <span id="favholder{{$answer->id}}">{{$answer->count}}
                                                            Fave</span>
                                                    @endif
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="message_id" value="{{$answer->id}}">
                                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                </form>
                                            @else
                                                <form method="POST" action="/votemessage">
                                                    <button type="submit" class="ui icon button">
                                                        <i class="star icon grey"></i>
                                                    </button>
                                                    @if($answer->count!=1)
                                                        <span id="favholder{{$answer->id}}">{{$answer->count}}
                                                            Faves</span>
                                                    @else
                                                        <span id="favholder{{$answer->id}}">{{$answer->count}}
                                                            Fave</span>
                                                    @endif
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="message_id" value="{{$answer->id}}">
                                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text">
                                        {{$answer->text}}
                                    </div>
                                </div>
                            </div>
                            <?php $answercounter += 1; ?>
                        @endforeach
                    </div>
                </div>

                {{-- Antwoorden op een message --}}
                @unless(Auth::user()->banned())
                    <form class="ui reply form" method="POST" action="{{action("MessageController@store")}}">
                        <div class="field">
                            <div class="ui action input">
                                <div class="inline field"
                                     style="margin-bottom: 7px;margin-top: 7px;margin-right: 14px;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="question_id" value="{{$post[1]->id}}">
                                    <input type="hidden" name="channel_id" value="{{1}}">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="wall_id" value="{{$wall->id}}">

                                    <div class="ui input checkbox">
                                        <input type="hidden" name="anonymous" value="0" tabindex="0">
                                        <input type="checkbox" name="anonymous" value="1" tabindex="0">
                                        <label>Anonymous</label>
                                    </div>
                                </div>
                                <input type="text" name="text">
                                <button type="submit" class="ui blue right labeled icon button">
                                    <i class="edit icon"></i>
                                    Add Reply
                                </button>
                            </div>
                        </div>
                    </form>
                @endunless
            </div>
        </div>
    @elseif($post[0]=='p')
        <div id="pollholder{{$post[1]->id}}" class="ui comments">
            <div class="ui raised segment">
                <div class="comment">
                    <a class="avatar">
                        <img src="{{ route('user_images', ['filename' => Auth::user()->id]) }}"
                             class="ui mini circular image">
                    </a>
                    <div class="content">
                        <a class="author">Elliot Fu</a>
                        <div class="metadata">
                            <span class="date">
                                {{\App\Http\Controllers\WallController::humanTimeDifference($post[1]->created_at)}}
                            </span>
                        </div>
                        <div class="text">
                            <p>{{$post[1]->question}}</p>
                        </div>
                        <div id="choicesholder{{$post[1]->id}}"
                             class="actions group">

                            <?php
                            $total = 0;
                            foreach ($post[1]->choices->where('moderation_level', 0) as $choice) {
                                $total += $choice->count;
                            }
                            $already = 0;

                            $percArr = array();
                            foreach ($post[1]->choices as $choice) {
                                if ($total != 0) {
                                    $percentage = round($choice->count / $total * 100);
                                    $already += $percentage;
                                } else {
                                    $percentage = 0;
                                }
                                array_push($percArr, $percentage);
                            }
                            arsort($percArr);
                            if ($already > 100) {
                                $percArr[0] -= $already - 100;
                            }
                            ?>
                            <?php $counter = 0 ?>
                            @foreach($post[1]->choices->sortByDesc('count') as $choice)
                                @if(Auth::user()->banned())
                                    <div id="choiceholder{{$choice->id}}"
                                         class="ui indicating progress success progess_jquery"
                                         data-percent={{$percArr[$counter]}}>
                                        <button  class="choiceButton ui disabled icon button">
                                            <i class="ban icon"></i>
                                        </button>
                                        <div class="bar">
                                            <div class="progress"></div>
                                        </div>
                                        <div class="label">{{$choice->text}}</div>
                                    </div>
                                @else
                                    @if(Auth::user()->pollVotes()->where('poll_choice_id', $choice->id)->first())
                                        <form method="POST" action="/votepoll">
                                            <div id="choiceholder{{$choice->id}}"
                                                 class="ui indicating progress success progess_jquery"
                                                 data-percent={{$percArr[$counter]}}>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="poll_choice_id" value={{$choice->id}}>
                                                <input type="hidden" name="user_id" value={{Auth::user()->id}}>
                                                <button type="submit" class="choiceButton ui icon button">
                                                    <i class="check circle outline icon"></i>
                                                </button>
                                                <div class="bar">
                                                    <div class="progress"></div>
                                                </div>
                                                <div class="label">{{$choice->text}}</div>
                                            </div>
                                        </form>
                                    @else
                                        <form method="POST" action="/votepoll">
                                            <div id="choiceholder{{$choice->id}}"
                                                 class="ui indicating progress success progess_jquery"
                                                 data-percent={{$percArr[$counter]}}>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="poll_choice_id" value={{$choice->id}}>
                                                <input type="hidden" name="user_id" value={{Auth::user()->id}}>
                                                <button type="submit" class="choiceButton ui icon button">
                                                    <i class="radio icon"></i>
                                                </button>
                                                <div class="bar">
                                                    <div class="progress"></div>
                                                </div>
                                                <div class="label">{{$choice->text}}</div>
                                            </div>
                                        </form>
                                    @endif
                                @endif
                                <?php $counter += 1 ?>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if($post[1]->addable && !Auth::user()->banned())
                    <form method="POST" action="{{ action("PollChoiceController@store") }}" class="ui reply form"
                          style="margin-top: 14px;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_id" value={{1}}>
                        <input type="hidden" name="poll_id" value={{$post[1]->id}}>
                        <input type="hidden" name="channel_id" value="{{1}}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="wall_id" value="{{$wall->id}}">

                        <div class="field">
                            <div class="ui action input">
                                <input type="text" name="text">
                                <button type="submit" class="ui blue right labeled icon button">
                                    <i class="edit icon"></i>
                                    Add Option
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
@endforeach

<script>
    $(document).ready(function () {
        $('.progess_jquery').progress();
    })
</script>
