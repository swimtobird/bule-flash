<?php
/**
 *
 * User: swimtobird
 * Date: 2020-10-23
 * Email: <swimtobird@gmail.com>
 */

namespace Swimtobird;


use GuzzleHttp\Client;

class BlueFlash implements Flash
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $app_id;

    /**
     * @var string
     */
    protected $app_key;

    /**
     * @var string
     */
    protected $url = 'https://api.253.com';

    public function __construct($app_id, $app_key, $token)
    {
        $this->setAppId($app_id);

        $this->setToken($token);

        $this->setAppKey($app_key);
    }

    /**
     * @param $app_id
     */
    protected function setAppId($app_id): void
    {
        $this->app_id = $app_id;
    }

    /**
     * @param $token
     */
    protected function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @param $app_key
     */
    protected function setAppKey($app_key): void
    {
        $this->app_key = $app_key;
    }

    /**
     * @return string
     */
    public function getMobile(): string
    {
        $params = [
            'appId' => $this->app_id,
            'token' => $this->token,
            'sign' => $this->getSignature()
        ];

        $client = new Client(['base_uri' => $this->url]);

        $response = $client->request('POST', '/open/flashsdk/mobile-query', [
            'form_params' => $params
        ]);

        $result = json_decode($response->getBody(), true);

        if (!isset($result['code']) || $result['code'] != '200000') {
            throw new RuntimeException($result['message']);
        }

        return $this->decrypt($result['mobileName']);
    }

    /**
     * @param $content
     * @return string
     */
    protected function decrypt($content): string
    {
        $key = md5($this->app_key);

        return openssl_decrypt(
            hex2bin($content),
            'AES-128-CBC',
            substr($key, 0, 16),
            OPENSSL_RAW_DATA,
            substr($key, 16)
        );
    }

    /**
     * @param $content
     * @return string
     */
    protected function encrypt($content): string
    {
        return bin2hex(hash_hmac('sha256', $content, $this->app_key, true));
    }

    /**
     * @return string
     */
    protected function getSignature(): string
    {
        $content = 'appId' . $this->app_id . 'token' . $this->token;

        return $this->encrypt($content);
    }
}