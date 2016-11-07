<?php
/** @var $ctrl \bbn\mvc\controller */
$ctrl->data['root'] = $ctrl->say_dir().'/';
bindtextdomain('appui_notes', BBN_LIB_PATH.'bbn/appui-notes/src/locale');
setlocale(LC_ALL, "fr_FR.utf8");
textdomain('appui_notes');
