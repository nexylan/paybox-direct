<?php

namespace Nexy\PayboxDirect\Response;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @method string getAuthorization()
 * @method int getCode()
 * @method string getComment()
 * @method int getCallNumber()
 * @method int getQuestionNumber()
 * @method int getTransactionNumber()
 * @method string getCountry()
 * @method string getRank()
 * @method string getSubscriberRef()
 * @method string getDiscount()
 * @method string getSha1()
 * @method string getSite()
 * @method string getStatus()
 * @method string getCardType()
 */
final class PayboxResponse
{
    private static $availableProperties = [
        'getAuthorization' => 'AUTORISATION:string',
        'getCode' => 'CODEREPONSE:int',
        'getComment' => 'COMMENTAIRE:string',
        'getCallNumber' => 'NUMAPPEL:int',
        'getQuestionNumber' => 'NUMQUESTION:int',
        'getTransactionNumber' => 'NUMTRANS:int',
        'getCountry' => 'PAYS:string',
        'getRank' => 'RANG:string',
        'getSubscriberRef' => 'REFABONNE:string',
        'getDiscount' => 'REMISE:string',
        'getSha1' => 'SHA-1:string',
        'getSite' => 'SITE:string',
        'getStatus' => 'STATUS:string',
        'getCardType' => 'TYPECARTE:string',
    ];

    private $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __call($name, $arguments)
    {
        if (!array_key_exists($name, static::$availableProperties)) {
            throw new \BadMethodCallException('Undefined method '.$name);
        }

        list($key, $type) = explode(':', static::$availableProperties[$name]);
        if (!array_key_exists($key, $this->data)) {
            return;
        }
        $caster = 'to'.ucfirst($type);

        return $this->$caster($this->data[$key]);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    private function toString($value)
    {
        return (string) $value;
    }

    /**
     * @param mixed $value
     *
     * @return int
     */
    private function toInt($value)
    {
        return (int) $value;
    }
}
