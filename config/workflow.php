<?php

return [
    'straight'   => [
        'type'          => 'workflow', // or 'state_machine'
        'marking_store' => [
            'type'      => 'multiple_state',
            'arguments' => ['currentPlace']
        ],
        'supports'      => ['App\Models\Project'],
        'places'        => ['task1', 'task2', 'task3', 'task4'],
        'transitions'   => [
            'task1_finished' => [
                'from' => 'task1',
                'to'   => 'task2'
            ],
            'task2_finished' => [
                'from' => 'task2',
                'to'   => 'task3'
            ],
            'task3_finished' => [
                'from' => 'task3',
                'to'   => 'task4'
            ]
        ],
    ]
];
