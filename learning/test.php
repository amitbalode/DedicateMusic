<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<input type="text" value="lata" id="searchbox" name="searchbox"/>
<script type="text/javascript">
DM = {};
DM.App = {};
DM.App.mediaSource = [];
DM.App.mediaSource['yt'] = {
  'id': 'youtube', 
  'fetchUrl': 'http://gdata.youtube.com/feeds/api/videos?q='
};

<?php // ------- Defining Data Structures --------------- ?>
DM.App.struct = {};
DM.App.struct.song = function(){
  this.songId = '';
  this.songTitle = '';
  this.songUrl = '';
  this.songMedia = '';
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

    			var video = item['id']['$t'];
			  video = video.replace('http://gdata.youtube.com/feeds/api/videos/','http://www.youtube.com/watch?v=');  //replacement of link
			  videoID = video.replace('http://www.youtube.com/watch?v=',''); // removing link and getting the video ID

			  song = new DM.App.struct.song();
			  song.songId = videoID;
			  song.songTitle = item['title']['$t'];
			  song.songUrl = video;
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

DM.App.search.searchButtonClicked();
</script>
