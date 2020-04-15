<?php

namespace app\controllers;

use yii\web\Response;
use app\models\Currency;
use yii\rest\Controller;

class ApiController extends Controller
{

    public function actionGetCurrency($valuteID, $from, $to)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $result = Currency::find()->where(['valuteID' => $valuteID])
            ->andWhere(['BETWEEN', 'date', date('Y-m-d', strtotime($from)), date('Y-m-d', strtotime($to))])
        ->all();

        return $result;
    }

}