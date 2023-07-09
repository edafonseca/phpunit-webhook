<?php

namespace PHPUnitWebhook\Subscribers;

use PHPUnit\Event\Test\Passed as PassedEvent;
use PHPUnit\Event\Test\PassedSubscriber;
use PHPUnitWebhook\Webhook;

class Passed implements PassedSubscriber
{

    public function __construct(private Webhook $client)
    {}

    public function notify(PassedEvent $event): void
    {
        $this->client->passed($event->test()->id());
    }
}
