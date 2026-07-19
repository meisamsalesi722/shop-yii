<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m260710_092834_create_order_table extends Migration
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
            'original_price' => $this->string(),
            'order_final_amount' => $this->string(),
            'order_discount_amount' => $this->string(),
            'copan_id' => $this->integer(),
            'order_copan_discount_amount' => $this->string(),
            'order_total_products_discount_amount' => $this->string(),
            'order_status' => $this->tinyInteger()->defaultValue(0),
            'payment_status' => $this->tinyInteger()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('order_address_id_key' , 'order' , 'address_id' , 'address' , 'id' , 'CASCADE' , 'CASCADE');
        $this->addForeignKey('order_user_id_key' , 'order' , 'user_id' , 'user' , 'id' , 'CASCADE' , 'CASCADE');
        $this->addForeignKey('order_copan_id_key' , 'order' , 'copan_id' , 'copan' , 'id' , 'CASCADE' , 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
