<?php

namespace console\controllers;

use common\models\Currency;
use yii\console\Controller;
use yii\httpclient\Client;

class CurrencyController extends Controller
{
    public function actionSyncCurrency()
    {
        $client = new Client();

        $response = $client->get('https://cbu.uz/common/json/amcharts.php', [
            'rate' => 'USD'
        ])->send();

        if (!$response->isOk) {
            throw new \Exception('API error');
        }

        $data = $response->data;

        $today = date('Y-m-d');

        $todayRate = array_filter($data, function ($item) use ($today) {
            return isset($item['date']) && $item['date'] === $today;
        });

        $todayRate = reset($todayRate);

        if (!$todayRate) {
            throw new \Exception('Bugungi kurs yo‘q');
        }
        $oldCurrency = Currency::findOne(['date'=>date("Y-m-d")]);

        $model =$oldCurrency?? new Currency();
        $model->date =date("Y-m-d");
        $model->value =$todayRate['value'];
        $model->currency ='USD';
        $model->save();


        return $todayRate;



    }


}