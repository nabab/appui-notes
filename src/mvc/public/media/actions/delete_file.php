<?php
/*
 * Describe what it does!
 *
 * @var $ctrl \bbn\mvc\controller 
 *
 */
$success = false;
if ( $id_media = $ctrl->arguments[0] ){
  $medias = new \bbn\appui\medias($ctrl->db);
  $fs = new \bbn\file\system();
  if ( $media = $medias->get_media($id_media, true) ){
    $content = json_decode($media['content'],true);
    $path = $content['path'].$id_media.'/'.$media['name'];
    $root = \bbn\mvc::get_data_path('appui-note').'media/';
 	
    if ( $fs->exists($root.$path) ){
      $ctrl->obj->removed = true;
      if ( !empty($medias->get_thumbs_path($root.$path)) ){
        $medias->remove_thumbs($root.$path);
      }
      $success = unlink($root.$path);
      $ctrl->obj->success = $success;		
    }
  }
	  
}