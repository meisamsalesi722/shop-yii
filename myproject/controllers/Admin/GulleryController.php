<?php

namespace app\controllers\admin;

use Yii;
use app\models\Gullery;
use app\models\Product;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\GullerySearch;
use yii\web\NotFoundHttpException;

/**
 * GulleryController implements the CRUD actions for Gullery model.
 */
class GulleryController extends Controller
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
     * Lists all Gullery models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GullerySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Gullery model.
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
     * Creates a new Gullery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Gullery();
        
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model , 'image');
                
                if($model->validate()){
                    if($model->imageFile){
                        $imageName = time() . '.' . $model->imageFile->extension;
                        if(!file_exists('uploads/images/gullery')){
                            mkdir('uploads/images/gullery' , 0777 , true);
                        }
                        $model->imageFile->saveAs('uploads/images/gullery/' . $imageName);
                        $model->image = $imageName;
                    }

                if($model->save(false)){
                    Yii::$app->session->setFlash('success' , 'تصویر با موفقیت اضافه شد');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                    Yii::$app->session->setFlash('success' , 'اضافه کردن تصویر با خطا مواجه شد');
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }
        } else {
            $model->loadDefaultValues();
        }

        $products = ArrayHelper::map(Product::find()->all() , 'id' , 'name');

        return $this->render('create', [
            'model' => $model,
            'products' => $products,
        ]);
    }

    /**
     * Updates an existing Gullery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model , 'imageFile');
            if($model->validate()){
                if($model->imageFile){

                        $model->deleteImage();
                        $imageName = time() . '.' . $model->imageFile->extension;
                        if(!file_exists('uploads/images/gullery')){
                            mkdir('uploads/images/gullery' , 0777 , true);
                        }
                        $model->imageFile->saveAs('uploads/images/gullery/' . $imageName);
                        $model->image = $imageName;
                    }
            if( $model->save(false)){
                Yii::$app->session->setFlash('success' , 'تصویر با موفقیت ویرایش شد');
                return $this->redirect(['view', 'id' => $model->id]);
            }
                Yii::$app->session->setFlash('success' , 'ویرایش تصویر با خطا مواجه شد');
                return $this->redirect(['view', 'id' => $model->id]);
        }
    }
            $products = ArrayHelper::map(Product::find()->all() , 'id' , 'name');

        return $this->render('update', [
            'model' => $model,
            'products' => $products,
        ]);
    }

    /**
     * Deletes an existing Gullery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleteImage();
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Gullery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Gullery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gullery::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
