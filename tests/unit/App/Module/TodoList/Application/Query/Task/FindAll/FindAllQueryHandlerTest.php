<?php

namespace App\Module\TodoList\Application\Query\Task\FindAll;

use App\Module\TodoList\Domain\TaskRepository;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class FindAllQueryHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test__invoke()
    {
        $repository = \Mockery::mock(TaskRepository::class);
        $handler = new FindAllQueryHandler($repository);

        $expectedEntities = new \ArrayIterator([]);
        $repository->expects("findAll")->andReturn($expectedEntities);

        $currentEntities = $handler(new FindAllQuery());

        $this->assertSame($expectedEntities, $currentEntities);

    }
}
