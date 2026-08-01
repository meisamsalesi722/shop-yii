<?php

namespace app\models;

use Yii;
use app\models\Color;
use app\models\Comment;
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
    public $exist;
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
            [['name', 'introduction', 'slug', 'status'], 'default', 'value' => null],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp'],
            [['image', 'introduction'], 'string'],
            [['view'], 'default', 'value' => 0],
            [['category3_id','persian_name', 'brand_id' ,'user_id'], 'required'],
            [['view', 'category_id', 'status', 'brand_id' , 'user_id'], 'integer'],
            [['created_at', 'updated_at' , 'category2_id', 'category3_id' , 'category1_id'], 'safe'],
            [['name', 'persian_name', 'slug'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::class, 'targetAttribute' => ['brand_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'persian_name' => 'Persian Name',
            'image' => 'Image',
            'view' => 'View',
            'introduction' => 'Introduction',
            'slug' => 'Slug',
            'category_id' => 'Category ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'brand_id' => 'Brand ID',
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
     * Gets query for [[Galleries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGalleries()
    {
        return $this->hasMany(Gallery::class, ['product_id' => 'id']);
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

    public function getComments(){
        return $this->hasMany(Comment::class , ['product_id' => 'id']);
    }

    public function getProductUser(){
        return $this->hasMany(ProductUser::class , ['product_id' => 'id']);
    }

    public function getComment_count()
    {
        return $this->getComments()->count();
    }

        /**
     * Gets query for [[ProductVariants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductVariants()
    {
        return $this->hasMany(ProductVariant::class, ['product_id' => 'id']);
    }
   
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getProductVariantsHasDiscount()
    {
        return $this->hasMany(ProductVariant::class, ['product_id' => 'id'])
        ->innerJoinWith('vendorProducts.discountAmounts')
        ->groupBy('product_variant.id');

    }

    public function getProductVariantsHasVendorProducts()
    {
        return $this->hasMany(ProductVariant::class, ['product_id' => 'id'])
        ->innerJoinWith('vendorProducts')
        ->groupBy('product_variant.id');
    }

    



}
