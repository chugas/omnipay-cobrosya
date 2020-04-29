<?php

namespace Omnipay\CobrosYa;

use Omnipay\Common\CreditCard;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setAccessToken("8d7dc5011bcc8451bcadc9ca3470dc4c");
        $this->gateway->setPaymentMethod(2);
        $this->gateway->setReturnUrl('http://october.ecommerce.com.uy/en');
        $this->gateway->setTestMode(true);
        $this->gateway->setDescription(bin2hex(random_bytes(10)));
        $this->gateway->setCard(new CreditCard([
            'firstName' => 'Bobby',
            'lastName' => 'Tables',
            'number' => '097413938',
            'email' => 'testcard@gmail.com',
        ]));
    }

    public function testPurchase()
    {
        $response = $this->gateway->purchase()->send();
        $this->assertInstanceOf('\Omnipay\CobrosYa\Message\PurchaseResponse', $response);
    }
}

?>
