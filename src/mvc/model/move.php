<?php
if ( !empty($model->data['id_parent']) && !empty($model->data['id'] )){
  return ['success' => $model->db->update('bbn_notes', [
    'id_parent' => $model->data['id_parent']
  ], [
    'id' => $model->data['id']
  ])];
}
else{
  return ['success' => false];
}
