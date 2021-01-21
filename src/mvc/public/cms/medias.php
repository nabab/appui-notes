<?php
/*
 * Describe what it does!
 *
 * @var $ctrl \bbn\mvc\controller 
 *
 */
$notes = new \bbn\appui\note();
//gets all the media in notes/media/browser
$ctrl->obj->medias = $notes->get_notes_medias();