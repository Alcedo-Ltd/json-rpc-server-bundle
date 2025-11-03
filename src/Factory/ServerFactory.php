<?php

namespace Alcedo\Bundle\JsonRpcServerBundle\Factory;

use Alcedo\JsonRpc\Server\Factory\RequestFactory;
use Alcedo\JsonRpc\Server\Server;
use Symfony\Component\DependencyInjection\Container;

class ServerFactory
{
    public function __invoke(): Server
    {
        return new Server(new RequestFactory(), new Container());
    }
}
