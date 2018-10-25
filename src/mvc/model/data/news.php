<?php
/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 13/09/2018
 * Time: 10:40
 */

if ( isset($model->data['limit'], $model->data['start']) ){
  $grid = new \bbn\appui\grid($model->db, $model->data, [
    'tables' => 'bbn_notes',
    'fields' => [
      'versions1.id_note',
      'note_title' => 'versions1.title',
      'note_content' => 'versions1.content',
      'note_id_user' => 'versions1.id_user',
      'note_creation' => 'versions1.creation'
    ],
    'join' => [[
      'table' => 'bbn_notes_versions',
      'type' => 'left',
      'alias' => 'versions1',
      'on' => [
        'conditions' => [[
          'field' => 'bbn_notes.id',
          'exp' => 'versions1.id_note'
        ]]
      ]
    ], [
      'table' => 'bbn_notes_versions',
      'type' => 'left',
      'alias' => 'versions2',
      'on' => [
        'conditions' => [[
          'field' => 'bbn_notes.id',
          'exp' => 'versions2.id_note'
        ], [
          'field' => 'versions1.version',
          'operator' => '<',
          'exp' => 'versions2.version'
        ]]
      ]
    ]],
    'filters' => [
      'conditions' => [[
        'field' => 'bbn_notes.id_type',
        'value' => $model->inc->options->from_code('news', 'types', 'notes', 'appui')
      ], [
        'field' => 'bbn_notes.active',
        'value' => 1
      ], [
        'field' => 'versions2.version',
        'operator' => 'isnull'
      ]]
    ],
    'group_by' => 'bbn_notes.id',
    'order' => [[
      'field' => 'versions1.version',
      'dir' => 'DESC'
    ], [
      'field' => 'versions1.creation',
      'dir' => 'DESC'
    ]]
  ]);

  if ( $grid->check() ){
    return $grid->get_datatable();
  }
}