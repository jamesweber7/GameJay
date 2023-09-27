<div class='comment-card' id='comment-card-{{$comment->id}}'>
    <a href={{route('user', $comment->user()->username)}}>
        <div class="profile-picture-sm" style="width:60px;">
            {{$comment->user()->image()}}
        </div>
        <div style="display:inline-block;color:var(--jay-blue-deeper);font-family:'Bookman';font-size:26px;">
            {{$comment->user()->username}}
        </div>
    </a>
    <div class='comment-extras' style='display:inline-block;margin-left:12px;color:var(--jay-deep-blue-gray)'>
        @unless($comment->created_at == $comment->updated_at)
            edited {{$comment->updated_at->diffForHumans()}}
        @else
            posted {{$comment->created_at->diffForHumans()}}
        @endunless
        @if ($comment->user()->id === auth()->id())
            <div class='auth-edits' style='display: inline-block;'>
                <button class='comment-edit-icon' onclick="editComment({{$comment->id}})">
                    <x-eos-edit />
                </button>
                <form action='deleteComment' id="comment-delete-{{$comment->id}}" style='display:inline-block;' method="post">
                    @csrf
                    @method('DELETE')
                    <button class='comment-edit-icon'>
                        <x-heroicon-o-trash />
                    </button>
                </form>
            </div>
        @endif
    </div>
    <div id='comment-body-container-{{$comment->id}}'>
        <div class='comment-body' id='comment-body-{{$comment->id}}'>
            {{$comment->body}}
        </div>
    </div>
    <form action="submitCommentEdit" enctype="multipart/form-data" id="comment-submit-form-{{$comment->id}}" method="put">
        @method('PUT')
        @csrf
    </form>

    <script type='text/javascript'>

        commentId = '<?php echo $comment->id; ?>';

        function editComment(commentId) {

            const commentBody = document.getElementById('comment-body-' + commentId);
            const commentBodyContainer = document.getElementById('comment-body-container-' + commentId);
            const commentBodyTextarea = document.createElement('input');
            console.log('ok her');
            commentBody.className = 'hidden';
            commentBodyTextarea.type = 'textarea';
            console.log('stll oki');
            commentBodyTextarea.className='comment-body';
            console.log('&stll oki');
            commentBodyTextarea.placeholder = "<?php echo $comment->body; ?>";
            console.log(commentBodyTextarea);
            console.log(commentBodyContainer);
            commentBodyContainer.appendChild(commentBodyTextarea);
            console.log('oki 4');

            const submitForm = document.getElementById('comment-submit-form-' + commentId);
            var submitBtn = document.createElement('button');
            console.log('oki 5');
            submitBtn.id = 'comment-submit-' + commentId;
            console.log('oki 6');
            submitBtn.className='comment-submit';
            console.log('oki 7');
            submitBtn.style="display:flex;outline:none;";
            submitBtn.innerHTML = 'Submit';
            console.log('oki 8');
            submitForm.appendChild(submitBtn);
            console.log('oki final');
        }

        function submitCommentEdit(e) {
            e.preventDefault();

            commentCard = document.getElementById('comment-card-' + commentId);
            commentCard.className = 'hidden';

            clickUnlike();

            // Create XHR Object
            var xhr = new XMLHttpRequest();
            // open : type, url, isAsync
            xhr.open('PUT', "<?php echo Route('game.update-comment', [$comment->game(), auth()->id(), $comment->body]); ?>", true);
            xhr.onload = function() {
                if (this.status !== 200) {
                    console.log(this.statusText);
                }
            }

            xhr.send();
        }

        document.getElementById('comment-delete-' + commentId).addEventListener('submit', deleteComment);

        function deleteComment(e) {
            e.preventDefault();

            const commentCard = document.getElementById('comment-card-' + commentId);
            commentCard.className = 'hidden';

            clickUnlike();

            // Create XHR Object
            var xhr = new XMLHttpRequest();   
            // open : type, url, isAsync
            xhr.open('DELETE', "<?php echo Route('game.destroy-comment', [$comment->id]); ?>", true);
            xhr.onload = function() {
                if (this.status !== 200) {
                    console.log(this.statusText);
                }
            }

            xhr.send();
        }
    </script>
</div>