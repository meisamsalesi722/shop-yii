<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%discount_amount}}`.
 */
class m260630_074229_create_discount_amount_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%discount_amount}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'percentage' => $this->integer(3),
            'statsu' => $this->tinyInteger()->defaultValue(0),
            'discount_ceiling' => $this->bigInteger(),
            'start_date' => $this->dateTime(),
            'end_date' => $this->dateTime(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'discount_amount_product_id_key',
            'discount_amount',
            'product_id',
            'product',
            'id',
            'CASCADE',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%discount_amount}}');
    }
}
