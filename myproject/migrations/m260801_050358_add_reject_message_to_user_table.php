<?php

use yii\db\Migration;

class m260801_050358_add_reject_message_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vendor', 'reject_message', $this->text()->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260801_050358_add_reject_message_to_user_table cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260801_050358_add_reject_message_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
