<?php

use yii\db\Migration;

class m260630_071820_add_brand_guarantee_color_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
 $this->addColumn(
            'product',
            'color_id',
            $this->integer()->notNull()->after('updated_at')
        );
        $this->addColumn(
            'product',
            'brand_id',
            $this->integer()->notNull()->after('color_id')
        );
        $this->addColumn(
            'product',
            'guarantee_id',
            $this->integer()->notNull()->after('brand_id')
        );

        $this->addForeignKey(
            'product_color_id_key',
            'product',
            'color_id',
            'color',
            'id',
            'CASCADE',
            'CASCADE',
        );
        $this->addForeignKey(
            'product_brand_id_key',
            'product',
            'brand_id',
            'brand',
            'id',
            'CASCADE',
            'CASCADE',
        );
        $this->addForeignKey(
            'product_guarantee_id_key',
            'product',
            'guarantee_id',
            'guarantee',
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
        echo "m260630_071820_add_brand_guarantee_color_to_product_table cannot be reverted.\n";
        $this->dropColumn('{{%product}}', 'color_id');
        $this->dropColumn('{{%product}}', 'brand_id');
        $this->dropColumn('{{%product}}', 'guarantee_id');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260630_071820_add_brand_guarantee_color_to_product_table cannot be reverted.\n";

        return false;
    }
    */
}
