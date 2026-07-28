<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;

use app\models\Comment;
use app\models\Product;
use yii\web\Controller;
use app\models\CartItem;
use yii\web\ErrorAction;
use app\models\ProductUser;
use yii\helpers\ArrayHelper;
use app\models\VendorProduct;
use app\models\ProductVariant;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
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
                    'only' => ['create'],
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
    public function actionIndex($id)
    {
        $model = new Comment();
        $product = Product::find()->where(['product.id' => $id])->innerJoinWith('productVariants.vendorProducts')->one();
        $productVariants = $product->productVariantsHasVendorProducts ?? '';
        $productVariant = ProductVariant::find()->where(['product_id' => $product->id])->innerJoinWith('vendorProducts')->one();
        $modelCartItem =  new CartItem();
        $vendorProduct = $productVariant->vendorProducts[0];


        $request = Yii::$app->request;
    
    if ($request->isPost) {
        if(Yii::$app->request->post('change_productVariants') == 1){
            $productVariant = ProductVariant::find()->where(['product_variant.id' => Yii::$app->request->post('productVariant_id')])->innerJoinWith('vendorProducts')->one();
            $vendorProduct = $productVariant->vendorProducts[0];
        }else if(Yii::$app->request->post('change_vendor_product_id')){
            $vendorProduct = VendorProduct::find()->where(['id' => Yii::$app->request->post('change_vendor_product_id')])->one();
    }else{
            if(Yii::$app->user->isGuest){
                return $this->redirect('/login-register');
            }
            
            $vendor_product_id = $request->post('vendor_product_id');
            $cartItem = CartItem::find()->where(['user_id' => Yii::$app->user->id , 'vendor_product_id' => $vendor_product_id ])->all();
            
            if($cartItem){
                Yii::$app->session->setFlash('error', 'این محصول قبلا به سبد خرید اضافه شده است.');
                return $this->redirect(['/product', 'id' => $id]);
            }
        
        
        $modelCartItem->user_id = (int)(Yii::$app->user->id) ;
        $modelCartItem->vendor_product_id = (int)Yii::$app->request->post('vendor_product_id');
        $modelCartItem->number = 1;
        
    if ($modelCartItem->save()) {
        Yii::$app->session->setFlash('success', 'محصول با موفقیت به سبد خرید اضافه شد.');
                $vendorProduct->frozen_number += 1;
                $vendorProduct->marketable_number -= 1;
                $vendorProduct->save(true,['frozen_number' , 'marketable_number']);
    } else {
        Yii::$app->session->setFlash('error', 'افزودن به سبد خرید با شکست مواجه شد.');
        dd($modelCartItem->errors , $modelCartItem);
    }
    return $this->redirect(['/product', 
        'id' => $id,
    ]);
}
}
        

        $attributeNames = ArrayHelper::getColumn($product->category->categoryAttributes,'name');

        $productMetas = array_values(array_filter($product->productMetas, function ($meta) use ($attributeNames) {
            return in_array($meta->meta_key, $attributeNames, true);
        }));


        $newProducts = Product::find()->where(['product.status' => 1])->with('productVariantsHasDiscount')->innerJoinWith('productVariants.vendorProducts')->orderBy('created_at DESC')->limit(10)->all();



        $comments = Comment::find()->where(['parent_id' => null , 'product_id' => $product->id , 'status' => Comment::STATUS_APPROVED])->all();
        $productVariant_id = $productVariant->id;

        return $this->render('index', [
            'model' => $model,
            'product' => $product,
            'comments' => $comments,
            'productMetas' => $productMetas,
            // 'productMetasdi' => $productMetasdi,
            'newProducts' => $newProducts,
            'productVariant_id' => $productVariant_id,
             'productVariants' => $productVariants,
             'productVariant' => $productVariant,
             'vendorProduct' => $vendorProduct
        ]);

    }


        /**
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $model = new Comment();
        
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $user = Yii::$app->user->identity;
                if($user && empty($user->email)){
                    Yii::$app->session->setFlash('error' , 'برای ثبت نظر ابتدا ایمیل خود را وارد کنید');
                    return $this->redirect(['/userpanel/user-info/update']);
                }
                if(!$user || $user->email != $model->email){
                    Yii::$app->session->setFlash('error' , 'کاربر مورد نظر یافت نشد یا ایمیل متعلق به شما نیست');
                    return $this->redirect(['/product' , 'id' => $id]);
                }
                $model->product_id = $id;
                $model->user_id = $user->id;
                if( $model->save()){
                    return $this->redirect(['/product', 'id' => $model->product_id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('/admin/comment/create', [
            'model' => $model,
        ]);
    }

    public function actionToggleFavorite($id){

        
        $isGuest = Yii::$app->user->isGuest;
        
        if(!$isGuest){
        $model = new ProductUser();
        $user_id = Yii::$app->user->identity->id ;
        $product = ProductUser::find()->where(['user_id' => $user_id , 'product_id' => $id])->one();
        if($product){
            $product->delete();
            return $this->redirect(['/product' , 'id' => $id]);
        }
        $model->product_id = $id;
        $model->user_id = $user_id;
        $model->save();
        return $this->redirect(['/product' , 'id' => $id]);
        }else{
            return $this->redirect(['/login']);
        }
    }

        protected function findModel($id)
    {
        if (($model = Product::find()->where(['product.id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
}
