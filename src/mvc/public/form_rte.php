<?php
/** @var \bbn\mvc\controller $ctrl */

if ( !empty($ctrl->arguments[0]) ){
  $ctrl->data['id_note'] = $ctrl->arguments[0];
}
$ctrl->combo(_("Note Editor (Markdown)"), true);