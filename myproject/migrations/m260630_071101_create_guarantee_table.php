<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%guarantee}}`.
 */
class m260630_071101_create_guarantee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%guarantee}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'price_increase' => $this->bigInteger()->notNull(),
            'status' => $this->tinyInteger()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%guarantee}}');
    }
}
