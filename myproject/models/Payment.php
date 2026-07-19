<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property int $amount
 * @property int $user_id
 * @property string|null $gateway
 * @property string|null $transaction_id
 * @property string|null $bank_first_responce
 * @property string|null $bank_second_responce
 * @property int|null $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class Payment extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gateway', 'transaction_id', 'bank_first_responce', 'bank_second_responce'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['amount', 'user_id'], 'required'],
            [['amount', 'user_id', 'status'], 'integer'],
            [['bank_first_responce', 'bank_second_responce'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['gateway', 'transaction_id'], 'string', 'max' => 255],
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
            'amount' => 'Amount',
            'user_id' => 'User ID',
            'gateway' => 'Gateway',
            'transaction_id' => 'Transaction ID',
            'bank_first_responce' => 'Bank First Responce',
            'bank_second_responce' => 'Bank Second Responce',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
