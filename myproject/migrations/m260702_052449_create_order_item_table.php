<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_item}}`.
 */
class m260702_052449_create_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_item}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'number' => $this->integer(),
            'final_product_price' => $this->bigInteger(),
            'final_total_price' => $this->bigInteger()->comment('productPrice * number'),
            'color_id' => $this->integer()->notNull(),
            'guarantee_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'order_item_order_id_key',
            'order_item',
            'order_id',
            'order',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'order_item_product_id_key',
            'order_item',
            'product_id',
            'product',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'order_item_color_id_key',
            'order_item',
            'color_id',
            'color',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'order_item_guarantee_key',
            'order_item',
            'guarantee_id',
            'guarantee',
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
        $this->dropTable('{{%order_item}}');
    }
}
