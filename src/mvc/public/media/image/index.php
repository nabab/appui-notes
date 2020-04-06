<?php
/*
 * Describe what it does!
 *
 * @var $ctrl \bbn\mvc\controller
 *
 */



if (  $ctrl->arguments[0] ){
	$ctrl->set_mode("image");
	$medias = new \bbn\appui\medias($ctrl->db);
	if ( empty($ctrl->arguments[1]) ){
		//case of previews in block, I want the thumbnails 60 x 60
		$img = $medias->get_thumbs($medias->get_media_path($ctrl->arguments[0]));
	}
	else{
		//case of showing full picture
		$img = $medias->get_media_path($ctrl->arguments[0]);
	}
	$image= new \bbn\file\image($img);
	die(var_dump($image->display()));
}


