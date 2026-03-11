<?php

return [
    'shift_ranges' => [
        'morning'   => ['06:00', '13:59'],
        'afternoon' => ['14:00', '21:59'],
        'night'     => ['22:00', '05:59'],
    ],

    'shift_colors' => [
        'morning' => '#0000ff5c', // green
        'afternoon' => '#00ff004a', // yellow
        'night'   => '#ff0000ad', // blue
    ],

    'default_shift_color' => '#6c757d',

    
    'task_type' => [
        1 => 'Single Member',
        2 => 'Team Member',     
    ]

];
