<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
if ( !empty($model->data['id_note']) ){
  $mask = new \bbn\appui\masks($model->db);
  $model->data['res']['success'] = $mask->delete($model->data['id_note']);
}
return $model->data['res'];