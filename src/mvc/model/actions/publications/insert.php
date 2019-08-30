<?php
$res = ['success' => false];

if ( isset($model->data['of_import']) ){
  $model->db->change('apst_app');  
}

$urls = array_map(function($val){  
  return $val['url'];
},$model->db->rselect_all( [
  'table' => 'bbn_notes_url',
  'fields' => ['url']      
]));


//no exist more note with the same url
if ( in_array($model->data['url'], $urls) === false ){  
  $type = $model->inc->options->from_code('pages', 'types', 'notes', 'appui');
  $type_event = $model->inc->options->from_code('PAGE', 'evenements');

  if ( (!empty($model->data['title']) || !empty($model->data['content'])) &&
    !empty($model->data['start']) &&
    !empty($type) &&
    !empty($type_event)
  ){
    $note = new \bbn\appui\notes($model->db);
    if ( $id_note = $note->insert(
      $model->data['title'] ?? '',
      $model->data['content'] ?? '',
      $type,
      empty($model->data['private']) ? 0 : 1,
      empty($model->data['locked']) ? 0 : 1
    ) ){    
      if ( $model->db->insert('bbn_events', [
          'id_type' => $type_event,
          'start' => $model->data['start'],
          'end' => !empty($model->data['end']) ? $model->data['end'] : NULL
        ]) &&
        ($id_event = $model->db->last_id()) &&
        $model->db->insert('bbn_notes_events', [
          'id_note' => $id_note,
          'id_event' => $id_event
        ])
      ){
        
        if ( !empty($model->data['url']) && 
          $model->db->insert('bbn_notes_url', [
            'id_note' => $id_note,
            'url' => $model->data['url']
          ])
        ){
          $res['success'] = true;
        }  
        $res['success'] = true;
      }     
    }
  }
}


return $res;
