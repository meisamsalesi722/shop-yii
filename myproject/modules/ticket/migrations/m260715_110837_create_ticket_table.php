<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ticket}}`.
 */
class m260715_110837_create_ticket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ticket}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'status' => $this->tinyInteger(),
            'user_id' => $this->integer()->notNull(),
            'is_admin' => $this->tinyInteger()->defaultValue(0),
            'ticket_id' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
        ]);

        $this->addForeignKey('ticket_user_id_key', 'ticket',  'user_id', 'user', 'id', 'CASCADE' , 'CASCADE');
        $this->addForeignKey('ticket_ticket_id_key', 'ticket',  'ticket_id', 'ticket', 'id', 'CASCADE' , 'CASCADE');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ticket}}');
    }
}
