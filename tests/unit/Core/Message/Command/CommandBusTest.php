<?php

namespace App\Core\Message\Command;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CommandBusTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testHandle()
    {
        $messengerBus = \Mockery::mock(MessageBusInterface::class);
        $commandBus = new CommandBus($messengerBus);
        $command = \Mockery::mock(Command::class);

        $messengerBus->expects("dispatch")->with($command)->andReturn(new Envelope($command));

        $commandBus->handle($command);
    }
}
