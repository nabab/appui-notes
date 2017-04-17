<?php
/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 08/02/17
 * Time: 11.06
 *
 * @var $ctrl \bbn\mvc\controller
 */
$ctrl->data = \bbn\x::merge_arrays($ctrl->data, $ctrl->post);

$ctrl->obj->data = $ctrl->get_model('./prove_notes', $ctrl->data);