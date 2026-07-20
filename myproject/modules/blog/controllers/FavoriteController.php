<?php

namespace app\modules\blog\controllers;

use Yii;

use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\modules\blog\models\Article;
use app\modules\blog\models\Favorite;

class FavoriteController extends Controller
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
                'only' => ['toggle', 'index', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['toggle', 'index', 'delete'],
                        'roles' => ['@'], // فقط کاربران لاگین شده
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'toggle' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * نمایش لیست علاقه‌مندی‌های کاربر
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;
        $favorites = Favorite::getUserFavorites($userId);
        
        return $this->render('index', [
            'favorites' => $favorites,
        ]);
    }

    /**
     * اضافه یا حذف از علاقه‌مندی‌ها (Toggle)
     */
    public function actionToggle()
    {
        $request = Yii::$app->request;
        $articleId = $request->post('article_id');
        $userId = Yii::$app->user->id;
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        if (!$articleId) {
            return [
                'success' => false,
                'message' => 'شناسه مقاله ارسال نشده است.',
            ];
        }
        
        // بررسی وجود مقاله
        $article = Article::findOne($articleId);
        if (!$article) {
            return [
                'success' => false,
                'message' => 'مقاله مورد نظر پیدا نشد.',
            ];
        }
        
        $isFavorite = Favorite::isFavorite($userId, $articleId);
        
        if ($isFavorite) {
            // حذف از علاقه‌مندی‌ها
            $success = Favorite::removeFavorite($userId, $articleId);
            $message = $success ? 'مقاله از علاقه‌مندی‌ها حذف شد.' : 'خطا در حذف از علاقه‌مندی‌ها.';
        } else {
            // اضافه به علاقه‌مندی‌ها
            $success = Favorite::addFavorite($userId, $articleId);
            $message = $success ? 'مقاله به علاقه‌مندی‌ها اضافه شد.' : 'خطا در اضافه کردن به علاقه‌مندی‌ها.';
        }
        
        return [
            'success' => $success,
            'message' => $message,
            'isFavorite' => !$isFavorite, // وضعیت جدید
            'favoriteCount' => Favorite::find()
                ->where(['article_id' => $articleId])
                ->count(),
        ];
    }

    /**
     * حذف یک آیتم از علاقه‌مندی‌ها
     */
    public function actionDelete($id)
    {
         Yii::$app->response->format = Response::FORMAT_JSON;
        $favorite = $this->findModel($id);
        
        // بررسی اینکه کاربر صاحب این آیتم است
        if ($favorite->user_id != Yii::$app->user->id) {
            throw new NotFoundHttpException('شما اجازه حذف این آیتم را ندارید.');
        }
        
        if ($favorite->delete()) {
            Yii::$app->session->setFlash('success', 'آیتم با موفقیت از علاقه‌مندی‌ها حذف شد.');
            return [
                    'success' => true,
                    'message' => 'آیتم با موفقیت از علاقه‌مندی‌ها حذف شد.',
                    'id' => $id,
                ];
        } else {
            Yii::$app->session->setFlash('error', 'خطا در حذف آیتم.');
            return [
                    'success' => false,
                    'message' => 'خطا در حذف آیتم.',
                ];
        }
        
        return $this->redirect(['index']);
    }

    /**
     * پیدا کردن مدل Favorite
     */
    protected function findModel($id)
    {
        if (($model = Favorite::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('آیتم مورد نظر پیدا نشد.');
    }
}