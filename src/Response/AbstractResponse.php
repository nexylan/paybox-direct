<?php

namespace Nexy\PayboxDirect\Response;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractResponse implements ResponseInterface
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var string
     */
    private $site;

    /**
     * @var string
     */
    private $rank;

    /**
     * @var int
     */
    private $callNumber;

    /**
     * @var int
     */
    private $questionNumber;

    /**
     * @var int
     */
    private $transactionNumber;

    /**
     * @var string|null|false
     */
    private $authorization = null;

    /**
     * @var string|null|false
     */
    private $country = null;

    /**
     * @var string|null|false
     */
    private $sha1 = null;

    /**
     * @var string|null|false
     */
    private $cardType = null;

    /**
     * @param string[] $parameters
     */
    public function __construct(array $parameters)
    {
        // Cleanup array to set false for empty/invalid values.
        array_walk($parameters, function (&$value) {
            if (in_array($value, ['', '???'], true)) {
                $value = false;
            }
        });

        $this->code = intval($parameters['CODEREPONSE']);
        $this->comment = $parameters['COMMENTAIRE'];
        $this->site = $parameters['SITE'];
        $this->rank = $parameters['RANG'];
        $this->callNumber = intval($parameters['NUMAPPEL']);
        $this->questionNumber = intval($parameters['NUMQUESTION']);
        $this->transactionNumber = intval($parameters['NUMTRANS']);

        if (array_key_exists('AUTORISATION', $parameters)) {
            $this->authorization = $parameters['AUTORISATION'];
        }
        if (array_key_exists('PAYS', $parameters)) {
            $this->country = $parameters['PAYS'];
        }
        if (array_key_exists('SHA-1', $parameters)) {
            $this->sha1 = $parameters['SHA-1'];
        }
        if (array_key_exists('TYPECARTE', $parameters)) {
            $this->cardType = $parameters['TYPECARTE'];
        }
    }

    /**
     * {@inheritdoc}
     */
    final public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    final public function getComment()
    {
        return $this->comment;
    }

    /**
     * {@inheritdoc}
     */
    final public function getSite()
    {
        return $this->site;
    }

    /**
     * {@inheritdoc}
     */
    final public function getRank()
    {
        return $this->rank;
    }

    /**
     * {@inheritdoc}
     */
    final public function getCallNumber()
    {
        return $this->callNumber;
    }

    /**
     * {@inheritdoc}
     */
    final public function getQuestionNumber()
    {
        return $this->questionNumber;
    }

    /**
     * {@inheritdoc}
     */
    final public function getTransactionNumber()
    {
        return $this->transactionNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * {@inheritdoc}
     */
    final public function getSha1()
    {
        return $this->sha1;
    }

    /**
     * {@inheritdoc}
     */
    public function getCardType()
    {
        return $this->cardType;
    }
}
