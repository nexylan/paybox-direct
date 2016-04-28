<?php

namespace Nexy\PayboxDirect\Response;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
interface ResponseInterface
{
    /**
     * Tells if response is successful based on `CODEREPONSE` parameter.
     *
     * @return bool
     */
    public function isSuccessful();

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

    /**
     * Corresponding to `AUTORISATION`.
     *
     * @return string|null|false Null if not provided, false if empty.
     */
    public function getAuthorization();

    /**
     * Corresponding to `PAYS`.
     *
     * @return string|null|false Null if not requested, false if '???' or empty string returned by Paybox.
     */
    public function getCountry();

    /**
     * Corresponding to `SHA-1`.
     *
     * @return string|null|false Null if not requested, false if empty string returned by Paybox.
     */
    public function getSha1();

    /**
     * Corresponding to `TYPECARTE`.
     *
     * @return string|null|false Null if not requested, false if empty string returned by Paybox.
     */
    public function getCardType();
}
