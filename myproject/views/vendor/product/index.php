<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}",
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            'id',
            'name',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function($model){
                    return '<img src="' . Yii::getAlias('@web/uploads/images/') . ($model->image ?? '') .'" alt="" style="max-width:100px;">';
                }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {meta} {gallery} {product-variant}',
                 'buttons' => [
                    'meta' => function ($url, $model, $key) {
                        if($model->user_id == Yii::$app->user->id){
                            return Html::a(
                                '<i class="fas fa-user-tag"></i>',
                                ['vendor/product/meta-index', 'product_id' => $model->id]
                            );
                        }
                    },
                    'gallery' => function ($url, $model, $key) {
                        if($model->user_id == Yii::$app->user->id){
                            return Html::a(
                                '<i class="fas fa-images"></i>',
                                ['vendor/product/gallery-index', 'product_id' => $model->id]
                            );
                        }
                    },
                    'product-variant' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fas fa-folder-tree"></i>',
                            ['vendor/product-variant/index' , 'product_id' => $model->id]
                        );
                    },
                    'update' => function ($url, $model, $key) {
                        if($model->user_id == Yii::$app->user->id){
                            return Html::a(
                                '<i class="fas fa-edit"></i>',
                                ['vendor/product/update' , 'id' => $model->id]
                            );
                        }
                    },
                ],
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([ $action, 'id' => $model->id]);
                 }
            ],
        ],
        
    ]); ?>


</div>
