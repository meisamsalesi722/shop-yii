<?php

namespace app\controllers\admin;

use Yii;
use app\models\Vendor;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use app\models\VendorSearch;
use yii\web\NotFoundHttpException;

/**
 * VendorController implements the CRUD actions for Vendor model.
 */
class VendorController extends Controller
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
     * Lists all Vendor models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VendorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vendor model.
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
     * Creates a new Vendor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Vendor();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->user_id = Yii::$app->user->id;
                
                    $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                    if($model->validate()){


                        if($model->imageFile){
                            $imageName = time() . '.' . $model->imageFile->extension;
                            if (!file_exists('uploads/images/vendor')) {
                                mkdir('uploads/images/vendor', 0777, true);
                            }
                            $model->imageFile->saveAs('uploads/images/vendor/' . $imageName);
                            $model->image = $imageName;
                        }

                    if( $model->save(false)){
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
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
     * Updates an existing Vendor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->user_id = Yii::$app->user->id;
                
                    $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                    if($model->validate()){


                        if($model->imageFile){
                            $imageName = time() . '.' . $model->imageFile->extension;
                            if (!file_exists('uploads/images/vendor')) {
                                mkdir('uploads/images/vendor', 0777, true);
                            }
                            $model->imageFile->saveAs('uploads/images/vendor/' . $imageName);
                            $model->image = $imageName;
                        }

                    if( $model->save(false)){
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }

            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Vendor model.
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
     * Finds the Vendor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Vendor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vendor::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
