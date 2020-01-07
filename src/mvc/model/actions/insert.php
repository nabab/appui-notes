<?php
/** @var \bbn\mvc\model $model */

$res = ['success' => false];

if ( !empty($model->data['title']) || !empty($model->data['content']) ){
  $note = new \bbn\appui\notes($model->db);
  if ( $id_note = $note->insert(
    $model->data['title'] ?? '',
    $model->data['content'] ?? '',
    $model->data['type'] ?? NULL,
    empty($model->data['private']) ? 0 : 1,
    empty($model->data['locked']) ? 0 : 1
  ) ){
    $ok = true;
    if ( 
      !empty($model->data['type']) &&
      isset($model->data['start']) &&
      ($type_news = $model->inc->options->from_code('news', 'types', 'notes', 'appui')) &&
      ($model->data['type'] === $type_news) &&
      ($type_event = $model->inc->options->from_code('NEWS', 'evenements')) &&
      $model->db->insert('bbn_events', [
        'id_type' => $type_event,
        'start' => $model->data['start'],
        'end' => !empty($model->data['end']) && (strtotime($model->data['start']) < strtotime($model->data['end'])) ? $model->data['end'] : NULL
      ]) &&
      ($id_event = $model->db->last_id()) &&
      $model->db->insert('bbn_notes_events', [
        'id_note' => $id_note,
        'id_event' => $id_event
      ])
    ){
      $ok2 = true;
    }
    $res['success'] = isset($ok2) ? ($ok === $ok2) : $ok;
  }
}
return $res;