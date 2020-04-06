<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/

$db = new \bbn\db();
$opt = new \bbn\appui\options($db);
$notes = new \bbn\appui\notes($db);
$cms = new \bbn\appui\cms($model->db);

$all = [
  'data' => [],
  'total' => 0,
];

$notes = $cms->get_all();
if(isset($model->data['start']) && isset($model->data['limit'])){
	$all['data'] = array_slice($notes, $model->data['start'], $model->data['limit']);
}
$all['total'] = count($notes);

//$content_path = \bbn\mvc::get_content_path();
return $all;