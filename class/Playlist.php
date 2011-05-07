<?php
/**
 * Author: Amit Balode, Abhishek Sinhal & Rohani Raina.
 * Playlist contains multiple songs
 */
class Playlist{
    private $playlistId = 0;
    private $playlistName = 0;
    private $songs = array(); //Each Playlist can contain multiple songs.
    
    public function getPlaylistId(){
      return $this->playlistId;
    }
    
    public function getPlaylistName(){
      return $this->playlistName;
    }
    
    
    
    
  }