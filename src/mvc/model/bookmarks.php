<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$file = BBN_DATA_PATH.'bookmarksv2.json';



$bookmarks = [];
//check if the file already exists;
if ( !empty(file_exists($file)) ){
  $content = json_decode(file_get_contents($file), true);
  $bookmarks = !empty($content) ? $content : [];
}
else{
  $bookmarks = [];
}
return [
 // 'imageDom' => $imageDom,
  'bookmarks' => $bookmarks
];