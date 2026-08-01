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
                'attribute' => 'reject_message',
                'label' => 'message',
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    $text = match($model->status){
                        0 => 'در انتظار تایید',
                        1 => 'تایید شده',
                        2 => 'رد شده',
                        default => "نامشخص!",
                    };
                    return $text;
                }
            ],
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function($model){
                    return '<img src="' . Yii::getAlias('@web/uploads/images/') . ($model->image ?? '') .'" alt="" style="max-width:100px;">';
                }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}',
                 'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if($model->user_id == Yii::$app->user->id && $model->status == 2){
                            return Html::a(
                                '<i class="fas fa-edit"></i>',
                                ['vendor/products-awaiting-approval/update' , 'id' => $model->id]
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
