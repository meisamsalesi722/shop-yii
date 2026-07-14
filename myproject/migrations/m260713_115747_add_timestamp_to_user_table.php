<?php

use yii\db\Migration;

class m260713_115747_add_timestamp_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'user',
            'created_at',
            $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
        );
        $this->addColumn(
            'user',
            'updated_at',
             $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260713_115747_add_timestamp_to_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260713_115747_add_timestamp_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
