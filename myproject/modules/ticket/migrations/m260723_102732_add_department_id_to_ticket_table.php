<?php

use yii\db\Migration;

class m260723_102732_add_department_id_to_ticket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ticket' , 'department_id' , $this->integer());
        $this->addForeignKey('ticket_department_id_key' , 'ticket', 'department_id' , 'department' , 'id' , 'CASCADE' , 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260723_102732_add_department_id_to_ticket_table cannot be reverted.\n";
        $this->dropColumn('ticket', 'department_id');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260723_102732_add_department_id_to_ticket_table cannot be reverted.\n";

        return false;
    }
    */
}
