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
            'mobile' => $this->string(15)->notNull(),
            'recipient_name' => $this->string(255),
            'postal_code' => $this->string(255)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

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
        $this->dropTable('{{%address}}');
    }
}
