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
    
    public $product_id;
    public $product_variant_id;


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
            [['final_product_price', 'final_discount', 'final_total_price'], 'default', 'value' => null],
            [['number'], 'default', 'value' => 1],
            [['order_id', 'vendor_product_id'], 'required'],
            [['order_id', 'vendor_product_id', 'number'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['vendor_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => VendorProduct::class, 'targetAttribute' => ['vendor_product_id' => 'id']],
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
            'vendor_product_id' => 'Vendor Product ID',
            'number' => 'Number',
            'final_product_price' => 'Final Product Price',
            'final_discount' => 'Final Discount',
            'final_total_price' => 'Final Total Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getOrder(){
        return $this->hasOne(Order::class , ['id' => 'order_id']);
    }

    /**
     * Gets query for [[VendorProduct]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendorProduct()
    {
        return $this->hasOne(VendorProduct::class, ['id' => 'vendor_product_id']);
    }


}
