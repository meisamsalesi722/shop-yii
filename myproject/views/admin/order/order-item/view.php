<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\OrderItem $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '/ Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Order Items', 'url' => ['order-item' , 'order_id' => $order_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['/admin/order/order-item-update', 'id' => $model->id , 'order_id' => $order_id], ['class' => 'btn btn-primary']) ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'product_id',
                'value' => function($model){
                    return $model->product->name;
                },
            ],
            'number',
            'final_product_price',
            'final_total_price',
            [
                'attribute' => 'color_id',
                'value' => function($model){
                    return $model->color->name;
                },
            ],
            [
                'attribute' => 'guarantee_id',
                'value' => function($model){
                    return $model->guarantee->name;
                },
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
