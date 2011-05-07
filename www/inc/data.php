<?php

  $dm_category = array();
  $dm_category['bollywood'] = array('name' => 'Bollywood','album_ids' => array('lataji'));
  $dm_category['hollywood'] = array('name' => 'Hollywood','album_ids' => array());
  
  $dm_albums = array(
    array('id' => 'lataji','name' => 'Lata Mangeskar', 'playlist_ids' => array('lataji1')),
    array('id' => 'hollywood','name' => 'Hollywood', 'playlist_ids' => array()),
  );
  
  $dm_playlists = array(
    array('id' => 'lataji1','name' => 'Lata Mangeskar1', 'song_ids' => array('7aPtjImR5RA','TFr6G5zveS8')),
  );    