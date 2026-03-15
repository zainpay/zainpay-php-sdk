<?php

namespace Zainpay\SDK;

use GuzzleHttp\Exception\GuzzleException;
use Zainpay\SDK\Lib\RequestTrait;

class Auth
{
    use RequestTrait;


    public function generateAuthToken(
        string $username,
        string $secret
    ): Response {
        return $this->postWithoutAuth($this->getModeUrl() . 'merchant/auth/token/request', [
            'username' => $username,
            'secret' => $secret
        ]);
    }

    public function regenerateAuthKeys(
        string $username,
        string $oldSecret
    ): Response {
        return $this->postWithoutAuth($this->getModeUrl() . 'merchant/auth/key/regenerate', [
            'username' => $username,
            'oldSecret' => $oldSecret
        ]);
    }

}
