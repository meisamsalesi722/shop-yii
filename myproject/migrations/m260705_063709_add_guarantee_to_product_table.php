<?php

use yii\db\Migration;

class m260705_063709_add_guarantee_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'guarantee_id', $this->integer()->notNull());
        $this->addForeignKey(
            'guarantee_id_product_id_key',
            'product',
            'guarantee_id',
            'guarantee',
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
        echo "m260705_063709_add_guarantee_to_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260705_063709_add_guarantee_to_product_table cannot be reverted.\n";

        return false;
    }
    */
}
