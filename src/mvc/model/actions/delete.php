<?php
$res = [
  'success' => false
];
$notes = new \bbn\appui\notes($model->db);
if ( !empty($model->data['id_note']) ){
  $res['success'] = $notes->remove($model->data['id_note'], !empty($model->data['keep']));
}
return $res;
