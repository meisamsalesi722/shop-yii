<?php

use yii\db\Migration;

class m260702_085748_add_relation_user_id_to_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->addColumn(
            'address',
            'user_id',
            $this->integer()->notNull()->after('id')
        );
        $this->addForeignKey(
            'address_user_id_key',
            'address',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260702_085748_add_relation_user_id_to_address_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260702_085748_add_relation_user_id_to_address_table cannot be reverted.\n";

        return false;
    }
    */
}
