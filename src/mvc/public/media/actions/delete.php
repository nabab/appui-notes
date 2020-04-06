<?php
$success = false;
if ( !empty($ctrl->post['id']) ){
	$medias = new \bbn\appui\medias($ctrl->db);
  $success = $medias->delete($ctrl->post['id']);
}
$ctrl->obj->success = $success;