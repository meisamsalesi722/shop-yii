<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ProductVariant;
use yii\web\NotFoundHttpException;
use app\models\ProductVariantSearch;

/**
 * ProductVariantController implements the CRUD actions for ProductVariant model.
 */
class ProductVariantController extends Controller
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
     * Lists all ProductVariant models.
     *
     * @return string
     */
    public function actionIndex($product_id)
    {
        $searchModel = new ProductVariantSearch();
        $dataProvider = $searchModel->search($this->request->queryParams , $product_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'product_id' => $product_id
        ]);
    }

    /**
     * Displays a single ProductVariant model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id , $product_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id , $product_id),
            'product_id' => $product_id
        ]);
    }

    /**
     * Creates a new ProductVariant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($product_id)
    {
        $model = new ProductVariant();

        if ($this->request->isPost) {
            $model->user_id = Yii::$app->user->id;
            if ($model->load($this->request->post())) {
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id , 'product_id' => $product_id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'product_id' => $product_id,
        ]);
    }

    /**
     * Updates an existing ProductVariant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id , $product_id)
    {
        $model = $this->findModel($id , $product_id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if( $model->save()){
                return $this->redirect(['view', 'id' => $model->id , 'product_id' =>  $product_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'product_id' => $product_id,
        ]);
    }

    /**
     * Deletes an existing ProductVariant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $product_id)
    {
        $this->findModel($id , $product_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductVariant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ProductVariant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id , $product_id)
    {
        if (($model = ProductVariant::findOne(['id' => $id , 'product_id' => $product_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
