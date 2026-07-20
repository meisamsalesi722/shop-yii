<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<div class="page-content page-content-mobile">
    <div class="breadcrumb-page mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start justify-content-lg-center mb-0">
                <li class="breadcrumb-item"><a href="#">صفحه اصلی</a></li>
                <li class="breadcrumb-item"><a href="<?= Url::to('/userpanel/order-history/') ?>">تاریخچه سفارشات</a></li>
                <li class="breadcrumb-item"><a href="<?= Url::to(['/userpanel/order-history/order-item' , 'order_id' => $model->order->id]) ?>"><?= $model->order->id ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $model->product->name ?></li>
            </ol>
        </nav>
    </div>
    <div class="content-in">
<div class="order-item-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => ' نام محصول',
                'value' => function($model){
                    return $model->product->name;
                },
            ],
            [
                'attribute' => 'تعداد',
                'value' => function($model){
                    return $model->number;
                }
            ],
            [
                'attribute' => 'قیمت محصول',
                'value' => function($model){
                    return $model->final_product_price;
                }
            ],
            [
                'attribute' => 'قیمت نهایی محصول',
                'value' => function($model){
                    return $model->final_total_price;
                }
            ],
            [
                'attribute' => 'رنگ',
                'format' => 'raw',
                'value' => function($model){
                    return '<i class="fas fa-circle color-withe" style="color: '. ($model->color->color_code ?? ''). ';"></i>';
                },
            ],
            [
                'attribute' => 'گارانتی',
                'value' => function($model){
                    return $model->guarantee->name;
                },
            ],
            [
                'attribute' => 'تاریخ سفارش',
                'value' => function($model){
                    return $model->created_at;
                },
            ],
        ],
    ]) ?>
    
</div>
</div>
