<?php

declare(strict_types=1);

namespace Alcedo\Bundle\JsonRpcServerBundle\Controller;

use Alcedo\JsonRpc\Server\DTO\Error;
use Alcedo\JsonRpc\Server\DTO\ErrorCodes;
use Alcedo\JsonRpc\Server\Factory\ErrorFactory;
use Alcedo\JsonRpc\Server\Server as JsonRpcServer;
use Alcedo\JsonRpc\Server\DTO\Response as JsonRpcResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonRpcServerController extends AbstractController
{
    public function __invoke(JsonRpcServer $server, Request $request): Response
    {
        try {
            $content = json_decode($request->getContent(), true, flags: JSON_THROW_ON_ERROR);
            $result = $server->executeArrayRequest($content);
        } catch (\JsonException $exception) {
            $result = new JsonRpcResponse(error: ErrorFactory::invalidRequest(message: $exception->getMessage()));
        }

        if ($result !== null) {
            return $this->json($result);
        }

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
