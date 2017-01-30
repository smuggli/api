<?php
declare(strict_types = 1);

namespace Smuggli;

class Api
{
    /** @var array */
    private $config;
    /** @var \FastRoute\Dispatcher */
    private $dispatcher;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Register APIs
     *
     * @return void
     */
    public function register(): void
    {
        $registerData = [];

        foreach ($this->config['apis'] as $api) {

            /** @var Api\ApiInterface $instance */
            $instance = new $api();

            $registerData[] = $instance->register();

        }

        $this->dispatcher = $this->createDispatcher($registerData);
    }

    /**
     * Create dispatcher for api
     *
     * @param Model\Api[] $registerData
     *
     * @return \FastRoute\Dispatcher
     */
    private function createDispatcher($registerData): \FastRoute\Dispatcher
    {
        $cb = function (\FastRoute\RouteCollector $r) use ($registerData) {
            foreach ($registerData as $data) {

                if (!is_array($data)) {
                    $data = [$data];
                }

                /** @var \Smuggli\Model\Api $api */
                foreach ($data as $api) {

                    $r->addRoute(
                        $api->getHttpMethod(), $api->getRoute(), $api->getCallback()
                    );

                }

            }
        };

        if ($this->config['cached']) {
            $dispatcher = \FastRoute\cachedDispatcher($cb);
        } else {
            $dispatcher = \FastRoute\simpleDispatcher($cb);
        }

        return $dispatcher;
    }

    /**
     * Run API request
     *
     * @return void
     */
    public function run(): void
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (strpos($uri, $this->config['apiPathPrefix']) === 0) {
            $uri = substr($uri, strlen($this->config['apiPathPrefix']));
        }

        $uri = rawurldecode($uri);

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                header("HTTP/1.1 404 Not Found");
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                #$allowedMethods = $routeInfo[1];
                header("HTTP/1.0 405 Method Not Allowed");
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                echo $handler($vars);
                // ... call $handler with $vars
                break;
        }

    }

}
