<?php

namespace Nexy\PayboxDirect;

use Nexy\PayboxDirect\Enum\Activity;
use Nexy\PayboxDirect\Enum\Currency;
use Nexy\PayboxDirect\Enum\Version;
use Nexy\PayboxDirect\HttpClient\AbstractHttpClient;
use Nexy\PayboxDirect\HttpClient\GuzzleHttpClient;
use Nexy\PayboxDirect\OptionsResolver\OptionsResolver;
use Nexy\PayboxDirect\Request\RequestInterface;
use Nexy\PayboxDirect\Response\DirectPlusResponse;
use Nexy\PayboxDirect\Response\DirectResponse;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @see http://www1.paybox.com/espace-integrateur-documentation/les-solutions-paybox-direct-et-paybox-direct-plus/les-operations-de-caisse-direct-plus/
 * @see http://www1.paybox.com/espace-integrateur-documentation/dictionnaire-des-donnees/paybox-direct-et-direct-plus/
 */
final class Paybox
{
    const API_URL_PRODUCTION = 'https://ppps.paybox.com/PPPS.php';
    const API_URL_RESCUE = 'https://ppps1.paybox.com/PPPS.php';
    const API_URL_TEST = 'https://preprod-ppps.paybox.com/PPPS.php';

    /**
     * @var AbstractHttpClient
     */
    private $httpClient;

    /**
     * @var array
     */
    private $options;

    public function __construct(array $options = [], AbstractHttpClient $httpClient = null)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);

        $this->httpClient = $httpClient ? $httpClient : new GuzzleHttpClient();
        $this->httpClient->setOptions($this->options);
        $this->httpClient->init();
    }

    /**
     * @param RequestInterface $request
     *
     * @return DirectResponse
     */
    public function sendDirectRequest(RequestInterface $request)
    {
        if ($request->getRequestType() >= RequestInterface::SUBSCRIBER_AUTHORIZE) {
            throw new \InvalidArgumentException(
                'Direct Plus requests must be passed onto '.__CLASS__.'::sendDirectPlusRequest method.'
            );
        }

        return $this->request($request);
    }

    /**
     * @param RequestInterface $request
     *
     * @return DirectPlusResponse
     */
    public function sendDirectPlusRequest(RequestInterface $request)
    {
        if ($request->getRequestType() < RequestInterface::SUBSCRIBER_AUTHORIZE) {
            throw new \InvalidArgumentException(
                'Direct requests must be passed onto '.__CLASS__.'::sendDirectRequest method.'
            );
        }

        return $this->request($request, true);
    }

    /**
     * @param RequestInterface $request
     * @param bool             $directPlus
     *
     * @return DirectResponse|DirectPlusResponse
     *
     * @throws Exception\PayboxException
     */
    private function request(RequestInterface $request, $directPlus = false)
    {
        return $this->httpClient->call(
            $request->getRequestType(),
            $this->resolveRequestParameters($request->getParameters()),
            $directPlus
        );
    }

    /**
     * Paybox base options validation.
     *
     * @param OptionsResolver $resolver
     */
    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'timeout' => 10,
            'production' => false,
            'paybox_default_currency' => Currency::EURO,
        ]);
        $resolver->setRequired([
            'paybox_version', // Paybox Direct Plus protocol
            'paybox_site',
            'paybox_rank',
            'paybox_identifier',
            'paybox_key',
        ]);

        $resolver->setAllowedTypes('timeout', 'int');
        $resolver->setAllowedTypes('production', 'bool');
        $resolver->setAllowedTypes('paybox_version', 'string');
        $resolver->setAllowedTypes('paybox_default_currency', 'int');
        $resolver->setAllowedTypes('paybox_site', 'string');
        $resolver->setAllowedTypes('paybox_rank', 'string');
        $resolver->setAllowedTypes('paybox_identifier', 'string');
        $resolver->setAllowedTypes('paybox_key', 'string');

        $resolver->setAllowedValues('paybox_version', Version::getConstants());
    }

    /**
     * Paybox request paramaters validation.
     *
     * @param array $parameters
     *
     * @return array
     */
    private function resolveRequestParameters(array $parameters)
    {
        $resolver = new OptionsResolver();

        // Defines parameters keys to enable them.
        foreach (array_keys($parameters) as $key) {
            $resolver->setDefined($key);
        }

        $resolver
            ->setAllowedTypesIfDefined('ACQUEREUR', 'string')
            ->setAllowedTypesIfDefined('ACTIVITE', 'int')
            ->setAllowedTypesIfDefined('ARCHIVAGE', 'string')
            ->setAllowedTypesIfDefined('AUTORISATION', 'string')
            ->setAllowedTypesIfDefined('CVV', 'string')
            ->setAllowedTypesIfDefined('DATENAISS', 'string')
            ->setAllowedTypesIfDefined('DATEQ', ['string', 'null'])
            ->setAllowedTypesIfDefined('DATEVAL', 'string')
            ->setAllowedTypesIfDefined('DEVISE', ['int', 'null'])
            ->setAllowedTypesIfDefined('DIFFERE', 'int')
            ->setAllowedTypesIfDefined('ERRORCODETEST', 'int')
            ->setAllowedTypesIfDefined('ID3D', 'string')
            ->setAllowedTypesIfDefined('MONTANT', 'int')
            ->setAllowedTypesIfDefined('NUMAPPEL', 'int')
            ->setAllowedTypesIfDefined('NUMTRANS', 'int')
            ->setAllowedTypesIfDefined('PORTEUR', 'string')
            ->setAllowedTypesIfDefined('PRIV_CODETRAITEMENT', 'string')
            ->setAllowedTypesIfDefined('REFABONNE', 'string')
            ->setAllowedTypesIfDefined('REFERENCE', 'string') // TODO: Auto-generated if not provided?
        ;

        $resolver
            ->setAllowedValuesIfDefined('ACQUEREUR', ['PAYPAL', 'EMS', 'ATOSBE', 'BCMC', 'PSC', 'FINAREF', 'BUYSTER', '34ONEY'])
            ->setAllowedValuesIfDefined('ACTIVITE', Activity::getConstants())
            ->setAllowedValuesIfDefined('DEVISE', array_merge([null], Currency::getConstants()))
            ->setAllowedValuesIfDefined('PAYS', '')
            ->setAllowedValuesIfDefined('SHA-1', '')
            ->setAllowedValuesIfDefined('TYPECARTE', '')
        ;

        return $resolver->resolve($parameters);
    }
}
