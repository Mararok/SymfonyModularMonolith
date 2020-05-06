<?php

namespace App\Core\Message\Event;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class EventBusTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testHandle()
    {
        $messengerBus = \Mockery::mock(MessageBusInterface::class);
        $eventBus = new EventBus($messengerBus);
        $event = \Mockery::mock(Event::class);

        $messengerBus->expects("dispatch")->with($event)->andReturn(new Envelope($event));

        $eventBus->handle($event);
    }
}
