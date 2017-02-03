<?php

return [
    'routes' => [
        'prefix' => 'swagger',
        'cors' => false,
    ],
    'api' => [
        'directories' => [base_path('app')],
        'excludes' => [],
        'host' => null,
    ],
];
