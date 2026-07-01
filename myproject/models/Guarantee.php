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
 * @property int|null $created_at
 * @property int|null $updated_at
 *
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
            [['name', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['price_increase'], 'required'],
            [['price_increase', 'status', 'created_at', 'updated_at'], 'integer'],
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
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['guarantee_id' => 'id']);
    }

}
