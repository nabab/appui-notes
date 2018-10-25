<?php
/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 20/07/17
 * Time: 17.09
 *
 * @var $model \bbn\mvc\model
 */
$res = [
  'success' => false
];
$notes = new \bbn\appui\notes($model->db);
if ( !empty($model->data['id_note']) && isset($model->data['content']) ){
  $res['success'] = $notes->update($model->data['id_note'], $model->data['title'] ?? '', $model->data['content']);
}
return $res;