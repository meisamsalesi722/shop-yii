<?php

use yii\db\Migration;

class m260729_101042_add_user_id_to_product_and_productvariant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product' , 'user_id' ,$this->integer()->notNull());
        $this->addForeignKey('product_user_id_key' , 'product' , 'user_id' , 'user' , 'id' , 'CASCADE' , 'CASCADE');
        
        $this->addColumn('product_variant' , 'user_id' ,$this->integer()->notNull());
        $this->addForeignKey('product_variant_user_id_key' , 'product_variant' , 'user_id' , 'user' , 'id' , 'CASCADE' , 'CASCADE');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260729_101042_add_user_id_to_product_and_productvariant_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260729_101042_add_user_id_to_product_and_productvariant_table cannot be reverted.\n";

        return false;
    }
    */
}
