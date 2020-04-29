<?php

namespace Omnipay\CobrosYa\Message;

use Omnipay\Common\Message\AbstractResponse;

class TokenResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset($this->data->access_token);
    }

    public function getData()
    {
        return $this->data;
    }
}

?>
