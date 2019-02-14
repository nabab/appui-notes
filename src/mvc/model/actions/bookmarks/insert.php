<?php
if ( ($model->data['type'] === 'folder') || ( $model->data['url'] ) ){
  $success = false;
  $parent = $model->data['parent'];
  
  $file = BBN_DATA_PATH.'bookmarksv2.json';
  $data = $model->data;
  $bookmarks = [];
  //if the file exists it takes the content
  if ( file_exists($file) && !empty(json_decode(file_get_contents($file), true))){
    
    $bookmarks = json_decode(file_get_contents($file), true);
    if ( !empty ($bookmarks)){
      $tmp = $model->data['type'] === 'link' ? \bbn\x::get_row($bookmarks, ['url' => $model->data['url']]) : \bbn\x::get_row($bookmarks, ['text' => $model->data['text'],'parent' => $model->data['parent']]);
    
    }
    if ( empty($tmp) ){
       $bookmarks[] = ($model->data['type'] === 'link') ? [
        'type' => $model->data['type'],
        'text' => $model->data['text'],
        'url' => $model->data['url'],
        'description' => $model->data['description'],
        'image' => $model->data['link'],
        'parent' => $model->data['parent']
      ] : [
        'type' => $model->data['type'],
        'text' => $model->data['text'],
        'parent' => $model->data['parent']
      ];
      $success = file_put_contents($file, json_encode($bookmarks,JSON_PRETTY_PRINT)) ;
    }
    else{
      $error = _('The'.' '.$model->data['type'].' '.'already exists');
      $success = false;
    }
  }
  else{
    $bookmarks[] = ($model->data['type'] === 'link') ? [
        'type' => $model->data['type'],
        'text' => $model->data['text'],
        'url' => $model->data['url'],
        'description' => $model->data['description'],
        'image' => $model->data['link'],
        'parent' => $model->data['parent']
      ] : [
        'type' => $model->data['type'],
        'text' => $model->data['text'],
        'parent' => $model->data['parent']
      ];
    $success = file_put_contents($file, json_encode($bookmarks,JSON_PRETTY_PRINT)) ;  
  }
  
  return [
    'bookmarks' => $bookmarks,
    'success' => $success,
    'error' => $error
  ];    
}  