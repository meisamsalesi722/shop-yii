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
        $specials = Product::find()->where(['product.status' => 1])
        ->innerJoinWith('discountAmounts')
        ->all();

        //baners
        $banerSliders = Banner::find()->where(['position' => 1 , 'status' => 1])->limit(10)->all();
        $bottomRightBanners = Banner::find()->where(['position' => 2 , 'status' => 1])->one();
        $bottomLeftBanners = Banner::find()->where(['position' => 3 , 'status' => 1])->one();
        $leftBottomBanners = Banner::find()->where(['position' => 4 , 'status' => 1])->one();
        $leftTopBanners = Banner::find()->where(['position' => 5 , 'status' => 1])->one();
        $fourMiddleBanners = Banner::find()->where(['position' => 6 , 'status' => 1])->limit(4)->all();
        $twoMiddleBanners = Banner::find()->where(['position' => 7 , 'status' => 1])->limit(2)->all();
        $OneLastBanner = Banner::find()->where(['position' => 8 , 'status' => 1])->one();

        //Products
        $newProducts = Product::find()->where(['status' => 1])->orderBy('created_at DESC')->limit(10)->all();
        $bestsellers = Product::find()->where(['status' => 1])->orderBy('sold_number DESC')->limit(10)->all();
        $categories_notchilren = Category::find()->alias('c')->leftJoin('category child', 'child.parent_id = c.id')->where(['IS NOT', 'c.parent_id', null])->andWhere(['c.status' => 1])->andWhere(['child.id' => null])->all();
        if($categories_notchilren){
            $productsCategory1 = Product::find()->where(['category_id' => $categories_notchilren[0] , 'status' => 1])->limit(10)->all();
        }else{
            $productsCategory1 = [];
        }
        $mostVieweds = Product::find()->where(['status' => 1])->orderBy('view DESC')->limit(10)->all();

        return $this->render('index', [
            'specials' => $specials,
            'banerSliders' => $banerSliders,
            'bottomRightBanners' => $bottomRightBanners,
            'bottomLeftBanners' => $bottomLeftBanners,
            'leftBottomBanners' => $leftBottomBanners,
            'leftTopBanners' => $leftTopBanners,
            'fourMiddleBanners' => $fourMiddleBanners,
            'twoMiddleBanners' => $twoMiddleBanners,
            'OneLastBanner' => $OneLastBanner,
            'newProducts' => $newProducts,
            'bestsellers' => $bestsellers,
            'productsCategory1' => $productsCategory1,
            'categories_notchilren' => $categories_notchilren,
            'mostVieweds' => $mostVieweds,

        ]);

    }


}
