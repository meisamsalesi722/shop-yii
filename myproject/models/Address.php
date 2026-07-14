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
 * @property string $postal_code
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
            [['recipient_name'], 'default', 'value' => null],
            [['user_id', 'city', 'address', 'mobile', 'postal_code'], 'required'],
            [['user_id'], 'integer'],
            [['address'], 'string'],
            [['mobile'], 'string', 'max' => 13],
            [['mobile'], 'match', 'pattern' => '/^((98|\+98|0098|0)*(9)[0-9]{9})+$/'],
            [['postal_code'], 'match', 'pattern' => '/^[0-9]{10}$/'],
            [['city', 'recipient_name', 'postal_code'], 'string', 'max' => 255],
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
            'postal_code' => 'Postal Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
