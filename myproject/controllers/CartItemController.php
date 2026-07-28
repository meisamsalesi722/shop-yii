<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use DateTime;
use Exception;
use yii\web\Controller;
use app\models\CartItem;
use yii\web\ErrorAction;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class CartItemController extends Controller
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
                            'roles' => ['@']
                        ],
                    ],
                ],
            ]
        );
    }
    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'transparent' => true,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $user_id = Yii::$app->user->id; 
        $cartItems = CartItem::find()->with(['vendorProduct'])->where(['user_id' => $user_id])->all();
        $request = Yii::$app->request;
        $cartItemId = $request->get('cartItemId');

            $totalPrice = 0;
            $totalDiscount = 0;
            $finalPrice = 0;
            foreach ($cartItems as $key => $item) {
                $price = $item->vendorProduct->price;
                $count = $item->number;
                $itemTotal = $price * $count;
                $totalPrice += $itemTotal; 
                
                $discount = 0;

                if ($item->vendorProduct->discountAmounts) {

                    $discount = ($itemTotal * $item->vendorProduct->discountAmounts->percentage) / 100;

                    if ($discount > $item->vendorProduct->discountAmounts->discount_ceiling) {
                        $discount = $item->vendorProduct->discountAmounts->discount_ceiling;
                    }
                }
                
                $totalDiscount += $discount;
                $finalPrice += $itemTotal - $discount;
                // if($key == 1){
                // }
            }
            
            
            if($request->isPost){
                $transaction = Yii::$app->db->beginTransaction();
                try{
                    $cartUpdate = CartItem::findOne($cartItemId);
                    $number = $cartUpdate->number;
                    $vendorProduct = $cartUpdate->vendorProduct;
                    $vendorProduct->marketable_number += ($number - $request->post('number'));
                    $vendorProduct->frozen_number -= ($number - $request->post('number'));
                    
                    $cartUpdate->number = $request->post('number');
            
                    if($cartUpdate->number > $cartUpdate->vendorProduct->marketable_number + $cartUpdate->vendorProduct->frozen_number){
                        Yii::$app->session->setFlash('موجودی محصول کافی نمیباشد');
                        return $this->redirect('/cart-item');
                    }
                    if(!$vendorProduct->save(true , ['marketable_number' , 'frozen_number'])){
                        throw new Exception('هنگام انجام عملیات مشکلی پیش امده است');
                    }
                    if(!$cartUpdate->save(true , ['number'])){
                        throw new Exception('هنگام انجام عملیات مشکلی پیش امده است');
                    }
                    $transaction->commit();
                    return $this->refresh();    
                }catch(\Throwable $e){
                    $transaction->rollBack();
                    throw $e;
                }
            }




        foreach($cartItems as $cartItem){
            $now = new DateTime();
            $expireDate = (new DateTime($cartItem->updated_at))->modify('+1 day');

            if($now > $expireDate){
                $vendorProduct = $cartItem->vendorProduct;
                $vendorProduct->frozen_number -= $cartItem->number;
                $vendorProduct->marketable_number += $cartItem->number;
                $vendorProduct->save(true , ['marketable_number' , 'frozen_number']);
                
                $cartItem->delete();
            }
        }


        return $this->render('/cartItem/index', [
            'totalPrice' => $totalPrice,
            'finalPrice' => $finalPrice,
            'totalDiscount' => $totalDiscount,
            'cartItems' => $cartItems,
        ]);

    }

        public function actionDelete($id)
        {
            $cartItem = $this->findModel($id);

                $vendorProduct = $cartItem->vendorProduct;
                $vendorProduct->frozen_number -= $cartItem->number;
                $vendorProduct->marketable_number += $cartItem->number;
                $vendorProduct->save(false);
            $cartItem->delete();

            return $this->redirect(['index']);
        }


        protected function findModel($id)
    {
        if (($model = CartItem::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
}
