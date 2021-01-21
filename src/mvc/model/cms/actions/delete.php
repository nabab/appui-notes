<?php
$res = [
  'success' => false
];
$notes = new \bbn\appui\note($model->db);
$cms = new \bbn\appui\cms($model->db);

if ( !empty($model->data['id']) ){
  $res['success'] = $cms->delete($model->data['id']);
}
return $res;