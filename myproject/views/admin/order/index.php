<?php

use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = ['label' => ' / Orders'];
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'user_id',
                'value' => 'user.username'
            ],
            [
                'attribute' => 'address_id',
                'value' => function($model){
                    return substr($model->address->address , 0  ,50);
                }
            ],
            'original_price',
            'order_final_amount',
            //'order_discount_amount',
            //'copan_id',
            //'order_copan_discount_amount',
            //'order_total_products_discount_amount',
            //'order_status',
            //'created_at',
            //'updated_at',
            [
            'class' => ActionColumn::className(),
                'template' => '{view} {orderItem}',
                 'buttons' => [
                    'orderItem' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fas fa-dedent"></i>',
                            ['admin/order/order-item', 'order_id' => $model->id]
                        );
                    },
                ],
                'urlCreator' => function ($action, Order $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
