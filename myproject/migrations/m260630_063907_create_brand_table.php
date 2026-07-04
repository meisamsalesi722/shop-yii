<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%brand}}`.
 */
class m260630_063907_create_brand_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%brand}}', [
            'id' => $this->primaryKey(),
            'original_name' => $this->string()->notNull(),
            'persian_name' => $this->string()->notNull(),
            'status' => $this->integer()->defaultValue(0),
            'slug' => $this->string()->notNull(),
            'logo' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%brand}}');
    }
}
