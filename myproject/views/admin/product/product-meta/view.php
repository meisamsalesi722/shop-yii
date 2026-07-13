<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ProductMeta $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '/ Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Product Metas', 'url' => ['meta-index'  , 'product_id' => $product_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-meta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['meta-update', 'product_id' => $product_id , 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['meta-delete', 'product_id' => $product_id ,'id' => $model->id], [
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
            'meta_key',
            'meta_value',
            [
                'attribute' => 'product',
                'value' => function($model){
                    return $model->product->name;
                }
            ]
        ],
    ]) ?>

</div>
