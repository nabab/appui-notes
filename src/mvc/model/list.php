<?php
/** @var \bbn\mvc\model $model */
if ( isset($model->data['ss']) ){
  $r = [];
  $notes = new \bbn\appui\notes($model->db);
  return $r;
}
