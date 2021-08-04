
var gameframe = document.getElementById("gameframe");
var gamboxNormalWidth = gameframe.getAttribute("normalwidth");
var gamboxNormalHeight = gameframe.getAttribute("normalheight");

function goFullscreen() {
  var elem = document.documentElement;
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.msRequestFullscreen) {
    elem.msRequestFullscreen();
  } else if (elem.mozRequestFullScreen) {
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) {
    elem.webkitRequestFullscreen();
  }
  gameframe.style="#fsoverflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px;width:100%;height:100%;z-index:1000;background-color:var(--div-dark-darker);";
}

function escapeFullscreen() {
  if (!document.fullscreenElement) {
    gameframe.style= ("width:" + gamboxNormalWidth + "px;height:" + gamboxNormalHeight + "px;background-color:var(--div-dark-darker);");
  }
}

window.onresize = escapeFullscreen;

window.onkeydown = function(evt) {
  evt = evt || window.event;
  var isEscape = false;
  if ("key" in evt) {
      isEscape = (evt.key === "Escape" || evt.key === "Esc");
  } else {
      isEscape = (evt.keyCode === 27);
  }
  if (isEscape) {
    escapeFullscreen();
  }
};

getStatus(gameframe.getAttribute('src'));

function getStatus(url) {

  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState === 4){
        request.status;//this contains the status code
        if (request.status === 404) {
          location.replace("/game_error/" + gameframe.getAttribute("about").replace(" ", "%20"));
        }
    }
  };
  request.open("GET", url, true);
  request.send(); 
}

function seeMore() {
  const gameCard = document.getElementById('game-card');
  gameCard.style.height='auto';

  const textFade = document.getElementById('text-fade');
  textFade.style = 'hidden';

  const seeMore = document.getElementById('see-more');
  seeMore.style = 'hidden';
  seeMore.innerHTML = '';

}