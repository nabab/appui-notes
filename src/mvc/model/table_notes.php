<?php
if ( !empty($model->data['limit']) ){
  $notes = new \bbn\appui\notes($model->db);
  return $notes->browse($model->data);
}
return [];
