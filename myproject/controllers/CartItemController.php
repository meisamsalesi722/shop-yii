<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use DateTime;
use Exception;
use app\models\Brand;
use yii\base\Security;
use app\models\Product;
use yii\web\Controller;
use app\models\CartItem;
use yii\web\ErrorAction;
use yii\filters\VerbFilter;
use yii\mail\MailerInterface;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
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
        $cartItems = CartItem::find()->with(['product' , 'color'])->where(['user_id' => $user_id])->all();
        $request = Yii::$app->request;
        $cartItemId = $request->get('cartItemId');

            $totalPrice = 0;
            $totalDiscount = 0;
            $finalPrice = 0;

            foreach ($cartItems as $item) {

                $price = $item->product->price;
                if($item->color){
                    $price += $item->color->price_increase;
                }
                $count = $item->number;

                $itemTotal = $price * $count;
                $totalPrice += $itemTotal;

                $discount = 0;

                if ($item->product->discountAmounts) {

                    $discount = ($itemTotal * $item->product->discountAmounts->percentage) / 100;

                    if ($discount > $item->product->discountAmounts->discount_ceiling) {
                        $discount = $item->product->discountAmounts->discount_ceiling;
                    }
                }

                $totalDiscount += $discount;
                $finalPrice += $itemTotal - $discount;
            }



        if($request->isPost){
            $transaction = Yii::$app->db->beginTransaction();
            try{
            $cartUpdate = CartItem::findOne($cartItemId);
            $number = $cartUpdate->number;
            $product = $cartUpdate->product;
            $product->marketable_number += ($number - $request->post('number'));
            $product->frozen_number -= ($number - $request->post('number'));

            $cartUpdate->number = $request->post('number');

            if($cartUpdate->number > $cartUpdate->product->marketable_number + $cartUpdate->product->frozen_number){
                Yii::$app->session->setFlash('موجودی محصول کافی نمیباشد');
                return $this->redirect('/cart-item');
            }

            
            
            if(!$cartUpdate->save() || !$product->save(false)){
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
                $product = $cartItem->product;
                $product->frozen_number -= $cartItem->number;
                $product->marketable_number += $cartItem->number;
                $product->save(false);
                
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

                
                $product = $cartItem->product;
                $product->frozen_number -= $cartItem->number;
                $product->marketable_number += $cartItem->number;
                $product->save(false);
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
