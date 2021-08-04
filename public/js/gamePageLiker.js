
const liker = document.getElementById('game-liker');
const unliker = document.getElementById('game-unliker');
const likeCounter = document.getElementById('like-counter');

function clickLike() {
    hideLiker();
    showUnliker(); 
    incrementLikeCounter();
}

function clickUnlike() {
    showLiker();
    hideUnliker();
    decrementLikeCounter();
}

function showLiker() {
    if (liker.classList.contains('hidden')) {
        liker.classList.remove('hidden');
    }
}

function hideLiker() {
    if (!liker.classList.contains('hidden')) {
        liker.classList.add('hidden');
    }
}

function showUnliker() {
    if (unliker.classList.contains('hidden')) {
        unliker.classList.remove('hidden');
    }
}

function hideUnliker() {
    if (!unliker.classList.contains('hidden')) {
        unliker.classList.add('hidden');
    }
}

function incrementLikeCounter() {
    var likeCounterText = likeCounter.innerHTML;
    if (!likeCounterText) {
        likeCounter.innerHTML = "1 like";
    } else {
        var likeCount = likeCounterText.substring(0, likeCounterText.indexOf(' '));
        likeCount ++;
        likeCounterText = likeCount + " Like";
        if (likeCount > 1) {
            likeCounterText += 's';
        }
        likeCounter.innerHTML = likeCounterText;
    }
}

function decrementLikeCounter() {
    var likeCounterText = likeCounter.innerHTML;
    if (likeCounterText) {
        var likeCount = likeCounterText.substring(0, likeCounterText.indexOf(' '));
        likeCount --;
        likeCounterText = likeCount + " Like";
        if (likeCount > 1) {
            likeCounterText += 's';
        } else if (likeCount < 1) {
            likeCounterText = '';
        }
        likeCounter.innerHTML = likeCounterText;
    }
}