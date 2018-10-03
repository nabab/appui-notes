<?php
/**
 * Created by BBN Solutions.
 * User: Mirko Argentino
 * Date: 06/03/2018
 * Time: 15:36
 *
 * @var $ctrl \bbn\mvc\controller
 */

$ctrl->obj->icon = 'fas fa-rss-square';
$ctrl->combo(_('News'), [
  'root' => APPUI_NOTES_ROOT,
  'type' => $ctrl->inc->options->from_code('news', 'types', 'notes', 'appui')
]);