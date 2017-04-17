<?php

$parent_cond = empty($model->data['id']) ? 'IS NULL' : ' = '.$model->data['id'];
//senza il secondo left jpoin per prendere il contenuto dalla tabella bbn_notes_versions
/*$prove_notes = $model->db->get_rows("
  SELECT n1.id, n1.id_parent, n1.private, n1.locked, n1.pinned, n1.creator,
  COUNT(n2.id) AS num_children
  FROM bbn_notes AS n1
    LEFT JOIN bbn_notes AS n2
        ON n1.id = n2.id_parent
        AND n2.active = 1
  WHERE n1.id_parent = 1553
  AND n1.active = 1
  GROUP BY n1.id");
return[
    'prove_notes' => $prove_notes
];*/

//UFFICIALE
/*$prove_notes = $model->db->get_rows("
SELECT n1.id, n1.id_parent, n1.private, n1.locked, n1.pinned, n1.creator, versions.title,
  GROUP_CONCAT(id_media SEPARATOR ',') AS medias,
  COUNT(n2.id) AS num_children,
  COUNT(versions.version) AS num_v
FROM bbn_notes AS n1
  LEFT JOIN bbn_notes AS n2
    ON n1.id = n2.id_parent
  LEFT JOIN bbn_notes_medias AS medias
    ON n1.id = medias.id_note
  LEFT JOIN bbn_notes_versions AS versions
    ON n1.id = versions.id_note
WHERE n1.id_parent $parent_cond
AND n1.active = 1
GROUP BY n1.id
HAVING num_v = 0
ORDER BY `n1`.`id`  DESC");

return [
  'prove_notes' => $prove_notes
];*/

$prove_notes = $model->db->get_rows("
SELECT bbn_notes.id AS myid, bbn_notes.id_parent, bbn_notes.private, bbn_notes.locked, bbn_notes.pinned, bbn_notes
.creator, 
    IFNULL((
        SELECT COUNT(bbn_notes.id)
        FROM bbn_notes
        WHERE bbn_notes.id_parent = myid
        GROUP BY bbn_notes.id_parent
    ),0) AS num_children,
    IFNULL((
        SELECT COUNT(bbn_notes_versions.version)
        FROM bbn_notes_versions
        WHERE bbn_notes_versions.id_note = myid
        GROUP BY bbn_notes_versions.id_note
    ),0) AS num_v,
  (
        SELECT GROUP_CONCAT(bbn_notes_medias.id_media SEPARATOR ',')
        FROM bbn_notes_medias
        WHERE bbn_notes_medias.id_note = myid
        GROUP BY bbn_notes_medias.id_note
    ) AS medias
FROM bbn_notes
  LEFT JOIN bbn_notes AS n2
    ON bbn_notes.id = n2.id_parent
    AND n2.active = 1
    LEFT JOIN bbn_notes_medias
    ON bbn_notes.id = bbn_notes_medias.id_note
    
WHERE bbn_notes.id_parent $parent_cond
    AND bbn_notes.active = 1
GROUP BY bbn_notes.id
/*HAVING num_v = 0*/
ORDER BY bbn_notes.id DESC
");
return[
  'prove_notes' => $prove_notes
];

/*$prove_notes = $model->db->get_rows("
SELECT n1.id, n1.id_parent, n1.private, n1.locked, n1.pinned, n1.creator, versions.title,
GROUP_CONCAT(id_media SEPARATOR ',') AS medias,
COUNT(n2.id) AS num_children
FROM bbn_notes AS n1
    LEFT JOIN bbn_notes AS n2
        ON n1.id = n2.id_parent

    LEFT JOIN bbn_notes_medias AS medias
    	ON n1.id = medias.id_note
    LEFT JOIN bbn_notes_versions AS versions
    	ON n1.id = versions.id_note
WHERE n1.id_parent IS NULL
AND n1.active = 1
GROUP BY n1.id
ORDER BY `n1`.`id`  DESC");

return[
  'prove_notes' => $prove_notes
];
*/

//CON Group_concat prendendo i vari id media di ogni nota
/*
  SELECT n1.id, n1.id_parent, n1.private, n1.locked, n1.pinned, n1.creator,versions.content,
GROUP_CONCAT(id_media SEPARATOR ',') AS medias,
COUNT(n2.id) AS num_children
  FROM bbn_notes AS n1
    LEFT JOIN bbn_notes AS n2
      ON n1.id = n2.id_parent
      AND n2.active = 1
    LEFT JOIN bbn_notes_versions AS versions
    	ON n1.id = versions.id_note
    LEFT JOIN bbn_notes_medias
		ON n1.id = bbn_notes_medias.id_note
  WHERE n1.id_parent = NULL
AND n1.active = 1
  GROUP BY n1.id
 */