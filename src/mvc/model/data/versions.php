<?php
/* @var \bbn\mvc\model $model */
if ( isset($model->data['id']) || isset($model->data['data']['id']) ){
  $notes = new \bbn\appui\note($model->db);
  $versions = $notes->get_versions($model->data['id'] ?? $model->data['data']['id']);
  if ( is_array($versions) ){
    return [
      'success' => true,
      'data' => array_map(function($v){
        return [
          'value' => $v['version'],
          'text' => $v['version'],
          'creation' => $v['creation'],
          'id_user' => $v['id_user']
        ];
      }, $versions)
    ];
  }
}
return ['success' => false];
