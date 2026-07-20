<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorite}}`.
 */
class m260622_115150_create_favorite_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favorite}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'article_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
        ]);

        // FK به user
        $this->addForeignKey(
            'fk-favorite-user',
            'favorite',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // FK به article
        $this->addForeignKey(
            'fk-favorite-article',
            'favorite',
            'article_id',
            'article',
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
        $this->dropForeignKey('fk-favorite-user', 'favorite');
        $this->dropForeignKey('fk-favorite-article', 'favorite');
        $this->dropTable('{{%favorite}}');
    }
}
