<?php

namespace app\modules\blog\models;

use Yii;

/**
 * This is the model class for table "favorite".
 *
 * @property int $id
 * @property int $user_id
 * @property int $article_id
 * @property int|null $created_at
 *
 * @property Article $article
 * @property User $user
 */
class Favorite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'default', 'value' => null],
            [['user_id', 'article_id'], 'required'],
            [['user_id', 'article_id', 'created_at'], 'integer'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::class, 'targetAttribute' => ['article_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            // جلوگیری از ثبت تکراری
            [['user_id', 'article_id'], 'unique', 'targetAttribute' => ['user_id', 'article_id'], 'message' => 'این مقاله قبلاً به علاقه‌مندی‌ها اضافه شده است.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'user_id' => 'کاربر',
            'article_id' => 'مقاله',
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
     * قبل از ذخیره‌سازی
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert && empty($this->created_at)) {
                $this->created_at = time();
            }
            return true;
        }
        return false;
    }

    /**
     * بررسی اینکه آیا کاربر مقاله را به علاقه‌مندی‌ها اضافه کرده است
     */
    public static function isFavorite($userId, $articleId)
    {
        return self::find()
            ->where(['user_id' => $userId, 'article_id' => $articleId])
            ->exists();
    }

    /**
     * اضافه کردن به علاقه‌مندی‌ها
     */
    public static function addFavorite($userId, $articleId)
    {
        if (self::isFavorite($userId, $articleId)) {
            return false;
        }

        $favorite = new self();
        $favorite->user_id = $userId;
        $favorite->article_id = $articleId;
        $favorite->created_at = time();
        
        return $favorite->save();
    }

    /**
     * حذف از علاقه‌مندی‌ها
     */
    public static function removeFavorite($userId, $articleId)
    {
        $favorite = self::find()
            ->where(['user_id' => $userId, 'article_id' => $articleId])
            ->one();
            
        if ($favorite) {
            return $favorite->delete();
        }
        
        return false;
    }

    /**
     * دریافت لیست مقالات محبوب یک کاربر
     */
    public static function getUserFavorites($userId)
    {
        return self::find()
            ->with(['article'])
            ->where(['user_id' => $userId])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }
}