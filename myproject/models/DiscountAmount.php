<?php

namespace app\models;

use Yii;
use app\models\VendorProduct;

/**
 * This is the model class for table "discount_amount".
 *
 * @property int $id
 * @property int $vendor_product_id 
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

    public $product_id;
    public $product_variant_id;
    public $is_discount_active; 
    


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
            [['discount_ceiling'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            // [['vendor_product_id'], 'required'],
            [['vendor_product_id', 'percentage', 'status', 'discount_ceiling'], 'integer'],
            [['vendor_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => VendorProduct::class, 'targetAttribute' => ['vendor_product_id' => 'id']],
            
            // قوانین تخفیف
            [['is_discount_active'], 'boolean'],
            [['percentage'], 'number', 'min' => 1, 'max' => 100],
            [['percentage'], 'required', 'when' => function($model) {
                return $model->is_discount_active == 1;
            }, 'whenClient' => "function (attribute, value) {
                return $('#is_discount_active').val() == 1;
            }"],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
            [['start_date'], 'required', 'when' => function($model) {
                return $model->is_discount_active == 1;
            }, 'whenClient' => "function (attribute, value) {
                return $('#is_discount_active').val() == 1;
            }"],
            [['end_date'], 'required', 'when' => function($model) {
                return $model->is_discount_active == 1;
            }, 'whenClient' => "function (attribute, value) {
                return $('#is_discount_active').val() == 1;
            }"],
            [['end_date'], 'compare', 'compareAttribute' => 'start_date', 'operator' => '>=', 'message' => 'تاریخ پایان باید بزرگتر یا مساوی تاریخ شروع باشد.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vendor_product_id' => 'vendor Product ID',
            'status' => 'Status',
            'discount_ceiling' => 'Discount Ceiling',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'percentage' => 'درصد تخفیف',
            'start_date' => 'تاریخ شروع تخفیف',
            'end_date' => 'تاریخ پایان تخفیف',
            'is_discount_active' => 'فعال‌سازی تخفیف',

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

}
