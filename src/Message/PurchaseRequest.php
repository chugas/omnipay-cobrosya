<?php

namespace Omnipay\CobrosYa\Message;

use Omnipay\Common\Exception\InvalidCreditCardException;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        if(!$this->getCard())
            throw new InvalidCreditCardException("There is no credit card information on request", 1);
            
        $purchaseObject['id_transaccion'] = $this->getDescription();
        $purchaseObject['nombre'] = $this->getCard()->getFirstName();
        $purchaseObject['apellido'] = $this->getCard()->getLastName();
        $purchaseObject['email'] = $this->getCard()->getEmail();
        $purchaseObject['concepto'] = 'Cobro Web Ecommerce';
        $purchaseObject['celular'] = $this->getCard()->getNumber();
        $purchaseObject['moneda'] = $this->getCurrency();
        $purchaseObject['monto'] = (double)($this->formatCurrency($this->getAmount()));
        $purchaseObject['url_respuesta'] = $this->getReturnUrl();
        $this->check($purchaseObject);

        return $purchaseObject;
    }

    protected function createResponse($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    public function send(){
        return $this->sendData($this->getData());
    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function check($data)
    {
        foreach ($data as $key => $value) {
            if (!isset($value) || $value === '') {
                throw new InvalidRequestException("The $key parameter is required on CobrosYa request data");
            }
        }
    }

}

?>
