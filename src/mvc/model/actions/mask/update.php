<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
if ( isset($model->data['title'], $model->data['content'], $model->data['id_type']) ){
  if ( !empty($model->data['id_note']) ){
    $note = new \bbn\appui\notes($model->db);
    $model->data['res']['success'] = $note->update($model->data['id_note'], $model->data['title'], $model->data['content']);
  }
  else {
    $mask = new \bbn\appui\masks($model->db);
    $model->data['res']['success'] = $mask->insert($model->data['id_type'], $model->data['title'], $model->data['content']);
  }
}
return $model->data['res'];