<?php
namespace frontend\components;

use common\services\CurrenciesService;
use frontend\models\Directions;

class XmlGenerator {
    private static $path = 'runtime' . DIRECTORY_SEPARATOR . 'payXml';  // путь, по которому будет сохраняться итоговый файл
    private static $fileName = 'pay.xml';                               // имя генерируемого файла
    private static $fileTTL = 15;                                       // допустимое время жизни файла в секундах

    public static function getOrGenerate() {
        self::log('run');
        $fileDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . self::$path;
        $filePath = $fileDir . DIRECTORY_SEPARATOR . self::$fileName;
        self::touchDir($fileDir);
        if(!self::checkFile($filePath)) {
            self::generate($filePath);
        }
        self::log('sending', true);
        return file_get_contents($filePath);
    }

    private static function touchDir($path) {
        if(!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }

    private static function checkFile($filePath) {
        return (file_exists($filePath) && time() - filemtime($filePath) < self::$fileTTL);
    }

    private static function generate($filePath) {
        $time = microtime(true);
        self::log('generation started');
        self::log('begin db request');
        /** @var Directions[] $models */
        $models = Directions::find()
            ->join('LEFT JOIN', 'price AS p1', 'p1.currency = d_from')
            ->join('LEFT JOIN', 'price AS p2', 'p2.currency = d_to')
            ->andWhere(['p1.enable' => true])
            ->andWhere(['p2.enable' => true])
            ->orderBy('d_from ASC')
            ->all();
        self::log('db request completed. found ' . count($models) . ' records');
        self::log('begin xml generation');

        $xml = '<rates>';
        $i = 1;
        foreach ($models as $model) {
            self::log("begin $i iteration");
            $from = $model->d_from == 'VTB24' ? 'TBRUB' : $model->d_from;
            $to = $model->d_to == 'VTB24' ? 'TBRUB' : $model->d_to;
            $code = CurrenciesService::create()->getCurrencyPublicCode($model->d_from);
            $xml .= "<item>
                        <from>$from</from>
                        <to>$to</to>
                        <in>{$model->d_in}</in>
                        <out>{$model->d_out}</out>
                        <amount>{$model->reserve->amount}</amount>
                        <minamount>{$model->exchange_limit_min} {$code}</minamount>
			            <param>manual</param>
                    </item>";
            self::log("string: from - $from, to - $to, in - {$model->d_in}, out - {$model->d_out}, amount - {$model->reserve->amount}, minamount - {$model->exchange_limit_min} {$code}, param - manual");
            self::log("$i iteration completed");
            $i++;
        }
        $xml .= '</rates>';
        self::log('xml generation completed');

        self::log('begin file saving');
        file_put_contents($filePath, $xml, LOCK_EX);
        self::log('xml-file saved');
        self::log('generation completed successfully in ' . (microtime(true) - $time) . ' seconds');
    }

    private static function log($smth, $isLast = false) {
        $logFile = fopen(dirname(__DIR__) . '/runtime/logs/monitorXml.log', 'a');
        fwrite($logFile, '[' . date('Y-m-d H:i:s') . "]: $smth\n");
        if ($isLast) {
            fwrite($logFile, "\n\n");
        }
        fclose($logFile);
    }
}