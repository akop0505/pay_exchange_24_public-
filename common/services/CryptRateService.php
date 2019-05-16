<?php

namespace common\services;

use common\models\CryptRates;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;

class CryptRateService
{
    private static  $_instance = null;


    protected $rateBTC = 0.0;

    protected $rateETH = 0.0;

    protected $rateBCH = 0.0;

    protected $rateXRP = 0.0;


    private final function __construct()
    {
        $this->pullRates();
    }

    /**
     * @return $this
     */
    public static function create()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    protected function pullRates()
    {
        try {

            $this->pullRatesFromCoinmarket();

            if ($this->rateBTC <= 0 || $this->rateETH <= 0 || $this->rateBCH <= 0) {
                throw new Exception('Cant get crypt rates from Coinbase');
            }

            $this->saveRatesToDB();

        } catch (\Exception $e) {
            $this->pullRatesFromDB();
        }
    }

    protected function pullRatesFromCoinmarket()
    {
        $httpCli = new Client(['transport' => 'yii\httpclient\CurlTransport']);
        $response = $httpCli->createRequest()
            ->setOptions([
                'timeout' => 10,
                'followLocation' => true
            ])
            ->setFormat(Client::FORMAT_JSON)
            ->setMethod('get')
            ->setUrl('https://api.coinmarketcap.com/v1/ticker/?convert=RUB&limit=10')
            ->send();


        if ($response->isOk) {
            $resp = json_decode($response->content, true);

            if ($resp) {
                $resp = ArrayHelper::map($resp, 'symbol', 'price_rub');

                $this->rateBTC = round((float) $resp['BTC'], 2);
                $this->rateETH = round((float) $resp['ETH'], 2);
                $this->rateBCH = round((float) $resp['BCH'], 2);
                $this->rateXRP = round((float) $resp['XRP'], 2);
            }
        }
    }

    protected function pullRatesFromDB()
    {
        $this->rateBTC = CryptRates::get('BTC')->rate;
        $this->rateETH = CryptRates::get('ETH')->rate;
        $this->rateBCH = CryptRates::get('BCH')->rate;
        $this->rateXRP = CryptRates::get('XRP')->rate;
    }

    protected function saveRatesToDB()
    {
        $model = CryptRates::get('BTC');
        $model->rate = $this->rateBTC;
        $model->save(false);

        $model = CryptRates::get('ETH');
        $model->rate = $this->rateETH;
        $model->save(false);

        $model = CryptRates::get('BCH');
        $model->rate = $this->rateBCH;
        $model->save(false);

        $model = CryptRates::get('XRP');
        $model->rate = $this->rateXRP;
        $model->save(false);
    }

    public function get($code)
    {
        $getter = 'get' . $code;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        throw new Exception('Currency not found');
    }

    public function getBTC()
    {
        return $this->rateBTC;
    }

    public function getETH()
    {
        return $this->rateETH;
    }

    public function getBCH()
    {
        return $this->rateBCH;
    }

    public function getXRP()
    {
        return $this->rateXRP;
    }
}