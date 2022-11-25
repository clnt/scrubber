<?php

use ClntDev\Scrubber\Tests\Support\Fakes\ThrowableTestObject;

return [
    'users' => [
        'first_name' => [
            'value' => new ThrowableTestObject(),
            'type' => 'pid',
        ],
    ],
];
