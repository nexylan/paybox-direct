<?php

namespace Nexy\PayboxDirect\Response;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
interface ResponseInterface
{
    /**
     * @return int
     */
    public function getCode();

    /**
     * @return string
     */
    public function getComment();

    /**
     * @return int
     */
    public function getCallNumber();

    /**
     * @return int
     */
    public function getQuestionNumber();

    /**
     * @return int
     */
    public function getTransactionNumber();
}
