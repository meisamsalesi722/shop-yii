<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Brand;
use yii\data\Sort;
use yii\base\Security;
use app\models\Product;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\ErrorAction;
use yii\filters\VerbFilter;
use yii\mail\MailerInterface;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ListController extends Controller
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
    $request = $this->request->get();
    $sortId = $request['sortId'] ?? 4;
    $search = $request['send'] ?? '';
    $exist = $request['exist'] ?? false;
    $minPrice = $request['minPrice'] ?? null;
    $maxPrice = $request['maxPrice'] ?? null;

    switch ($sortId) {
        case '1':
            $column = 'price';
            $sort = 'DESC';
            break;
                
        case '2':
            $column = 'price';
            $sort = 'ASC';
            break;
        
        case '3':
            $column = 'view';
            $sort = 'DESC';
            break;
            
            case '4':
                $column = 'created_at';
                $sort = 'DESC';
                break;
                
                default:
                $column = 'created_at';
                $sort = 'DESC';
                break;
            }

            $query = Product::find()->orderBy($column . ' ' .  $sort);
            

if ($search !== '') {
    $query->andWhere(['like', 'name', $search]);
}

if ($exist) {
    $query->andWhere(['>', 'marketable_number', 0]);
}
    
    
    if ($minPrice !== null && $minPrice !== '') {
        $query->andWhere(['>=', 'price', (int)$minPrice]);
    }
    
    if ($maxPrice !== null && $maxPrice !== '') {
        $query->andWhere(['<=', 'price', (int)$maxPrice]);
    }


    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 4,
        ],
    ]);

                     $brands = Brand::find()->all();

    return $this->render('/list/index', [
        'dataProvider' => $dataProvider,
        'sortId' => $sortId,
        'exist' => $exist,
        'search' => $search,
        'brands' => $brands,
        'minPrice' => $minPrice,
        'maxPrice' => $maxPrice,
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
