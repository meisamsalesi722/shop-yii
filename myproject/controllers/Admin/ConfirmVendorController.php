<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Vendor;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * ConfirmVendorController implements the CRUD actions for Vendor model.
 */
class ConfirmVendorController extends Controller
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
     * Lists all Vendor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        
        $query = Vendor::find()
            ->with([ 'user'])
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
            'total' => Vendor::find()->count(),
            'pending' => Vendor::find()->where(['status' => 0])->count(),
            'approved' => Vendor::find()->where(['status' => 1])->count(),
            'rejected' => Vendor::find()->where(['status' => 2])->count(),
        ];


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'vendors' => $dataProvider->getModels(), 
            'stats' => $stats,
        ]);
    }

    /**
     * Displays a single Vendor model.
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
     * Approve a vendor.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionApprove($id)
    {
        
        $model = $this->findModel($id);
        $model->status = 1;
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('vendor_product');
        if ($model->save(true , ['status'])) {
            if (!$auth->getAssignment('vendor_product', $model->user_id)) {
                $auth->assign($admin, $model->user_id);
            }
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
     * Reject a vendor.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionReject($id)
    {
        $model = $this->findModel($id);

        $auth = Yii::$app->authManager;
        $vendor_product = $auth->getRole('vendor_product');
        if ($auth->getAssignment('vendor_product', $model->user_id)) {
            $auth->revoke($vendor_product, $model->user_id);
        }

        $model->status = 2; 
        
        
        if(Yii::$app->request->isPost){
            
            $model->reject_message = Yii::$app->request->post('message');
            
            Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->save(true , ['status' , 'reject_message'])) {
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
     * Finds the Vendor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vendor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vendor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('صفحه مورد نظر یافت نشد.');
    }
}