<div class="comment-card">
    <a href={{route('user', $comment->user()->username)}}>
        <div class="profile-picture-sm" style="width:60px;">
            {{$comment->user()->image()}}
        </div>
        <div style="display:inline-block;color:var(--jay-blue-deeper);font-family:'Bookman';font-size:26px;">
            {{$comment->user()->username}}
        </div>
        <div style="display:inline-block;margin-left:12px;color:var(--jay-deep-blue-gray)">
            @unless($comment->created_at == $comment->updated_at)
                edited {{$comment->updated_at->diffForHumans()}}
            @else
                posted {{$comment->created_at->diffForHumans()}}
            @endunless
        </div>
    </a>
    <div style="display:flex;">
        {{$comment->body}}
    </div>
</div>