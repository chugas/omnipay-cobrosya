<?php

namespace Omnipay\CobrosYa;

require_once __DIR__.'/payment_methods.php';

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{

    public function getName()
    {
        return 'CobrosYa';
    }

    public function getDefaultParameters()
    {
        return array(
            'access_token' => '',
            'payment_method' => array_merge(PAYMENT_METHODS['online'], PAYMENT_METHODS['offline']),
            'testMode' => false,
        );
    }

    public function setAccessToken($value)
    {
        return $this->setParameter('access_token', $value);
    }

    public function getAccessToken()
    {
        return $this->getParameter('access_token');
    }
    
    public function setPaymentMethod($value)
    {
        return $this->setParameter('payment_method', $value);
    }

    public function getPaymentMethod()
    {
        return $this->getParameter('payment_method');
    }

    public function setCard($value)
    {
        return $this->setParameter('card', $value);
    }

    public function getCard()
    {
        return $this->getParameter('card');
    }
    
    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    public function setDescription($value)
    {
        return $this->setParameter('description', $value);
    }

    public function getDescription()
    {
        return $this->getParameter('description');
    }

    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }

    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }

    public function setCancelUrl($value)
    {
        return $this->setParameter('cancelUrl', $value);
    }

    public function getCancelUrl()
    {
        return $this->getParameter('cancelUrl');
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\CobrosYa\Message\PurchaseRequest', $parameters);
    }
}
