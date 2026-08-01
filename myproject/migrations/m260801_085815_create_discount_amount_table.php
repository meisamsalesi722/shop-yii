<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%discount_amount}}`.
 */
class m260801_085815_create_discount_amount_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%discount_amount}}', [
            'id' => $this->primaryKey(),
            'vendor_product_id' => $this->integer()->notNull(),
            'percentage' => $this->integer(3),
            'status' => $this->tinyInteger()->defaultValue(0),
            'discount_ceiling' => $this->bigInteger(),
            'start_date' => $this->dateTime(),
            'end_date' => $this->dateTime(),
            'created_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP"),
            'updated_at' => $this->timestamp()->defaultExpression("CURRENT_TIMESTAMP")->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'discount_amount_vendor_product_id_key',
            'discount_amount',
            'vendor_product_id',
            'vendor_product',
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
