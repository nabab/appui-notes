<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model */

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
        'tag' => 'h1'
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
          'border-style'=> 'dashed',
          'border-color'=> '#8a8a8a',
          'border-radius' => '3px',
          'width'=> '90%'          
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
    ]
    

    
  ]
];