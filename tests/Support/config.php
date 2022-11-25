<?php

use ClntDev\Scrubber\Handlers\FakerHandler;

return [
    'users' => [
        'first_name' => [
            'primary_key' => 'id',
            'value' => 'faker.firstName',
            'type' => 'pid',
        ],
        'last_name' => [
            'value' => 'faker.lastName',
            'type' => 'pid',
        ],
        'email' => [
            'value' => 'faker.email',
            'handler' => FakerHandler::class,
            'type' => 'pid',
        ],
        'toggle' => [
            'value' => static fn (): bool => true,
        ],
    ],
];
