<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gallery".
 *
 * @property int $id
 * @property string $image
 * @property int $product_id
 *
 * @property Product $product
 */
class Gallery extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'product_id'], 'required'],
            [['imageFile'], 'file' , 'extensions' => 'jpg,png,jpeg,webp'],
            [['product_id'], 'integer'],
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
            'image' => 'Image',
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

    public function deleteImage()
    {
        if ($this->image && file_exists('uploads/images/gallery/' . $this->image)) {
            return unlink('uploads/images/gallery/' . $this->image);
        }
        return false;
    }

}
