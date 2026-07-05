<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "color".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $color_code
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Product[] $products
 */
class Color extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'color_code', 'created_at', 'updated_at'], 'default', 'value' => null],
            [[ 'created_at', 'updated_at'], 'integer'],
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
            'color_code' => 'Color Code',
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
        return $this->hasOne(Product::class, ['color_id' => 'id']);
    }

}
