<?php
/** @var $model \bbn\mvc\model */
$model->db->change('apst_web');
$columns_wp_posts = $model->db->get_columns('wp_posts');

$columns_wp_posts = array_map(function($col){      
  return 'wp_posts.'.$col;              
},array_keys($model->db->get_columns('wp_posts')));


$columns_wp_users = ['wp_users.display_name', 'wp_users.user_registered', 'user_status'];
$fields = array_merge(
  $columns_wp_posts,
  $columns_wp_users,
  [
    'url' => "CONCAT(DATE_FORMAT(wp_posts.post_date, '%Y/%m/%d/'), wp_posts.post_name)"
  ]
);

  

if ( !empty($fields) ){  
  $grid = new \bbn\appui\grid($model->db, $model->data, [
    'table' => 'wp_posts',
    'fields' => $fields,
    'join' => [[
      'table' => 'wp_users',
      'on' => [        
        'conditions' => [[
          'field' => 'wp_posts.post_author',          
          'exp' => 'wp_users.id'
        ]]
      ]
    ]],        
    /*'filters' => [[
      'field' => 'wp_posts.post_type',      
      'value' => 'page'
    ]],*/
    'order' => [[
      'field' => 'wp_posts.ID',
      'dir' => 'ASC'
    ]],    
  ]);
  
  if ( $grid->check() ){   
    $dataTable = $grid->get_datatable();
    $dataTable['data'] = array_map(function($row){    
      if ( $row['post_type'] === 'page' ){
        $part_url = explode('//', $row['guid']);
        $url =  $part_url[0].'//';
        $part_url = explode('/', $part_url[1]); 
        $url .= $part_url[0].'/'.$row['url'];
        
        $row['url_complete'] = $url; 
      }
      else{
        $row['url_complete'] = null;
        $row['url'] = null;
      }
      $row['post_content'] = \bbn\str::cut($row['post_content'], 100);
      
      return $row;
    },$dataTable['data']);
    return $dataTable;
  }
}
return ['success' => false];

