<?php

declare(strict_types=1);

namespace Alcedo\Bundle\JsonRpcServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class JsonRpcServerController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->json([]);
    }
}
