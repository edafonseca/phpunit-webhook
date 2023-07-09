<?php

namespace PHPUnitWebhook;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Webhook
{
    private HttpClientInterface $client;

    public function __construct(private string $url, private string $appName)
    {
        $this->client = HttpClient::create();
    }

    public function prepared(string $id, string $name)
    {
        $this->client->request('POST', $this->url, [
            'json' => [
                'app' => $this->appName,
                'id' => $id,
                'name' => $name,
                'status' => 'prepared',
            ],
        ]);
    }

    public function passed(string $id)
    {
        $this->client->request('POST', $this->url, [
            'json' => [
                'app' => $this->appName,
                'id' => $id,
                'status' => 'passed',
            ],
        ]);
    }

    public function failed(string $id)
    {
        $this->client->request('POST', $this->url, [
            'json' => [
                'app' => $this->appName,
                'id' => $id,
                'status' => 'failed',
            ],
        ]);
        file_get_contents("http://127.0.0.1:3002/api/test?id=$id&status=failed");
    }
}
