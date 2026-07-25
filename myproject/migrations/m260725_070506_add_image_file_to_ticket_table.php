<?php

use yii\db\Migration;

class m260725_070506_add_image_file_to_ticket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('ticket' , 'image' , $this->string(255));
        $this->addColumn('ticket' , 'file' , $this->string(255));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260725_070506_add_image_file_to_ticket_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260725_070506_add_image_file_to_ticket_table cannot be reverted.\n";

        return false;
    }
    */
}
