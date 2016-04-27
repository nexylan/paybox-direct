<?php

namespace Nexy\PayboxDirect\Response;

/**
 * Special response for inquiry request.
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class InquiryResponse extends AbstractResponse
{
    /**
     * @var string
     */
    private $status;

    /**
     * @var string|null
     */
    private $discount = null;

    public function __construct($data)
    {
        parent::__construct($data);

        $this->status = $data['STATUS'];

        if (array_key_exists('REMISE', $data)) {
            $this->discount = $data['REMISE'];
        }
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getDiscount()
    {
        return $this->discount;
    }
}
