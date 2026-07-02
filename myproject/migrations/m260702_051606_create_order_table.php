<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m260702_051606_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'address_id' => $this->integer()->notNull(),
            'delivery_id' => $this->integer()->notNull(),
            'delivery_status' => $this->tinyInteger()->defaultValue(0),
            'original_price' => $this->bigInteger(),
            'order_final_amount' => $this->bigInteger(),
            'order_discount_amount' => $this->bigInteger(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'order_user_id_key',
            'order',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'order_address_id_key',
            'order',
            'address_id',
            'address',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'order_delivery_id_key',
            'order',
            'delivery_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
