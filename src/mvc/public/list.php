<?php
if ( empty($ctrl->post) ){
  echo $ctrl->combo("My notes", [
    'lng' => [
      'text' => _("Text"),
      'title' => _("Title")
    ],
    'root' => $ctrl->data['root']
  ]);
}
else{
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}
