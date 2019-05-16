<?php

namespace common\services;


use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Enum\Param;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\EthereumAddress;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;
use yii\base\Component;


/**
 * Class CoinbaseService
 * @package common\services
 *
 * @property \Coinbase\Wallet\Client $client
 */
class CoinbaseService extends Component
{
    public $apiKey;
    
    public $apiSecret;

    /** @var Client */
    protected $client;

    protected $lastError;


    public function getRates($currency)
    {
        return $this->client->getExchangeRates($currency);
    }

    /**
     * @param $address
     * @param $amount
     * @param $idem
     * @return bool
     */
    public function sendETHFunds($address, $amount, $idem)
    {
        try {

            $transaction = Transaction::send([
                'to'        => new EthereumAddress($address),
                'amount'    => new Money($amount, CurrencyCode::ETH),
                'idem'      => $idem,
            ]);

            $this->client->createAccountTransaction($this->getAccount('ETH'), $transaction);

        } catch (\Exception $e) {

            $this->lastError = $e->getMessage();
            return false;
        }

        return true;
    }

    /**
     * @param $addressStr
     * @param $currency
     * @return bool|\Coinbase\Wallet\Resource\Transaction
     * @throws \Exception
     */
    public function getLastTransaction($addressStr, $currency)
    {
        $acc = $this->getAccount($currency);

        $address = false;
        foreach ($acc->getAddresses([Param::FETCH_ALL => true]) as $rAddress) {
            if ($rAddress->getAddress() == $addressStr) {
                $address = $rAddress;
                break;
            }
        }

        if (!$address) {
            throw new \Exception('Cant find ETH address');
        }

        $trans = false;
        foreach ($address->getTransactions([Param::FETCH_ALL => true]) as $rTrans) {
            $trans = $rTrans;
            break;
        }

        return $trans;
    }

    public function init()
    {
        parent::init();

        $conf = Configuration::apiKey($this->apiKey, $this->apiSecret);
        $this->client = Client::create($conf);
        $this->client->enableActiveRecord();
    }

    public function createETHAddress()
    {
        try {
            $address = new Address();

            $account = $this->getAccount('ETH');
            $account->createAddress($address);

            return $address->getAddress();

        } catch (\Exception $e) {

            //$this->lastError = $e->getMessage();
            return $e->getMessage();
            //return Currencies::find()->where(['send' => 'ETH'])->one()->wallet->requisite;
        }
    }

    public function createBTCAddress()
    {
        try {
            $address = new Address();

            $account = $this->getAccount('BTC');
            $account->createAddress($address);

            return $address->getAddress();

        } catch (\Exception $e) {
            return '';
            //return Currencies::find()->where(['send' => 'ETH'])->one()->wallet->requisite;
        }
    }

    public function createBCHAddress()
    {
        try {
            $address = new Address();

            $account = $this->getAccount('BCH');
            $account->createAddress($address);

            return $address->getAddress();

        } catch (\Exception $e) {
            return '';
            //return Currencies::find()->where(['send' => 'ETH'])->one()->wallet->requisite;
        }
    }

    /**
     * @param $currency
     * @return Account
     * @throws \Exception
     */
    public function getAccount($currency)
    {
        /** @var Account $account */
        foreach ($this->client->getAccounts() as $acc) {
            if ($acc->getCurrency() == $currency) {
                return $acc;
            }
        }

        throw new \Exception('Cant find Coinbase account: ' . $currency);
    }

    /**
     * @return string
     */
    public function getLastError()
    {
        return $this->lastError;
    }
}