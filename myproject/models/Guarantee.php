<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "guarantee".
 *
 * @property int $id
 * @property string|null $name
 * @property int $price_increase
 * @property int|null $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property OrderItem[] $orderItems
 * @property ProductGuarantee[] $productGuarantees
 * @property Product[] $products
 */
class Guarantee extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'guarantee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['price_increase'], 'required'],
            [['price_increase', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price_increase' => 'Price Increase',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['guarantee_id' => 'id']);
    }

    /**
     * Gets query for [[ProductGuarantees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductGuarantees()
    {
        return $this->hasMany(ProductGuarantee::class, ['guarantee_id' => 'id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('product_guarantee', ['guarantee_id' => 'id']);
    }

}
