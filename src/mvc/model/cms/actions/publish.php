<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$cms = new \bbn\appui\cms($model->db);
$res['success'] = false;
if ( !empty($model->data['id_note']) && !empty($model->data['url']) ){
  $res['success'] = $cms->publish(
    $model->data['id_note'], 
    [
      'url' => $model->data['url'],
      'start' => $model->data['start'],
      'end' => $model->data['end']
    ]);
}
return $res;