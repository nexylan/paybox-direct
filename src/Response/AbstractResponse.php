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
     * @param string[] $data
     */
    public function __construct(array $data)
    {
        $this->code = intval($data['CODEREPONSE']);
        $this->comment = $data['COMMENTAIRE'];
        $this->site = $data['SITE'];
        $this->rank = $data['RANG'];
        $this->callNumber = intval($data['NUMAPPEL']);
        $this->questionNumber = intval($data['NUMQUESTION']);
        $this->transactionNumber = intval($data['NUMTRANS']);

        if (array_key_exists('AUTORISATION', $data)) {
            $this->authorization = '' === $data['AUTORISATION'] ? false : $data['AUTORISATION'];
        }
        if (array_key_exists('PAYS', $data)) {
            $this->country = in_array($data['PAYS'], ['', '???'], true) ? false : $data['PAYS'];
        }
        if (array_key_exists('SHA-1', $data)) {
            $this->sha1 = '' === $data['SHA-1'] ? false : $data['SHA-1'];
        }
        if (array_key_exists('TYPECARTE', $data)) {
            $this->cardType = '' === $data['TYPECARTE'] ? false : $data['TYPECARTE'];
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
