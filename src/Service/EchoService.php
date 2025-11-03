<?php

namespace Alcedo\Bundle\JsonRpcServerBundle\Service;

use Alcedo\JsonRpc\Server\DTO\Response;
use Alcedo\JsonRpc\Server\RemoteProcedureInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\DependencyInjection\Attribute\When;

#[
    When('dev'),
    AutoconfigureTag('json_rpc.procedure', ['procedure_name' => 'test.echo']),
    Autoconfigure(public: true)
]
class EchoService implements RemoteProcedureInterface
{
    public function call(...$args): Response
    {
        return new Response($args);
    }
}
