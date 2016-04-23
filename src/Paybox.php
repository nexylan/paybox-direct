<?php

namespace Nexy\PayboxDirect;

use Nexy\PayboxDirect\Enum\Activity;
use Nexy\PayboxDirect\Enum\Currency;
use Nexy\PayboxDirect\HttpClient\AbstractHttpClient;
use Nexy\PayboxDirect\HttpClient\GuzzleHttpClient;
use Nexy\PayboxDirect\OptionsResolver\OptionsResolver;
use Nexy\PayboxDirect\Request\RequestInterface;
use Nexy\PayboxDirect\Response\PayboxResponse;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @see http://www1.paybox.com/espace-integrateur-documentation/les-solutions-paybox-direct-et-paybox-direct-plus/les-operations-de-caisse-direct-plus/
 * @see http://www1.paybox.com/espace-integrateur-documentation/dictionnaire-des-donnees/paybox-direct-et-direct-plus/
 *
 * @method PayboxResponse authorize(array $parameters)
 * @method PayboxResponse debit(array $parameters)
 * @method PayboxResponse authorizeAndCapture(array $parameters)
 * @method PayboxResponse credit(array $parameters)
 * @method PayboxResponse cancel(array $parameters)
 * @method PayboxResponse check(array $parameters)
 * @method PayboxResponse transact(array $parameters)
 * @method PayboxResponse updateAmount(array $parameters)
 * @method PayboxResponse refund(array $parameters)
 * @method PayboxResponse inquiry(array $parameters)
 * @method PayboxResponse authorizeSubscriber(array $parameters)
 * @method PayboxResponse debitSubscriber(array $parameters)
 * @method PayboxResponse authorizeAndCaptureSubscriber(array $parameters)
 * @method PayboxResponse creditSubscriber(array $parameters)
 * @method PayboxResponse cancelSubscriberTransaction(array $parameters)
 * @method PayboxResponse registerSubscriber(array $parameters)
 * @method PayboxResponse updateSubscriber(array $parameters)
 * @method PayboxResponse deleteSubscriber(array $parameters)
 * @method PayboxResponse transactSubscriber(array $parameters)
 */
final class Paybox
{
    const VERSION_DIRECT = '00103';
    const VERSION_DIRECT_PLUS = '00104';

    const VERSIONS = [
        'direct' => self::VERSION_DIRECT,
        'direct_plus' => self::VERSION_DIRECT_PLUS,
    ];

    const API_URL_PRODUCTION = 'https://ppps.paybox.com/PPPS.php';
    const API_URL_RESCUE = 'https://ppps1.paybox.com/PPPS.php';
    const API_URL_TEST = 'https://preprod-ppps.paybox.com/PPPS.php';

    // TODO: Remove it
    private static $operations = [
        'authorize' => [
            'code' => '00001',
            'parameters' => [
                'defined' => [
                    'AUTORISATION',
                ],
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'DATEVAL',
                    'MONTANT',
                    'PORTEUR',
                    'REFERENCE',
                ],
            ],
        ],
        'debit' => [
            'code' => '00002',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'MONTANT',
                    'NUMAPPEL',
                    'NUMTRANS',
                    'REFERENCE',
                ],
            ],
        ],
        'authorizeAndCapture' => [
            'code' => '00003',
            'parameters' => [
                'defined' => [
                    'AUTORISATION',
                ],
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'DATEVAL',
                    'MONTANT',
                    'PORTEUR',
                    'REFERENCE',
                ],
            ],
        ],
        'credit' => [
            'code' => '00004',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'DATEVAL',
                    'MONTANT',
                    'PORTEUR',
                    'REFERENCE',
                ],
            ],
        ],
        'cancel' => [
            'code' => '00005',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'MONTANT',
                    'NUMAPPEL',
                    'NUMTRANSL',
                    'REFERENCE',
                ],
            ],
        ],
        'check' => [
            'code' => '00011',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'MONTANT',
                    'REFERENCE',
                ],
            ],
        ],
        'transact' => [
            'code' => '00012',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'DATEVAL',
                    'MONTANT',
                    'PORTEUR',
                    'REFERENCE',
                ],
            ],
        ],
        'updateAmount' => [
            'code' => '00013',
            'parameters' => [
                'defined' => [
                    'AUTORISATION',
                ],
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'MONTANT',
                    'NUMAPPEL',
                    'NUMTRANS',
                ],
            ],
        ],
        'refund' => [
            'code' => '00014',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'MONTANT',
                    'NUMAPPEL',
                    'NUMTRANS',
                ],
            ],
        ],
        'inquiry' => [
            'code' => '00017',
            'parameters' => [
                'required' => [
                    'NUMTRANS',
                ],
            ],
        ],
        'authorizeSubscriber' => [
            'code' => '00051',
            'parameters' => [
                'defined' => [
                    'AUTORISATION',
                ],
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'DATEVAL',
                    'PORTEUR',
                    'REFABONNE',
                    'REFERENCE',
                ],
            ],
        ],
        'debitSubscriber' => [
            'code' => '00052',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'MONTANT',
                    'NUMAPPEL',
                    'NUMTRANS',
                    'REFERENCE',
                ],
            ],
        ],
        'authorizeAndCaptureSubscriber' => [
            'code' => '00053',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'DATEVAL',
                    'MONTANT',
                    'PORTEUR',
                    'REFABONNE',
                    'REFERENCE',
                ],
            ],
        ],
        'creditSubscriber' => [
            'code' => '00054',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'DATEVAL',
                    'MONTANT',
                    'PORTEUR',
                    'REFABONNE',
                    'REFERENCE',
                ],
            ],
        ],
        'cancelSubscriberTransaction' => [
            'code' => '00055',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'DATEVAL',
                    'MONTANT',
                    'NUMAPPEL',
                    'NUMTRANS',
                    'PORTEUR',
                    'REFABONNE',
                    'REFERENCE',
                ],
            ],
        ],
        'registerSubscriber' => [
            'code' => '00056',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'defined' => [
                    'AUTORISATION',
                ],
                'required' => [
                    'DATEVAL',
                    'MONTANT',
                    'PORTEUR',
                    'REFABONNE',
                    'REFERENCE',
                ],
            ],
        ],
        'updateSubscriber' => [
            'code' => '00057',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'defined' => [
                    'AUTORISATION',
                ],
                'required' => [
                    'DATEVAL',
                    'MONTANT',
                    'PORTEUR',
                    'REFABONNE',
                ],
            ],
        ],
        'deleteSubscriber' => [
            'code' => '00058',
            'parameters' => [
                'required' => [
                    'REFABONNE',
                ],
            ],
        ],
        'transactSubscriber' => [
            'code' => '00061',
            'parameters' => [
                'defaults' => [
                    'DEVISE' => null,
                ],
                'required' => [
                    'DATEVAL',
                    'MONTANT',
                    'PORTEUR',
                    'REFABONNE',
                    'REFERENCE',
                ],
            ],
        ],
    ];

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
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function request(RequestInterface $request)
    {
        return $this->httpClient->call(
            $request->getRequestType(),
            $this->resolveRequestParameters($request->getParameters())
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

        $resolver->setAllowedValues('paybox_version', static::VERSIONS);
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
            ->setAllowedValuesIfDefined('ACTIVITE', [
                Activity::NOT_SPECIFIED,
                Activity::PHONE_REQUEST,
                Activity::MAIL_REQUEST,
                Activity::MINITEL_REQUEST,
                Activity::WEB_REQUEST,
                Activity::RECURRING_PAYMENT,
            ])
            ->setAllowedValuesIfDefined('DEVISE', [
                null,
                Currency::EURO,
                Currency::US_DOLLAR,
                Currency::CFA,
            ])
            ->setAllowedValuesIfDefined('PAYS', '')
            ->setAllowedValuesIfDefined('SHA-1', '')
            ->setAllowedValuesIfDefined('TYPECARTE', '')
        ;

        return $resolver->resolve($parameters);
    }
}
