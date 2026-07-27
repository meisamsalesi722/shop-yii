<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_variant}}`.
 */
class m260726_111022_create_product_variant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_variant}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'color' => $this->string(),
            'color_code' => $this->string(),
            'guarantee' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('product_variant_product_id_key' , 'product_variant' , 'product_id' , 'product' , 'id' , 'CASCADE' , 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_variant}}');
    }
}
