<?php

namespace Omnipay\CobrosYa\Message;

require_once __DIR__.'/../payment_methods.php';

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndpoint = 'https://api.cobrosya.com/v4/crear';
    protected $testEndpoint = 'http://api-sandbox.cobrosya.com/v4/crear';

    protected $liveEndpointCobrar = 'https://api.cobrosya.com/v4/cobrar';
    protected $testEndpointCobrar = 'http://api-sandbox.cobrosya.com/v4/cobrar';

    public function sendData($data)
    {
        //Validate access_token and payment method
        $this->validate('access_token','payment_method');

        $data['token'] = $this->getAccessToken();

        $url = $this->getEndpoint();

        //Get cobrosya payment preference
        $httpRequest = $this->httpClient->createRequest(
            'POST',
            $url,
            array(
                'content-type' => 'text/plain;charset=UTF-8',
                'content-type' => 'application/x-www-form-urlencoded',
            ),
            $data
        );

        $response = $httpRequest->send();

        $result = $this->checkResponse($response);

        if(in_array($this->getPaymentMethod(),PAYMENT_METHODS['offline'])){

            return $this->createResponse($result);

        }else{
            foreach (PAYMENT_METHODS['online'] as $key => $value) {
                if ($value === $this->getPaymentMethod()) {
                    $id_medio_pago = $key;
                }
            }

            $data = [
                '$params' => [
                    'nro_talon' => (int)$result->nro_talon,
                    'id_medio_pago' => $id_medio_pago,
                    'cuotas' => 1
                ],
                '$url' => $this->getEndpointCobrar(),
                'online'    =>  true
            ];

            return $this->createResponse($data);

        }

    }

    private function checkResponse($response)
    {
        if (!in_array($response->getStatusCode(), [200, 201]))
            throw new InvalidResponseException('Unable to conctact CobrosYa server.');

        $result = $response->xml();
        switch ((int)$result->error) {
            case 1:
                throw new InvalidResponseException('There are some required fields that are missing.');
                break;
            case 2:
                throw new InvalidResponseException('The access_token provided is incorrect.');
                break;
            case 3:
                throw new InvalidResponseException('Something wrong happened creating the payment ticket.');
                break;
            case 4:
                throw new InvalidResponseException('The Expired datetime parameter format is incorrect.');
                break;
            case 5:
                throw new InvalidResponseException('The Mobile Phone parameter format is incorrect. Please use this regexp to generate it: /^09[0‐9]{7}$/');
                break;
            case 6:
                throw new InvalidResponseException('The email parameter format is incorrect.');
                break;
            case 7:
                throw new InvalidResponseException('The currency parameter is invalid.');
                break;
            case 8:
                throw new InvalidResponseException('Amount parameter is invalid.');
                break;
            case 9:
                throw new InvalidResponseException(sprintf('Transaction nro. %s has been already cashed.',$result->nro_talon));
                break;
        }

//        if(!in_array($this->getPaymentMethod(),explode(',',$result->mediosdepago))){
//            throw new InvalidResponseException(sprintf('Transaction nro. %s has been already cashed.',$result->nro_talon));
//        }

        return $result;
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

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    protected function getEndpointCobrar()
    {
        return $this->getTestMode() ? $this->testEndpointCobrar : $this->liveEndpointCobrar;
    }

    public function toJSON($data, $options = 0)
    {
        if (version_compare(phpversion(), '5.4.0', '>=') === true) {
            return json_encode($data, $options | 64);
        }
        return str_replace('\\/', '/', json_encode($data, $options));
    }

    public function validate()
    {
        foreach (func_get_args() as $key) {
            $value = $this->parameters->get($key);
            if (!isset($value) || $value === '') {
                throw new InvalidRequestException("The $key parameter is required");
            }
        }
    }

}
