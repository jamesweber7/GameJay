const appendCommentBank = document.getElementById('append-comment-bank');

function addComment(body, username, userImage, userHref) {
    var commentCard = document.createElement('div');
    commentCard.className = 'comment-card';

        var userLink = document.createElement('a');
        userLink.href = userHref;

            var profilePicture = document.createElement('div');
            profilePicture.className='profile-picture-sm';
            profilePicture.style='width:60px;';
            profilePicture.innerHTML=userImage;

            var usernameDiv = document.createElement('div');
            usernameDiv.style="display:inline-block;color:var(--jay-blue-deeper);font-family:'Bookman';font-size:26px;";
            usernameDiv.innerHTML=username;

        userLink.appendChild(profilePicture);
        userLink.appendChild(usernameDiv);

        var timeStamp = document.createElement('div');
        timeStamp.style="display:inline-block;margin-left:12px;color:var(--jay-deep-blue-gray)";
        timeStamp.innerHTML='posted just now'

        var commentBody = document.createElement('div');
        commentBody.style="display:flex";
        commentBody.innerHTML=body;
    commentCard.appendChild(userLink);
    commentCard.appendChild(timeStamp);
    commentCard.appendChild(commentBody);
    console.log('CREATED CARD ' + commentCard);
    // NOT READING APPENDCOMMENTBANK CORRECTLY
    // var newCommentBank = document.getElementById('append-comment-bank');
    appendCommentBank.append(commentCard);
    console.log("COMMENT APPENDED");
}

function commentIsValid(comment) {
    return comment.length > 0 && comment.length < 1001;
}