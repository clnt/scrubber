<?php

use ClntDev\Scrubber\Handlers\FakerHandler;

return [
    'users' => [
        'first_name' => [
            'handler' => FakerHandler::class,
            'type' => 'pid',
        ],
    ],
];
