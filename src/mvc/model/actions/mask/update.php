<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
if ( isset($model->data['title'], $model->data['content'], $model->data['id_type'], $model->data['name']) ){
  $mask = new \bbn\appui\masks($model->db);
  if ( !empty($model->data['id_note']) ){
    $model->data['res']['success'] = $mask->update([
      'id_note' => $model->data['id_note'],
      'name' => $model->data['name'],
      'title' => $model->data['title'],
      'content' => $model->data['content']
    ]);
  }
  else {
    $model->data['res']['success'] = $mask->insert($model->data['name'], $model->data['id_type'], $model->data['title'], $model->data['content']);
  }
}
return $model->data['res'];