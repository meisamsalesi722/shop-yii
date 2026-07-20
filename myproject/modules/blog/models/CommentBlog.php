<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $article_id
 * @property int $user_id
 * @property string $comment
 * @property int|null $status
 * @property int|null $created_at
 *
 * @property Article $article
 * @property User $user
 */
class CommentBlog extends \yii\db\ActiveRecord
{
    // ثابت‌های وضعیت
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;
    const STATUS_DELETED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment_blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => self::STATUS_PENDING],
            [['article_id', 'user_id', 'comment'], 'required'],
            [['article_id', 'user_id', 'status', 'created_at'], 'integer'],
            [['comment'], 'string', 'min' => 3, 'max' => 5000],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::class, 'targetAttribute' => ['article_id' => 'id']],
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
            'article_id' => 'مقاله',
            'user_id' => 'کاربر',
            'comment' => 'متن نظر',
            'status' => 'وضعیت',
            'created_at' => 'تاریخ ثبت',
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
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
     * قبل از ذخیره‌سازی
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // حذف تگ‌های HTML برای امنیت
            $this->comment = strip_tags($this->comment, '<p><br><strong><em><u>');
            
            // تنظیم زمان ایجاد در صورت جدید بودن
            if ($insert && empty($this->created_at)) {
                $this->created_at = time();
            }
            
            return true;
        }
        return false;
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
}