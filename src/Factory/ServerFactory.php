<?php

namespace Alcedo\Bundle\JsonRpcServerBundle\Factory;

use Alcedo\JsonRpc\Server\Factory\RequestFactory;
use Alcedo\JsonRpc\Server\Server;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;

readonly class ServerFactory
{
    public function __construct(private ContainerInterface $serviceLocator)
    {
        // ...
    }

    public function __invoke(): Server
    {
        return new Server(new RequestFactory(), $this->serviceLocator);
    }
}
