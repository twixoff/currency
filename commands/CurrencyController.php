<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Currency;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\VarDumper;
use yii\httpclient\Client;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CurrencyController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        $client = new Client();
        $client->createRequest()->setHeaders([
            'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36'
        ]);
        $response = $client->get('http://www.cbr.ru/scripts/XML_daily.asp?date_req='.date('d-m-Y'))->send();

        $lastDate = Currency::find()->max('date');
        $startDate = $lastDate ? date('d-m-Y', strtotime($lastDate)) : date('d-m-Y', strtotime('-3 month'));
        $endDate = date('d-m-Y');

        $this->stdout($startDate." - ".$endDate."\n");

        $data = $response->getData();
        foreach ($data['Valute'] as $valute) {
            $valuteId = $valute['@attributes']['ID'];
            $numCode = $valute['NumCode'];
            $charCode = $valute['CharCode'];
            $name = $valute['Name'];
            $this->stdout($valuteId.' - '.$name.' ('.$numCode.' / '.$charCode.")\n");
            $responseCourses = $client
                ->get('http://www.cbr.ru/scripts/XML_dynamic.asp?date_req1='.$startDate.'&date_req2='.$endDate.'&VAL_NM_RQ='.$valuteId)
                ->send();

            $courses = $responseCourses->getData();
            if(!empty($courses['Record'])) {
                if(!isset($courses['Record']['@attributes'])) foreach ($courses['Record'] as $course) {
                    $value = str_replace(',', '.', $course['Value']);
                    $date = $course['@attributes']['Date'];
                    $currency = new Currency();
                    $currency->valuteID = $valuteId;
                    $currency->сharCode = $charCode;
                    $currency->numCode = $numCode;
                    $currency->name = $name;
                    $currency->value = $value;
                    $currency->date = date('Y-m-d', strtotime($date));
                    if(!$currency->save()) {
                        continue;
                    }
                }
            }
        }

        return ExitCode::OK;
    }
}
