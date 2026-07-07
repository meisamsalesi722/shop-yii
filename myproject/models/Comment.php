<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property string $comment
 * @property int|null $status
 * @property int|null $created_at
 *
 * @property Product $product
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    // ثابت‌های وضعیت
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;
    const STATUS_DELETED = 3;
    public $email;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_PENDING],
            [['comment'], 'required'],
            [['product_id', 'user_id','email'], 'safe'],
            [['status'], 'integer'],
            [['comment'], 'string', 'min' => 3, 'max' => 5000],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            
            // اعتبارسنجی محتوا
            [['comment'], 'filter', 'filter' => 'trim'],
            [['comment'], 'validateSpam'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'product_id' => 'مقاله',
            'user_id' => 'کاربر',
            'comment' => 'متن نظر',
            'status' => 'وضعیت',
            'created_at' => 'تاریخ ثبت',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
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
            self::STATUS_PENDING => 'در انتظار تایید',
            self::STATUS_APPROVED => 'تایید شده',
            self::STATUS_REJECTED => 'رد شده',
            self::STATUS_DELETED => 'حذف شده',
        ];
        return $statuses[$this->status] ?? 'نامشخص';
    }

    /**
     * دریافت کلاس بوت‌استرپ برای وضعیت
     */
    public function getStatusClass()
    {
        $classes = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_APPROVED => 'success',
            self::STATUS_REJECTED => 'danger',
            self::STATUS_DELETED => 'secondary',
        ];
        return $classes[$this->status] ?? 'secondary';
    }

    /**
     * اعتبارسنجی اسپم
     */
    public function validateSpam($attribute, $params)
    {
        $spamKeywords = ['spam', 'viagra', 'casino', 'لینک'];
        $content = strtolower($this->$attribute);
        
        foreach ($spamKeywords as $keyword) {
            if (strpos($content, $keyword) !== false) {
                $this->addError($attribute, 'متن نظر شامل کلمات اسپم است.');
                break;
            }
        }
    }


    /**
     * دریافت تاریخ به صورت فرمت شده
     */
    public function getCreatedAtFormatted()
    {
        return Yii::$app->formatter->asDatetime($this->created_at, 'php:Y/m/d H:i');
    }

    /**
     * دریافت تاریخ به صورت نسبی (مثلاً: ۲ ساعت پیش)
     */
    public function getCreatedAtRelative()
    {
        return Yii::$app->formatter->asRelativeTime($this->created_at);
    }

        /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Comment::class, ['id' => 'parent_id']);
    }

    public function getChildren()
    {
        return $this->hasMany(Comment::class, ['parent_id' => 'id']);
    }
}