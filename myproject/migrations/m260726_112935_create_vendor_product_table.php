<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vendor_product}}`.
 */
class m260726_112935_create_vendor_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vendor_product}}', [
            'id' => $this->primaryKey(),
            'price' => $this->string(255)->notNull(),
            'marketable_number' => $this->integer()->defaultValue(0),
            'product_variant_id' => $this->integer()->defaultValue(0),
            'frozen_number' => $this->integer()->defaultValue(0),
            'sold_number' => $this->integer()->defaultValue(0),
            'status' => $this->tinyInteger()->defaultValue(0)->comment('0 => در انتظار تایید , 1  => تایید شده ,  2 => رد شده'),
            'vendor_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('vendor_product_vendor_id_key' , 'vendor_product' , 'vendor_id' , 'vendor' , 'id' ,'CASCADE' , 'CASCADE');
        $this->addForeignKey('vendor_product_product_variant_id_key' , 'vendor_product' , 'product_variant_id' , 'product_variant' , 'id' , 'CASCADE' , 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vendor_product}}');
    }
}
