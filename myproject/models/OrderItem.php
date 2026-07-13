<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int|null $number
 * @property string|null $final_product_price
 * @property string|null $final_total_price
 * @property int|null $color_id
 * @property int|null $guarantee_id
 * @property string $created_at
 * @property string $updated_at
 */
class OrderItem extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['final_product_price', 'final_total_price', 'color_id', 'guarantee_id'], 'default', 'value' => null],
            [['number'], 'default', 'value' => 1],
            [['order_id', 'product_id'], 'required'],
            [['order_id', 'product_id', 'number', 'color_id', 'guarantee_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'number' => 'Number',
            'final_product_price' => 'Final Product Price',
            'final_total_price' => 'Final Total Price',
            'color_id' => 'Color ID',
            'guarantee_id' => 'Guarantee ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
