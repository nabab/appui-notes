<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\controller */
if ( isset($ctrl->arguments[0]) ){
  $res = $ctrl->get_model('./../note', ['id_note' => $ctrl->arguments[0]]);
  if ( $res['success'] && !empty($res['note']) ){
    echo $ctrl->get_view('./../note/note', $res['note']);
  }
}
