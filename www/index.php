<?php 
/**
 * Authors: Amit Balode, Abhishek Sinhal & Rohani Raina.
 */
  require_once dirname(dirname(__FILE__))."/www/inc/path.php";
  require_once DEDICATE_MUSIC_PATH."/www/header.php";

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="<?php echo DM_BASE_URL ?>www/js/youtube.js?3" type="text/javascript"></script>
<script src="<?php echo DM_BASE_URL ?>www/js/static.js" type="text/javascript"></script>
<script src="<?php echo DM_BASE_URL ?>www/js/lib.js" type="text/javascript"></script>
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript"> google.load("swfobject", "2.1"); </script>
<link type="text/css" href="<?php echo DM_BASE_URL ?>www/css/youtube.css" rel="stylesheet" />
<input type="text" style="display:none" value="lata" id="searchbox" name="searchbox"/>
<a onclick="DM.App.search.searchButtonClicked();"><img src="http://www.topnews.in/files/Lata%20mangeshkar1.jpg" width="100" height="100" /></a>
<?php require_once DEDICATE_MUSIC_PATH."/www/js/main.js.php";  ?>
<script type="text/javascript">


var mainPlayer = null;
$(document).ready(function() {
  //DM.App.Events.addEventListener('complete',DM.App.search.searchButtonClicked);
  //DM.App.Events.triggerEvent('complete');
	<?php //Instantiate our player ?>
	mainPlayer = new DM.App.player('yt');
	loadPlayer(480,320);
});
</script>
<?php ?>
<div id="youtube_js">
    <div id="youtube_js_player">
        <div id="youtube_replaceme" style="width: '+viewportwidth+'px; height: '+viewportheight+'px;"></div>
        <div class="youtube_controls">
            <a href="#" id="yt_play_video" onclick="mainPlayer.play(); return false;">Play</a>
            <a href="#" id="yt_pause_video" onclick="mainPlayer.pause(); return false;">Pause</a>
            <a href="#" id="yt_next_video" onclick="mainPlayer.playNext(); return false;">Next</a>
            <span id="yt_time">00:00/00:00</span>
            <input type="hidden" id="videoid" value="d_2lnr5bOSI" />
            <div id="yt_volume"><div style="position: absolute" id="yt_slider"></div></span>
            </div>
        </div>
    </div>
</div>
