<script>
var dm_category = <?php echo json_encode($dm_category);?>;
var dm_albums = <?php echo json_encode($dm_albums);?>;

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

<?php // ------------------------------------------------ ?>

createDMPlayer = function(){
	<?php //Instantiate our player ?>
	mainPlayer = new DM.App.player(DM.App.mediaSource.active);
	mainPlayer.load();
};

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


<?php //This is our main player class ?>
DM.App.player = function(playerType){
  this.currentSong = '';
  this.playerType = playerType;
  this.videos = null;

  this.initialize = function(videos){
    this.videos = videos;
  };

  this.load = function(){
	  loadPlayer(400,270);
	};

  
  this.playNext = function(){
    var nextVideo = this.videos.getNextVideo();
	  console.log(nextVideo);	  
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

<?php 
  //This is our main player videos to be played.
  //It contains an array of playlist.
  //For single video, to be played, it will contain just 1 playlist with 1 song.
  //fetchOnEmpty paramter should be used, to fetch more songs from youtube when
  //songs are about to end....
?>
DM.App.player.videos = function(){
  this.playlists = [];
  this.fetchOnEmpty = 'N';
  this.randomize = 'Y';
  this.add = function(playlist){
    this.playlists.push(playlist);
  };

  this.fetch = function(){

  };

  this.getNextVideo = function(){
	  var song = null;
	  var i = 0;
	  if(this.randomize == 'Y' && this.playlists.length > 0){
		  i = Math.floor(Math.random()*this.playlists.length);
		}
	  for(; i < this.playlists.length; i++) {
		  //console.log(this.playlists[i]);
			if(this.playlists[i].songs.length > 0){
				var j = 0;
				if(this.randomize == 'Y'){
					j = Math.floor(Math.random()*this.playlists[i].songs.length);
				}
			  song = this.playlists[i].songs.splice(j,1);
			  return song[0].songId;
		  }
	  }
  }; 

};

<?php // ------- Defining Listener Framework --------------- ?>
DM.App.Events = {};
DM.App.Events.eventListeners = [];
DM.App.Events.storedEvents = [];
DM.App.Events.addEventListener = function(_msg, _callback) { 
	if (DM.App.Events.storedEvents[_msg] != null) {
		if (typeof _callback == "function") {
	    _callback.call(this, DM.App.Events.storedEvents[_msg].params);
	    return;
	  }
	}
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
  DM.App.Events.storedEvents[_msg] = {params: _params};
}
<?php // ------------------------------------------------ ?>

<?php // ------- Defining Search Configuration HTML ids and functions --------------- ?>
DM.App.search = {};
DM.App.search.searchButton = "searchbox";

<?php //Function called when user click on Search button/ or type in search button ?>
DM.App.search.searchButtonClicked = function(val){
	var query = val;
	if(query == null) query = $("#"+DM.App.search.searchButton).val();
  DM.App.search.ytFetchSongs(query);
};

<?php //Function called when user click on Search button/ or type in search button ?>
DM.App.search.albumClicked = function(val){
	var playList = new DM.App.struct.playList();
	for(var i = 0; i < dm_albums[val]['song_ids'].length; i++) {
    var song = new DM.App.struct.song();
    song.songId = dm_albums[val]['song_ids'][i];
    playList.addSong(song);
	}
	DM.App.homeTab.populate(playList);
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
  	      console.log(song);	  
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