<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%department}}`.
 */
class m260723_102654_create_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%department}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'color' => $this->string(),
            'icon' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%department}}');
    }
}
