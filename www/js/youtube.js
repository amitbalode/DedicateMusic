onPlayerError = function(errorCode) {
	mainPlayer.playNext();
}

function onPlayerStateChange(state) {
    if (state == 0) {
      mainPlayer.playNext();
    }
}

 
setVideoVolume = function(volume) {
  if(isNaN(volume) || volume < 0 || volume > 100) {
    alert("Please enter a valid volume between 0 and 100.");
  }
  else if(document.getElementById(DM.App.constant.get('playerId'))){
    document.getElementById(DM.App.constant.get('playerId')).setVolume(volume);
  }
}
 
// Set the current time
updateVideoControlsAtInterval = function() {
    var time = secondsToTime(document.getElementById(DM.App.constant.get('playerId')).getCurrentTime())+'/'+secondsToTime(document.getElementById(DM.App.constant.get('playerId')).getDuration());
    $("#yt_time").html(time);
}
 
onYouTubePlayerReady = function(playerId) {
  var ytplayer = document.getElementById(DM.App.constant.get('playerId'));
  ytplayer.addEventListener("onStateChange", "onPlayerStateChange");
  ytplayer.addEventListener("onError", "onPlayerError");
  //ytplayer.cueVideoById("YTwCvshBNKU");
   
  // Init the volume dragger and attach the setVideoVolume() method onDrag
  var aThumb = document.getElementById("yt_slider");
  Drag.init(aThumb, null, 0, 175, 0, 0);
  aThumb.onDrag = function(x,y) {
      var percent = (x*100)/175;
      setVideoVolume(percent);
  }
  // The slider is initialized to 0 by default, let's change that
  document.getElementById("yt_slider").setAttribute('style','left:80px;position:absolute;')
  setVideoVolume(50);

  setInterval(updateVideoControlsAtInterval,1000);   
  updateVideoControlsAtInterval();           
}
 
loadPlayer = function(width, height) {
  var params = { allowScriptAccess: "always", wmode: 'opaque' };
  var atts = { id: DM.App.constant.get('playerId') };
  swfobject.embedSWF("http://www.youtube.com/apiplayer?" +
                     "&enablejsapi=1&version=3&playerapiid=player1",
                     "youtube_replaceme", width, height, "8", null, null, params, atts);
}