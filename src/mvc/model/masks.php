<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$masks = new \bbn\appui\masks($model->db);
$all = $masks->get_all();
$cats = $model->inc->options->options('masks', 'appui');
return [
  'is_dev' => $model->inc->user->is_dev(),
  'data' => $all,
  'cats' => $cats
];