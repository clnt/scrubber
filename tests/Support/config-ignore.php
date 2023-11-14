<?php

return [
    'not_ignored1' => [
        'foobar' => [
            'primary_key' => 'id',
            'value' => 'faker.firstName',
            'type' => 'pid',
        ],
    ],
    'not_ignored2' => [
        'is_admin' => [
            'primary_key' => 'id',
            'value' => '1',
        ],
    ],
    'users' => [
        '*' => [
            'ignore' => true,
        ],
    ],
];
