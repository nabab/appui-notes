<?php
/** @var $model \bbn\mvc\model */
$notes = new \bbn\appui\note($model->db);
return [
  'notes' => $notes->get_by_type(
    $model->inc->options->from_code('personal', 'types', 'note', 'appui'),
    $model->inc->user->get_id()
  )
];
