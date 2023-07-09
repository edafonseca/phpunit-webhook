<?php

namespace PHPUnitWebhook\Subscribers;

use PHPUnit\Event\Test\Failed as FailedEvent;
use PHPUnit\Event\Test\FailedSubscriber;
use PHPUnitWebhook\Webhook;

class Failed implements FailedSubscriber
{
    public function __construct(private Webhook $client)
    {}

    public function notify(FailedEvent $event): void
    {
        $this->client->failed($event->test()->id());
    }
}
