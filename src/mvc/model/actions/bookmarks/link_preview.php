<?php
/*
 * Describe what it does or you're a pussy
 *
 **/

/** @var $model \bbn\mvc\model*/

if ( isset($model->data['url'], $model->data['ref']) && \bbn\str::is_url($model->data['url']) ){
  $linkPreview = new \LinkPreview\LinkPreview($model->data['url']);
  $parsed = $linkPreview->getParsed();
  $path = BBN_USER_PATH.'tmp/'.$model->data['ref'].'/';
  $root = \strval(time());
  \bbn\file\dir::create_path($path.$root);

  foreach ($parsed as $parserName => $link) {
    if ( $parserName === 'general' ){
      $r = [
        'url' => $link->getUrl(),
        'realurl' => $link->getRealUrl(),
        'title' => $link->getTitle(),
        'desc' => $link->getDescription(),
        'picture' => ''
      ];
      $img = $link->getImage();
      $pictures = $link->getPictures();
      
      if ( !\is_array($pictures) ){
        $pictures = [];
      }
      if ( !empty($img) ){
        array_unshift($pictures, $img);
      }
      foreach ( $pictures as $pic ){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $pic);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $saved = curl_exec($curl);
        if ( $saved && (\strlen($saved) > 1000) ){
          $new = \bbn\str::encode_filename(basename($pic), \bbn\str::file_ext(basename($pic)));
          file_put_contents($path.$root.'/'.$new, $saved);
          
          unset($saved);
       
          $img = new \bbn\file\image($path.$root.'/'.$new);

          if ( $img->test() && ($img->get_height() > 96) ){
            $img->resize(false, 96)->save();
            $r['picture'] = $root.'/'.$new;
            $r['img_path'] = $model->data['ref'].'/';
            break;
          }
        }
      }
      return ['data' => $r];
    }
  }
}