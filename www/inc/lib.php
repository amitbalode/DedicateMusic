<?php
  function getCategoryAlbums($category){
    global $dm_category;
    $album_ids = $dm_category[$category]['album_ids'];
    return $album_ids;
  }
 
