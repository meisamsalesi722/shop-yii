<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment}}`.
 */
class m260719_093727_create_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'amount' => $this->bigInteger()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'gateway' => $this->string(),
            'transaction_id' => $this->string(),
            'bank_first_responce' => $this->text(),
            'bank_second_responce' => $this->text(),
            'status' => $this->tinyInteger()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('payment_user_id_key'  , 'payment' , 'user_id' , 'user' , 'id' , 'CASCADE' , 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment}}');
    }
}
