<?php
/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 20/07/17
 * Time: 17.09
 *
 * @var $model \bbn\mvc\model
 */

$res = ['success' => false];

if ( !empty($model->data['title']) &&
    ($cms = new \bbn\appui\cms($model->db)) 
){
  $notes = new \bbn\appui\note($model->db);
  if( ($notes->insert_version(
     $model->data['id_note'],
     $model->data['title'], 
     $model->data['content'])
   )  
    ){
      //if the url is not set or if it's different from the one in database it sets the url  
      if ( empty($cms->get_url($model->data['id_note'])) || 
      ( $cms->get_url($model->data['id_note']) !== $model->data['url'])
      ){
        if ( !empty($model->data['url'])){
          try {
            $cms->set_url($model->data['id_note'], $model->data['url']);
          }
          catch ( \Exception $e ){
            return ['error' =>$e->getMessage()];
          }
          
        }
        //$cms->set_url($model->data['id_note'], $model->data['url']);
      }    

      if ( empty($cms->get_event($model->data['id_note'])) ){
        $res['success'] = $cms->set_event($model->data['id_note'], [
        'start' => $model->data['start'], 
        'end' => $model->data['end'] 
      ]);
      }
      else {
        $res['success'] = $cms->update_event($model->data['id_note'], [
          //if we need the name of the event in bbn_events
        //'name' => $model->data['title'],
        'start' => $model->data['start'], 
        'end' => $model->data['end'] 
      ]);
    }    
  }
}

return $res;