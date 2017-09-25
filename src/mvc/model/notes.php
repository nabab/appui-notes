<?php
$notes = new \bbn\appui\notes($model->db);
$res = $notes->browse(['limit' => 25]);
if ( $res ){
  return ['notes' => $res['data']];
}
return [
  'notes' => false
];