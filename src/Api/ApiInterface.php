<?php
declare(strict_types = 1);

namespace Smuggli\Api;

interface ApiInterface
{
    /**
     * Register API
     *
     * @return array
     */
    public function register();
}
