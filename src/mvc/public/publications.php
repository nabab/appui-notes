<?php
if ( !empty($ctrl->post['limit']) ){ 
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
else{
  $ctrl->obj->bcolor = '#096484';
  $ctrl->obj->fcolor = '#FFF';
  $ctrl->obj->icon = 'nf nf-fa-wordpress';
  $ctrl->combo(_("Publications"), $ctrl->get_cached_model('./wp_categories'));
}