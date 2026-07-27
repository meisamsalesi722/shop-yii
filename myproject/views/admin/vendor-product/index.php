<?php

use app\models\VendorProduct;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\VendorProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Vendor Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-product-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'product_variant_id',
                'label' => 'محصول',
                'value' => function($model){
                    return $model->productVariant->product->name;
                }
            ],
            [
                'label' => 'رنگ',
                'value' => function($model){
                    return $model->productVariant->color;
                }
            ],
            [
                'label' => 'گارانتی',
                'value' => function($model){
                    return $model->productVariant->guarantee;
                }
            ],
            'price',
            'marketable_number',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}',
                'urlCreator' => function ($action, VendorProduct $model, $key, $index, $column) {
                    return Url::toRoute([$action , 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
