<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$masks = new \bbn\appui\masks($model->db);
if ( isset($model->data['id_note']) ){
  $model->data['res']['success'] = $masks->set_default($model->data['id_note']);
}
return $model->data['res'];