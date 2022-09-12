<?php

return [
    'title' => 'Task',
    'index' => 'Tasks',

    'cache' => [
        '_' => 'Temporary files',

        'data' => [
            '_' => 'Cached data',
            'description' => 'Delete temporary application cache data.',
            'done' => 'Temporary application data has been cleared.'
        ],
        'sessions' => [
            '_' => 'Cached sessions',
            'description' => 'Delete session data.',
            'done' => 'Session files have been cleared.'
        ],
        'views' => [
            '_' => 'Cached views',
            'description' => 'Delete cached views.',
            'done' => 'Cache views have been cleared.'
        ]
    ]
];
