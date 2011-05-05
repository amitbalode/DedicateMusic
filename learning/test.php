<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
DM = {};
DM.App = {};
DM.App.search = {};

<?//Configuration ?>
DM.App.search.searchButton = "searchbox";

DM.App.search.homeTabCallback = function(data){
	$.each(data.feed.entry, function(i, item) {
		 var title = item['title']['$t'];
		 var video = item['id']['$t'];
		 video = video.replace('http://gdata.youtube.com/feeds/api/videos/','http://www.youtube.com/watch?v=');  //replacement of link
		 videoID = video.replace('http://www.youtube.com/watch?v=',''); // removing link and getting the video ID
		 console.log(videoID);
	});
};

DM.App.search.searchButtonClicked = function(){
	var txt = $("#"+DM.App.search.searchButton).val();
};
DM.App.search.fetchSongs = function(){
	$.getJSON('http://gdata.youtube.com/feeds/api/videos?q=lata&alt=json-in-script&callback=?&max-results=12&start-index=1',DM.App.search.homeTabCallback);
};
DM.App.search.fetchSongs();
</script>
<?php
  echo 1;