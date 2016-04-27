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
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @return string
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @return int
     */
    public function getCallNumber()
    {
        return $this->callNumber;
    }

    /**
     * @return int
     */
    public function getQuestionNumber()
    {
        return $this->questionNumber;
    }

    /**
     * @return int
     */
    public function getTransactionNumber()
    {
        return $this->transactionNumber;
    }
}
