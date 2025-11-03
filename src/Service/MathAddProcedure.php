<?php

namespace Alcedo\Bundle\JsonRpcServerBundle\Service;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\DependencyInjection\Attribute\When;

#[When('dev')]
#[Autoconfigure(public: true)]
#[AutoconfigureTag('json_rpc.procedure', ['procedure_name' => 'test.math_add'])]
class MathAddProcedure
{
    public function __invoke(int $a, int $b): int
    {
        return $a + $b;
    }
}
