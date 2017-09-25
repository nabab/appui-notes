<?php
/** @var \bbn\mvc\controller $ctrl */
if ( !empty($ctrl->post['limit']) ){
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
else{
  $ctrl->combo(_("Notes"));
}
