<?php

use yii\db\Migration;

class m260729_134317_add_status_to_vendor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vendor' , 'status' , $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260729_134317_add_status_to_vendor_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260729_134317_add_status_to_vendor_table cannot be reverted.\n";

        return false;
    }
    */
}
