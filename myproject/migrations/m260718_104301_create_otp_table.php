<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%otp}}`.
 */
class m260718_104301_create_otp_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%otp}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'opt_code' => $this->integer()->notNull(),
            'expired_at' => $this->timestamp(),
            'token' => $this->text()->notNull(),
            'used' => $this->tinyInteger()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('otp_user_id_key', 'otp', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%otp}}');
    }
}
