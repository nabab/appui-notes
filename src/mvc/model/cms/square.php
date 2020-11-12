<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model */

return [
  'lines' => [
    [
      'content' => '<p>Hello world</p>',
      'type' => 'html'
    ],[
      'content' => 'https://upload.wikimedia.org/wikipedia/commons/8/84/Example.svg',
      'type' => 'image'
    ],[
      'content' => 'https://www.youtube.com/embed/tgbNymZ7vqY',
      'type' => 'video'
    ],[
      'content' => [
        'border-width' => '10px',
        'border-style'=> 'solid',
        'border-color'=> '#8a8a8a',
        'border-radius' => '3px',
        'width'=> '90%'
      ],
      'type' => 'line'
    ],[
      'content' => 'click',
      'type' => 'button'
    ],
    [
      'content' => '30',
      'type' => 'space'
    ]
    

    
  ]
];