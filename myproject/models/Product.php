<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $image
 * @property int|null $price
 * @property string|null $introduction
 * @property string|null $slug
 * @property int $category_id
 * @property int|null $status
 * @property int|null $sold_number
 * @property int|null $frozen_number
 * @property int|null $marketable_number
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $color_id
 * @property int $brand_id
 * @property int $guarantee_id
 *
 * @property Brand $brand
 * @property CartItem[] $cartItems
 * @property Category $category
 * @property Color $color
 * @property DiscountAmount $discountAmounts
 * @property Guarantee $guarantee
 * @property OrderItem[] $orderItems
 * @property ProductMeta[] $productMetas
 */
class Product extends \yii\db\ActiveRecord
{

    public $category1_id; 
    public $category2_id; 
    public $category3_id;
    public $meta_key;
    public $meta_value;
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['name', 'imageFile', 'price', 'introduction', 'status', 'sold_number', 'frozen_number', 'marketable_number'], 'default', 'value' => null],
            [['introduction'], 'string'],
            [['price', 'category_id', 'status', 'sold_number', 'frozen_number', 'marketable_number',  'color_id', 'brand_id', 'guarantee_id'], 'integer'],
            [['category3_id', 'color_id', 'brand_id', 'guarantee_id'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::class, 'targetAttribute' => ['brand_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::class, 'targetAttribute' => ['color_id' => 'id']],
            [['guarantee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Guarantee::class, 'targetAttribute' => ['guarantee_id' => 'id']],
             [['category1_id' , 'imageFile' , 'category2_id', 'category3_id'], 'safe'],
             [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function deleteImage()
    {
        if ($this->image && file_exists('uploads/images/' . $this->image)) {
            return unlink('uploads/images/' . $this->image);
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'image' => 'Image',
            'price' => 'Price',
            'introduction' => 'Introduction',
            'slug' => 'Slug',
            'category_id' => 'Category ID',
            'status' => 'Status',
            'sold_number' => 'Sold Number',
            'frozen_number' => 'Frozen Number',
            'marketable_number' => 'Marketable Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'color_id' => 'Color ID',
            'brand_id' => 'Brand ID',
            'guarantee_id' => 'Guarantee ID',
        ];
    }

    /**
     * Gets query for [[Brand]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
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
     * Gets query for [[DiscountAmounts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiscountAmounts()
    {
        return $this->hasOne(DiscountAmount::class, ['product_id' => 'id']);
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
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductMetas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductMetas()
    {
        return $this->hasMany(ProductMeta::class, ['product_id' => 'id']);
    }

}
