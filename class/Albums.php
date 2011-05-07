<?php
/**
 * Author: Amit Balode, Abhishek Sinhal & Rohani Raina.
 * Albums contains multiple playlist
 */
  class Albums{
    private $albumId = 0;
    private $albumName = 0;
    private $playLists = array();//Each albums can contain multiple playlists.
    
    public function getAlbumId(){
      return $this->albumId;
    }
    
    public function getAlbumName(){
      return $this->albumName;
    }
    
    
    
    
  }