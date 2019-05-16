<?php

namespace backend\modules\bestchange\parsers;


use backend\modules\bestchange\rates\DirectionRatesList;
use backend\modules\bestchange\models\MonitorDirection;
use backend\modules\bestchange\rates\Rate;
use backend\modules\bestchange\rates\RatesList;
use yii\helpers\FileHelper;


/**
 * Class ApiRatesParser
 * @package backend\modules\bestchange
 */
class ApiRatesParser implements RatesParserInterface
{
    private $rates;

    private $currencies;

    private $exchangers;


    /**
     * @inheritdoc
     */
    public function getRates() : RatesList
    {
        $this->parseData();

        $ratesList = new RatesList();

        /** @var MonitorDirection[] $models */
        $models = MonitorDirection::find()->all();

        $rates = $this->rates;


        foreach ($models as $i => $model) {

            if (!isset($rates[$model->monitor_from_id]) || !isset($rates[$model->monitor_from_id][$model->monitor_to_id])) {
                continue;
            }

            uasort($rates[$model->monitor_from_id][$model->monitor_to_id], function ($a, $b) {
                if ($a["rate"] > $b["rate"]) return 1;
                if ($a["rate"] < $b["rate"]) return -1;
                return (0);
            });

            $directionRateList = new DirectionRatesList($model);

            foreach ($rates[$model->monitor_from_id][$model->monitor_to_id] as $exchangerId => $entry) {
                $directionRateList->addExchangerRate($exchangerId, new Rate($model->direction, $entry["rate"]));
            }

            $ratesList->addRates($directionRateList);
        }

        return $ratesList;
    }

    private function download($tmpFilename)
    {
        $fp = fopen($tmpFilename, "w");
        $ctx = stream_context_create(['http' =>
            [
                'timeout' => 10,
            ]
        ]);
        $content = file_get_contents("http://www.bestchange.ru/bm/info.zip", false, $ctx);
        if (strlen($content) < 10) {
            unlink($tmpFilename);
            throw new \Exception('Cant get Bestchange archive');
        }

        fputs($fp, $content);
        fclose($fp);
    }

    private function parseData()
    {
        $tmpFilename = \Yii::getAlias('@runtime/bc.zip');

        if (!file_exists($tmpFilename)) {
            throw new \Exception('Api file not found');
        }

        //$this->download($tmpFilename);

        $zip = new \ZipArchive();
        if (!$zip->open($tmpFilename)) {
            throw new \Exception('Cant open Bestchange archive');
        }

        foreach (explode("\n", iconv('CP1251', 'UTF8', $zip->getFromName("bm_cy.dat"))) as $value) {
            $entry = explode(";", $value);
            $this->currencies[$entry[0]] = $entry[2];
        }
        ksort($this->currencies);

        foreach (explode("\n", iconv('CP1251', 'UTF8', $zip->getFromName("bm_exch.dat"))) as $value) {
            $entry = explode(";", $value);
            $this->exchangers[$entry[0]] = $entry[1];
        }
        ksort($this->exchangers);

        foreach (explode("\n", iconv('CP1251', 'UTF8', $zip->getFromName("bm_rates.dat"))) as $value) {
            $entry = explode(";", $value);
            $this->rates[$entry[0]][$entry[1]][$entry[2]] = ["rate" => $entry[4] > 0 ? $entry[3] / $entry[4] : 0, "reserve" => $entry[5]];
        }

        $zip->close();
    }
}