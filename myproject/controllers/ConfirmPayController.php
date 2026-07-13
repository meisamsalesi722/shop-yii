<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use yii\data\Sort;
use app\models\User;
use app\models\Brand;
use app\models\Order;
use yii\base\Security;
use app\models\Address;
use app\models\Product;
use yii\web\Controller;
use app\models\CartItem;
use app\models\Copan;
use app\models\OrderItem;
use Exception;
use yii\data\Pagination;
use yii\web\ErrorAction;
use yii\filters\VerbFilter;
use yii\mail\MailerInterface;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ConfirmPayController extends Controller
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
        $addressModel = new Address();
        $user_id = Yii::$app->user->id; 
        $cartItems = CartItem::find()->with(['product' , 'color'])->where(['user_id' => $user_id])->all();

            $totalPrice = 0;
            $totalDiscount = 0;
            $finalPrice = 0;
            $copan_discount = 0;
            $copan_id = null;
            $address_select = null;

            if (empty($cartItems)) {
                Yii::$app->session->setFlash('warning', 'سبد خرید شما خالی است');
                return $this->redirect(['/cart']);
            }

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

            if(Yii::$app->request->isPost){
                    if(Yii::$app->request->post('save_address')){
                        $addressModel = new Address();
                        if($addressModel->load(Yii::$app->request->post())){
                            $addressModel->user_id = Yii::$app->user->id;
                            if( $addressModel->save()){
                                Yii::$app->session->setFlash('success', 'آدرس با موفقیت ذخیره شد');
                                return $this->redirect(['/confirm-pay']);
                            }
                        }
                    }
                    if(Yii::$app->request->post('confirm_order')){
                        $transaction = Yii::$app->db->beginTransaction();
                        try{
                        $orderModel = new Order();  
                        $copan_id = Yii::$app->request->post('copan_id');
                        $orderModel->user_id = Yii::$app->user->id ;
                        $address_id = (int)Yii::$app->request->post('address_id');
                        
                        
                        if($copan_id != null){
                            $copan = Copan::findOne($copan_id);
                            if($copan->amount_type == 1){
                                $copan_discount = $copan->amount > $copan->discount_ceiling ?  $copan->discount_ceiling : $copan->amount;
                                }else{
                                    $copan_discount = (($totalPrice * $copan->amount) / 100) > $copan->discount_ceiling ? $copan->discount_ceiling : (($totalPrice * $copan->amount) / 100);
                                }
                                $orderModel->copan_id = $copan->id;
                                $orderModel->order_copan_discount_amount = $copan_discount;
                                $copan->used = 1;
                                $finalPrice -= $copan_discount >= $finalPrice ?  $finalPrice : $copan_discount;
                                $copan->save(false);                
                            }
                            $orderModel->address_id = $address_id;
                            $orderModel->original_price = $totalPrice;
                            $orderModel->order_discount_amount = $totalDiscount;
                            $orderModel->order_final_amount = $finalPrice;
                            $orderModel->order_total_products_discount_amount = $totalDiscount + $copan_discount;
                            $orderModel->order_status = 1;
                            if($orderModel->save()){
                                    

                                $cartItems = CartItem::find()->where(['user_id' => Yii::$app->user->id])->all();
                                foreach($cartItems as $cartItem){
                                    
                                    $discount = 0;
                                    $singleItemDiscount = 0;
                                    $count = $cartItem->number;
                                    $price = $cartItem->product->price;
                                    if($cartItem->color){
                                        $price += $cartItem->color->price_increase;
                                    }
                                    $itemTotal = $price * $count;
                                    if ($cartItem->product->discountAmounts) {
                                        
                                        $discount = ($itemTotal * $cartItem->product->discountAmounts->percentage) / 100;
                                        $singleItemDiscount = ($price * $cartItem->product->discountAmounts->percentage) / 100;
                                        
                                        if ($discount > $cartItem->product->discountAmounts->discount_ceiling) {
                                            $discount = $cartItem->product->discountAmounts->discount_ceiling;
                                        }
                                        if ($singleItemDiscount > $cartItem->product->discountAmounts->discount_ceiling) {
                                            $singleItemDiscount = $cartItem->product->discountAmounts->discount_ceiling;
                                        }
                                    }
                                    
                                    $orderItemModel = new OrderItem();
                                    $orderItemModel->order_id = $orderModel->id;
                                    
                                    $orderItemModel->product_id = $cartItem->product_id;
                                    $orderItemModel->number = $cartItem->number;
                                    $final_product_price = $cartItem->product->price - $singleItemDiscount;
                                    if($cartItem->color){
                                        $final_product_price += $cartItem->color->price_increase;
                                    }
                                    $orderItemModel->final_product_price = $final_product_price;
                                    $orderItemModel->final_total_price = ($final_product_price) * $cartItem->number;
                                    $orderItemModel->color_id = $cartItem->color_id;
                                    $orderItemModel->guarantee_id = $cartItem->product->guarantee_id;
                                    
                                    if(!$orderItemModel->save()){
                                        throw new Exception('ذخیره اطلاعات با خطا مواجه شد');
                                    }
                                    
                                    $product = $cartItem->product;
                                    $product->frozen_number -= $cartItem->number;
                                    $product->sold_number += $cartItem->number; 
                                    if(!$product->save(false) ||  !$cartItem->delete()){
                                        dd('eror 1');
                                    }
                                    
                                }
                                $transaction->commit();
                                return $this->goHome();
                            }else{
                                return $this->redirect('/confirm-pay');
                            }
                        }catch(\Throwable $e){
                            $transaction->rollBack();
                            throw $e;
                        }

                    }

                    if(Yii::$app->request->post('copan')){
                        $user = User::findOne(Yii::$app->user->id);
                        $copan = $user->getCopans()
                        ->andWhere(['code' => Yii::$app->request->post('copan_code')])
                        ->andWhere(['used' => 0])
                        ->one();

                        if($copan){
                            if($copan->amount_type == 1){
                                $copan_discount = $copan->amount > $copan->discount_ceiling ?  $copan->discount_ceiling : $copan->amount;
                            }else{
                                $copan_discount = (($totalPrice * $copan->amount) / 100) > $copan->discount_ceiling ? $copan->discount_ceiling : (($totalPrice * $copan->amount) / 100);
                                
                            }
                            
                            $finalPrice -=  $copan_discount >= $finalPrice ?  $finalPrice : $copan_discount;
                            $copan_id = $copan->id;
                        }
                    }

            }
            $addresses = Address::find()->all();

        return $this->render('/confirmPay/index' ,[
            'totalPrice' => $totalPrice,
            'totalDiscount' => $totalDiscount,
            'addresses' => $addresses,
            'finalPrice' => $finalPrice,
            'addressModel' => $addressModel,
            'copan_discount' => $copan_discount,
            'copan_id' => $copan_id,
    ]);
}
    
}
