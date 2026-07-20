<?php

namespace app\modules\blog\controllers\admin;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\modules\blog\models\CommentBlog;
use app\modules\blog\models\CommentBlogSearch;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentBlogController extends Controller
{
    public $layout = '/admin/admin';
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Comment models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $comments = CommentBlog::find()
            ->with(['user', 'article'])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
        
        $stats = [
            'total' => CommentBlog::find()->count(),
            'pending' => CommentBlog::find()->where(['status' => CommentBlog::STATUS_PENDING])->count(),
            'approved' => CommentBlog::find()->where(['status' => CommentBlog::STATUS_APPROVED])->count(),
            'rejected' => CommentBlog::find()->where(['status' => CommentBlog::STATUS_REJECTED])->count(),
        ];

        $searchModel = new CommentBlogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('/admin/comment-blog/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'comments' => $comments,
            'stats' => $stats,
        ]);
    }

    /**
     * Displays a single Comment model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('/admin/comment-blog/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CommentBlog();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('/admin/comment-blog/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('/admin/comment-blog/update', [
            'model' => $model,
        ]);
    }

    /**
     * حذف کامنت (فقط نویسنده یا ادمین)
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $article = $model->article;
        
        // بررسی اجازه حذف
        if ($model->user_id != Yii::$app->user->id && !Yii::$app->user->can('admin')) {
            throw new NotFoundHttpException('شما اجازه حذف این نظر را ندارید.');
        }

        // حذف نرم (تغییر وضعیت به DELETED)
        $model->status = CommentBlog::STATUS_DELETED;
        
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'نظر با موفقیت حذف شد.');
        } else {
            Yii::$app->session->setFlash('error', 'خطا در حذف نظر.');
        }
                if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'success' => true,
                'message' => 'کامنت با موفقیت حذف شد.'
            ];
        }

        return $this->redirect(['/blog/view', 'slug' => $article->slug, '#' => 'comments']);
    }

        /**
     * تایید کامنت (برای ادمین)
     */
    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $model->status = CommentBlog::STATUS_APPROVED;
        
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'کامنت با موفقیت تایید شد.');
        } else {
            Yii::$app->session->setFlash('error', 'خطا در تایید کامنت.');
        }

    if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'success' => true,
            'message' => 'کامنت با موفقیت تایید شد.'
        ];
    }
            
        return $this->redirect(Yii::$app->request->referrer ?: ['admin/comment']);
    }

    /**
     * رد کامنت (برای ادمین)
     */
    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->status = CommentBlog::STATUS_REJECTED;
        
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'کامنت با موفقیت رد شد.');
        } else {
            Yii::$app->session->setFlash('error', 'خطا در رد کامنت.');
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'success' => true,
                'message' => 'کامنت با موفقیت رد شد.'
            ];
        }
        
        return $this->redirect(Yii::$app->request->referrer ?: ['admin/comment']);
    }



    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CommentBlog::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
