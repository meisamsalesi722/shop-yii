<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m260630_061156_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'image' => $this->text(255),
            'price' => $this->bigInteger(),
            'introduction' => $this->text(),
            'slug' => $this->string(255),
            'category_id' => $this->integer()->notNull(),
            'status' => $this->integer(),
            'sold_number' => $this->integer(),
            'frozen_number' => $this->integer(),
            'marketable_number' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey(
            'product_category_key',   
            'product',                 
            'category_id',         
            'category',            
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
        $this->dropTable('{{%product}}');
    }
}
