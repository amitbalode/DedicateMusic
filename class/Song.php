<?php
/**
 * Author: Amit Balode, Abhishek Sinhal & Rohani Raina.
 * Song class contains song id and song name.
 * type paramter is explicitly introduced so that we are not dependent on youtube itself,
 * in future we can find some other source also for songs. 
 */
  class Song{
    private $songId = 0;
    private $songName = 0;
    private $type = null;
    
    public function getSongId(){
      return $this->songId;
    }
    
    public function getSongName(){
      return $this->songName;
    }
    
    
  }