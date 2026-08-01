<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart_item}}`.
 */
class m260801_085317_create_cart_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cart_item}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'vendor_product_id' => $this->integer()->notNull(),

            'product_variant_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'vendor_id' => $this->integer()->notNull(),
            
            'number' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('cart_item_user_id_key','cart_item','user_id','user','id','CASCADE','CASCADE');

        $this->addForeignKey('cart_item_product_id_key','cart_item','product_id','product','id','CASCADE','CASCADE');
        $this->addForeignKey('cart_item_product_variant_id_key','cart_item','product_variant_id','product_variant','id','CASCADE','CASCADE');
        $this->addForeignKey('cart_item_vendor_id_key','cart_item','vendor_id','vendor','id','CASCADE','CASCADE');
        
        $this->addForeignKey('cart_item_vendor_producte_id_key','cart_item','vendor_product_id','vendor_product','id','CASCADE','CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cart_item}}');
    }
}
