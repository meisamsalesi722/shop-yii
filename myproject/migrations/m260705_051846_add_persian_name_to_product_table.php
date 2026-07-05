<?php

use yii\db\Migration;

class m260705_051846_add_persian_name_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'product',
            'persian_name',
            $this->string(255)->notNull()->after('name'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260705_051846_add_persian_name_to_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260705_051846_add_persian_name_to_product_table cannot be reverted.\n";

        return false;
    }
    */
}
