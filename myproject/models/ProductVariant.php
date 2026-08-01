<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_variant".
 *
 * @property int $id
 * @property int $product_id
 * @property string|null $color
 * @property string|null $color_code
 * @property string|null $guarantee
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Product $product
 */
class ProductVariant extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_variant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'color_code', 'guarantee'], 'default', 'value' => null],
            [['product_id' , 'user_id'], 'required'],
            [['product_id' , 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['color', 'color_code', 'guarantee'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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

    /**
     * Gets query for [[VendorProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendorProducts()
    {
        return $this->hasMany(VendorProduct::class, ['product_variant_id' => 'id']);
    }

    public function getVendorProductsHasDiscount()
    {
        return $this->hasMany(VendorProduct::class, ['product_variant_id' => 'id'])->innerJoinWith('discountAmounts');
    }


}
