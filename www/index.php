<?php 
/**
 * Authors: Amit Balode, Abhishek Sinhal & Rohani Raina.
 */
  require_once dirname(dirname(__FILE__))."/www/inc/path.php";
  require_once DEDICATE_MUSIC_PATH."/www/header.php";

?>

<link type="text/css" href="<?php echo DM_BASE_URL ?>www/css/youtube.css" rel="stylesheet" />
<link type="text/css" href="<?php echo DM_BASE_URL ?>www/css/main.css?1" rel="stylesheet" />

<?php //Common JS library for Dedicate Music ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="<?php echo DM_BASE_URL ?>www/js/static.js" type="text/javascript"></script>
<script src="<?php echo DM_BASE_URL ?>www/js/lib.js" type="text/javascript"></script>

<?php //JS library for Youtube ?>
<script src="<?php echo DM_BASE_URL ?>www/js/youtube.js" type="text/javascript"></script>
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript"> google.load("swfobject", "2.1"); </script>

<?php //JS library for Dedicate Music ?>
<?php require_once DEDICATE_MUSIC_PATH."/www/js/main.js.php";  ?>


<script type="text/javascript">
var mainPlayer = null;
DM.App.Events.addEventListener('complete',createDMPlayer);
DM.App.Events.addEventListener('complete',imageHover);

$(document).ready(function() {
  DM.App.Events.triggerEvent('complete');
});
</script>

<body>
<?php 
  $current_albums = $dm_category[$default_category]['album_ids'];
  error_log(json_encode($current_albums));
?>
<div id="wrapper">
<div id="main">
  <div class="pghead h150"></div>
  <div class="content3" style="margin-top:50px;">
  <?php /*
      <img width="100%" height="120" alt="" src="http://ytplayer.com/home/wp-content/uploads/2010/09/cropped-concert-bw.jpg">
  		  <div style="background:none repeat scroll 0 0 #000000;height:2px;"></div> */ ?>
  		  <div>
  		    <input type="text" style="display:none" value="lata" id="searchbox" name="searchbox"/>
        <ul class="thumb">
          <?php foreach($current_albums as $album){ ?>
          		<li><a onclick='DM.App.search.albumClicked("<?php echo $album; ?>");'><img src="<?php echo $dm_albums[$album]['album_cover']?>" alt="" /></a></li>
          	<?php } ?>
        </ul>
      </div>
      <div id="youtube_js" style="float:right;margin-right:50px;margin-top:50px;">
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
    <div class="clearer"></div>
  </div>
</div>
</div>

</body>