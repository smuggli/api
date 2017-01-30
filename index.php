<?php

require 'vendor/autoload.php';

try {

    $api = new Smuggli\Api(require 'config' . DIRECTORY_SEPARATOR . 'api.php');
    $api->register();
    $api->run();

} catch (\Throwable $e) {
    // debug only atm
}