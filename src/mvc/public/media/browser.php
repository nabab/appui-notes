<?php

if ( !empty($ctrl->post['limit']) ){
  $ctrl->obj = $ctrl->get_model($ctrl->post);
}
else{
  //first load
  $ctrl->obj->fcolor= '#009688';
  $ctrl->obj->bcolor = '#ccffcc';
	$ctrl->obj->icon = 'nf nf-oct-file_media';
  $ctrl->combo(_('Medias browser'));
}