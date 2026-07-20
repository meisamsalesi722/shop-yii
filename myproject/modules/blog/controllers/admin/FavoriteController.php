<?php

namespace app\modules\blog\controllers\admin;


use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\modules\blog\models\Favorite;
use app\modules\blog\models\FavoriteSearch;

class FavoriteController extends Controller
{
    public $layout = '/admin/admin';
    
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
                            'roles' => ['admin'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new FavoriteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort->defaultOrder = ['created_at' => SORT_DESC];

        // آمار
        $stats = [
            'total' => Favorite::find()->count(),
            'today' => Favorite::find()
                ->where(['>=', 'created_at', strtotime('today')])
                ->count(),
            'top_articles' => Favorite::find()
                ->select(['article_id', 'COUNT(*) as count'])
                ->groupBy('article_id')
                ->orderBy(['count' => SORT_DESC])
                ->limit(5)
                ->with('article')
                ->asArray()
                ->all(),
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'stats' => $stats,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'آیتم با موفقیت حذف شد.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Favorite::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('آیتم مورد نظر پیدا نشد.');
    }
}