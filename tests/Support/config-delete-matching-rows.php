<?php

return [
    'users' => [
        'is_admin' => [
            'primary_key' => 'id',
            'delete_matching_rows' => true,
            'value' => '1',
        ],
    ],
];
