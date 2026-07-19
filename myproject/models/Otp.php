<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "otp".
 *
 * @property int $id
 * @property int $user_id
 * @property int $opt_code
 * @property string $expired_at
 * @property string $token
 * @property int|null $used
 * @property string $created_at
 *
 * @property User $user
 */
class Otp extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'otp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['used'], 'default', 'value' => 0],
            [['user_id', 'opt_code', 'token'], 'required'],
            [['user_id', 'opt_code', 'used'], 'integer'],
            [['expired_at', 'created_at'], 'safe'],
            [['token'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'opt_code' => 'Opt Code',
            'expired_at' => 'Expired At',
            'token' => 'Token',
            'used' => 'Used',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
