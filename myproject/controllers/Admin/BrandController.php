<?php

namespace app\controllers\admin;

use Yii;
use app\models\Brand;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\BrandSearch;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\web\NotFoundHttpException;
use function PHPUnit\Framework\fileExists;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends Controller
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
     * Lists all Brand models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BrandSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Brand model.
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
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Brand();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                dd(Yii::$app->request->post());

                $model->imageFile = UploadedFile::getInstance($model , 'imageFile');
                if($model->validate()){

                    if($model->imageFile){
                        $imageName = time() . '.' . $model->imageFile->extension;
                        if (!file_exists('uploads/images')) {
                            mkdir('uploads/images', 0777, true);
                        }
                        $model->imageFile->saveAs('uploads/images/' . $imageName , true);
                        $model->logo = $imageName;
                    }

                    if( $model->save(false)){
                        Yii::$app->session->setFlash('success' , 'برند با موفقیت ثبت شد');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                    Yii::$app->session->setFlash('success' , 'ثبت برند با خطا مواجه شد');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) ) {
            $model->imageFile = UploadedFile::getInstance($model , 'imageFile');
            
            if($model->validate()){
                if($model->imageFile){
                    $model->deleteImage();
                    $imageName = time() . '.' . $model->imageFile->extension;
                    if(!file_exists('uploads/images')){
                        mkdir('uploads/images' , 0777,true);
                    }
                    $model->imageFile->saveAs('uploads/images/' . $imageName);
                    $model->logo = $imageName;
                }

                
                if($model->save(false)){
                    Yii::$app->session->setFlash('success' , 'ویرایش با موفقیت انجام شد');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                Yii::$app->session->setFlash('success' , 'ویرایش با خطا مواجه شد');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Brand model.
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
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Brand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
