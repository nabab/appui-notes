<?php
/** @var \bbn\mvc\controller $ctrl */

if ( !empty($ctrl->post['title']) || !empty($ctrl->post['content']) && empty($ctrl->arguments[0]) ){
  $ctrl->action();
  return;
}
else if ( !empty($ctrl->arguments[0]) ){
  $ctrl->data['id_note'] = $ctrl->arguments[0];
  
}
$ctrl->combo(_("Markdown editor"), true);