<?php
/** @var $ctrl \bbn\mvc\controller */
$ctrl->data['root'] = $ctrl->plugin_url('appui-notes').'/';
bindtextdomain('appui_notes', BBN_LIB_PATH.'bbn/bbn-notes/src/locale');
setlocale(LC_ALL, "fr_FR.utf8");
textdomain('appui_notes');