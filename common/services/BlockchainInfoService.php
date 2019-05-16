<?php

namespace common\services;


use yii\base\Component;
use yii\helpers\Url;
use yii\httpclient\Client;

class BlockchainInfoService extends Component
{
    /**
     * @var string
     */
    public $apiKey;

    /**
     * @var string
     */
    public $xPub;


    public function createBTCAddress() : string
    {
        $httpCli = new Client();

        $data = [
            'key' => $this->apiKey,
            'xpub' => $this->xPub,
            'callback' => !LOCAL_DEV ? Url::toRoute(['blockchain-info/check-callback'], true) : 'http://ya.ru',
        ];

        $response = $httpCli->createRequest()
            ->setMethod('get')
            ->setUrl('https://api.blockchain.info/v2/receive')
            ->setData($data)
            ->send();


        if ($response->isOk) {
            return $response->data['address'];
        }

        return $response->content . "Cant create BTC address";
    }

    /**
     * Not working. Callback does not invoke.
     *
     * @param $address
     * @param $requestId
     */
    public function setBalanceMonitor($address, $requestId)
    {
        $callback = Url::toRoute(['blockchain-info/balance-notify', 'id' => $requestId, 'secret' => $this->getSecret($requestId)], true);

        $httpCli = new Client([
            'transport' => 'yii\httpclient\CurlTransport'
        ]);

        $response = $httpCli->createRequest()
            ->setMethod('post')
            ->setUrl('https://api.blockchain.info/v2/receive/balance_update')
            ->setFormat(Client::FORMAT_JSON)
            ->setData([
                'key' => self::API_KEY,
                'addr' => $address,
                'op' => 'RECEIVE',
                'confs' => 1,
                'callback' => $callback,
                'onNotification' => 'KEEP',
            ])
            ->send();

        if ($response->isOk) {
            \Yii::info('Set monitor OK - ' . $address . "\r\n" . $response->content . "\r\n", 'btc_monitor');
        } else {
            \Yii::info('Set monitor FAIL - ' . $address . "\r\n" . $response->content . "\r\n", 'btc_monitor');
        }
    }

    public function getSecret($id)
    {
        return md5($id . 'salt');
    }
}