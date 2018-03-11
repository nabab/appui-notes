<?php
/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 06/03/2018
 * Time: 15:36
 *
 * @var $ctrl \bbn\mvc\controller
 */

if ( isset($ctrl->post['limit'], $ctrl->post['start']) ){
  $ctrl->action();
}
else {
  $ctrl->obj->icon = 'fa fa-feed';
  echo $ctrl
    ->set_title(_('News'))
    ->add_js([
      'root' => APPUI_NOTES_ROOT,
      'type' => $ctrl->inc->options->from_code('news', 'types', 'notes', 'appui')
    ])
    ->get_view();
}
