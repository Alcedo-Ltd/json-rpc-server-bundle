<?php

namespace Alcedo\Bundle\JsonRpcServerBundle\Service;

use Alcedo\JsonRpc\Server\DTO\Response;
use Alcedo\JsonRpc\Server\RemoteProcedureInterface;

class EchoService implements RemoteProcedureInterface
{
    public function call(...$args): Response
    {
        return new Response($args);
    }
}
