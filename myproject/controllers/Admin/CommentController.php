<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Response;
use app\models\Comment;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\CommentSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
{
    public $layout = 'admin/admin';
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
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
        $comments = Comment::find()
            ->with(['user', 'product'])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
        
        $stats = [
            'total' => Comment::find()->count(),
            'pending' => Comment::find()->where(['status' => Comment::STATUS_PENDING])->count(),
            'approved' => Comment::find()->where(['status' => Comment::STATUS_APPROVED])->count(),
            'rejected' => Comment::find()->where(['status' => Comment::STATUS_REJECTED])->count(),
        ];

        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('/admin/comment/index', [
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
        return $this->render('/admin/comment/view', [
            'model' => $this->findModel($id),
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

        return $this->render('/admin/comment/update', [
            'model' => $model,
        ]);
    }

    /**
     * حذف کامنت (فقط نویسنده یا ادمین)
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $product = $model->product;
        


        // حذف نرم (تغییر وضعیت به DELETED)
        $model->status = Comment::STATUS_DELETED;
        
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

        return $this->redirect(['/admin/comment']);
    }

        /**
     * تایید کامنت (برای ادمین)
     */
    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $model->status = Comment::STATUS_APPROVED;
        
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
        $model->status = Comment::STATUS_REJECTED;
        
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


    public function actionAnswer($id)
    {
        $model = new Comment;
        $comment = Comment::findOne($id);
        if($this->request->isPost){
            if($model->load($this->request->post())){
                $model->product_id = $comment->product->id;
                $model->user_id = Yii::$app->user->identity->id;
                $model->parent_id = $id;
                $model->status = Comment::STATUS_APPROVED;
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'پاسخ شما با موفقیت ثبت شد.');
                    return $this->redirect(['/admin/comment/index', 'id' => $model->id]);
                }
            }
        }
        
       return $this->render('/admin/comment/create' , ['model' => $model , 'comment' => $comment]);
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
        if (($model = Comment::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
