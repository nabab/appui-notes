<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$model->db->change('apst_web');
$res = [
  'types' => $model->db->get_column_values('wp_posts', 'post_type'),
  'statuses' => $model->db->get_column_values('wp_posts', 'post_status')
];
$model->db->change('apst_app');
return $res;