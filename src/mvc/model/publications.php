<?php
  $all = [    
    'data' => [],
    'total' => 0
  ];

  if ( !empty($model->data['limit']) ){ 
    $notes = new \bbn\appui\notes($model->db);  
    $type = $model->inc->options->from_code('pages', 'types', 'notes', 'appui');
    
    $all['data'] = array_map(function($note)use($model){      
      $note['url'] = $model->db->rselect('bbn_notes_url', ['url'], [ 'id_note' => $note['id_note'] ])['url'];
      $note['content'] = \bbn\str::cut($note['content'], 100);
      return $note;
    }, $notes->get_by_type($type));
    
    $all['total'] = $notes->count_by_type($type);    
  }
return $all;