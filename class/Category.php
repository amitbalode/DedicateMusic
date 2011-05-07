<?php
/**
 * Author: Amit Balode, Abhishek Sinhal & Rohani Raina.
 * Category contains multiple albums
 */
class Category{
    private $categoryId = 0;
    private $categoryName = 0;
    private $albums = array();//Each Category can contain multiple albums.
    
    public function getCategoryId(){
      return $this->categoryId;
    }
    
    public function getCategoryName(){
      return $this->categoryName;
    }
    
    
    
    
  }