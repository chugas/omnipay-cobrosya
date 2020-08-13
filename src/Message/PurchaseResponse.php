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
//        return isset($this->data->error) && ($this->data->error == 0);
        return true;
    }

    /**
     * Redirect for the Payment URL
     * @return boolean
     */
    public function isRedirect()
    {
//        if(in_array($this->getRequest()->getPaymentMethod(),PAYMENT_METHODS['offline']))
//            return true;

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

            return url("/checkout");

        }

    }

    public function getTransactionReference()
    {
        return $this->getRequest()->getParameters()["access_token"];
    }

    public function getTransactionId()
    {
        return $this->getRequest()->getDescription();
    }

}

?>
