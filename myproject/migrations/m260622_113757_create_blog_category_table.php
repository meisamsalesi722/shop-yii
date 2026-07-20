<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_category}}`.
 */
class m260622_113757_create_blog_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */

      public function safeUp()
    {
        $this->createTable('{{%blog_category}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(150)->notNull(),
            'parent_id' => $this->integer()->null(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-category-parent',
            'blog_category',
            'parent_id',
            'blog_category',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-category-parent', 'blog_category');
        $this->dropTable('{{%blog_category}}');
    }


}
