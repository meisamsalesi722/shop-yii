<?php

namespace app\modules\blog\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property string $title
 * @property string $slug
 * @property string|null $summary
 * @property string|null $content
 * @property string|null $image
 * @property string|null $pdf
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Category $category
 * @property Comment[] $comments
 * @property Favorite[] $favorites
 * @property User $user
 */
class Article extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $pdfFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['summary', 'content', 'imageFile', 'pdfFile'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['pdfFile'], 'file', 'extensions' => 'pdf'],
            [['user_id', 'blog_category_id', 'title', 'slug'], 'required'],
            [['user_id', 'blog_category_id', 'status'], 'integer'],
            [['summary', 'content'], 'string'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['blog_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogCategory::class, 'targetAttribute' => ['blog_category_id' => 'id']],
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
            'blog_category_id' => 'Category ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'summary' => 'Summary',
            'content' => 'Content',
            'image' => 'Image',
            'pdf' => 'Pdf',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogCategory()
    {
        return $this->hasOne(BlogCategory::class, ['id' => 'blog_category_id']);
    }


    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCommentsBlog()
    {
        return $this->hasMany(CommentBlog::class, ['article_id' => 'id']);
    }


    public function getComment_count()
    {
        return $this->getCommentsBlog()->count();
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::class, ['article_id' => 'id']);
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


    public function deleteImage()
    {
        if ($this->image && file_exists('uploads/images/' . $this->image)) {
            return unlink('uploads/images/' . $this->image);
        }
        return false;
    }


    public function deletePdf()
    {
        if ($this->pdf && file_exists('uploads/pdf/' . $this->pdf)) {
            return unlink('uploads/pdf/' . $this->pdf);
        }
        return false;
    }

    public function deleteFiles()
    {
        $this->deleteImage();
        $this->deletePdf();
    }

        public function isFavorite()
{
    if (Yii::$app->user->isGuest) {
        return false;
    }

    return Favorite::find()
        ->where([
            'article_id' => $this->id,
            'user_id' => Yii::$app->user->id,
        ])
        ->exists();
}

}
