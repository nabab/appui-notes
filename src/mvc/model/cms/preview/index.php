<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
if ($model->has_data(['url'])) {
  $cms = new \bbn\appui\cms($model->db);
  if ( $note = $cms->get($model->data['url']) ){
    $note['url'] = $model->data['url'];
    
    return $note;
  }
}