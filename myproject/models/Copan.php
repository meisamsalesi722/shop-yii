<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "copan".
 *
 * @property int $id
 * @property string $code
 * @property string $amount
 * @property int|null $amount_type 0 => % , 1 => $
 * @property int|null $discount_ceiling
 * @property int $used
 * @property string $start_date
 * @property string $end_date
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Order[] $orders
 * @property User $user
 */
class Copan extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'copan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discount_ceiling'], 'default', 'value' => null],
            [['amount_type'], 'default', 'value' => 1],
            [['used'], 'default', 'value' => 0],
            [['code', 'amount', 'user_id'], 'required'],
            [['amount_type', 'discount_ceiling', 'used', 'user_id'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['code', 'amount'], 'string', 'max' => 255],
            [['code'], 'unique'],
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
            'code' => 'Code',
            'amount' => 'Amount',
            'amount_type' => 'Amount Type',
            'discount_ceiling' => 'Discount Ceiling',
            'used' => 'Used',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['copan_id' => 'id']);
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
