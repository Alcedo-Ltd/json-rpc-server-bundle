<?php

namespace Alcedo\Bundle\JsonRpcServerBundle\Event;

use Alcedo\JsonRpc\Server\DTO\Error;

final class JsonRpcFailEvent extends JsonRpcRequestEvent
{
    public function getError(): Error
    {
        return $this->response->error();
    }
}
