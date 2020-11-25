<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model */
//TAKES THE IMAGES OF THE GALLERY FROM THE TEST FOLDER AND RETURNS IT WELL FORMATTED FOR THE BBN-UPLOAD
$path = $model->data_path().'poc/images/gallery';
$images = [];
if ( $gallery = scandir($path) ){
  foreach ( $gallery as $image ){
    if ( strpos($image, '.') !== 0 ){
      $img = new \bbn\file\image($path.'/'.$image);
      $extension = '.'.$img->get_extension();
      $size = $img->get_size($path.'/'.$image);
    /*  $imagick = new \Imagick($path.'/'.$image);
      die(var_dump($imagick->getImageResolution()));*/
      $images[] = [
        'src' => $image,
        //alt will arrive from db
        'alt' => '',
        'name' => $image,
        'size' => $size,
        'extension' => $extension
      ];
    }
  }
}



return [
  'lines' => [
    [
      'content' => [
        'data' => '<p>Hello world</p>'
      ],
      'type' => 'html'
    ],[
      'content' => [
        'data' => 'I\'m the title',
        'tag' => 'h1',
        'hr' => true
      ],
      'type' => 'title'
    ],[
      'content' => [
        'data' => 'italian_launguage_courses-3.png',
        'style' => [
          'width' => '75%'
        ]
      ],
      'type' => 'image'
    ],[
      'content' => [
        'data' => 'https://www.youtube.com/watch?v=zXhLFb34nz4&list=RDzXhLFb34nz4&start_radio=1',
        'style' => [
          'width' => '420',
          'height' => '315'
        ]
      ],
      'type' => 'video'
    ],[
      'content' => [
        'style' => [
					'border-width' => '1px',
          'border-style'=> 'solid',
          'border-color'=> '#bbb',
          'border-radius' => '1px',
          'width'=> '90%',
          
        ]
      ],
      'type' => 'line'
    ],[
      'content' => [
        'data' => 'click',
        'style' => [
          'font-size' => '16'
        ]
      ],
      'type' => 'button'
    ],[
			'content' => [
      	'style'=> [
      	  'height' => '30px'
      	]
      ],
      'type' => 'space'
    ],[
      'type' => 'gallery',
      'content' => [
        'columns' => 3,
        'data' => $images
        /*[
          [
            'alt' => 'Transracial Adoptee',
            'src' => "https://images.squarespace-cdn.com/content/v1/51e2f86de4b0180cf3be09fe/1596189760585-DCDHKK3GRGTFIPMSVT44/ke17ZwdGBToddI8pDm48kKAwwdAfKsTlKsCcElEApLR7gQa3H78H3Y0txjaiv_0fDoOvxcdMmMKkDsyUqMSsMWxHk725yiiHCCLfrh8O1z5QPOohDIaIeljMHgDF5CVlOqpeNLcJ80NK65_fV7S1UegTYNQkRo-Jk4EWsyBNhwKrKLo5CceA1-Tdpfgyxoog5ck0MD3_q0rY3jFJjjoLbQ/CydneyBlitzer_01.JPG?format=500w"
          ],
          [
            'alt' => 'Transracial Adoptee',
            'src' => "https://images.squarespace-cdn.com/content/v1/51e2f86de4b0180cf3be09fe/1596189764047-1KPIU8MJVIJA64OTR5IL/ke17ZwdGBToddI8pDm48kKAwwdAfKsTlKsCcElEApLR7gQa3H78H3Y0txjaiv_0fDoOvxcdMmMKkDsyUqMSsMWxHk725yiiHCCLfrh8O1z5QPOohDIaIeljMHgDF5CVlOqpeNLcJ80NK65_fV7S1UegTYNQkRo-Jk4EWsyBNhwKrKLo5CceA1-Tdpfgyxoog5ck0MD3_q0rY3jFJjjoLbQ/CydneyBlitzer_02.JPG?format=500w"
          ],
          [
            'alt' => 'Transracial Adoptee',
            'src' => "https://images.squarespace-cdn.com/content/v1/51e2f86de4b0180cf3be09fe/1596189777231-BCBX0F9NB2LB993VZO03/ke17ZwdGBToddI8pDm48kKAwwdAfKsTlKsCcElEApLR7gQa3H78H3Y0txjaiv_0fDoOvxcdMmMKkDsyUqMSsMWxHk725yiiHCCLfrh8O1z5QPOohDIaIeljMHgDF5CVlOqpeNLcJ80NK65_fV7S1UegTYNQkRo-Jk4EWsyBNhwKrKLo5CceA1-Tdpfgyxoog5ck0MD3_q0rY3jFJjjoLbQ/CydneyBlitzer_03.JPG?format=500w"
          ],
          [
            'alt' => 'Transracial Adoptee',
            'src' => "https://images.squarespace-cdn.com/content/v1/51e2f86de4b0180cf3be09fe/1596189780950-YNJRZXQE8AGRRCR0VL4R/ke17ZwdGBToddI8pDm48kKAwwdAfKsTlKsCcElEApLR7gQa3H78H3Y0txjaiv_0fDoOvxcdMmMKkDsyUqMSsMWxHk725yiiHCCLfrh8O1z5QPOohDIaIeljMHgDF5CVlOqpeNLcJ80NK65_fV7S1UegTYNQkRo-Jk4EWsyBNhwKrKLo5CceA1-Tdpfgyxoog5ck0MD3_q0rY3jFJjjoLbQ/EmilyRoe_01.JPG?format=500w"
          ],
          [
            'alt' => 'Transracial Adoptee',
            'src' => "https://images.squarespace-cdn.com/content/v1/51e2f86de4b0180cf3be09fe/1596189796239-TUNE28L71VIHHFEIVFN3/ke17ZwdGBToddI8pDm48kKAwwdAfKsTlKsCcElEApLR7gQa3H78H3Y0txjaiv_0fDoOvxcdMmMKkDsyUqMSsMWxHk725yiiHCCLfrh8O1z5QPOohDIaIeljMHgDF5CVlOqpeNLcJ80NK65_fV7S1UegTYNQkRo-Jk4EWsyBNhwKrKLo5CceA1-Tdpfgyxoog5ck0MD3_q0rY3jFJjjoLbQ/EmilyRoe_03.JPG?format=500w"
          ]
        ]*/
      ]
    ]
    

    
  ]
];