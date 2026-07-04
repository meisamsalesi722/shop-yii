<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string $original_name
 * @property string $persian_name
 * @property int|null $status
 * @property string $slug
 * @property string|null $logo
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Product[] $products
 */
class Brand extends \yii\db\ActiveRecord
{

    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['original_name', 'persian_name', 'slug'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['original_name', 'persian_name', 'slug'], 'string', 'max' => 255],
            [['imageFile'], 'file','extensions' => 'png, jpg, jpeg ,webp'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'original_name' => 'Original Name',
            'persian_name' => 'Persian Name',
            'status' => 'Status',
            'slug' => 'Slug',
            'logo' => 'Logo',
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
        return $this->hasMany(Product::class, ['brand_id' => 'id']);
    }

        public function deleteImage()
    {
        if ($this->logo && file_exists('uploads/images' . $this->logo)) {
            return unlink('uploads/images' . $this->logo);
        }
        return false;
    }

}
