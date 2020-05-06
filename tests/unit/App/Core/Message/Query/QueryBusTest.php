<?php

namespace App\Core\Message\Query;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class QueryBusTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testHandle()
    {
        $messengerBus = \Mockery::mock(MessageBusInterface::class);
        $queryBus = new QueryBus($messengerBus);
        $query = \Mockery::mock(Query::class);

        $expectedResult = "test_result";
        $envelope =  new Envelope($query, [new HandledStamp($expectedResult, "test_handler")]);
        $messengerBus->expects("dispatch")->with($query)->andReturn($envelope);

        $currentResult = $queryBus->handle($query);

        $this->assertSame($expectedResult, $currentResult);
    }
}
