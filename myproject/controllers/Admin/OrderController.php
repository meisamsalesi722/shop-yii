<?php

namespace app\controllers\admin;

use Yii;
use TCPDF;
use kartik\mpdf\Pdf;
use app\models\Color;
use app\models\Order;
use app\models\Product;
use yii\web\Controller;
use app\models\OrderItem;
use app\models\OrderSearch;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\models\OrderItemSearch;
use yii\web\NotFoundHttpException;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
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
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Order model.
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

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
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

    // ----------  order Item  ----------- //

        /**
     * Lists all OrderItem models.
     *
     * @return string
     */
    public function actionOrderItem($order_id)
    {
        $searchModel = new OrderItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams , $order_id);

        return $this->render('order-item/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'order_id' => $order_id,
        ]);
    }

        /**
     * Displays a single OrderItem model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionOrderItemView($id , $order_id)
    {
        return $this->render('order-item/view', [
            'model' => $this->findModelOrderItem($id),
            'order_id' => $order_id,
        ]);
    }

    /**
     * Creates a new OrderItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionOrderItemCreate($order_id)
    {
        $model = new OrderItem();
        
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                $price = $model->product->price;
                if($model->color){
                    $price += $model->color->price_increase;
                }
                $count = $model->number;
                $itemTotal = $price * $count;
                $discount = 0;
                if ($model->product->discountAmounts) {
                    $discount = ($itemTotal * $model->product->discountAmounts->percentage) / 100;
                    if ($discount > $model->product->discountAmounts->discount_ceiling) {
                        $discount = $model->product->discountAmounts->discount_ceiling;
                    }
                }
                $model->final_discount = $discount;
                $model->order_id = $order_id;
                $model->final_product_price = $price - ($discount / $count);
                $model->final_total_price = ($price - $discount / $count) * $model->number;
                $model->guarantee_id = $model->product->guarantee->id;
                
                $product = Product::findOne($model->product_id);


                    $product->marketable_number -= $model->number;
                    $product->sold_number += $model->number;
                    if (!$product->save(false)) {
                        throw new \Exception('Product could not be saved.');
                    };
                
                $order = Order::find()->where(['id' => $order_id])->one();

                    $order->original_price += ($model->number * $price);
                    $order->order_final_amount += $itemTotal - $discount;
                    $order->order_discount_amount += $discount;
                    $order->order_total_products_discount_amount += $discount;

                if (!$order->save(false)) {
                    throw new \Exception('Order could not be saved.');
                }

                if(!$model->save()){
                    throw new \Exception('Order item could not be saved.');
                }
                $transaction->commit();
                return $this->redirect(['/admin/order/order-item-view', 'order_id' => $order_id ,'id' => $model->id]);
                } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        $products = ArrayHelper::map(Product::find()->where(['product.status' => 1])->all() , 'id' , 'name');

        return $this->render('order-item/create', [
            'model' => $model,
            'products' => $products,
            'order_id' => $order_id,
        ]);
    }
// -------------------- color list ---------------------//
        public function actionColorList()
        {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            $product = Yii::$app->request->post('depdrop_parents');
            
            if (!empty($product)) {

                $product_id = $product[0];
                $colors = Color::find()
                    ->where(['product_id' => $product_id])
                    ->orderBy('name')
                    ->all();
                    
                $output = [];
                foreach ($colors as $color) {
                    $output[] = [
                        'id' => $color->id,
                        'name' => $color->name
                    ];
                }
                
                return ['output' => $output];
            }
            
            return ['output' => []];
        }
        // ----------------- end color list ----------------//
        // ----------------- product count ----------------//

        public function actionProductCount()
        {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            $product = Yii::$app->request->post('depdrop_parents');
            
            if (!empty($product)) {

                $product_id = $product[0];

                $product = Product::findOne($product_id);
                $productCount = $product->marketable_number;

                for($i = 1 ; $i <= $productCount ; $i++){
                    $output[] = [
                        'id' => $i,
                        'name' => $i
                    ];
                }
                
                return ['output' => $output];
            }
            
            return ['output' => []];
        }

        // ----------------- end product count -----------------//
        public function actionOrderItemUpdate($id , $order_id)
    {
        $model = $this->findModelOrderItem($id);
        $color = $model->color;
        $number = $model->number;
        
        $oldDiscount = $model->final_discount;
        $oldPrice = ($model->final_product_price * $number + $oldDiscount) ;
        

        if ($this->request->isPost && $model->load($this->request->post())) {


            $product = Product::findOne($model->product_id);
            $product->marketable_number += ($number - $model->number);
            $product->sold_number -= ($number - $model->number);

            if(!$product->save(false)){
                dd('false');
            };
                $price = $model->product->price;
                if($model->color){
                    $price += $model->color->price_increase;
                }
                $count = $model->number;
                $itemTotal = $price * $count;

            if($model->color_id != $color->id){
                $model->final_product_price += ($model->color->price_increase - $color->price_increase);
            }

            $model->final_total_price = (string)($model->final_product_price * $model->number);
                $discount = 0;
                if ($model->product->discountAmounts) {
                    $discount = ($itemTotal * $model->product->discountAmounts->percentage) / 100;
                    if ($discount > $model->product->discountAmounts->discount_ceiling) {
                        $discount = $model->product->discountAmounts->discount_ceiling;
                    }
                }
            $model->final_discount += $discount - $oldDiscount;
                
            $order = Order::find()->where(['id' => $order_id])->one();
            $order->original_price += ($itemTotal) - ($oldPrice);
            $order->order_discount_amount += ($discount) - ($oldDiscount);
            $order->order_final_amount += ((($itemTotal)) - ($discount) ) - (($oldPrice) - ($oldDiscount));
            $order->order_total_products_discount_amount += ($discount) - ($oldDiscount);

            $order->save(false);

            
            
            if($model->save()){
                return $this->redirect(['/admin/order/order-item-view', 'order_id' => $order_id, 'id' => $model->id]);
            }
        }
        $colors = ArrayHelper::map($model->product->color , 'id' , 'name');

        return $this->render('order-item/update', [
            'model' => $model,
            'colors' => $colors,
            'order_id' => $order_id,
        ]);
    }

    public function actionOrderItemDelete($id , $order_id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try{
        $order_item = $this->findModelOrderItem($id);
        
        $product = Product::find()->where(['id' => $order_item->product_id])->one();
        $product->marketable_number += ($order_item->number);
        $product->sold_number -= ($order_item->number);

        $order = Order::find()->where(['id' => $order_id])->one();
        $price = $order_item->product->price;
        if($order_item->color){
            $price += $order_item->color->price_increase;
        }
        $order->original_price -= $price * $order_item->number;
        $order->order_discount_amount -= $order_item->final_discount;
        $order->order_final_amount -= $price * $order_item->number - $order_item->final_discount;
        $order->order_total_products_discount_amount -= $order_item->final_discount;

        $order->save(false);

        $product->save(false);
        
        $order_item->delete();
        $transaction->commit();

        return $this->redirect(['/admin/order/order-item' , 'order_id' => $order_id]);

        } catch (\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
        }
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findModelOrderItem($id)
    {
        if (($model = OrderItem::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
public function actionPrintTcpdf($id)
{
  $model = $this->findModel($id);
    
    $content = $this->renderPartial('_print', ['model' => $model]);
    
    $pdf = new Pdf([
        'mode' => Pdf::MODE_UTF8,
        'format' => Pdf::FORMAT_A4,
        'orientation' => Pdf::ORIENT_PORTRAIT,
        'destination' => Pdf::DEST_BROWSER,
        'content' => $content,
        'options' => [
            'title' => 'گزارش',
            'subject' => 'پرینت گزارش',
        ],
        'methods' => [
            'SetHeader' => ['<h3>' . Yii::$app->name . '</h3>'],
            'SetFooter' => ['صفحه {PAGENO}'],
        ],
    ]);
    
    return $pdf->render();
}
}
