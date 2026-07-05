<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%color}}`.
 */
class m260630_063136_create_color_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%color}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'color_code' => $this->string(),
            'product_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'color_product_id_key',
            'color',
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
        $this->dropTable('{{%color}}');
    }
}
