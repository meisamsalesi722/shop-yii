<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Gallery $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '/ Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Product Gallery', 'url' => ['gallery-index'  , 'product_id' => $product_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gallery-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function($model){
                    return '<img src="' . Yii::getAlias('@web/uploads/images/gallery/') . ($model->image ?? '') .'" alt="" style="max-width:100px;">';
                }
            ],
            [
                'attribute'=> 'product',
                'value' => function($model){
                    return $model->product->name;
                }
            ],
        ],
    ]) ?>

</div>
