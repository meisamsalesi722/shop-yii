<?php

use yii\db\Migration;

class m260730_115143_add_faild_message_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'reject_message', $this->text()->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260730_115143_add_faild_message_to_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260730_115143_add_faild_message_to_product_table cannot be reverted.\n";

        return false;
    }
    */
}
