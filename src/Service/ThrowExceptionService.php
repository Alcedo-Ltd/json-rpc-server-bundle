<?php

namespace Alcedo\Bundle\JsonRpcServerBundle\Service;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When('dev')]
#[AutoconfigureTag('json_rpc.procedure', ['procedure_name' => 'test.throw_exception'])]
#[Autoconfigure(public: true)]
class ThrowExceptionService
{
    public function __invoke()
    {
        throw new \RuntimeException('This service will always throw an exception.', 1);
    }
}
