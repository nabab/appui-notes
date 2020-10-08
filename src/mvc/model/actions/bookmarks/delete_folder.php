<?php
if ( $folder = $model->data['folder'] ){
  $success = false;

  $file = BBN_DATA_PATH.'bookmarksv2.json';
  $bookmarks = json_decode(file_get_contents($file), true);
  
  function remove(&$array, $folder){
    foreach ( $folder['items'] as $i => $val ){
      $index = \bbn\x::find($array, [
        'text' => $val['text'],
        'parent' => $val['parent'],
        'type' => $val['type']
      ]);
      if ( !isset($index) ){
          array_splice($array, $index, 1);
      }
      
      if ( isset($val['items']) ){
        foreach( $val['items'] as $item ){
          remove($bookmarks, $item);

        }
      }
    }
    // die(var_dump('dafd', $array));
    return $array;
  }

  if ( !isset($folder['items']) ){
    $idx = \bbn\x::find($bookmarks, [
      'text' => $folder['text'],
      'parent' => $folder['parent'],
      'type' => 'folder'
    ]);
    if ( isset($idx) ){
      array_splice($bookmarks, $idx, 1);
    }
  }
  else {
    remove($bookmarks, $folder);
    $idx = \bbn\x::find($bookmarks, [
      'text' => $folder['text'],
      'parent' => $folder['parent'],
      'type' => 'folder'
    ]);
    if ( isset($idx) ){
      array_splice($bookmarks, $idx, 1);
    }
    
  }
  $success = file_put_contents($file, json_encode($bookmarks, JSON_PRETTY_PRINT));
  
  return [
    'success' => $success,
    'bookmarks' => $bookmarks
  ];
}