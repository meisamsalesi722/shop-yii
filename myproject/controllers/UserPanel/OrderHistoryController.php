<?php

declare(strict_types=1);    

namespace app\controllers\userpanel;

use Yii;
use app\models\User;
use kartik\mpdf\Pdf;
use app\models\Order;
use yii\web\Controller;
use yii\web\ErrorAction;
use app\models\OrderItem;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use app\models\OrderItemSearch;
use yii\data\ActiveDataProvider;
use PHPUnit\Metadata\DataProvider;
use yii\web\NotFoundHttpException;

class OrderHistoryController extends Controller
{

    public $layout = 'user-panel/main';

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
            ]
        );
    }
    
    public function actionIndex()
    {
        $user_id = Yii::$app->user->id;
        $query = Order::find()->where(['user_id' => $user_id]);
        $model = $query->all();



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);

        return $this->render('/user-panel/orderHistory/order-history',[
            'dataProvider' => $dataProvider,
            'model' => $model
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
        return $this->render('/user-panel/orderHistory/view', [
            'model' => $this->findModel($id),
        ]);
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
        $model = Order::findOne($order_id);
        
        return $this->render('/user-panel/orderHistory/order-item/index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

        /**
     * Displays a single OrderItem model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionOrderItemView($id)
    {
        return $this->render('/user-panel/orderHistory/order-item/view', [
            'model' => $this->findModelOrderItem($id),
        ]);
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
    
    $content = $this->renderPartial('/user-panel/orderHistory/_print', ['model' => $model]);
    
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
