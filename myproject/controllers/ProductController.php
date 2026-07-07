<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Response;
use app\models\Banner;
use yii\base\Security;
use app\models\Comment;
use app\models\Product;
use yii\web\Controller;
use app\models\Category;
use yii\web\ErrorAction;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\mail\MailerInterface;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
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
    public function actionIndex($id): string
    {
        $model = new Comment();
        
        $product = $this->findModel($id);

        $attributeNames = ArrayHelper::getColumn($product->category->categoryAttributes,'name');

        $productMetas = array_filter($product->productMetas, function ($meta) use ($attributeNames) {
            return in_array($meta->meta_key, $attributeNames, true);
        });

          $productMetasdi = array_filter($product->productMetas, function ($meta) use ($attributeNames) {
            return !in_array($meta->meta_key, $attributeNames, true);
        });
        $newProducts = Product::find()->orderBy(['created_at' => 'SORT_DESC'])->limit(10)->all();


        $comments = Comment::find()->where(['parent_id' => null , 'product_id' => $product->id])->all();


        return $this->render('index', [
            'model' => $model,
            'product' => $product,
            'comments' => $comments,
            'productMetas' => $productMetas,
            'productMetasdi' => $productMetasdi,
            'newProducts' => $newProducts
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
                    return $this->redirect(['product']);
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

        protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
}
