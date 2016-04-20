<?php

namespace Nexy\PayboxDirect\HttpClient;

use Nexy\PayboxDirect\Exception\PayboxException;
use Nexy\PayboxDirect\Paybox;
use Nexy\PayboxDirect\Response\PayboxResponse;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractHttpClient implements HttpClientInterface
{
    /**
     * @var int
     */
    protected $timeout;

    /**
     * @var int
     */
    protected $baseUrl = Paybox::API_URL_TEST;

    /**
     * @var string[]
     */
    private $baseParameters;

    /**
     * @var int
     */
    private $defaultDevise;

    /**
     * @var int
     */
    private $questionNumber;

    /**
     * @param array $options
     */
    final public function __construct($options)
    {
        $this->timeout = $options['timeout'];
        $this->baseUrl = true === $options['production'] ? Paybox::API_URL_PRODUCTION : Paybox::API_URL_TEST;
        $this->baseParameters = [
            'VERSION' => $options['paybox_version'],
            'SITE' => $options['paybox_site'],
            'RANG' => $options['paybox_rang'],
            'IDENTIFIANT' => $options['paybox_identifiant'],
            'CLE' => $options['paybox_cle'],
        ];
        $this->defaultDevise = $options['paybox_devise'];
        $this->questionNumber = rand(0, time());
    }

    /**
     * {@inheritdoc}
     */
    final public function call($type, array $parameters)
    {
        $bodyParams = array_merge($parameters, $this->baseParameters);
        $bodyParams['TYPE'] = $type;
        $bodyParams['NUMQUESTION'] = $this->questionNumber;
        $bodyParams['DATEQ'] = null !== $parameters['DATEQ'] ? $parameters['DATEQ'] : date('dmYHis');
        // Restore devise from parameters if given
        if (array_key_exists('DEVISE', $parameters)) {
            $bodyParams['DEVISE'] = null !== $parameters['DEVISE'] ? $parameters['DEVISE'] : $this->defaultDevise;
        }

        $response = $this->request($bodyParams);

        // Generate results array
        $results = [];
        foreach (explode('&', $response) as $element) {
            list($key, $value) = explode('=', $element);
            $value = utf8_encode(trim($value));
            $results[$key] = $value;
        }

        $this->questionNumber = (int) $results['NUMQUESTION'] + 1;

        if ('00000' !== $results['CODEREPONSE']) {
            throw new PayboxException($results['COMMENTAIRE'], $results['CODEREPONSE']);
        }

        return new PayboxResponse($results);
    }

    /**
     * Sends a request to the server, receive a response and returns it as a string.
     *
     * @param string[] $parameters Request parameters
     *
     * @return string The response content
     */
    abstract protected function request($parameters);
}
