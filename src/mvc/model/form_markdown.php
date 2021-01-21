<?php
/** @var \bbn\mvc\model $model */
if ( !empty($model->data['title']) || !empty($model->data['content']) ){
  $res = ['success' => false];
  $note = new \bbn\appui\note($model->db);
  
  if ( !empty($model->data['id_note']) ){

    if ( $note->update(
      $model->data['id_note'],
      $model->data['title'] ?? '',
      $model->data['content'] ?? '',
      empty($model->data['private']) ? 0 : 1,
      empty($model->data['locked']) ? 0 : 1
    ) ){
      $ok = true;
    }
  }
  else if ( $id_note = $note->insert(
    $model->data['title'] ?? '',
    $model->data['content'] ?? '',
    $model->data['type'] ?? NULL,
    empty($model->data['private']) ? 0 : 1,
    empty($model->data['locked']) ? 0 : 1
  ) ){
    if ( $new_note = $note->get($id_note) ){
      $res['note'] = $new_note;
    }
    $ok = true;
  }
  if (
    $ok &&
    !empty($model->data['type']) &&
    isset($model->data['start']) &&
    ($type_news = $model->inc->options->from_code('news', 'types', 'note', 'appui')) &&
    ($model->data['type'] === $type_news) &&
    ($type_event = $model->inc->options->from_code('NEWS', 'evenements')) &&
    $model->db->insert('bbn_events', [
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
    $ok2 = true;
  }
  $res['success'] = isset($ok2) ? ($ok === $ok2) : $ok;
  return $res;
}
else if ( !empty($model->data['id_note']) ){
  $note = new \bbn\appui\note($model->db);
  return $note->get($model->data['id_note']);
}