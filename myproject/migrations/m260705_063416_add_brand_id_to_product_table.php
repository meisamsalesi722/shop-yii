<?php

use yii\db\Migration;

class m260705_063416_add_brand_id_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'brand_id', $this->integer()->notNull());
        $this->addForeignKey(
            'brand_id_product_id_key',
            'product',
            'brand_id',
            'brand',
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
        echo "m260705_063416_add_brand_id_to_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260705_063416_add_brand_id_to_product_table cannot be reverted.\n";

        return false;
    }
    */
}
