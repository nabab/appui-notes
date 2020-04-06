<?php
/** @var $ctrl \bbn\mvc\controller */
if ( isset($ctrl->files['fichier']) ){
  $ctrl->files['file'] = $ctrl->files['fichier'];
}
elseif ( isset($ctrl->files['attachments']) ){
  $ctrl->files['file'] = $ctrl->files['attachments'];
}
if (
  isset($ctrl->files['file'], $ctrl->arguments[0]) &&
  \bbn\str::is_integer($ctrl->arguments[0])
){
  $f =& $ctrl->files['file'];
  $path = $ctrl->user_tmp_path().$ctrl->arguments[0];
  $new = !empty($_REQUEST['name']) && ($_REQUEST['name'] !== $f['name']) ?
    \bbn\str::encode_filename($_REQUEST['name'], \bbn\str::file_ext($_REQUEST['name'])) :
    \bbn\str::encode_filename($f['name'], \bbn\str::file_ext($f['name']));

  if ( \bbn\file\dir::create_path($path) &&
    rename($f['tmp_name'], $path.'/'.$new) ){
    $ctrl->obj->success = 1;
    $ctrl->obj->fichier = [
      'name' => $new,
      'size' => filesize($path.'/'.$new),
      'extension' => '.'.\bbn\str::file_ext($new)
    ];
  }
}