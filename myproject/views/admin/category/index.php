<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'parent',
                'value' => function($model){
                    return $model->parent == null ?  'دسته اصلی' : '>>' . $model->parent->name ;
                } 
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status == 1 ? 'فعال' : 'غیر فعال';
                }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {orderItem}',
                 'buttons' => [
                    'orderItem' => function ($url, $model, $key) {
                        if(!$model->children){
                        return Html::a(
                            '<i class="fas fa-dedent"></i>',
                            ['admin/category/attribute', 'category_id' => $model->id]
                        );
                    }else{
                        '';
                    }
                    }
                ],
                'urlCreator' => function ($action, Category $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
