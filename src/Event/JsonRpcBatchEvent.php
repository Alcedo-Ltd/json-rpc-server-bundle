<?php

namespace Alcedo\Bundle\JsonRpcServerBundle\Event;

use Alcedo\JsonRpc\Server\DTO\BatchResponse;

final readonly class JsonRpcBatchEvent
{
    public function __construct(private BatchResponse $response)
    {
        // ...
    }

    /**
     * @return BatchResponse
     */
    public function getResponse(): BatchResponse
    {
        return $this->response;
    }
}
