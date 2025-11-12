<?php

declare(strict_types=1);

namespace Alcedo\Bundle\JsonRpcServerBundle\Controller;

use Alcedo\Bundle\JsonRpcServerBundle\Event\JsonRpcBatchEvent;
use Alcedo\Bundle\JsonRpcServerBundle\Event\JsonRpcFailEvent;
use Alcedo\Bundle\JsonRpcServerBundle\Event\JsonRpcNotificationEvent;
use Alcedo\Bundle\JsonRpcServerBundle\Event\JsonRpcSuccessEvent;
use Alcedo\JsonRpc\Server\DTO\BatchResponse;
use Alcedo\JsonRpc\Server\Factory\ErrorFactory;
use Alcedo\JsonRpc\Server\Server as JsonRpcServer;
use Alcedo\JsonRpc\Server\DTO\Response as JsonRpcResponse;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonRpcServerController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
        // ...
    }

    public function __invoke(JsonRpcServer $server, Request $request): Response
    {
        try {
            $content = json_decode($request->getContent(), true, flags: JSON_THROW_ON_ERROR);
            $result = $server->executeArrayRequest($content);
        } catch (\JsonException $exception) {
            $result = new JsonRpcResponse(error: ErrorFactory::invalidRequest(message: $exception->getMessage()));
        }

        $this->dispatchEvent($result);

        if ($result instanceof JsonRpcResponse) {
            $this->logResponse($result);
        } elseif ($result instanceof BatchResponse) {
            $this->logger->info('[JSON-RPC Batch Request]');
            foreach ($result as $response) {
                $this->logResponse($response);
            }
        }

        if ($result instanceof BatchResponse || !$result->isNotification()) {
            return $this->json($result);
        }

        return new Response(status: Response::HTTP_NO_CONTENT);
    }

    private function logResponse(JsonRpcResponse $response): void
    {
        if ($response->isError()) {
            $error = $response->error();
            $this->logger->error(sprintf('[JSON-RPC] Error: %s %s]', $error->code(), $error->message()));
            $exception = $error->originalException();
            if ($exception) {
                $this->logger->error('[JSON-RPC] Exception: ' . $exception->getMessage(), [$exception->getTraceAsString()]);
            }
        } else {
            $this->logger->info('[JSON-RPC] Success, id: ' . $response->id());
        }
    }

    private function dispatchEvent(JsonRpcResponse|BatchResponse $response): void
    {
        if ($response instanceof BatchResponse) {
            $event = new JsonRpcBatchEvent($response);
        } else {
            if ($response->isNotification()) {
                $event = new JsonRpcNotificationEvent($response);
            } else {
                if ($response->isSuccess()) {
                    $event = new JsonRpcSuccessEvent($response);
                } else {
                    $event = new JsonRpcFailEvent($response);
                }
            }
        }
        $this->eventDispatcher->dispatch($event);
    }
}
