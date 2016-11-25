<?php
/** @var \bbn\mvc\model $model */
if ( !empty($model->data['take']) ){
  $notes = new \bbn\appui\notes($model->db);
  return [
    'data' => $notes->browse($model->data['take'], $model->data['skip']),
    'total' => $notes->count()
  ];
}
