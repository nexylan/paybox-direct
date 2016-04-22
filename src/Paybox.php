<?php

namespace Nexy\PayboxDirect;

use Nexy\PayboxDirect\HttpClient\AbstractHttpClient;
use Nexy\PayboxDirect\HttpClient\GuzzleHttpClient;
use Nexy\PayboxDirect\OptionsResolver\OptionsResolver;
use Nexy\PayboxDirect\Response\PayboxResponse;
use Nexy\PayboxDirect\Variable\PayboxVariableActivity;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @see http://www1.paybox.com/espace-integrateur-documentation/les-solutions-paybox-direct-et-paybox-direct-plus/les-operations-de-caisse-direct-plus/
 * @see http://www1.paybox.com/espace-integrateur-documentation/dictionnaire-des-donnees/paybox-direct-et-direct-plus/
 */
final class Paybox
{
    const VERSION_DIRECT = '00103';
    const VERSION_DIRECT_PLUS = '00104';

    const VERSIONS = [
        'direct' => self::VERSION_DIRECT,
        'direct_plus' => self::VERSION_DIRECT_PLUS,
    ];

    const CURRENCY_EURO = 978;
    const CURRENCY_US_DOLLAR = 840;
    const CURRENCY_CFA = 952;

    const CURRENCIES = [
        'euro' => self::CURRENCY_EURO,
        'us_dollar' => self::CURRENCY_US_DOLLAR,
        'cfa' => self::CURRENCY_CFA,
    ];

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
     * @param string      $DATEVAL
     * @param int         $MONTANT
     * @param string      $PORTEUR
     * @param string      $REFERENCE
     * @param string|null $AUTORISATION
     * @param int|null    $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function authorize($DATEVAL, $MONTANT, $PORTEUR, $REFERENCE, $AUTORISATION = null, $DEVISE = null)
    {
        $parameters = [
            'DATEVAL' => $DATEVAL,
            'MONTANT' => $MONTANT,
            'PORTEUR' => $PORTEUR,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $AUTORISATION) {
            $parameters['AUTORISATION'] = $AUTORISATION;
        }
        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(1, $parameters);
    }

    /**
     * @param int      $MONTANT
     * @param int      $NUMAPPEL
     * @param int      $NUMTRANS
     * @param string   $REFERENCE
     * @param int|null $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function debit($MONTANT, $NUMAPPEL, $NUMTRANS, $REFERENCE, $DEVISE = null)
    {
        $parameters = [
            'MONTANT' => $MONTANT,
            'NUMAPPEL' => $NUMAPPEL,
            'NUMTRANS' => $NUMTRANS,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(2, $parameters);
    }

    /**
     * @param string      $DATEVAL
     * @param int         $MONTANT
     * @param string      $PORTEUR
     * @param string      $REFERENCE
     * @param string|null $AUTORISATION
     * @param int|null    $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function authorizeAndCapture($DATEVAL, $MONTANT, $PORTEUR, $REFERENCE, $AUTORISATION = null, $DEVISE = null)
    {
        $parameters = [
            'DATEVAL' => $DATEVAL,
            'MONTANT' => $MONTANT,
            'PORTEUR' => $PORTEUR,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $AUTORISATION) {
            $parameters['AUTORISATION'] = $AUTORISATION;
        }
        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(3, $parameters);
    }

    /**
     * @param string   $DATEVAL
     * @param int      $MONTANT
     * @param string   $PORTEUR
     * @param string   $REFERENCE
     * @param int|null $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function credit($DATEVAL, $MONTANT, $PORTEUR, $REFERENCE, $DEVISE = null)
    {
        $parameters = [
            'DATEVAL' => $DATEVAL,
            'MONTANT' => $MONTANT,
            'PORTEUR' => $PORTEUR,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(4, $parameters);
    }

    /**
     * @param int      $MONTANT
     * @param int      $NUMAPPEL
     * @param int      $NUMTRANSL
     * @param string   $REFERENCE
     * @param int|null $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function cancel($MONTANT, $NUMAPPEL, $NUMTRANSL, $REFERENCE, $DEVISE = null)
    {
        $parameters = [
            'MONTANT' => $MONTANT,
            'NUMAPPEL' => $NUMAPPEL,
            'NUMTRANSL' => $NUMTRANSL,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(5, $parameters);
    }

    /**
     * @param int      $MONTANT
     * @param string   $REFERENCE
     * @param int|null $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function check($MONTANT, $REFERENCE, $DEVISE = null)
    {
        $parameters = [
            'MONTANT' => $MONTANT,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(11, $parameters);
    }

    /**
     * @param string   $DATEVAL
     * @param int      $MONTANT
     * @param string   $PORTEUR
     * @param string   $REFERENCE
     * @param int|null $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function transact($DATEVAL, $MONTANT, $PORTEUR, $REFERENCE, $DEVISE = null)
    {
        $parameters = [
            'DATEVAL' => $DATEVAL,
            'MONTANT' => $MONTANT,
            'PORTEUR' => $PORTEUR,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(12, $parameters);
    }

    /**
     * @param int         $MONTANT
     * @param int         $NUMAPPEL
     * @param int         $NUMTRANS
     * @param string|null $AUTORISATION
     * @param int|null    $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function updateAmount($MONTANT, $NUMAPPEL, $NUMTRANS, $AUTORISATION = null, $DEVISE = null)
    {
        $parameters = [
            'MONTANT' => $MONTANT,
            'NUMAPPEL' => $NUMAPPEL,
            'NUMTRANS' => $NUMTRANS,
        ];

        if (null !== $AUTORISATION) {
            $parameters['AUTORISATION'] = $AUTORISATION;
        }
        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(13, $parameters);
    }

    /**
     * @param int      $MONTANT
     * @param int      $NUMAPPEL
     * @param int      $NUMTRANS
     * @param int|null $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function refund($MONTANT, $NUMAPPEL, $NUMTRANS, $DEVISE = null)
    {
        $parameters = [
            'MONTANT' => $MONTANT,
            'NUMAPPEL' => $NUMAPPEL,
            'NUMTRANS' => $NUMTRANS,
        ];

        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(14, $parameters);
    }

    /**
     * @param int $NUMTRANS
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function inquiry($NUMTRANS)
    {
        $parameters = [
            'NUMTRANS' => $NUMTRANS,
        ];

        return $this->httpClient->call(17, $parameters);
    }

    /**
     * @param string      $DATEVAL
     * @param string      $PORTEUR
     * @param string      $REFABONNE
     * @param string      $REFERENCE
     * @param string|null $AUTORISATION
     * @param string|null $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function authorizeSubscriber($DATEVAL, $PORTEUR, $REFABONNE, $REFERENCE, $AUTORISATION = null, $DEVISE = null)
    {
        $parameters = [
            'DATEVAL' => $DATEVAL,
            'PORTEUR' => $PORTEUR,
            'REFABONNE' => $REFABONNE,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $AUTORISATION) {
            $parameters['AUTORISATION'] = $AUTORISATION;
        }
        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(51, $parameters);
    }

    /**
     * @param int      $MONTANT
     * @param int      $NUMAPPEL
     * @param int      $NUMTRANS
     * @param string   $REFERENCE
     * @param int|null $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function debitSubscriber($MONTANT, $NUMAPPEL, $NUMTRANS, $REFERENCE, $DEVISE = null)
    {
        $parameters = [
            'MONTANT' => $MONTANT,
            'NUMAPPEL' => $NUMAPPEL,
            'NUMTRANS' => $NUMTRANS,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(52, $parameters);
    }

    /**
     * @param string   $DATEVAL
     * @param int      $MONTANT
     * @param string   $PORTEUR
     * @param string   $REFABONNE
     * @param string   $REFERENCE
     * @param int|null $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function authorizeAndCaptureSubscriber($DATEVAL, $MONTANT, $PORTEUR, $REFABONNE, $REFERENCE, $DEVISE = null)
    {
        $parameters = [
            'DATEVAL' => $DATEVAL,
            'MONTANT' => $MONTANT,
            'PORTEUR' => $PORTEUR,
            'REFABONNE' => $REFABONNE,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(53, $parameters);
    }

    /**
     * @param string   $DATEVAL
     * @param int      $MONTANT
     * @param string   $PORTEUR
     * @param string   $REFABONNE
     * @param string   $REFERENCE
     * @param int|null $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function creditSubscriber($DATEVAL, $MONTANT, $PORTEUR, $REFABONNE, $REFERENCE, $DEVISE = null)
    {
        $parameters = [
            'DATEVAL' => $DATEVAL,
            'MONTANT' => $MONTANT,
            'PORTEUR' => $PORTEUR,
            'REFABONNE' => $REFABONNE,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(54, $parameters);
    }

    /**
     * @param string   $DATEVAL
     * @param int      $MONTANT
     * @param int      $NUMAPPEL
     * @param int      $NUMTRANS
     * @param string   $PORTEUR
     * @param string   $REFABONNE
     * @param string   $REFERENCE
     * @param int|null $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function cancelSubscriberTransaction($DATEVAL, $MONTANT, $NUMAPPEL, $NUMTRANS, $PORTEUR, $REFABONNE, $REFERENCE, $DEVISE = null)
    {
        $parameters = [
            'DATEVAL' => $DATEVAL,
            'MONTANT' => $MONTANT,
            'NUMAPPEL' => $NUMAPPEL,
            'NUMTRANS' => $NUMTRANS,
            'PORTEUR' => $PORTEUR,
            'REFABONNE' => $REFABONNE,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(55, $parameters);
    }

    /**
     * @param string      $DATEVAL
     * @param int         $MONTANT
     * @param string      $PORTEUR
     * @param string      $REFABONNE
     * @param string      $REFERENCE
     * @param string|null $AUTORISATION
     * @param int|null    $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function registerSubscriber($DATEVAL, $MONTANT, $PORTEUR, $REFABONNE, $REFERENCE, $AUTORISATION = null, $DEVISE = null)
    {
        $parameters = [
            'DATEVAL' => $DATEVAL,
            'MONTANT' => $MONTANT,
            'PORTEUR' => $PORTEUR,
            'REFABONNE' => $REFABONNE,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $AUTORISATION) {
            $parameters['AUTORISATION'] = $AUTORISATION;
        }
        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(56, $parameters);
    }

    /**
     * @param string      $DATEVAL
     * @param int         $MONTANT
     * @param string      $PORTEUR
     * @param string      $REFABONNE
     * @param string|null $AUTORISATION
     * @param int|null    $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function updateSubscriber($DATEVAL, $MONTANT, $PORTEUR, $REFABONNE, $AUTORISATION = null, $DEVISE = null)
    {
        $parameters = [
            'DATEVAL' => $DATEVAL,
            'MONTANT' => $MONTANT,
            'PORTEUR' => $PORTEUR,
            'REFABONNE' => $REFABONNE,
        ];

        if (null !== $AUTORISATION) {
            $parameters['AUTORISATION'] = $AUTORISATION;
        }
        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(57, $parameters);
    }

    /**
     * @param string $REFABONNE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function deleteSubscriber($REFABONNE)
    {
        $parameters = [
            'REFABONNE' => $REFABONNE,
        ];

        return $this->httpClient->call(58, $parameters);
    }

    /**
     * @param string   $DATEVAL
     * @param int      $MONTANT
     * @param string   $PORTEUR
     * @param string   $REFABONNE
     * @param string   $REFERENCE
     * @param int|null $DEVISE
     *
     * @return PayboxResponse
     *
     * @throws Exception\PayboxException
     */
    public function transactSubscriber($DATEVAL, $MONTANT, $PORTEUR, $REFABONNE, $REFERENCE, $DEVISE = null)
    {
        $parameters = [
            'DATEVAL' => $DATEVAL,
            'MONTANT' => $MONTANT,
            'PORTEUR' => $PORTEUR,
            'REFABONNE' => $REFABONNE,
            'REFERENCE' => $REFERENCE,
        ];

        if (null !== $DEVISE) {
            $parameters['DEVISE'] = $DEVISE;
        }

        return $this->httpClient->call(61, $parameters);
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'timeout' => 10,
            'production' => false,
            'paybox_default_currency' => static::CURRENCY_EURO,
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
     * @param string          $operation
     * @param OptionsResolver $resolver
     */
    private function configurePayboxCallParameters($operation, OptionsResolver $resolver)
    {
        $parametersDefinition = $operation['parameters'];

        // Available for each Paybox Action
        $defaults = [
            'ACTIVITE' => PayboxVariableActivity::WEB_REQUEST,
            'DATEQ' => null,
        ];
        $defined = [
            'CVV',
            'DATENAISS',
            'DIFFERE',
            'ERRORCODETEST',
            'ID3D',
            'PAYS',
            'PRIV_CODETRAITEMENT',
            'SHA-1',
            'TYPECARTE',
        ];

        if (isset($parametersDefinition['defaults'])) {
            $defaults = array_merge($defaults, $parametersDefinition['defaults']);
        }
        $resolver->setDefaults($defaults);
        if (isset($parametersDefinition['required'])) {
            $resolver->setRequired($parametersDefinition['required']);
        }
        if (isset($parametersDefinition['defined'])) {
            $defined = array_merge($defined, $parametersDefinition['defined']);
        }
        $resolver->setDefined($defined);

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
                PayboxVariableActivity::NOT_SPECIFIED,
                PayboxVariableActivity::PHONE_REQUEST,
                PayboxVariableActivity::MAIL_REQUEST,
                PayboxVariableActivity::MINITEL_REQUEST,
                PayboxVariableActivity::WEB_REQUEST,
                PayboxVariableActivity::RECURRING_PAYMENT,
            ])
            ->setAllowedValuesIfDefined('DEVISE', [null, static::CURRENCY_EURO, static::CURRENCY_US_DOLLAR, static::CURRENCY_CFA])
            ->setAllowedValuesIfDefined('PAYS', '')
            ->setAllowedValuesIfDefined('SHA-1', '')
            ->setAllowedValuesIfDefined('TYPECARTE', '')
        ;
    }
}
