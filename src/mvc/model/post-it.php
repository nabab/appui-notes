<?php
$notes = $model->db->get_rows("
  SELECT bbn_notes_versions.*, COUNT(bbn_notes_medias.id_media) AS num_media
  FROM bbn_notes_versions
    JOIN bbn_notes
      ON bbn_notes_versions.id_note = bbn_notes.id
    LEFT JOIN bbn_notes_medias
      ON bbn_notes_versions.id_note = bbn_notes_medias.id_note
  WHERE bbn_notes.creator = 38
  OR bbn_notes_versions.id_user = 38
  GROUP BY bbn_notes_versions.id_note
  ORDER BY bbn_notes_versions.creation DESC
  LIMIT 25
");
return [
  'notes' => $notes
];