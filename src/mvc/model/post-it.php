<?php
$notes =$this->db->get_rows("
  SELECT bbn_notes_version.*, COUNT()
  FROM bbn_notes_version
    JOIN bbn_notes
      ON bbn_notes_version.id_note = bbn_notes.id
    LEFT JOIN bbn_notes_medias
      ON bbn_notes_version.id_note = bbn_notes_medias.id_note
    LEFT JOIN 
  ORDER BY creation DESC
  GROUP BY id_note
");
