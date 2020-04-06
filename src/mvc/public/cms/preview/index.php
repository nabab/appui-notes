<?php
/*
 * Describe what it does!
 *
 * @var $ctrl \bbn\mvc\controller 
 *
 */

if ( !empty($ctrl->arguments[0]) ) {
  $ctrl->add_data([
    'url' => implode($ctrl->arguments, '/')
  ]);
  echo $ctrl->get_view()
    .$ctrl->get_js(APPUI_NOTES_ROOT.'cms/preview/index', $ctrl->get_model())
    .PHP_EOL.'<style>'.$ctrl->get_less().'</style>';
  //$ctrl->combo('preview', true);
}