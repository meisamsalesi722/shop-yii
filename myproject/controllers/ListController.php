<?php

declare(strict_types=1);

namespace app\controllers;

use yii\data\Sort;
use app\models\Brand;
use yii\base\Security;
use app\models\Product;
use yii\web\Controller;
use app\models\Category;
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
    $brandId = $request['brandId'] ?? null;
    $categoryId = $request['categoryId'] ?? null;
    $special = $request['special'] ?? false;

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

            case '5':
                $column = 'sold_number';
                $sort = 'DESC';
                break;
                
                default:
                $column = 'created_at';
                $sort = 'DESC';
                break;
            }

            $query = Product::find()->where(['status' => 1])->orderBy($column . ' ' .  $sort);
            

if ($search !== '') {
    $query->andWhere(['like', 'name', $search]);
}

if ($categoryId !== '') {
    function getAllChildren($categoryId, &$result = []) {
        $children = Category::find()
            ->where(['parent_id' => $categoryId])
            ->all();
        
        foreach ($children as $child) {
            $result[] = $child->id;
            getAllChildren($child->id, $result); 
        }
        
        return $result;
    }
    
    $allIds = [$categoryId];
    $childrenIds = getAllChildren($categoryId);
    $allIds = array_merge($allIds, $childrenIds);
    $query->andWhere(['category_id' => $allIds]);
}

if ($exist) {
    $query->andWhere(['>', 'marketable_number', 0]);
}
    
   if ($special) {
        $query->innerJoinWith('discountAmounts');
    }
    
    if ($minPrice !== null && $minPrice !== '') {
        $query->andWhere(['>=', 'price', (int)$minPrice]);
    }
    
    if ($maxPrice !== null && $maxPrice !== '') {
        $query->andWhere(['<=', 'price', (int)$maxPrice]);
    }
    if ($brandId !== null && $brandId !== '') {
        $query->andWhere(['brand_id' => $brandId]);
    }


    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 9,
        ],
    ]);

                     $brands = Brand::find()->where(['status' => 1])->all();

    return $this->render('/list/index', [
        'dataProvider' => $dataProvider,
        'sortId' => $sortId,
        'exist' => $exist,
        'search' => $search,
        'brands' => $brands,
        'minPrice' => $minPrice,
        'maxPrice' => $maxPrice,
        'brandId' => $brandId,
        'categoryId' => $categoryId,
        'special' => $special,
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
