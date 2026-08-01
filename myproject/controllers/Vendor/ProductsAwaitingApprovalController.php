<?php

namespace app\controllers\vendor;

use Yii;
use app\models\Brand;
use app\models\Product;
use yii\web\Controller;
use app\models\Category;
use yii\web\UploadedFile;
use app\models\ProductMeta;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\ProductSearch;
use app\models\ProductVariant;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\ProductVariantSearch;

/**
 * ProductVariantController implements the CRUD actions for ProductVariant model.
 */
class ProductsAwaitingApprovalController extends Controller
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
     * Lists all ProductVariant models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $params['ProductSearch']['awaitProduct'] = 1;
        $params['ProductSearch']['user_id'] = Yii::$app->user->id;
        $queryParams = array_merge($this->request->queryParams , $params);
        $dataProvider = $searchModel->search($queryParams);
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductVariant model.
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


    public function actionDelete($id){
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Updates an existing ProductVariant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
public function actionUpdate($id)
{
    $model = $this->findModel($id);
    
    if ($this->request->isPost) {

        if( $model->load($this->request->post())){
                    if (Yii::$app->request->post('step') == 2) {
                        $productId = Yii::$app->request->post('product_id');
                        $attributeIds = Yii::$app->request->post('Product')['meta_key'];
                        $values = Yii::$app->request->post('Product')['meta_value'];
                         $units = Yii::$app->request->post('Product')['unit'];
                        $transaction = Yii::$app->db->beginTransaction();
                        try {
                            foreach ($attributeIds as $i => $attributeId) {
                                $meta = ProductMeta::findOne([
                                    'product_id' => $productId,
                                    'meta_key' => $attributeId,
                                ]);
                                if ($meta === null) {
                                    $meta = new ProductMeta();
                                    $meta->product_id = $productId;
                                    $meta->unit = $units[$i];
                                    $meta->meta_key = $attributeId;
                                } 
                                $meta->meta_value = $values[$i];
                                if(!$meta->save()){
                                    throw new \Exception('خطا در ذخیره ویژگی');
                                }
                            }
                            $transaction->commit();
                                        
                            Yii::$app->session->setFlash('sucess', 'ویرایش محصول با موفقیت انجام شد.');
                            return $this->redirect(['view', 'id' => $productId]);
                        } catch (\Throwable $th) {
                             $transaction->rollBack();

                            throw $th;
                        }

            }else{                
                $model->category_id = $model->category3_id;
                $model->user_id = Yii::$app->user->id;
                $model->status = 0;
        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');        
        if ($model->validate()) {
        if ($model->imageFile) {
            $model->deleteImage();
                    if (!file_exists('uploads/images')) {
                        mkdir('uploads/images', 0777, true);
                    }
                    $imageName = time() . '.' . $model->imageFile->extension;
                    $model->imageFile->saveAs('uploads/images/' . $imageName);
                    $model->image = $imageName;
            }
            if($model->save(false)){
                $category = Category::findOne(['id' => $model->category_id]);
                $attributes = $category->categoryAttributes;
                if(!empty($attributes)){
                    return $this->render('create-attribute', [ 'product_id' => $id ,'model' => $model , 'attributes' => $attributes]);
                }else{
                    Yii::$app->session->setFlash('success', 'ویرایش محصول با موفقیت انجام شد.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            
                    Yii::$app->session->setFlash('error', 'ویرایش محصول با خطا مواجه شد.');
                    return $this->redirect(['view', 'id' => $model->id]);
        }
        }
        }
    }

    $brands = ArrayHelper::map(Brand::find()->where(['status' => 1])->all(), 'id', 'original_name');
    $categories = ArrayHelper::map(Category::find()->where(['parent_id' => null , 'status' => 1])->all(), 'id', 'name');

    return $this->render('update', [
        'model' => $model,
        'brands' => $brands,
        'categories' => $categories,
    ]);
}

    /**
     * Finds the ProductVariant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ProductVariant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
