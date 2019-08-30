<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\controller */
$fs = new \bbn\file\system();
$all = $fs->scan(BBN_DATA_PATH.'users');
$tmps = array_filter($all, function($a){
  return substr($a, -4) === '/tmp';
});
foreach ( $tmps as $tmp ){
  $fs->delete($tmp, false);
}
$all2 = $fs->scan(BBN_DATA_PATH.'users');


die(var_dump(
  $fs->dirsize(BBN_DATA_PATH.'users'),
  count($all),
  count($tmps),
  count($all2),
  $ctrl->get_plugins(),
  $ctrl->plugin_path(),
  $ctrl->plugin_url(),
  $ctrl->plugin_name(),
  $ctrl->tmp_path(),
  $ctrl->data_path(),
  $ctrl->user_tmp_path(),
  $ctrl->user_data_path(),
));
$p = [];
for ( $i = 0; $i < 10000; $i++ ){
  $path = \bbn\x::make_storage_path(BBN_DATA_PATH.'test/logs');
  if ( \bbn\x::indexOf($p, $path) === -1 ){
    $p[] = $path;
  }
  file_put_contents($path."/test$i.txt", 'hello world');
}
die(var_dump($p));