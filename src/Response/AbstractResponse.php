<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * @var mixed[]
     */
    protected $filteredParameters;

    /**
     * @param string[] $parameters
     */
    public function __construct(array $parameters)
    {
        // Cleanup array to set false for empty/invalid values.
        $this->filteredParameters = array_map(function ($value) {
            if (in_array($value, ['', '???'], true)) {
                return false;
            }

            return $value;
        }, $parameters);

        $this->code = intval($this->filteredParameters['CODEREPONSE']);
        $this->comment = $this->filteredParameters['COMMENTAIRE'];
        $this->site = $this->filteredParameters['SITE'];
        $this->rank = $this->filteredParameters['RANG'];
        $this->callNumber = intval($this->filteredParameters['NUMAPPEL']);
        $this->questionNumber = intval($this->filteredParameters['NUMQUESTION']);
        $this->transactionNumber = intval($this->filteredParameters['NUMTRANS']);

        if (array_key_exists('AUTORISATION', $this->filteredParameters)) {
            $this->authorization = $this->filteredParameters['AUTORISATION'];
        }
        if (array_key_exists('PAYS', $this->filteredParameters)) {
            $this->country = $this->filteredParameters['PAYS'];
        }
        if (array_key_exists('SHA-1', $this->filteredParameters)) {
            $this->sha1 = $this->filteredParameters['SHA-1'];
        }
        if (array_key_exists('TYPECARTE', $this->filteredParameters)) {
            $this->cardType = $this->filteredParameters['TYPECARTE'];
        }
    }

    /**
     * {@inheritdoc}
     */
    final public function isSuccessful()
    {
        return 0 === $this->code;
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
