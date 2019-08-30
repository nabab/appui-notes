<?php
if ( !empty($ctrl->post['limit']) ){
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
