<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * ConfirmProductController implements the CRUD actions for Product model.
 */
class ConfirmProductController extends Controller
{
    public $layout = 'admin/admin';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'approve' => ['POST'],
                    'reject' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'], // فقط ادمین
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        
        $query = Product::find()
            ->with(['category', 'user'])
            ->orderBy(['created_at' => SORT_DESC]);

        $status = $request->get('status');
        if ($status !== null && $status !== '') {
            $query->andWhere(['status' => $status]);
        }

        $search = $request->get('search');
        if ($search) {
            $query->andWhere(['like', 'name', $search]);
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        $stats = [
            'total' => Product::find()->count(),
            'pending' => Product::find()->where(['status' => 0])->count(),
            'approved' => Product::find()->where(['status' => 1])->count(),
            'rejected' => Product::find()->where(['status' => 2])->count(),
        ];


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'products' => $dataProvider->getModels(), 
            'stats' => $stats,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Approve a product.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $model->status = 1; 
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        if ($model->save(true , ['status'])) {
            return [
                'success' => true,
                'message' => 'محصول با موفقیت تایید شد.',
                'status' => $model->status,
                'status_text' => 'تایید شده',
                'status_class' => 'success',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'خطا در تایید محصول.',
                'errors' => $model->errors,
            ];
        }
    }

    /**
     * Reject a product.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->status = 2;
        if(Yii::$app->request->isPost){

            $model->reject_message = Yii::$app->request->post('message');

        Yii::$app->response->format = Response::FORMAT_JSON;
        
        if ($model->save(true , ['status' ,'reject_message'])) {
            return [
                'success' => true,
                'message' => 'محصول با موفقیت رد شد.',
                'status' => $model->status,
                'status_text' => 'رد شده',
                'status_class' => 'danger',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'خطا در رد محصول.',
                'errors' => $model->errors,
            ];
        }

        }
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('صفحه مورد نظر یافت نشد.');
    }
}