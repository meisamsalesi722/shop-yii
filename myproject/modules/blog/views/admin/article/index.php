<?php

use app\models\Article;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ArticleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?php if (Yii::$app->user->can('createArticle')): ?>
    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php endif; ?>
    <?php
    //  echo $this->render('_search', ['model' => $searchModel]);   
     ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'user_id',
                'value'=>'user.username',
            ],
            [
                'attribute'=>'blog_category_id',
                'value'=>'blog_category.title',
            ],
            'title',
            'slug',
            [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view} {update} {delete}',

    'buttons' => [
        'update' => function ($url, $model) {
            return Yii::$app->user->can('updateArticle')
                ? Html::a('Update', $url)
                : '';
        },

        'delete' => function ($url, $model) {
            return Yii::$app->user->can('deleteArticle')
                ? Html::a('Delete', $url, [
                    'data-method' => 'post',
                    'data-confirm' => 'Are you sure?'
                ])
                : '';
        },
    ],
],
        ],
    ]); ?>



</div>
