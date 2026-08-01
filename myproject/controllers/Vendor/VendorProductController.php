<?php

namespace app\controllers\vendor;

use Yii;
use Exception;
use app\models\Vendor;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\VendorProduct;
use app\models\DiscountAmount;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\VendorProductSearch;

/**
 * VendorProductController implements the CRUD actions for VendorProduct model.
 */
class VendorProductController extends Controller
{

    public $layout = 'vendor/admin';
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
                            'roles' => ['vendor'],
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
     * Lists all VendorProduct models.
     *
     * @return string
     */
    public function actionIndex($product_variant_id = null)
    {
        $searchModel = new VendorProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'product_variant_id' => $product_variant_id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VendorProduct model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id , $product_variant_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'product_variant_id' => $product_variant_id,
        ]);
    }

    /**
     * Creates a new VendorProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($product_variant_id , $product_id)
    {
        $model = new VendorProduct();
        $discountModel = new DiscountAmount();

        $request = Yii::$app->request;
        if ($this->request->isPost) {


            if ($model->load($this->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                try{
                $vendor = Vendor::findOne(['user_id' => Yii::$app->user->id]);
                $model->vendor_id = $vendor->id;
                $model->product_variant_id = (int)$product_variant_id;
                
                if($model->save()){
                    Yii::$app->session->setFlash('success' , 'محصول شما با موفقیت ثبت شد');
                }else{
                   throw new Exception('هنگام انجام عملیات مشکلی پیش امده است' . ' ' . $model->errors);
                }
                if($request->post('is_discount_active') == 1){
                    if($discountModel->load($request->post())){
                        $discountModel->vendor_product_id = $model->id;
                        if(!$discountModel->save()){
                             throw new Exception('هنگام انجام عملیات مشکلی پیش امده است');
                        }
                    }
                }
                $transaction->commit();
                    return $this->redirect(['view', 'product_variant_id' => $product_variant_id , 'id' => $model->id]);
                }catch(\Throwable $e){
                    $transaction->rollBack();
                    throw $e;
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'product_id' => $product_id,
            'discountModel' => $discountModel,
            'product_variant_id' => $product_variant_id
        ]);
    }


    public function actionVendors($id){
        $vendors = VendorProduct::find()->where(['product_variant_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $vendors,
        ]);

        return $this->renderAjax('/vendor/product-variant/vendors' , [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing VendorProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id , $product_variant_id)
    {
        
        $model = $this->findModel($id );
        $request = Yii::$app->request;
        
        $discountModel = DiscountAmount::find()->where([ 'vendor_product_id' => $id ])->one();

        if(!$discountModel){
            $discountModel = new DiscountAmount();
        };

        if ($this->request->isPost){
            $transaction = Yii::$app->db->beginTransaction();
            try{
            $isDiscountActive = $request->post('is_discount_active', 0);
            $discountModel->is_discount_active = $isDiscountActive;
                if($model->load($this->request->post())){
                    if(!$model->save()) {
                        throw new Exception('هنگام انجام عملیات مشکلی پیش امده است');
                    } 
                    if($request->post('is_discount_active') == 1){
                        if($discountModel->load($request->post())){
                            $discountModel->vendor_product_id = $model->id;
                            if(!$discountModel->save(false)){
                                throw new Exception('هنگام انجام عملیات مشکلی پیش امده است');
                            }
                        }            
                    }else{
                        if($discountModel){
                            $discountModel->delete();
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'product_variant_id' => $product_variant_id , 'id' => $model->id]);
                }
            }catch(\Throwable $e){
                $transaction->rollBack();
                throw $e;
            }

        }
        return $this->render('update', [
            'model' => $model,
            'discountModel' => $discountModel,
            'product_variant_id' => $product_variant_id
        ]);
    }

    /**
     * Deletes an existing VendorProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionAddToMyVendor($id){

        $refModel = $this->findModel($id);
        $model = new VendorProduct();

        return $this->render('add-to-my-vendor' , [
            'model' => $model,
        ]);
    }

    /**
     * Finds the VendorProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return VendorProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VendorProduct::findOne(['id' => $id ])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findDiscountModel($id)
    {
        if (($model = DiscountAmount::findOne(['vendor_product_id' => $id ])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
