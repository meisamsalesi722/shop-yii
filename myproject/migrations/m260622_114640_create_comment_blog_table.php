<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment_blog}}`.
 */
class m260622_114640_create_comment_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment_blog}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'comment' => $this->text()->notNull(),
            'status' => $this->tinyInteger()->defaultValue(0),
            'created_at' => $this->integer(),
        ]);
        // FK به article
        $this->addForeignKey(
            'fk-comment-article',
            'comment_blog',
            'article_id',
            'article',
            'id',
            'CASCADE',
            'CASCADE'
        );
        // FK به user
        $this->addForeignKey(
            'fk-comment-user_id-user',
            'comment_blog',
            'user_id',
            'user',
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
        $this->dropForeignKey('fk-comment-article', 'comment_blog');
        $this->dropForeignKey('fk-comment-user', 'comment_blog');
        $this->dropTable('{{%comment_blog}}');
    }


}
