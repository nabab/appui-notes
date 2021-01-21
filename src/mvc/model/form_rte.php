<?php
if ( !empty($model->data['id_note']) ){
  $note =  new \bbn\appui\note($model->db);
  return $note->get($model->data['id_note']);
}
return [];
