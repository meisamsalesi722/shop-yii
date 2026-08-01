<?php

namespace app\controllers\admin;

use Yii;
use app\models\Product;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\VendorProduct;
use app\models\DiscountAmount;
use app\models\ProductVariant;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\DiscountAmountSearch;

/**
 * DiscountAmountController implements the CRUD actions for DiscountAmount model.
 */
class DiscountAmountController extends Controller
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
     * Lists all DiscountAmount models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DiscountAmountSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DiscountAmount model.
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
     * Creates a new DiscountAmount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DiscountAmount();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

// $products = ArrayHelper::map(
//     Product::find()
//     ->joinWith('productVariants.vendorProducts.discountAmounts')
//     ->where([
//         'or',
//         ['discount_amount.id' => null],
//         ['<', 'discount_amount.end_date', date('y/m/d h:i:s')],
//     ])->andWhere(['product.status' => 1])
//     ->all() , 'id' , 'name');
$products = ArrayHelper::map(
    Product::find()->distinct()->leftJoin(
            'product_variant',
            'product_variant.product_id = product.id'
        )
        ->leftJoin(
            'vendor_product',
            'vendor_product.product_variant_id = product_variant.id'
        )
        ->leftJoin(
            'discount_amount',
            'discount_amount.vendor_product_id = vendor_product.id
             AND discount_amount.end_date > NOW()'
        )
        ->where(['product.status' => 1])
        ->andWhere(['IS', 'discount_amount.id', null])
        ->all(),
    'id',
    'name'
);

        return $this->render('create', [
            'model' => $model,
            'products' => $products,
        ]);
    }

    // -------------------- variant list ---------------------//
        public function actionProductVariantList()
        {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            $product = Yii::$app->request->post('depdrop_parents');
            
            if (!empty($product)) {

                $product_id = $product[0];
                // $productVariants = ProductVariant::find()->joinWith('vendorProducts.discountAmounts')
                //     ->where(['product_id' => $product_id])
                //     ->andWhere(['discount_amount.id' => null])
                //     ->andWhere([
                //             'or',
                //             ['discount_amount.id' => null],
                //             ['<', 'discount_amount.end_date', date('y/m/d h:i:s')],
                //         ])
                //     ->all();
$productVariants = ProductVariant::find()
    ->distinct()
    ->leftJoin(
        'vendor_product',
        'vendor_product.product_variant_id = product_variant.id'
    )
    ->leftJoin(
        'discount_amount',
        'discount_amount.vendor_product_id = vendor_product.id
         AND discount_amount.end_date > NOW()'
    )
    ->where([
        'product_variant.product_id' => $product_id
    ])
    ->andWhere(['IS', 'discount_amount.id', null])
    ->all();
                    
                $output = [];
                foreach ($productVariants as $productVariant) {
                    $output[] = [
                        'id' => $productVariant->id,
                        'name' =>'رنگ: ' . $productVariant->color . '  گارانتی:  ' . $productVariant->guarantee,
                    ];
                }
                
                return ['output' => $output];
            }
            
            return ['output' => []];
        }
        public function actionVendorProductList()
        {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            $productVariant = Yii::$app->request->post('depdrop_parents');
            
            if (!empty($productVariant)) {

                $productVariantId = $productVariant[0];
                // $vendorProducts = VendorProduct::find()
                //     ->where(['product_variant_id' => $productVariantId])
                //     ->all();
$vendorProducts = VendorProduct::find()
    ->leftJoin(
        'discount_amount',
        'discount_amount.vendor_product_id = vendor_product.id
         AND discount_amount.end_date > NOW()'
    )
    ->where([
        'vendor_product.product_variant_id' => $productVariantId
    ])
    ->andWhere(['IS', 'discount_amount.id', null])
    ->all();
                    
                $output = [];
                foreach ($vendorProducts as $vendorProduct) {
                    $output[] = [
                        'id' => $vendorProduct->id,
                        'name' => $vendorProduct->price . '_' . $vendorProduct->vendor->name,
                    ];
                }
                
                return ['output' => $output];
            }
            
            return ['output' => []];
        }
        // ----------------- end color list ----------------//

    /**
     * Updates an existing DiscountAmount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $vendorProduct = $model->vendorProduct;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $products = VendorProduct::find()->joinWith('discountAmounts')->where(['or',['discount_amount.id' => null],['<', 'discount_amount.end_date', time()]])->andWhere(['vendor_product.status' => 1])->all();

        
        
        $vendorProducts = ArrayHelper::map(($vendorProducts) , 'id' , 'price');
        
        $vendorProducts[$vendorProduct->id] = $vendorProduct->price;

        return $this->render('update', [
            'model' => $model,
            'products' => $products,
        ]);
    }

    /**
     * Deletes an existing DiscountAmount model.
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

    /**
     * Finds the DiscountAmount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return DiscountAmount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DiscountAmount::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
