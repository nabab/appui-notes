<?php
/** @var \bbn\mvc\model $model */
$res = ['success' => false];
if ( !empty($model->data['title']) || !empty($model->data['content']) ){
  $note = new \bbn\appui\notes($model->db);
  $res['success'] = $note->insert(
    $model->data['title'] ?? '',
    $model->data['content'] ?? '',
    empty($model->data['private']) ? 0 : 1,
    empty($model->data['locked']) ? 0 : 1
  );
}
return $res;