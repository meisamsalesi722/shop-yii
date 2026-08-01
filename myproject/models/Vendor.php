<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vendor".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $image
 * @property string|null $description
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 */
class Vendor extends \yii\db\ActiveRecord
{


    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'description'], 'default', 'value' => null],
            [['user_id', 'name'], 'required'],
            [['user_id'], 'integer'],
            [['image', 'description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'image' => 'Image',
            'description' => 'Description',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    
    public function deleteImage()
    {
        if ($this->image && file_exists('uploads/images/vendor/' . $this->image)) {
            return unlink('uploads/images/vendor/' . $this->image);
        }
        return false;
    }

       
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
