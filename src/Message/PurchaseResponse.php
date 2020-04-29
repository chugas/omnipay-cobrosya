<?php

namespace Omnipay\CobrosYa\Message;

require_once __DIR__.'/../payment_methods.php';

use Omnipay\Common\Message\AbstractResponse;

class PurchaseResponse extends AbstractResponse
{
    protected $liveEndpoint = 'https://api.cobrosya.com/v4/cobrar';
    protected $testEndpoint = 'http://api-sandbox.cobrosya.com/v4/cobrar';

    public function isSuccessful()
    {
        return isset($this->data->error) && $this->data->error;
    }

    /**
     * Redirect for the Payment URL
     * @return boolean
     */
    public function isRedirect()
    {
        return true;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectData()
    {
        return null;
    }

    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            if(in_array($this->getRequest()->getPaymentMethod(),PAYMENT_METHODS['offline']))
                return $this->data->url_pdf;
                
            return $this->getRequest()->getTestMode() ? $this->testEndpoint: $this->liveEndpoint;
        }
    }

}

?>
