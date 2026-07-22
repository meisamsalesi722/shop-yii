<?php

use app\models\OrderItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OrderItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Order Items';
$this->params['breadcrumbs'][] = ['label' => '/ Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-item-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a('Create Category', ['/admin/order/order-item-create' , 'order_id' => $order_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'order_id',
            [
                'attribute'=> 'product_id',
                'value' => 'product.name',
            ],
            'number',
            // 'final_product_price',
            //'final_total_price',
            //'color_id',
            //'guarantee_id',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}',
                 'buttons' => [
                    'view' => function ($url, $model, $key) use($order_id){
                        return Html::a(
                            '<i class="fas fa-eye"></i>',
                            ['admin/order/order-item-view', 'id' => $model->id , 'order_id' => $order_id]
                        );
                    },
                ],
                'urlCreator' => function ($action, OrderItem $model, $key, $index, $column) use($order_id) {
                    return Url::toRoute([ 'admin/order/order-item-' . $action, 'id' => $model->id , 'order_id' => $order_id]);
                 }
            ],
        ],
    ]); ?>


</div>
