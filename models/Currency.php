<?php

namespace app\models;

class Currency extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'currency';
    }

    public function rules()
    {
        return [
            [['valuteID', 'numCode', 'сharCode', 'name', 'value', 'date'], 'required'],
            [['valuteID', 'date'], 'unique', 'targetAttribute' => ['valuteID', 'date']],
            [['date'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'valuteID' => 'Идентификатор валюты',
            'numCode' => 'Числовой код валюты',
            'сharCode' => 'Буквенный код валюты',
            'name' => 'Имя валюты',
            'value' => 'Значение курса',
            'date' => 'Дата публикации курса'
        ];
    }
}