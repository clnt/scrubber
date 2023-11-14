<?php

use ClntDev\Scrubber\DataHandlers\FakerHandler;

return [
    'users' => [
        'first_name' => [
            'handler' => FakerHandler::class,
            'type' => 'pid',
        ],
    ],
];
