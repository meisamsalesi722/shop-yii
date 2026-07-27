<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vendor}}`.
 */
class m260726_073359_create_vendor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vendor}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'image' => $this->text(),
            'description' => $this->text(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vendor}}');
    }
}
