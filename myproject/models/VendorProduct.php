<?php

namespace app\models;

use Yii;
use app\models\ProductVariant;

/**
 * This is the model class for table "vendor_product".
 *
 * @property int $id
 * @property int $product_id
 * @property string|null $color
 * @property string|null $color_code
 * @property string|null $guarantee
 * @property string $price
 * @property int|null $marketable_number
 * @property int|null $frozen_number
 * @property int|null $sold_number
 * @property int|null $status 0 => در انتظار تایید , 1  => تایید شده ,  2 => رد شده
 * @property string $created_at
 * @property string $updated_at
 *
 * @property OrderItem[] $orderItems
 */
class VendorProduct extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 0],
            [['price', 'vendor_id'], 'required'],
            [['vendor_id', 'marketable_number', 'frozen_number', 'sold_number', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['price'], 'string', 'max' => 255],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::class, 'targetAttribute' => ['vendor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'color' => 'Color',
            'color_code' => 'Color Code',
            'guarantee' => 'Guarantee',
            'price' => 'Price',
            'marketable_number' => 'Markeblde Number',
            'frozen_number' => 'Frozen Number',
            'sold_number' => 'Sold Number',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[DiscountAmounts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiscountAmounts()
    {
        return $this->hasOne(DiscountAmount::class, ['vendor_product_id' => 'id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['vendor_product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductVariant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductVariant()
    {
        return $this->hasOne(ProductVariant::class, ['id' => 'product_variant_id']);
    }

    /**
     * Gets query for [[Vendor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::class, ['id' => 'vendor_id']);
    }

}
