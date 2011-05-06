<?php 
  /**
   * Authors: Amit Balode, Abhishek Sinhal & Rohani Raina.
   */
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<input type="text" value="lata" id="searchbox" name="searchbox"/>
<script type="text/javascript">
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
<?php // ------------------------------------------------ ?>

<?php // ------- Defining Data Constants --------------- ?>
DM.App.mediaSource = [];
DM.App.mediaSource['yt'] = {
  'id': 'youtube', 
  'fetchUrl': 'http://gdata.youtube.com/feeds/api/videos?q=',
  'pic_small': 'http://img.youtube.com/vi/{videoId}/2.jpg',
  'pic_big': 'http://img.youtube.com/vi/{videoId}/0.jpg'
};
<?php // ------------------------------------------------ ?>

<?php // ------- Defining Search Configuration HTML ids and functions --------------- ?>
DM.App.search = {};
<?php //Configuration ?>
DM.App.search.searchButton = "searchbox";

<?php //Function called when user click on Search button/ or type in search button ?>
DM.App.search.searchButtonClicked = function(){
  var query = $("#"+DM.App.search.searchButton).val();
  DM.App.search.ytFetchSongs(query);
};


<?php //Function called to fetch songs from youtube ?>
DM.App.search.ytFetchSongs = function(query){
  var media = DM.App.mediaSource['yt'];
  var songs = [];
  $.getJSON(media.fetchUrl+query+'&alt=json-in-script&callback=?&max-results=12&start-index=1',
    function(data){
      $.each(data.feed.entry, function(i, item) {
        console.log(item);
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
        songs.push(song);	
      });
      DM.App.homeTab.populate(songs);
  });
};
<?php // ------------------------------------------------ ?>


<?php // ------- Defining Home Tab functionality --------------- ?>
DM.App.homeTab = {};
DM.App.homeTab.populate = function(data){
  for(var i = 0; i < data.length; i++) {
	  console.log(data[i]);
  }	
};
<?php // ------------------------------------------------ ?>

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

$(document).ready(function() {
  DM.App.Events.addEventListener('complete',DM.App.search.searchButtonClicked);
  DM.App.Events.triggerEvent('complete');
});
</script>
