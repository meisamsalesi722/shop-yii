<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property int $address_id
 * @property string|null $original_price
 * @property string|null $order_final_amount
 * @property string|null $order_discount_amount
 * @property int|null $copan_id
 * @property string|null $order_copan_discount_amount
 * @property string|null $order_total_products_discount_amount
 * @property int|null $order_status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Address $address
 * @property Copan $copan
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
            [['original_price', 'order_final_amount', 'order_discount_amount', 'copan_id', 'order_copan_discount_amount', 'order_total_products_discount_amount'], 'default', 'value' => null],
            [['order_status'], 'default', 'value' => 0],
            [['user_id', 'address_id'], 'required'],
            [['user_id', 'address_id', 'copan_id', 'order_status'], 'integer'],
            [['created_at', 'updated_at' ], 'safe'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::class, 'targetAttribute' => ['address_id' => 'id']],
            [['copan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Copan::class, 'targetAttribute' => ['copan_id' => 'id']],
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
            'original_price' => 'Original Price',
            'order_final_amount' => 'Order Final Amount',
            'order_discount_amount' => 'Order Discount Amount',
            'copan_id' => 'Copan ID',
            'order_copan_discount_amount' => 'Order Copan Discount Amount',
            'order_total_products_discount_amount' => 'Order Total Products Discount Amount',
            'order_status' => 'Order Status',
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
     * Gets query for [[Copan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCopan()
    {
        return $this->hasOne(Copan::class, ['id' => 'copan_id']);
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
