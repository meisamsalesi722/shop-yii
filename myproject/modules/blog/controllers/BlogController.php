<?php

namespace app\modules\blog\controllers;


use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\modules\blog\models\Article;
use app\modules\blog\models\CommentBlog;

class BlogController extends Controller
{
    public $layout = 'main';
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Article::find()
                ->where(['status' => 1])
                ->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($slug)
    {

        $model = Article::findOne(['slug' => $slug]);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException();
        }
        $commentModel = new CommentBlog();

        return $this->render('view', [
            'model' => $model,
            'commentModel' => $commentModel,
            'isFavorite' => $model->isFavorite(),
        ]);
    }

    
}