<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$cms = new \bbn\appui\cms($model->db);
$res['success'] = false;

if ( !empty($model->data['id'])){
  $res['success'] = $cms->unpublish($model->data['id']);
}
return $res;