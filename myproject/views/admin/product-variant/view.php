<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ProductVariant $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Product Variants', 'url' => ['index' ,'product_id' => $product_id ]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-variant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'product_id' => $product_id , 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'product_id' => $product_id ,'id' => $model->id], [
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
            'product_id',
            'color',
            'color_code',
            [
                'attribute' => 'color_code',
                'format' => 'raw',
                'value' => function($model){
                    return ' <span class="status-product mt-2 text-muted"><i class="fas fa-circle " style="color: ' . $model->color_code . ';"></i></span>';
                }
            ],
            'guarantee',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
