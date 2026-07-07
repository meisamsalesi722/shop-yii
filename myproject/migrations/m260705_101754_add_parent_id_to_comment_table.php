<?php

use yii\db\Migration;

class m260705_101754_add_parent_id_to_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'comment',
            'parent_id',
            $this->integer(),
        );
        $this->addForeignKey(
            'fk-comment-parent_id',
            '{{%comment}}',
            'parent_id',
            '{{%comment}}',
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
        echo "m260705_101754_add_parent_id_to_comment_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260705_101754_add_parent_id_to_comment_table cannot be reverted.\n";

        return false;
    }
    */
}
