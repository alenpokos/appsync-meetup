<?php

namespace App\Service;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class AppSync
{
    public function __construct(
        private readonly string $endpointUrl,
        private readonly string $endpointApiKey,
        private readonly HttpClientInterface $httpClient,
    )
    {}

    public function publish(string $channel, array $data): void
    {
        $graphQLquery = '{"query":"mutation publish {publish(name: \"%s\", data: \"%s\") {data, name}}","variables":null,"operationName":"publish"}';

        $data = str_replace('"', '\\\\\\"', json_encode($data, JSON_FORCE_OBJECT | JSON_HEX_QUOT));
        $body = sprintf($graphQLquery, $channel, $data);

        $this->httpClient->request('POST', $this->endpointUrl, [
            'headers' => [
                'x-api-key' => $this->endpointApiKey,
                'Content-Type' => 'application/json',
            ],
            'body' => $body,
        ]);
    }

    public function playerAction(string $position, string $player, string $hitlog): void
    {
        $payload = [
            'position' => $position,
            'player' => $player,
            'hitlog' => $hitlog,
        ];
        $this->publish('game', $payload);
    }
}
