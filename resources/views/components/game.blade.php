@extends('layouts.app')
@section('content')

    <div class="outside-1">
        <div class="cool-card-1 mb-4 pb-8" id='game-card' style="width:{{$game->width}}px;min-width:400px;height:calc({{$game->height}}px + 300px);border-radius:0 0 5px 5px;overflow:hidden;position:relative;">
            <iframe
                id="gameframe"
                src={{ asset($game->source) }}
                allowFullScreen={{$game->fullscreen}}
                style={{"width:$game->width\px;height:$game->height\px;background-color:var(--div-dark-darker);"}}
                normalwidth="{{$game->width}}"
                normalheight="{{$game->height}}"
                sandbox="allow-scripts allow-same-origin"
                frameBorder="0"
                referrerpolicy="origin"
                about={{$game->user()->username . "/" . str_replace(" ", "%20", $game->name)}}       
            ></iframe>

            <div class="left-game-column">

                <div class="game-title">
                    {{$game->name}}
                </div>

                <div id='liker-container' style="display:inline-block;margin-top:5px;resize:horizontal;position:relative;top:8px;">
                    <div id='game-liker' class="hidden">
                        <form action="xhrPostLike" id="game-like-form" method="post">
                            @csrf
                            <button class="bold-btn-1 scale-up-effect" style="resize:horizontal;">
                                <div style="width:35px;margin:0;padding:0;display:inline-block;position:relative;top:3px;">
                                    <x-antdesign-like />
                                </div>
                                <div style="display:inline-block;position:relative;bottom:3px;padding-right:5px;">
                                    LIKE
                                </div>
                            </button>
                        </form>
                    </div>

                    <div id='game-unliker' class="hidden">
                        <form action="xhrDeleteLike" id="game-unlike-form" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="bold-btn-1 scale-up-effect" style="background-color:var(--jay-blue);color:black;resize:horizontal;">
                                <div style="width:35px;margin:0;padding:0;display:inline-block;position:relative;top:3px;">
                                    <x-antdesign-like />
                                </div>
                                <div style="display:inline-block;position:relative;bottom:3px;padding-right:5px;">
                                    LIKED
                                </div>
                            </button>
                        </form>
                    </div>
                </div>

                <div id="like-counter" style="display: inline;">
                    @if ($game->likes()->count())
                        {{ $game->likes()->count() }} {{ Str::plural('Like', $game->likes()->count()) }}
                    @endif
                </div>

                <script src="{{ asset('js/gamePageLiker.js')}}"></script>

                <script>
                    document.getElementById('game-like-form').addEventListener('submit', xhrPostLike);

                    function xhrPostLike(e) {
                        e.preventDefault();

                        clickLike();

                        // Create XHR Object
                        var xhr = new XMLHttpRequest();   
                        // open : type, url, isAsync
                        xhr.open('POST', "<?php echo Route('game.likes', [$game, auth()->id()]); ?>", true);
                        xhr.onload = function() {
                            console.log(this.responseURL);
                            console.log(this.responseXML);

                            if (this.status !== 200) {
                                console.log(this.statusText);
                                clickUnlike();
                            }
                        }

                        xhr.send();
                    }

                    document.getElementById('game-unlike-form').addEventListener('submit', xhrDeleteLike);

                    function xhrDeleteLike(e) {
                        e.preventDefault();

                        clickUnlike();

                        // Create XHR Object
                        var xhr = new XMLHttpRequest();   
                        // open : type, url, isAsync
                        xhr.open('DELETE', "<?php echo Route('game.likes', [$game, auth()->id()]); ?>", true);
                        xhr.onload = function() {
                            console.log(this.statusText);

                            if (this.status !== 200) {
                                console.log(this.statusText);
                                clickLike();
                            }
                        }

                        xhr.send();
                    }
                </script>

                @if (Auth::check())
                    @if ($game->likedBy(auth()->user()))
                        <script type="text/javascript">showUnliker();</script>
                    @else
                        <script type="text/javascript">showLiker();</script>
                    @endif
                @endif

                <div style="margin-bottom:16px;"> 
                    <a class="game-author" href="{{route('user', $game->user()->username)}}">
                        <div class="profile-picture-sm">
                            {{$game->user()->image()}}
                        </div>
                        <div style="display:inline-block;position:relative;bottom:16px;">
                            {{$game->user()->username}}
                        </div>
                    </a>
                </div>

            </div>

            <div class="right-game-column" style="padding-top:10px;">
                @if ($game->fullscreen===1)
                    <button class="bold-btn-1 scale-up-effect" style="float:right;margin-top:5px;" onclick="goFullscreen()">
                        FULLSCREEN
                    </button>
                @endif

                @if (Auth::check() && $game->user()->id===auth()->user()->id)
                    <a class="bold-btn-1 bold-icon-1 scale-up-effect" style="float:right;" href="{{ route('edit_game', [$game->user()->username, $game->name])}}">
                        <x-eos-edit />
                        EDIT
                    </a>
                    <a class="bold-btn-1 bold-icon-1 scale-up-effect" style="float:right;" href="{{ route('game_stats', [$game->user()->username, $game->name])}}">
                        <x-icomoon-stats-bars />
                        STATS
                    </a>
                @endif
            </div>

            <p class="game-detailed-description">
                {{$game->detailed_description}}
            </p>
            <div class="game-tags" style="display:flex;;width:100%;padding-right:20px;padding-left:20px;">
                @foreach($game->tags as $tag)
                    <a style="display:inline-block;margin-right:10px;" href={{route('search', "qry=%23$tag")}} name='qry'>#{{$tag}}</a>
                @endforeach
            </div>
            <div style="margin:24px;margin-bottom:0;color:var(--jay-deep-blue-gray)">
                Posted {{$game->created_at->diffForHumans()}}
                <br>
                @unless($game->created_at == $game->updated_at)
                    Last Updated {{$game->updated_at->diffForHumans()}}
                @endunless
            </div>

            <div style="display:flex;position:absolute;bottom:0;width:100%;height:30px;z-index:1;background:linear-gradient(transparent, var(--div-dark-darker));" id="text-fade"></div>
            <button style="display:flex;position:absolute;bottom:10px;left:30px;opacity:88%;z-index:2;background-color:black;border-radius:5px;padding:5px;text-decoration:underline;" onclick="seeMore()" id="see-more">See more</button>
        </div>

    </div>

    <div class="outside-1" style="margin-top:40px">
        <div class="cool-card-1 neon-border-lg" style="overflow:wrap;width:{{$game->width}}\px;max-width:1200px;">

            <div style="margin:50px;font-size:20px;text-decoration:underline;">
                Comments:
            </div>

            <form action="xhrPostComment" id="game-comment-form" method="post">
                @csrf
                <div class="nice-input-2 neon-border-1 comment-div" style="margin-top:0;">
                    <label for="comment_body" class="sr-only"></label>
                    <textarea id='comment_body' name='comment_body' class="comment-textarea" maxlength="1000" placeholder="Write a comment as {{auth()->user()->username}}..."></textarea>
                    <button id="comment-submit" class='comment-submit' style="display:flex;outline:none;" disabled>
                        Submit
                    </button>
                </div>            
            </form>

            <div id='append-comment-bank'></div>

            <script type='text/javascript'>
                var commentId;
            </script>

            @foreach ($game->orderedComments as $comment)
                <x-comment_card :comment="$comment" />
            @endforeach

            <script src="{{asset('js/gameCommenter.js')}}"></script>
            <script>
        
                document.getElementById('game-comment-form').addEventListener('submit', xhrPostComment);

                const commentTextarea = document.getElementById('comment_body');
                function commentBody() {
                    return commentTextarea.value;
                }

                function xhrPostComment(e) {
                    e.preventDefault();
                    var comment = commentBody();
                    resetTextarea();
                    if (commentIsValid(comment)) {
                        addComment(comment, "<?php echo auth()->user()->username; ?>", "<?php echo auth()->user()->image(); ?>", "<?php echo route('user', auth()->user()->username); ?>");
                        // Create XHR Object
                        var xhr = new XMLHttpRequest();
                        // open : type, url, isAsync
                        var route = "<?php echo Route('game.post-comment', [$game, auth()->id(), '']); ?>";
                        console.log(route);
                        route += `/${encodeURIComponent(comment)}`;
                        console.log(route);
                        xhr.open('POST', route, true);
                        xhr.onload = function() {
                            if (this.status !== 200) {
                                console.log(this.statusText);
                            }
                        }
                        xhr.send();
                    }

                }

                const commentSubmitButton = document.getElementById('comment-submit');
                commentTextarea.addEventListener('input', controlSubmitButton);
                function controlSubmitButton() {
                    if (commentIsValid(commentBody())) {
                        commentSubmitButton.removeAttribute('disabled');
                    } else {
                        commentSubmitButton.setAttribute('disabled', true);
                    }
                    commentTextarea.style.height = 'auto';
                    commentTextarea.style.height = commentTextarea.scrollHeight + 'px';
                }

                function resetTextarea() {
                    commentTextarea.value = '';
                    commentTextarea.style.height = 'auto';
                }
                
            </script>

        </div>
    </div>
    
    <script src="{{ asset('js/gameFrameControl.js')}}"></script>

@endsection