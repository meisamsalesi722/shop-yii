<?php

use app\models\OrderItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
?>

<div class="page-content page-content-mobile">
    <div class="breadcrumb-page mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start justify-content-lg-center mb-0">
                <li class="breadcrumb-item"><a href="#">صفحه اصلی</a></li>
                <li class="breadcrumb-item"><a href="<?= Url::to('/userpanel/order-history/') ?>">تاریخچه سفارشات</a></li>
                <li class="breadcrumb-item active" aria-current="page">ایتم های سفارش <?= $model->id ?></li>
            </ol>
        </nav>
    </div>
    <div class="content-in">
<div class="order-item-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'layout' => "{items}\n{pager}",
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'تصویر محصول',
                'format' => 'raw',
                'value' => function($model){
                    return '<img src="' . Yii::getAlias('@web/uploads/images/') . ($model->product->image ?? '') .'" alt="" style="max-width:70px; ">';
                }
            ],
            [
                'attribute'=> 'محصول',
                'value' => 'product.name',
            ],

            [
                'attribute' => 'تعداد',
                'value' => function($model){
                    return $model->number;
                }
            ],
            // 'final_product_price',
            //'final_total_price',
            //'color_id',
            //'guarantee_id',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
                 'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fas fa-eye"></i>',
                            ['/userpanel/order-history/order-item-view', 'id' => $model->id]
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>
</div>