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


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function($model){
                    return '<img src="' . Yii::getAlias('@web/uploads/images/') . ($model->vendorProduct->productVariant->product->image ?? '') .'" alt="" style="max-width:100px;">';
                }
            ],
            [
                'attribute' => 'vendor_product_id',
                'value' => function($model){
                    return $model->vendorProduct->id;
                },
            ],
            'number',
            'final_product_price',
            'final_total_price',
            [
                'attribute' => 'color_id',
                'value' => function($model){
                    return $model->vendorProduct->productVariant->color;
                },
            ],
            [
                'attribute' => 'guarantee_id',
                'value' => function($model){
                    return $model->vendorProduct->productVariant->guarantee;
                },
            ],

            [
                'attribute'=> 'product',
                'label' => 'محصول',
                'value' => function($model){
                    return $model->vendorProduct->productVariant->product->persian_name;
                }
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
