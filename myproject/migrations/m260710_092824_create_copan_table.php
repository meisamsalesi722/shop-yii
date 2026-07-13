<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%copan}}`.
 */
class m260710_092824_create_copan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%copan}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(255)->unique()->notNull(),
            'amount' => $this->string(255)->notNull(),
            'amount_type' => $this->tinyInteger()->defaultValue(1)->comment('0 => % , 1 => $'),
            'discount_ceiling' => $this->bigInteger(),
            'used' => $this->tinyInteger()->defaultValue(0),
            'start_date' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'end_date' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('copan_user_id_key', 'copan', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%copan}}');
    }
}
