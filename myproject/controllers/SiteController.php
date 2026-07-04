<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\models\Banner;
use app\models\Category;
use yii\base\Security;
use app\models\Product;
use yii\web\Controller;
use yii\web\ErrorAction;
use app\models\LoginForm;
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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
        $specials = Product::find()
        ->innerJoinWith('discountAmounts')
        ->all();

        //baners
        $banerSliders = Banner::find()->where(['position' => 1])->limit(10)->all();
        $bottomRightBanners = Banner::find()->where(['position' => 2])->one();
        $bottomLeftBanners = Banner::find()->where(['position' => 3])->one();
        $leftBottomBanners = Banner::find()->where(['position' => 4])->one();
        $leftTopBanners = Banner::find()->where(['position' => 5])->one();
        $fourMiddleBanners = Banner::find()->where(['position' => 6])->limit(4)->all();
        $twoMiddleBanners = Banner::find()->where(['position' => 7])->limit(2)->all();
        $OneLastBanner = Banner::find()->where(['position' => 8])->one();

        //Products
        $newProducts = Product::find()->orderBy(['created_at' => 'SORT_DESC'])->limit(10)->all();
        $bestsellers = Product::find()->orderBy(['sold_number' => SORT_DESC])->limit(10)->all();
        $categories_notchilren = Category::find()->alias('c')->leftJoin('category child', 'child.parent_id = c.id')->where(['IS NOT', 'c.parent_id', null])->andWhere(['child.id' => null])->all();
        if($categories_notchilren){
            $productsCategory1 = Product::find()->where(['category_id' => $categories_notchilren[0]])->limit(10)->all();
        }else{
            $productsCategory1 = [];
        }
        $mostVieweds = Product::find()->orderBy(['view' => SORT_DESC])->limit(10)->all();

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

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm($this->security);

        if ($model->load($this->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact(): Response|string
    {
        $model = new ContactForm();

        $contact = $model->load($this->request->post()) && $model->contact(
            $this->mailer,
            Yii::$app->params['adminEmail'],
            Yii::$app->params['senderEmail'],
            Yii::$app->params['senderName'],
        );

        if ($contact) {
            Yii::$app->session->setFlash(
                'success',
                'Thank you for contacting us. We will respond to you as soon as possible.',
            );

            return $this->refresh();
        }

        return $this->render('contact', ['model' => $model]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout(): string
    {
        return $this->render('about');
    }
}
