<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category_attribute}}`.
 */
class m260630_062034_create_category_attribute_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category_attribute}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string(255),
            'unit' => $this->string(255),
            'value' => $this->string(),
        ]);

        $this->addForeignKey(
            'category_id_key',
            'category_attribute',
            'category_id',
            'category',
            'id',
            'CASCADE',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category_attribute}}');
    }
}
