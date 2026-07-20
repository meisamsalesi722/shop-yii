<?php

namespace app\modules\blog\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\modules\blog\models\Article;
use app\modules\blog\models\CommentBlog;


class CommentBlogController extends Controller
{
    public $layout = 'main';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete', 'approve', 'reject', 'admin'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['@'], // فقط کاربران لاگین شده
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $commentId = Yii::$app->request->get('id');
                            $comment = CommentBlog::findOne($commentId);
                            if (!$comment) {
                                return false;
                            }
                            return Yii::$app->user->id == $comment->user_id || 
                                   Yii::$app->user->can('admin');
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['approve', 'reject', 'admin'],
                        'roles' => ['admin'], // فقط ادمین
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'approve' => ['POST'],
                    'reject' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * ایجاد کامنت جدید
     */
    public function actionCreate($article_id)
    {
        $model = new CommentBlog();
        $model->article_id = $article_id;
        $model->user_id = Yii::$app->user->id;
        $model->status = CommentBlog::STATUS_PENDING;
        $model->created_at = time();
        $article = Article::findOne($article_id);

        // بررسی تکراری نبودن (مبارزه با اسپم)
        $lastComment = CommentBlog::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['article_id' => $article_id])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        if ($lastComment && (time() - $lastComment->created_at) < 30) {
            Yii::$app->session->setFlash('error', 'شما خیلی سریع نظر می‌دهید! لطفاً 30 ثانیه صبر کنید.');
            return $this->redirect(Yii::$app->request->referrer ?: ['blog/view', 'slug' => $article->slug, '#' => 'comments']);
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            // اعتبارسنجی محتوا
            if (empty(trim($model->comment))) {
                Yii::$app->session->setFlash('error', 'متن نظر نمی‌تواند خالی باشد.');
                return $this->redirect(Yii::$app->request->referrer ?: ['blog/view', 'slug' => $article->slug, '#' => 'comments']);
            }

            // فیلتر کلمات ممنوع
            $forbiddenWords = ['کلمه1', 'کلمه2', 'کلمه3'];
            foreach ($forbiddenWords as $word) {
                if (stripos($model->comment, $word) !== false) {
                    Yii::$app->session->setFlash('error', 'نظر شما شامل کلمات نامناسب است.');
                    return $this->redirect(Yii::$app->request->referrer ?: ['blog/view', 'slug' => $article->slug, '#' => 'comments']);
                }
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'نظر شما با موفقیت ثبت شد. پس از تایید نمایش داده می‌شود.');
            } else {
                Yii::$app->session->setFlash('error', 'خطا در ثبت نظر. لطفاً دوباره تلاش کنید.');
            }
            
            return $this->redirect(['blog/view', 'slug' => $article->slug, '#' => 'comments']);
        }

        return $this->redirect(['blog/view', 'slug' => $article->slug]);
    }

    /**
     * ویرایش کامنت (فقط نویسنده یا ادمین)
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $article = $model->article;

        
        // بررسی اجازه ویرایش
        if ($model->user_id != Yii::$app->user->id) {
            throw new NotFoundHttpException('شما اجازه ویرایش این نظر را ندارید.');
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            if (empty(trim($model->comment))) {
                Yii::$app->session->setFlash('error', 'متن نظر نمی‌تواند خالی باشد.');
                return $this->redirect(['blog/view', 'slug' => $article->slug, '#' => 'comments']);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'نظر شما با موفقیت ویرایش شد.');
            } else {
                Yii::$app->session->setFlash('error', 'خطا در ویرایش نظر.');
            }
            
            return $this->redirect(['blog/view', 'slug' => $article->slug, '#' => 'comments']);
        }

    }



    /**
     * پیدا کردن مدل کامنت
     */
    protected function findModel($id)
    {
        if (($model = CommentBlog::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('کامنت مورد نظر پیدا نشد.');
    }
}