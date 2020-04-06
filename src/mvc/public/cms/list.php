<?php
if ( !empty($ctrl->post['limit']) ){
  $ctrl->obj = $ctrl->get_model($ctrl->post);
}
else{
  $ctrl->obj->bcolor = '#E600BF';
  $ctrl->obj->fcolor = '#FFF';
  $ctrl->obj->icon = 'nf nf-fa-newspaper_o';
  $ctrl->combo(_("Cms"), true);
  //$ctrl->combo(_("Publications"), $ctrl->get_cached_model('notes/wp_categories'));
}