<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%address}}`.
 */
class m260630_065318_create_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'city' => $this->string()->notNull(),
            'address' => $this->text()->notNull(),
            'mobile' => $this->integer(11)->notNull(),
            'recipient_name' => $this->string(255),
            'prstal_code' => $this->string(255)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%address}}');
    }
}
