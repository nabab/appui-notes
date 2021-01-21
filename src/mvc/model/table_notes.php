<?php

if ( !empty($model->data['limit']) ){
  $notes = new \bbn\appui\note($model->db);
  return $notes->browse($model->data);
}
return [];