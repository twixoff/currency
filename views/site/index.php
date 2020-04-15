<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Currency;
use yii\helpers\ArrayHelper;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <?php $dateRange = [
        'model' => $searchModel,
        'attribute' => 'date',
        'pickerIcon' => false,
        'convertFormat' => true,
        'startAttribute' => 'start_date',
        'endAttribute' => 'end_date',
        'presetDropdown' => true,
        'pluginOptions'=>[
            'locale'=>[
                'format'=>'Y-m-d',
                'separator'=>' - ',
            ],
        ]
    ] ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'valuteID',
            'numCode',
            [
                'attribute' => 'сharCode',
                'filter' => ArrayHelper::map(Currency::find()->distinct('сharCode')->orderBy('сharCode')->all(),
                    'сharCode', 'сharCode')
            ],
            'name',
            'value',
            [
                'attribute' => 'date',
                'format' => 'date',
                'headerOptions' => ['style' => 'width: 250px;'],
                'filter' => DateRangePicker::widget($dateRange)
            ],
            [
                'label' => 'Api link',
                'value' => function($model) {
                    $getParams = Yii::$app->request->get('CurrencySearch');
                    return Html::a('open', ['api/get-currency',
                        'valuteID' => $model->valuteID,
                        'from' => $getParams['start_date'] ?: date('Y-m-d', strtotime('-1 week')),
                        'to' => $getParams['end_date'] ?: date('Y-m-d')
                    ], ['target' => '_blank']);
                },
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
            ],
        ]
    ])?>

</div>