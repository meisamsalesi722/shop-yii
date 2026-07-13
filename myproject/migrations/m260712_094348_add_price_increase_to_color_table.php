<?php

use yii\db\Migration;

class m260712_094348_add_price_increase_to_color_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'color',
            'price_increase',
            $this->integer()->notNull(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260712_094348_add_price_increase_to_color_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260712_094348_add_price_increase_to_color_table cannot be reverted.\n";

        return false;
    }
    */
}
