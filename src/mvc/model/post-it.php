<?php
/** @var $model \bbn\mvc\model */
$notes = new \bbn\appui\notes($model->db);
return [
  'notes' => $notes->get_by_type(
    $model->inc->options->from_code('personal', 'types', 'notes', 'appui'),
    $model->inc->user->get_id()
  )
];
