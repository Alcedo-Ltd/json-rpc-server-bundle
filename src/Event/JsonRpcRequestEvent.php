<?php

namespace Alcedo\Bundle\JsonRpcServerBundle\Event;

use Alcedo\JsonRpc\Server\DTO\Response;
use Symfony\Contracts\EventDispatcher\Event;

abstract class JsonRpcRequestEvent extends Event
{
    public function __construct(protected readonly Response $response)
    {
        // ...
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}
