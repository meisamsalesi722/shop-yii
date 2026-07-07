<?php

namespace app\controllers\admin;

use Yii;
use app\models\Brand;
use app\models\Color;
use app\models\Product;
use yii\web\Controller;
use app\models\Category;
use app\models\Guarantee;
use app\models\ProductMeta;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\ProductSearch;
use yii\web\NotFoundHttpException;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();


        if ($this->request->isPost) {
            if (Yii::$app->request->post('step') == 2) {

            $productId = Yii::$app->request->post('product_id');
            $attributeIds = Yii::$app->request->post('Product')['meta_key'];
            $values = Yii::$app->request->post('Product')['meta_value'];
            $units = Yii::$app->request->post('Product')['unit'];
            $transaction = Yii::$app->db->beginTransaction();
                        try {
                            foreach ($attributeIds as $i => $attributeId) {
                                $meta = new ProductMeta();
                                $meta->product_id = $productId;
                                $meta->meta_key = $attributeId;
                                $meta->unit = $units[$i];
                                $meta->meta_value = $values[$i];
                                if(!$meta->save()){
                                    throw new \Exception('خطا در ذخیره ویژگی');
                                }
                            }
                                $transaction->commit();
                                Yii::$app->session->setFlash('success', 'ساخت محصول با موفقیت انجام شد.');
                                return $this->redirect(['view', 'id' => $productId]);
                        } catch (\Throwable $th) {
                             $transaction->rollBack();
                            $model = $this->findModel($productId);
                            $model->deleteImage();
                            $model->delete();
                            // Yii::$app->session->setFlash('sucess', 'ساخت محصول با موفقیت انجام شد.');
                            // return $this->redirect(['index']);
                            throw $th;
                        }
            }else{

            if ($model->load($this->request->post())) {
                $model->category_id = $model->category3_id;
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                    if($model->imageFile){
                        $imageName = time() . '.' . $model->imageFile->extension;
                        if (!file_exists('uploads/images')) {
                            mkdir('uploads/images', 0777, true);
                        }
                        $model->imageFile->saveAs('uploads/images/' . $imageName);
                        $model->image = $imageName;
                    }
                    
                    if($model->save(false)){
                        $category = Category::findOne(['id' => $model->category_id]);
                        $attributes = $category->categoryAttributes;
                        return $this->render('create-attribute', [ 'product_id' => $model->id ,'model' => $model , 'attributes' => $attributes]);
                    }

                    Yii::$app->session->setFlash('error', 'ساخت محصول با خطا مواجه شد.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
        }} else {
            $model->loadDefaultValues();
        }
        $guarantee = ArrayHelper::map(Guarantee::find()->all(), 'id', 'name');
        $brands = ArrayHelper::map(Brand::find()->all(), 'id', 'original_name');
        $colors = ArrayHelper::map(Color::find()->all(), 'id', 'name');
        $categories = ArrayHelper::map(Category::find()->where(['parent_id' => null])->all(), 'id', 'name');


        return $this->render('create', [
            'model' => $model,
            'guarantee' => $guarantee,
            'brands' => $brands,
            'colors' => $colors,
            'categories' => $categories,
        ]);
    }
public function actionCatList()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    $parents = Yii::$app->request->post('depdrop_parents');
    
    if (!empty($parents)) {

        $parent_id = $parents[0];
        $categories = Category::find()
            ->where(['parent_id' => $parent_id])
            ->orderBy('name')
            ->all();
            
        $output = [];
        foreach ($categories as $category) {
            $output[] = [
                'id' => $category->id,
                'name' => $category->name
            ];
        }
        
        return ['output' => $output];
    }
    
    return ['output' => []];
}

public function actionGetLevel1()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    $categories = Category::find()
        ->where(['parent_id' => null])
        ->orderBy('name')
        ->all();
        
    $output = [];
    foreach ($categories as $category) {
        $output[] = [
            'id' => $category->id,
            'name' => $category->name
        ];
    }
    
    return ['output' => $output];
}

    /**
     * Updates an existing Product model.
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
                return $this->render('create-attribute', [ 'product_id' => $id ,'model' => $model , 'attributes' => $attributes]);
            }
            
                    Yii::$app->session->setFlash('error', 'ویرایش محصول با خطا مواجه شد.');
                    return $this->redirect(['view', 'id' => $model->id]);
        }
        }
        }
    }

    $guarantee = ArrayHelper::map(Guarantee::find()->all(), 'id', 'name');
    $brands = ArrayHelper::map(Brand::find()->all(), 'id', 'original_name');
    $colors = ArrayHelper::map(Color::find()->all(), 'id', 'name');
    $categories = ArrayHelper::map(Category::find()->where(['parent_id' => null])->all(), 'id', 'name');

    return $this->render('update', [
        'model' => $model,
        'guarantee' => $guarantee,
        'brands' => $brands,
        'colors' => $colors,
        'categories' => $categories,
    ]);
}



    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleteImage();
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
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
