<?php

namespace PHPUnitWebhook;

use PHPUnit\Runner\Extension\Extension;
use PHPUnit\TextUI\Configuration\Configuration;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnitWebhook\Subscribers\Failed;
use PHPUnitWebhook\Subscribers\Passed;
use PHPUnitWebhook\Subscribers\Prepared;

class PHPUnitWebhookExtension implements Extension
{
    public function __construct(private $url, private $appName)
    {}

    public function bootstrap(Configuration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        $client = new Webhook($this->url, $this->appName);

        $facade->registerSubscriber(new Prepared($client));
        $facade->registerSubscriber(new Passed($client));
        $facade->registerSubscriber(new Failed($client));
    }
}
