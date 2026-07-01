<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_meta}}`.
 */
class m260630_061807_create_product_meta_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_meta}}', [
            'id' => $this->primaryKey(),
            'meta_key' => $this->string(),
            'meta_value' => $this->string(),
            'product_id' => $this->integer()->notNull(),
        ]);

            $this->addForeignKey(
                'product_id_key',   
                'product_meta',                 
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
        $this->dropTable('{{%product_meta}}');
    }
}
