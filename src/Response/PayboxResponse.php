<?php

namespace Nexy\PayboxDirect\Response;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @method string getAuthorization()
 * @method string getCountry()
 * @method string getBearer()
 * @method string getRank()
 * @method string getSubscriberRef()
 * @method string getDiscount()
 * @method string getSha1()
 * @method string getSite()
 * @method string getStatus()
 * @method string getCardType()
 */
final class PayboxResponse extends AbstractResponse
{
    private static $availableProperties = [
        'getAuthorization' => 'AUTORISATION:string',
        'getCountry' => 'PAYS:string',
        'getBearer' => 'PORTEUR:string',
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
        parent::__construct($data);

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
