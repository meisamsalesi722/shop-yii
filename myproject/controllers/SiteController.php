<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\models\Banner;
use yii\base\Security;
use app\models\Product;
use yii\web\Controller;
use app\models\Category;
use yii\web\ErrorAction;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use yii\filters\VerbFilter;
use yii\mail\MailerInterface;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;

class SiteController extends Controller
{
        public function __construct(
        $id,
        $module,
        private readonly MailerInterface $mailer,
        private readonly Security $security,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'logout' ,
                    // 'signup'
                ],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // [
                    //     'actions' => ['signup'],
                    //     'allow' => true,
                    //     'roles' => ['?']
                    // ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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
    public function actionIndex(): string
    {

            
        //baners
        $banners = Banner::find()->all();
        

        
        //Products
        $specials = Product::find()->where(['product.status' => 1])->with('productVariantsHasDiscount')->innerJoinWith('productVariants.vendorProducts.discountAmounts')->all();
        $newProducts = Product::find()->where(['product.status' => 1])->with('productVariantsHasDiscount')->innerJoinWith('productVariants.vendorProducts')->orderBy('created_at DESC')->limit(10)->all();
        // dd($newProducts);
        $bestsellers = Product::find()->select(['product.*','SUM(vendor_product.sold_number) AS total_sold'])->with('productVariantsHasDiscount')->where(['product.status' => 1])->innerJoinWith('productVariants.vendorProducts')->groupBy('product.id')->orderBy('total_sold DESC')->limit(10)->all();
        $mostVieweds = Product::find()->where(['product.status' => 1])->with('productVariantsHasDiscount')->innerJoinWith('productVariants.vendorProducts')->orderBy('view DESC')->limit(10)->all();

        $categories_notchilren = Category::find()->alias('c')->leftJoin('category child', 'child.parent_id = c.id')->where(['IS NOT', 'c.parent_id', null])->andWhere(['c.status' => 1])->andWhere(['child.id' => null])->all();
        if($categories_notchilren){
            $productsCategory1 = Product::find()->with('productVariantsHasDiscount')->innerJoinWith('productVariants.vendorProducts')->where(['category_id' => $categories_notchilren[0] , 'product.status' => 1])->limit(10)->all();
        }else{
            $productsCategory1 = [];
        }

        return $this->render('index', [
            'specials' => $specials,
            'banners' => $banners,
            'newProducts' => $newProducts,
            'bestsellers' => $bestsellers,
            'productsCategory1' => $productsCategory1,
            'categories_notchilren' => $categories_notchilren,
            'mostVieweds' => $mostVieweds,

        ]);

    }


}
