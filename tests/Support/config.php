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
    'admins' => [
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
        'company' => [
            'value' => 'string handler',
        ],
    ],
    'composite_table' => [
        'composite_field' => [
            'primary_key' => ['entity_id', 'deleted', 'delta', 'langcode'],
            'value' => 'string handler',
        ],
    ],
];
