<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$masks = new \bbn\appui\masks($model->db);
$all = $masks->get_all();
$cats = $model->inc->options->options($masks->get_option_root());
return [
  'is_admin' => $model->inc->user->is_admin(),
  'data' => $all,
  'cats' => $cats
];