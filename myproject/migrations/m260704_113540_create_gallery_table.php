<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gallery}}`.
 */
class m260704_113540_create_gallery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%gallery}}', [
            'id' => $this->primaryKey(),
            'image' => $this->text()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'gallery_product_id_key',
            'gallery',
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
        $this->dropTable('{{%gallery}}');
    }
}
