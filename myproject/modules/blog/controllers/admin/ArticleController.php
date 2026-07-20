<?php

namespace app\modules\blog\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\modules\blog\models\Article;
use app\modules\blog\models\BlogCategory;
use app\modules\blog\models\ArticleSearch;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    public $layout = '/admin/admin';
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
     * Lists all Article models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('/admin/article/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('/admin/article/view', [
            'model' => $this->findModel($slug),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createArticle')) {
            throw new ForbiddenHttpException();
        }
        $model = new Article();
        $categories = ArrayHelper::map(BlogCategory::find()->all(), 'id', 'title');

        if ($this->request->isPost) {
            echo '<pre>';
            print_r($this->request->post());
            
            if ($model->load($this->request->post()) ) {

                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->pdfFile = UploadedFile::getInstance($model, 'pdfFile');
                $model->user_id = Yii::$app->user->id;

                if($model->validate()){

                    if($model->imageFile){
                        $imageName = time() . '.' . $model->imageFile->extension;
                        if (!file_exists('uploads/images')) {
                            mkdir('uploads/images', 0777, true);
                        }
                        $model->imageFile->saveAs('uploads/images/' . $imageName);
                        $model->image = $imageName;
                    }
                    if($model->pdfFile){
                        $pdfName = time() . '.' . $model->pdfFile->extension;
                        if (!file_exists('uploads/pdf')) {
                            mkdir('uploads/pdf', 0777, true);
                        }
                        $model->pdfFile->saveAs('uploads/pdf/' . $pdfName);
                        $model->pdf = $pdfName;
                    }

                    if($model->save(false)){
                        Yii::$app->session->setFlash('success', 'مقاله با موفقیت ساخته شد.');
                        return $this->redirect(['view', 'slug' => $model->slug]);
                    }
                }
                
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->render('/admin/article/create', [
            'model' => $model,
            'categories' => $categories
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

        public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categories = ArrayHelper::map(BlogCategory::find()->all(), 'id', 'title');

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->pdfFile = UploadedFile::getInstance($model, 'pdfFile');

            if ($model->validate()) {
                if ($model->imageFile) {
                        if (!file_exists('uploads/images')) {
                            mkdir('uploads/images', 0777, true);
                        }
                    $model->deleteImage();
                    $imageName = time() . '.' . $model->imageFile->extension;
                    $model->imageFile->saveAs('uploads/images/' . $imageName);
                    $model->image = $imageName;
                }
                if ($model->pdfFile) {
                     if (!file_exists('uploads/pdf')) {
                            mkdir('uploads/pdf', 0777, true);
                        }
                    $model->deletePdf();
                    $pdfName = time() . '.' . $model->pdfFile->extension;
                    $model->pdfFile->saveAs('uploads/pdf/' . $pdfName);
                    $model->pdf = $pdfName;
                }
                // echo '<pre>';
                // print_r($model);
                // die;
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'مقاله با موفقیت به‌روزرسانی شد.');
                    return $this->redirect(['view', 'slug' => $model->slug]);
                }
            }
        }

        return $this->render('/admin/article/update', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteArticle')) {
            throw new ForbiddenHttpException();
        }
        $model =$this->findModel($id);
        $model->deleteFiles();
        $model->delete();
        Yii::$app->session->setFlash('success', 'مقاله با موفقیت حذف شد.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Article::findOne(['slug' => $slug])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
