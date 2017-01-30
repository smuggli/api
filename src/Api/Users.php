<?php
declare(strict_types = 1);

namespace Smuggli\Api;

use Smuggli\HttpMethod;
use Smuggli\Model\Api;

class Users implements ApiInterface
{
    /** {@inheritdoc} */
    public function register()
    {
        return [
            new Api(HttpMethod::GET, '/users', [$this, 'getList']),
            new Api(HttpMethod::GET, '/users/{id:[0-9]+}', [$this, 'getUser'])
        ];
    }

    public function getList()
    {
        return 'Users requested';
    }

    public function getUser(array $parameters)
    {
        return var_export($parameters, true);
    }
}
