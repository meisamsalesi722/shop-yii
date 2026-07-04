<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gullery}}`.
 */
class m260704_113540_create_gullery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%gullery}}', [
            'id' => $this->primaryKey(),
            'image' => $this->text()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'gullery_product_id_key',
            'gullery',
            'product_id',
            'product',
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
        $this->dropTable('{{%gullery}}');
    }
}
