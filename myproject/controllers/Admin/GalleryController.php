<?php

namespace app\controllers\admin;

use Yii;
use app\models\Gallery;
use app\models\Product;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\GallerySearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * GalleryController implements the CRUD actions for Gallery model.
 */
class GalleryController extends Controller
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
     * Lists all Gallery models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GallerySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Gallery model.
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
     * Creates a new Gallery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Gallery();
        
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model , 'imageFile');
                
                if($model->validate()){
                    if($model->imageFile){
                        $imageName = time() . '.' . $model->imageFile->extension;
                        if(!file_exists('uploads/images/gallery')){
                            mkdir('uploads/images/gallery' , 0777 , true);
                        }
                        $model->imageFile->saveAs('uploads/images/gallery/' . $imageName);
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
     * Updates an existing Gallery model.
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
                        if(!file_exists('uploads/images/gallery')){
                            mkdir('uploads/images/gallery' , 0777 , true);
                        }
                        $model->imageFile->saveAs('uploads/images/gallery/' . $imageName);
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
     * Deletes an existing Gallery model.
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
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Gallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gallery::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
