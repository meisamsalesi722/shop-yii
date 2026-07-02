<?php

use yii\db\Migration;

class m260702_072728_add_view_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->addColumn(
            'product',
            'view',
            $this->integer()->defaultValue(0)->notNull()->after('image')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260702_072728_add_view_to_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260702_072728_add_view_to_product_table cannot be reverted.\n";

        return false;
    }
    */
}
