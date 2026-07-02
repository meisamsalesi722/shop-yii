<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property int $address_id
 * @property int $delivery_id
 * @property int|null $delivery_status
 * @property int|null $original_price
 * @property int|null $order_final_amount
 * @property int|null $order_discount_amount
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Address $address
 * @property User $delivery
 * @property OrderItem[] $orderItems
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['original_price', 'order_final_amount', 'order_discount_amount'], 'default', 'value' => null],
            [['delivery_status'], 'default', 'value' => 0],
            [['user_id', 'address_id', 'delivery_id'], 'required'],
            [['user_id', 'address_id', 'delivery_id', 'delivery_status', 'original_price', 'order_final_amount', 'order_discount_amount'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::class, 'targetAttribute' => ['address_id' => 'id']],
            [['delivery_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['delivery_id' => 'id']],
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
            'address_id' => 'Address ID',
            'delivery_id' => 'Delivery ID',
            'delivery_status' => 'Delivery Status',
            'original_price' => 'Original Price',
            'order_final_amount' => 'Order Final Amount',
            'order_discount_amount' => 'Order Discount Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Address]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::class, ['id' => 'address_id']);
    }

    /**
     * Gets query for [[Delivery]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasOne(User::class, ['id' => 'delivery_id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
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
