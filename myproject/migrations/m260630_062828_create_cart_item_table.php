<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart_item}}`.
 */
class m260630_062828_create_cart_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cart_item}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'number' => $this->integer(),
            'color_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
                $this->addForeignKey(
            'cart_item_user_id_key',
            'cart_item',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE',
        );
        $this->addForeignKey(
            'cart_item_product_id_key',
            'cart_item',
            'product_id',
            'product',
            'id',
            'CASCADE',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cart_item}}');
    }
}
