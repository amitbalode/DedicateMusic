<script>
<?php // ------- Defining Data Structures --------------- ?>
DM = {};
DM.App = {};
DM.App.struct = {};
DM.App.struct.song = function(){
  this.songId = '';
  this.songTitle = '';
  this.songUrl = '';
  this.songSmallPic = '';
  this.songBigPic = '';
  this.songMedia = '';
};
DM.App.struct.playList = function(){
  this.songs = [];
  this.playlistId = '';

  this.addSong = function(song){
	  this.songs.push(song);
	};
};
<?php // ------------------------------------------------ ?>

<?php // ------- Defining Data Constants --------------- ?>

DM.App.mediaSource = [];
DM.App.mediaSource.active = 'yt';
DM.App.mediaSource['yt'] = {
  'id': 'youtube',
  'playerId': 'ytPlayer', 
  'fetchUrl': 'http://gdata.youtube.com/feeds/api/videos?q=',
  'pic_small': 'http://img.youtube.com/vi/{videoId}/2.jpg',
  'pic_big': 'http://img.youtube.com/vi/{videoId}/0.jpg'
};

DM.App.constant = {};
DM.App.constant.get = function(id){
	return DM.App.mediaSource[DM.App.mediaSource.active][id];
};

console.log(DM.App.constant.get('playerId'));

<?php // ------------------------------------------------ ?>

letsPlaySomeMusic = function(object){
	var playlist = null;
	if(object instanceof DM.App.struct.playList){
		playlist = object;
  }else if(object instanceof DM.App.struct.song){
	  playlist = new DM.App.struct.playList('',object);
  }else{
	  alert("You suck Balode. Not a valid type object to play");
	  return;
	}	  
  var playerVideos = new DM.App.player.videos();
  playerVideos.add(playlist);
  mainPlayer.initialize(playerVideos);
  mainPlayer.playNext(); 
};



DM.App.player = function(playerType){
  this.currentSong = '';
  this.playerType = playerType;
  this.videos = null;

  this.initialize = function(videos){
    this.videos = videos;
  };

  
  this.playNext = function(){
    var nextVideo = this.videos.getNextVideo();
    document.getElementById(DM.App.constant.get('playerId')).loadVideoById(nextVideo);
  };

  this.playPrevious = function(){
    previousVideo = this.videos.getPreviousVideo();
  };

  this.pause = function(){
	  document.getElementById(DM.App.constant.get('playerId')).pauseVideo();
	};
	
  this.mute = function(){};
  this.unmute = function(){};

  

};

DM.App.player.videos = function(){
  this.playlists = [];
  this.fetchOnEmpty = 'N';
  this.add = function(playlist){
    this.playlists.push(playlist);
  };

  this.fetch = function(){

  };

  this.getNextVideo = function(){
	  var song = null;
	  for(var i = 0; i < this.playlists.length; i++) {
		  //console.log(this.playlists[i]);
			if(this.playlists[i].songs.length > 0){
			  song = this.playlists[i].songs.splice(0,1);
			  return song[0].songId;
		  }
	  }
  }; 

};

<?php // ------- Defining Listener Framework --------------- ?>
DM.App.Events = {};
DM.App.Events.eventListeners = [];
DM.App.Events.addEventListener = function(_msg, _callback) { 
  if (DM.App.Events.eventListeners[_msg] == null) DM.App.Events.eventListeners[_msg] = [];
  DM.App.Events.eventListeners[_msg].push(_callback);
}

DM.App.Events.triggerEvent = function(_msg, _params) {
  if (_msg == null || _msg == "") return;
  <?php // see if a listener has been set on this message?>
  if (DM.App.Events.eventListeners[_msg] != null) {
    <?php // support for multiple callbacks per event so loop through ?>
    for (var i = 0; i < DM.App.Events.eventListeners[_msg].length; i++) {
      if (typeof DM.App.Events.eventListeners[_msg][i] == "function") {
        DM.App.Events.eventListeners[_msg][i].call(this, _params);
      }
    }
  }
}
<?php // ------------------------------------------------ ?>

<?php // ------- Defining Search Configuration HTML ids and functions --------------- ?>
DM.App.search = {};
DM.App.search.searchButton = "searchbox";

<?php //Function called when user click on Search button/ or type in search button ?>
DM.App.search.searchButtonClicked = function(){
  var query = $("#"+DM.App.search.searchButton).val();
  DM.App.search.ytFetchSongs(query);
};


<?php //Function called to fetch songs from youtube ?>
DM.App.search.ytFetchSongs = function(query){
  var media = DM.App.mediaSource['yt'];
  var playList = new DM.App.struct.playList();
  $.getJSON(media.fetchUrl+query+'&alt=json-in-script&callback=?&max-results=40&start-index=1',
    function(data){
      $.each(data.feed.entry, function(i, item) {
        var video = item['id']['$t'];
        video = video.replace('http://gdata.youtube.com/feeds/api/videos/','http://www.youtube.com/watch?v=');
        var videoID = video.replace('http://www.youtube.com/watch?v=','');

        var song = new DM.App.struct.song();
        song.songId = videoID;
        song.songTitle = item['title']['$t'];
        song.songUrl = video;
        song.songSmallPic = media.pic_small.replace('{videoId}',videoID);
        song.songBigPic = media.pic_big.replace('{videoId}',videoID);
        song.songMedia = media.id;
        playList.addSong(song);	
      });
      DM.App.homeTab.populate(playList);
  });
};
<?php // ------------------------------------------------ ?>

<?php // ------- Defining Home Tab functionality --------------- ?>
DM.App.homeTab = {};
DM.App.homeTab.populate = function(playList){
  letsPlaySomeMusic(playList);
};

<?php // ------------------------------------------------ ?>

</script>