<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property string $subject
 * @property string $description
 * @property int|null $status
 * @property int $user_id
 * @property int|null $ticket_id
 * @property string $created_at
 *
 * @property Ticket $ticket
 * @property Ticket[] $tickets
 * @property User $user
 */
class Ticket extends \yii\db\ActiveRecord
{

    const STATUS_UNSEEN = 0;
    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 2;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ticket_id'], 'default', 'value' => null],
            [['status' , 'is_admin'], 'default', 'value' => 0],
            [['subject', 'description', 'user_id'], 'required'],
            [['description'], 'string'],
            [['status', 'user_id', 'ticket_id'], 'integer'],
            [['created_at'], 'safe'],
            [['subject'], 'string', 'max' => 255],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::class, 'targetAttribute' => ['ticket_id' => 'id']],
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
            'subject' => 'Subject',
            'description' => 'Description',
            'status' => 'Status',
            'user_id' => 'User ID',
            'ticket_id' => 'Ticket ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Ticket]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::class, ['id' => 'ticket_id']);
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::class, ['ticket_id' => 'id']);
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


        /**
     * دریافت وضعیت به صورت متنی
     */
    public function getStatusText()
    {
        $statuses = [
            self::STATUS_UNSEEN => 'دیده نشده',
            self::STATUS_OPEN => 'باز',
            self::STATUS_CLOSE => 'بسته شده',
        ];
        return $statuses[$this->status] ?? 'نامشخص';
    }

    /**
     * دریافت کلاس بوت‌استرپ برای وضعیت
     */
    public function getStatusClass()
    {
        $classes = [
            self::STATUS_OPEN => 'success',
            self::STATUS_CLOSE => 'danger',
            self::STATUS_UNSEEN => 'secondary',
        ];
        return $classes[$this->status] ?? 'secondary';
    }
}
