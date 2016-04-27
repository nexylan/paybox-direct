<?php

namespace Nexy\PayboxDirect\Response;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
interface ResponseInterface
{
    /**
     * Corresponding to `CODEREPONSE`.
     *
     * @return int
     */
    public function getCode();

    /**
     * Corresponding to `COMMENTAIRE`.
     *
     * @return string
     */
    public function getComment();

    /**
     * Corresponding to `SITE`.
     *
     * @return string
     */
    public function getSite();

    /**
     * Corresponding to `RANG`.
     *
     * @return string
     */
    public function getRank();

    /**
     * Corresponding to `NUMAPPEL`.
     *
     * @return int
     */
    public function getCallNumber();

    /**
     * Corresponding to `NUMQUESTION`.
     *
     * @return int
     */
    public function getQuestionNumber();

    /**
     * Corresponding to `NUMTRANS`.
     *
     * @return int
     */
    public function getTransactionNumber();
}
