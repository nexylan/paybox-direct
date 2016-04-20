<?php

namespace Nexy\PayboxDirect\HttpClient;

use GuzzleHttp\Client;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class GuzzleHttpClient extends AbstractHttpClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function request($parameters)
    {
        $response = $this->client->post('', [
            'form_params' => $parameters,
        ]);

        return (string) $response->getBody();
    }
}
