<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\CartItem;
use app\models\Color;
use Yii;
use app\models\User;
use yii\web\Response;
use yii\base\Security;
use app\models\Comment;
use app\models\Product;
use yii\web\Controller;
use yii\web\ErrorAction;
use app\models\LoginForm;
use app\models\ProductUser;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\mail\MailerInterface;
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
        $product = $this->findModel($id);
        $modelCartItem =  new CartItem();

        $color_id = null;
    $request = Yii::$app->request;
    
    if ($request->isPost) {
        if(Yii::$app->request->post('change_color') == 1){
            $color = Color::findOne(Yii::$app->request->post('color_id'));
            $product->price += $color->price_increase;
            $color_id = Yii::$app->request->post('color_id');
        }else{

        
        
        $colorId = $request->post('color_id');
        
        if(!empty($product->color)){
            if(!$colorId){
                Yii::$app->session->setFlash('error', 'لطفا رنگ محصول را انتخاب کنید.');
                return $this->redirect(['/product', 'id' => $id]);
            }
            $modelCartItem->color_id = (int)$colorId;
        }
        
        $modelCartItem->user_id = (int)(Yii::$app->user->id) ;
        $modelCartItem->product_id = (int)$id;
        $modelCartItem->number = 1;
        
    if ($modelCartItem->save()) {
        Yii::$app->session->setFlash('success', 'محصول با موفقیت به سبد خرید اضافه شد.');
                $product->frozen_number += 1;
                $product->marketable_number -= 1;
                $product->save(false);
    } else {
        Yii::$app->session->setFlash('error', 'افزودن به سبد خرید با شکست مواجه شد.');
    }

    return $this->redirect(['/product', 'id' => $id]);
}
}
        

        $attributeNames = ArrayHelper::getColumn($product->category->categoryAttributes,'name');

        $productMetas = array_values(array_filter($product->productMetas, function ($meta) use ($attributeNames) {
            return in_array($meta->meta_key, $attributeNames, true);
        }));

        //   $productMetasdi = array_filter($product->productMetas, function ($meta) use ($attributeNames) {
        //     return !in_array($meta->meta_key, $attributeNames, true);
        // });
        $newProducts = Product::find()->where(['!=' , 'id' , $id])->orderBy('created_at DESC')->limit(10)->all();



        $comments = Comment::find()->where(['parent_id' => null , 'product_id' => $product->id , 'status' => Comment::STATUS_APPROVED])->all();


        return $this->render('index', [
            'model' => $model,
            'product' => $product,
            'comments' => $comments,
            'productMetas' => $productMetas,
            // 'productMetasdi' => $productMetasdi,
            'newProducts' => $newProducts,
            'color_id' => $color_id
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
                $user = User::findOne(['email' => $model->email]);
                if(!$user){
                    Yii::$app->session->setFlash('error' , 'کاربر مورد نظر یافت نشد');
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
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
}
