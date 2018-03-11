<?php
/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 06/03/2018
 * Time: 16:02
 */

if ( isset($model->data['limit'], $model->data['start']) ){
  $notes = new \bbn\appui\notes($model->db);
  $id_type = $model->inc->options->from_code('news', 'types', 'notes', 'appui');
  $news = $notes->get_by_type($id_type, false, $model->data['limit'], $model->data['start']);
  return [
    'data' => $news,
    'total' => count($notes->get_by_type($id_type))
  ];
}