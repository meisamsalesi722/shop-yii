<?php

use app\models\Gallery;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\GallerySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Gulleries';
$this->params['breadcrumbs'][] = ['label' => ' / Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title ;
?>
<div class="gallery-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Gallery', ['gallery-create' , 'product_id' => $product_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
