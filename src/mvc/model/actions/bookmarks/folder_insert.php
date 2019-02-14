<?php
if ( !empty($model->data['text']) ){
  $success = false;
  $file = BBN_DATA_PATH.'bookmarks.json';
  if ( !empty(file_exists($file)) ){
    $bookmarks = json_decode(file_get_contents($file), true);
    if ( ( $parent = $model->data['parent'] ) && ( $idx = $model->data['idx'] ) ){
      
      
      foreach ( $bookmarks as $key => $val ){
        if ( ($val['text'] === $parent) && ($model->data['new_type'] === 'folder' ) ){
          $bookmarks[$key]['items'][] = [
            'text' => $model->data['text'],
            'type' => $model->data['new_type'],
            'items' => []
          ];
        }
        die(var_dump($bookmarks[$key]));
      }
    }
    else {
      $bookmarks[] = [
      'text' => $model->data['text'],
      'type' => $model->data['new_type'],
      'items' => []
    ];
    }
  }
  else { 
    $bookmarks = [
      'text' => $model->data['text'],
      'type' => 'folder',
      'items' => []
    ];
    

  }
  $success = file_put_contents($file, json_encode($bookmarks));
  return [
    'success' => $success,
    'bookmarks' => json_decode(file_get_contents($file))
  ];
}
