<?php
declare(strict_types = 1);

namespace Smuggli\Model;

class Api
{
    /** @var string */
    private $httpMethod;
    /** @var string */
    private $route;
    /** @var callable */
    private $callback;

    /**
     * Constructor
     *
     * @param string   $httpMethod
     * @param string   $route
     * @param callable $callback
     */
    public function __construct(string $httpMethod, string $route, callable $callback)
    {
        $this->httpMethod = $httpMethod;
        $this->route = $route;
        $this->callback = $callback;
    }

    /**
     * @return mixed
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

}
