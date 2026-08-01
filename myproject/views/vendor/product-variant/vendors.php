<?php

use yii\grid\GridView;

?>
<div class="product-variant-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'فروشنده',
                'attribute' => 'vendor_id',
                'value' => 'vendor.name'
            ],
            [
                'label' => 'قیمت',
                'attribute' => 'price',
                'value' => function($model){
                    return $model->price . ' تومان ';
                }
            ],


        ],
    ]); ?>



</div>
