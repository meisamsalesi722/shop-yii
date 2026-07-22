<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use Exception;
use yii\data\Sort;
use app\models\User;
use app\models\Brand;
use app\models\Copan;
use app\models\Order;
use yii\base\Security;
use app\models\Address;
use app\models\Payment;
use app\models\Product;
use yii\web\Controller;
use app\models\CartItem;
use yii\data\Pagination;
use yii\web\ErrorAction;
use app\models\OrderItem;
use yii\filters\VerbFilter;
use yii\mail\MailerInterface;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use app\services\PaymentService;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class PaymentController extends Controller
{

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

    
    public function actionPaymentSubmit($order_id){
        $paymentService = new PaymentService;
        $user_id = Yii::$app->user->id;
        $order = Order::findOne($order_id);


            $targetModel = new Payment;

            $targetModel->amount = $order->order_final_amount;
            $targetModel->user_id = $user_id;
            $targetModel->status = 1;
            $targetModel->save();
            $paymented = $targetModel;


            $result =  $paymentService->zarinPal($order->order_final_amount , $order->id , $paymented->id);

              if($result['code'] === 100){
                $paymented->bank_first_responce = json_encode($result['response']);
                $paymented->save(false);
                $authority = $result['response']['data']['authority'];
                return $this->redirect("https://sandbox.zarinpal.com/pg/StartPay/". $authority);
            }else{
                Yii::$app->session->setFlash('error' , $result['message']);
                return $this->redirect(['/userpanel/order-history/view' , 'id' => $order_id]);
            }

        $order->order_status = 3;
        $order->save();
        Yii::$app->session->setFlash('success' , 'سفارش شما با موفقیت ثبت شد');
        return $this->redirect(['/userpanel/order-history/view' , 'id' => $order_id]);

    }

      public function  actionPaymentCallback($order_id , $payment_id){
          $paymentService = new PaymentService;
          $payment = Payment::findOne($payment_id);
          $order = Order::findOne($order_id);
          
          $amount = $payment->amount;
          $result = $paymentService->zarinPalVerify($amount , $payment);


        if($result['message'][0] == 'success'){
            $order->order_status = 3;
            $order->payment_status = 1;

        }else{
            $order->order_status = 2;
        }

            $order->save(false);



          
          if($result['message']){
            Yii::$app->session->setFlash($result['message'][0],  $result['message'][1]);
            return $this->redirect(['/userpanel/order-history/view' , 'id' => $order_id]);
          }
  }


}
    
