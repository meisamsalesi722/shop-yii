<?php

namespace app\modules\blog\controllers;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\blog\models\Article;
use app\modules\blog\models\BlogCategory;

class BlogCategoryController extends Controller
{
    public $layout = 'main';

    public function actionView($id)
    {
        echo 'hi';
        $category = $this->findModel($id);
        
        // مقالات این دسته
        $articles = Article::find()
            ->where(['blog_category_id' => $id, 'status' => 1])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
        
        return $this->render('view', [
            'category' => $category,
            'articles' => $articles,
        ]);
    }
    
    protected function findModel($id)
    {
        if (($model = BlogCategory::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('دسته‌بندی مورد نظر پیدا نشد.');
    }
}