<?php

namespace app\controllers\admin;

use Yii;
use app\models\Banner;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use app\models\BannerSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * BannerController implements the CRUD actions for Banner model.
 */
class BannerController extends Controller
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
     * Lists all Banner models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Banner model.
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
     * Creates a new Banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Banner();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'image');
                if($model->validate()){
                    if($model->imageFile){
                        $imageName = time() . '.' . $model->imageFile->extension;
                        if (!file_exists('uploads/images')) {
                            mkdir('uploads/images', 0777, true);
                        }
                        $model->imageFile->saveAs('uploads/images/' . $imageName);
                        $model->image = $imageName;
                    }
                    if($model->save(false)){
                        Yii::$app->session->setFlash('success', 'بنر با موفقیت ساخته شد.');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                    Yii::$app->session->setFlash('error', 'ساخت بنر با خطا مواجه شد.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
        } else {
            $model->loadDefaultValues();
        }
        
    }
    return $this->render('create', [
        'model' => $model,
    ]);
}

    /**
     * Updates an existing Banner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'image');
            if ($model->validate()) {
            // dd($model->position);

                if ($model->imageFile) {
                    $model->deleteImage();
                            if (!file_exists('uploads/images/')) {
                                mkdir('uploads/images/', 0777, true);
                            }
                            $imageName = time() . '.' . $model->imageFile->extension;
                            $model->imageFile->saveAs('uploads/images' . $imageName);
                            $model->image = $imageName;
                    }
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'بنر با موفقیت بروزرسانی شد.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            Yii::$app->session->setFlash('error', 'بروزرسانی بنر با خطا شد.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Banner model.
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
     * Finds the Banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
