<?php

namespace app\models;

use Yii;
use app\models\Color;

/**
 * This is the model class for table "cart_item".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int|null $number
 * @property int $color_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Product $product
 * @property User $user
 */
class CartItem extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number'], 'default', 'value' => null],


            [['user_id', 'vendor_product_id', 'product_variant_id', 'product_id', 'vendor_id'], 'required'],
            [['user_id', 'vendor_product_id', 'product_variant_id', 'product_id', 'vendor_id', 'number'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['product_variant_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductVariant::class, 'targetAttribute' => ['product_variant_id' => 'id']],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::class, 'targetAttribute' => ['vendor_id' => 'id']],
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
            'user_id' => 'User ID',
            'vendor_product_id' => 'Vendor Product ID',
            'product_variant_id' => 'Product Variant ID',
            'product_id' => 'Product ID',
            'vendor_id' => 'Vendor ID',
            'number' => 'Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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


    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
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

