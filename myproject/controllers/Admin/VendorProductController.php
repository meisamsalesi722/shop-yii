<?php

namespace app\controllers\admin;

use app\models\Vendor;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\VendorProduct;
use yii\web\NotFoundHttpException;
use app\models\VendorProductSearch;
use yii\data\ActiveDataProvider;

/**
 * VendorProductController implements the CRUD actions for VendorProduct model.
 */
class VendorProductController extends Controller
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
    public function actionIndex()
    {
        $searchModel = new VendorProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $vendor = Vendor::findOne(['user_id' => Yii::$app->user->id]);
                $model->vendor_id = $vendor->id;
                $model->product_variant_id = (int)$product_variant_id;
                
                if($model->save()){
                    Yii::$app->session->setFlash('success' , 'محصول شما با موفقیت ثبت شد');
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    dd($model->errors , $model->vendor_id);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'product_id' => $product_id,
            'product_variant_id' => $product_variant_id
        ]);
    }


    public function actionVendors($id){
        $vendors = VendorProduct::find()->where(['product_variant_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $vendors,
        ]);

        return $this->renderAjax('/admin/product-variant/vendors' , [
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
}
