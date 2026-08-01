<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m260622_114149_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'blog_category_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'summary' => $this->text(),
            'content' => $this->text(),
            'image' => $this->string(255)->null(),
            'pdf' => $this->string(255)->null(),
            'status' => $this->tinyInteger()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // FK به user
        $this->addForeignKey(
            'fk-article-user',
            'article',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // FK به category
        $this->addForeignKey(
            'fk-article-category',
            'article',
            'blog_category_id',
            'blog_category',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-article-user', 'article');
        $this->dropForeignKey('fk-article-category', 'article');
        $this->dropTable('{{%article}}');
    }
}
