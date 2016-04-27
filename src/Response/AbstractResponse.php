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
