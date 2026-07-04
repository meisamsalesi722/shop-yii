<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use app\models\Category;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\CategoryAttribute;
use yii\web\NotFoundHttpException;
use app\models\CategoryAttributeSearch;

/**
 * CategoryAttributeController implements the CRUD actions for CategoryAttribute model.
 */
class CategoryAttributeController extends Controller
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
     * Lists all CategoryAttribute models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategoryAttributeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CategoryAttribute model.
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
     * Creates a new CategoryAttribute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CategoryAttribute();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                 $model->category_id = $model->category3_id;
                 if($model->save(false)){
                        Yii::$app->session->setFlash('success', 'مقاله با موفقیت ساخته شد.');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                return $this->redirect(['view', 'id' => $model->id]);
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


public function actionGetLevel1()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    $categories = Category::find()
        ->where(['parent_id' => null])
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

    /**
     * Updates an existing CategoryAttribute model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $categories = Category::find()->where(['',['parent_id' , 'null']])->all();
        $categories = ArrayHelper::map(Category::find()->where(['parent_id' => null])->all(), 'id', 'name');
        return $this->render('update', [
            'model' => $model,
             'categories' => $categories,
        ]);
    }

    /**
     * Deletes an existing CategoryAttribute model.
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
     * Finds the CategoryAttribute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CategoryAttribute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CategoryAttribute::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
