<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "discount_amount".
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $percentage
 * @property int|null $status
 * @property int|null $discount_ceiling
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Product $product
 */
class DiscountAmount extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discount_amount';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['percentage', 'discount_ceiling', 'start_date', 'end_date', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['product_id'], 'required'],
            [['product_id', 'percentage', 'status', 'discount_ceiling', 'updated_at', 'deleted_at'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
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
            'product_id' => 'Product ID',
            'percentage' => 'Percentage',
            'status' => 'Status',
            'discount_ceiling' => 'Discount Ceiling',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
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

}
