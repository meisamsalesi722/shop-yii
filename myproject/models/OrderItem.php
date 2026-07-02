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
 * @property int|null $final_product_price
 * @property int|null $final_total_price productPrice * number
 * @property int $color_id
 * @property int $guarantee_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Color $color
 * @property Guarantee $guarantee
 * @property Order $order
 * @property Product $product
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
            [['number', 'final_product_price', 'final_total_price'], 'default', 'value' => null],
            [['order_id', 'product_id', 'color_id', 'guarantee_id'], 'required'],
            [['order_id', 'product_id', 'number', 'final_product_price', 'final_total_price', 'color_id', 'guarantee_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::class, 'targetAttribute' => ['color_id' => 'id']],
            [['guarantee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Guarantee::class, 'targetAttribute' => ['guarantee_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
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

    /**
     * Gets query for [[Color]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::class, ['id' => 'color_id']);
    }

    /**
     * Gets query for [[Guarantee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGuarantee()
    {
        return $this->hasOne(Guarantee::class, ['id' => 'guarantee_id']);
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

}
