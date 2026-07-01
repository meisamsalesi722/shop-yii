<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_attribute".
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $name
 * @property string|null $unit
 * @property string|null $value
 *
 * @property Category $category
 */
class CategoryAttribute extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_attribute';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'unit', 'value'], 'default', 'value' => null],
            [['category_id'], 'required'],
            [['category_id'], 'integer'],
            [['name', 'unit', 'value'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'unit' => 'Unit',
            'value' => 'Value',
        ];
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

}
