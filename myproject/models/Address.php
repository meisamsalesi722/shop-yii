<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property int $user_id
 * @property string $city
 * @property string $address
 * @property int $mobile
 * @property string|null $recipient_name
 * @property string $prstal_code
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Address extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recipient_name', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'city', 'address', 'mobile', 'prstal_code'], 'required'],
            [['user_id', 'mobile', 'created_at', 'updated_at'], 'integer'],
            [['address'], 'string'],
            [['city', 'recipient_name', 'prstal_code'], 'string', 'max' => 255],
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
            'city' => 'City',
            'address' => 'Address',
            'mobile' => 'Mobile',
            'recipient_name' => 'Recipient Name',
            'prstal_code' => 'Prstal Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
