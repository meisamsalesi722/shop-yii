<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Gallery;
use app\models\Product;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var app\models\GallerySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Gulleries';
$this->params['breadcrumbs'][] = ['label' => ' / Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title ;
?>
<div class="gallery-index">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <div class="d-flex justify-content-between align-items-center">
        <p>
            <?= Html::a('Create Gallery', ['gallery-create' , 'product_id' => $product_id], ['class' => 'btn btn-success']) ?>
        </p>
        <?php 
            $product = Product::findOne($product_id);
        ?>
        <img style="border-radius: 100%; width: 150px; height: 150px;" src="<?= Yii::getAlias('@web/uploads/images/') . ($product->image ?? '') ?>" alt="" style="max-width:100px;">
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function($model){
                    return '<img src="' . Yii::getAlias('@web/uploads/images/gallery/') . ($model->image ?? '') .'" alt="" style="max-width:100px;">';
                }
            ],
            [
                'attribute' => 'product_id',
                'value' => 'product.name'
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Gallery $model, $key, $index, $column) use($product_id) {
                    return Url::toRoute([ 'gallery-' .$action, 'product_id' => $product_id ,  'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
