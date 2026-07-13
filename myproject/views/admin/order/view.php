<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => ' / Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user',
                'value' => function($model){
                    return $model->user->username;
                }
            ],
            [
                'attribute' => 'address',
                'value' => function($model){
                    return $model->address->address;
                }
            ],
            [
                'attribute' => 'copan',
                'value' => function($model){
                    return $model->copan->code;
                }
            ],
            'original_price',
            'order_final_amount',
            'order_discount_amount',
            'order_copan_discount_amount',
            'order_total_products_discount_amount',
            // [
            //     'attribute' => 'order_status',
            //     'value' => function($model){
            //         return $model->order_status ? '' :;
            //     }
            // ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
