<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\controller */

if ( $res = $ctrl->get_model($ctrl->data['root'].'note', $ctrl->post) ){
  $ctrl->obj = \bbn\x::to_object($res);
}
else{
  $ctrl->obj->error = _("Impossible to find the note");
}