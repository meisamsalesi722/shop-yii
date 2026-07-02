<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $image
 * @property int $position
 * @property int|null $status
 * @property string $created_at
 * @property string $updated_at
 */
class Banner extends \yii\db\ActiveRecord
{

    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 0],
            // [['title', 'url', 'position' , 'imageFile'], 'required'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg ,webp'],
            [['position', 'status'], 'integer'],
            [['created_at', 'updated_at' , 'imageFile'], 'safe'],
            [['title', 'url'], 'string', 'max' => 255],


            // [['created_at', 'updated_at' , 'title', 'url',  'imageFile' , 'position', 'status'], 'safe'],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
            'image' => 'Image',
            'position' => 'Position',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function deleteImage()
    {
        if ($this->image && file_exists('uploads/images/banner' . $this->image)) {
            return unlink('uploads/images/banner' . $this->image);
        }
        return false;
    }

}
