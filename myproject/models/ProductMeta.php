<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_meta".
 *
 * @property int $id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @property int $product_id
 *
 * @property Product $product
 */
class ProductMeta extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_meta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meta_key', 'meta_value'], 'default', 'value' => null],
            [['product_id'], 'required'],
            [['product_id'], 'integer'],
            [['meta_key', 'meta_value'], 'string', 'max' => 255],
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
            'meta_key' => 'Meta Key',
            'meta_value' => 'Meta Value',
            'product_id' => 'Product ID',
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
