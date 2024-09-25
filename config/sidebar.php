<?php

return [
    [
        'title' => 'PBKK 1',
        'icon' => 'fas fa-tachometer-alt',
        'route' => 'PBKK1',
        'children' => [
            ['title' => 'Even / Odd', 'route' => 'even-odd', 'icon' => 'far fa-circle', ],
            ['title' => 'Fibonacci', 'route' => 'fibonacci', 'icon' => 'far fa-circle'],
            ['title' => 'Prime Number', 'route' => 'prime-number', 'icon' => 'far fa-circle'],
            ['title' => 'Routing Parameter', 'route' => 'param', 'icon' => 'far fa-circle', 'is_param' => true],
        ],
    ],
];