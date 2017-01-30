<?php
declare(strict_types = 1);

use \Smuggli\Api;

return [
    'apiPathPrefix' => '/api',
    'cached' => false,
    'apis' => [
        Api\Users::class
    ]
];