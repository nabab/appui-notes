<?php
/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 20/07/17
 * Time: 17.09
 */
$res = [
  'success' => false
];
$notes = new \appui\notes($model->db);
if ( isset($model->data['id_note'], $model->data['content']) ){
  $res['success'] = $notes->update($model->data['id_note'], [
    'content' => $model->data['content'],
    'title' => $model->data['title']
  ]);
}
return $res;