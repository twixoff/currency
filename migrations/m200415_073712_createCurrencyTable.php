<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency}}`.
 */
class m200415_073712_createCurrencyTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currency}}', [
            'id' => $this->primaryKey(),
            'valuteID' => $this->string(10)->notNull(),   // идентификатор валюты, который возвращает метод (пример: R01010)
            'numCode' => $this->integer(3)->notNull(),   // числовой код валюты (пример: 036)
            'сharCode' => $this->string(3)->notNull(),   // буквенный код валюты (пример: AUD)
            'name' => $this->string()->notNull(),               // имя валюты (пример: Австралийский доллар)
            'value' => $this->float(),                          // значение курса (пример: 43,9538)
            'date' => $this->dateTime()                         // дата публикации курса (может быть в UNIX-формате или ISO 8601)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currency}}');
    }
}
