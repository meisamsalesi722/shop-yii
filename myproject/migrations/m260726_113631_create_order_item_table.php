<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_item}}`.
 */
class m260726_113631_create_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_item}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'vendor_product_id' => $this->integer()->notNull(),
            'number' => $this->integer()->defaultValue(1),
            'final_product_price' => $this->string(),
            'final_discount' => $this->string(),
            'final_total_price' => $this->string(),
            // 'color_id' => $this->integer(),
            // 'guarantee_id' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('order_item_vendor_product_id_key' , 'order_item' , 'vendor_product_id' , 'vendor_product' , 'id' , 'CASCADE' , 'CASCADE');
        $this->addForeignKey('order_item_order_id_key' , 'order_item' , 'order_id' , 'order' , 'id' , 'CASCADE' , 'CASCADE');
    }
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_item}}');
    }
}
