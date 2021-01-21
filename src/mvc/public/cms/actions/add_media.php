<?php
/*
 * Describe what it does!
 *
 * @var $ctrl \bbn\mvc\controller 
 *
 */
$success = false;
if ( ($id_note = $ctrl->post['id_note']) &&
    ($id_media = $ctrl->post['id_media']) &&
    isset($ctrl->post['version'])
   ){
  $notes = new \bbn\appui\note($ctrl->db);
  $success = $notes->add_media_to_note($id_media, $id_note, $ctrl->post['version']);
}
$ctrl->obj->success = $success;