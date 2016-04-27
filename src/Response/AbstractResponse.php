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
     * @var string|null
     */
    private $sha1 = null;

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

        if (array_key_exists('SHA-1', $data)) {
            $this->sha1 = $data['SHA-1'];
        }
    }

    /**
     * @return int
     */
    final public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    final public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    final public function getSite()
    {
        return $this->site;
    }

    /**
     * @return string
     */
    final public function getRank()
    {
        return $this->rank;
    }

    /**
     * @return int
     */
    final public function getCallNumber()
    {
        return $this->callNumber;
    }

    /**
     * @return int
     */
    final public function getQuestionNumber()
    {
        return $this->questionNumber;
    }

    /**
     * @return int
     */
    final public function getTransactionNumber()
    {
        return $this->transactionNumber;
    }

    /**
     * @return string|null
     */
    final public function getSha1()
    {
        return $this->sha1;
    }
}
