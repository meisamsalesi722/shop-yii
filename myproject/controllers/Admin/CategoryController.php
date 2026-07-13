<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use app\models\Category;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\CategorySearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    public $layout = 'admin/admin';
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
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();
        
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {


                
                 if(!empty(Yii::$app->request->post('Category')['category2_id'])){
                    $category_id = Yii::$app->request->post('Category')['category2_id'];
                }elseif(!empty(Yii::$app->request->post('Category')['category1_id'])){
                    $category_id = Yii::$app->request->post('Category')['category1_id'];
                }else{
                    $category_id = null;
                }

                $model->parent_id = (int)$category_id;



            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        } else {
            $model->loadDefaultValues();
        }
        
        $categories = ArrayHelper::map(Category::find()->where(['parent_id' => null])->all(), 'id', 'name');

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }
    public function actionCatList()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    $parents = Yii::$app->request->post('depdrop_parents');
    
    if (!empty($parents)) {

        $parent_id = $parents[0];
        $categories = Category::find()
            ->where(['parent_id' => $parent_id])
            ->orderBy('name')
            ->all();
            
        $output = [];
        foreach ($categories as $category) {
            $output[] = [
                'id' => $category->id,
                'name' => $category->name
            ];
        }
        
        return ['output' => $output];
    }
    
    return ['output' => []];
}

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {

                if(!empty(Yii::$app->request->post('Category')['category2_id'])){
                    $category_id = Yii::$app->request->post('Category')['category2_id'];
                }elseif(!empty(Yii::$app->request->post('Category')['category1_id'])){
                    $category_id = Yii::$app->request->post('Category')['category1_id'];
                }else{
                    $category_id = null;
                }

                $model->parent_id = (int)$category_id;
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
        }

 $categories = ArrayHelper::map(Category::find()->where(['parent_id' => null])->all(), 'id', 'name');

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
