<?php

namespace PHPUnitWebhook\Subscribers;

use PHPUnit\Event\Code\TestMethod;
use PHPUnit\Event\Test\Prepared as PreparedEvent;
use PHPUnit\Event\Test\PreparedSubscriber;
use PHPUnitWebhook\Webhook;

class Prepared implements PreparedSubscriber
{
    public function __construct(private Webhook $client)
    {}

    public function notify(PreparedEvent $event): void
    {
        $test = $event->test();
        $name = '';

        if ($test instanceof TestMethod) {
            $name = $test->testDox()->prettifiedMethodName();
        }
        $this->client->prepared($event->test()->id(), $name);
    }
}
