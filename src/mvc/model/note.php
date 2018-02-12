<?php
/*
 * Describe what it does!
 *
 **/
/** @var $this \bbn\mvc\model*/

$model->data['successw'] = false;
if ( !empty($model->data['id_note']) && !empty($model->data['id_type']) ){
  $notes = new \bbn\appui\notes($model->db);
	$note = $notes->get($model->data['id_note']);
  $note['id_type'] = $model->data['id_type'];
  $note['default'] = $model->data['default'];
  $note['type'] =  $model->data['type'];
  return [
    'note' => $note,
    'success' => true,
  ];

}